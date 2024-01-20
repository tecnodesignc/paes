<?php

namespace Modules\Media\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Media\Entities\File;
use Modules\Media\Events\FolderIsCreating;
use Modules\Media\Events\FolderIsDeleting;
use Modules\Media\Events\FolderIsUpdating;
use Modules\Media\Events\FolderStartedMoving;
use Modules\Media\Events\FolderWasCreated;
use Modules\Media\Events\FolderWasUpdated;
use Modules\Media\Repositories\FolderRepository;
use Modules\Media\Support\Collection\NestedFoldersCollection;

class EloquentFolderRepository extends EloquentBaseRepository implements FolderRepository
{
    /**
     * Return a collection of all elements of the resource
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->with('translations')->where('is_folder', 1)->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Find a folder by its ID
     * @param int $folderId
     * @return File|null
     */
    public function findFolder(int $folderId): ?File
    {
        return $this->model->where('is_folder', 1)->where('id', $folderId)->first();
    }
    /**
     * Create a resource
     * @param  $data
     * @return Model|Collection|Builder|array|null
     */

    public function create($data): Model|Collection|Builder|array|null
    {
        $data = [
            'filename' => Arr::get($data, 'name'),
            'path' => $this->getPath($data),
            'is_folder' => true,
            'folder_id' => Arr::get($data, 'parent_id'),
        ];
        event($event = new FolderIsCreating($data));
        $folder = $this->model->create($event->getAttributes());

        event(new FolderWasCreated($folder, $data));

        return $folder;
    }

    /**
     * Update a resource
     * @param  $model
     * @param array $data
     * @return Model|Collection|Builder|array|null
     */
    public function update($model, array $data): Model|Collection|Builder|array|null
    {
        $previousData = [
            'filename' => $model->filename,
            'path' => $model->path,
        ];
        $formattedData = [
            'filename' => Arr::get($data, 'name'),
            'path' => $this->getPath($data),
            'parent_id' => Arr::get($data, 'parent_id'),
        ];

        event($event = new FolderIsUpdating($formattedData));
        $model->update($event->getAttributes());

        event(new FolderWasUpdated($model, $formattedData, $previousData));

        return $model;
    }

    /**
     * Destroy a resource
     * @param  $folder
     * @return bool
     */
    public function destroy($folder): bool
    {
        event(new FolderIsDeleting($folder));

        return $folder->delete();
    }

    /**
     * @param File $folder
     * @return Collection
     */
    public function allChildrenOf(File $folder): Collection
    {
        $path = $folder->path->getRelativeUrl();

        return $this->model->where('path', 'like', "{$path}/%")->get();
    }

    /**
     * @return NestedFoldersCollection
     */
    public function allNested(): NestedFoldersCollection
    {
        return new NestedFoldersCollection($this->all());
    }

    /**
     * @param File $folder
     * @param File $destination
     * @return File
     */
    public function move(File $folder, File $destination): File
    {
        $previousData = [
            'filename' => $folder->filename,
            'path' => $folder->path,
        ];

        $folder->update([
            'path' => $this->getNewPathFor($folder->filename, $destination),
            'folder_id' => $destination->id,
        ]);

        event(new FolderStartedMoving($folder, $previousData));

        return $folder;
    }

    /**
     * Find the folder by ID or return a root folder
     * which is an instantiated File class
     * @param int $folderId
     * @return File
     */
    public function findFolderOrRoot(int $folderId): File
    {
        $destination = $this->findFolder($folderId);

        if ($destination === null) {
            $destination = $this->makeRootFolder();
        }

        return $destination;
    }

    /**
     * @param string $filename
     * @param File $folder
     * @return string
     */
    private function getNewPathFor(string $filename, File $folder):string
    {
        return $this->removeDoubleSlashes($folder->path->getRelativeUrl() . '/' . Str::slug($filename));
    }

    /**
     * @param string $string
     * @return string
     */
    private function removeDoubleSlashes(string $string) : string
    {
        return str_replace('//', '/', $string);
    }

    /**
     * @param array $data
     * @return string
     */
    private function getPath(array $data): string
    {
        if (array_key_exists('parent_id', $data)) {
            $parent = $this->findFolder($data['parent_id']);
            if ($parent !== null) {
                return $parent->path->getRelativeUrl() . '/' . Str::slug(Arr::get($data, 'name'));
            }
        }

        return config('encore.media.config.files-path') . Str::slug(Arr::get($data, 'name'));
    }

    /**
     * Create an instantiated File entity, appointed as root
     * @return File
     */
    private function makeRootFolder() : File
    {
        return new File([
            'id' => 0,
            'folder_id' => 0,
            'path' => config('encore.media.config.files-path'),
        ]);
    }

    /**
     * Get resources by an array of attributes
     * @param object $params
     * @return LengthAwarePaginator|Collection
     */
  public function getItemsBy($params = false): Collection|LengthAwarePaginator
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with(["createdBy"]);
    } else {//Especific relationships
      $includeDefault = [];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }

    /*== FILTERS ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;//Short filter

      //Filter by date
      if (isset($filter->date)) {
        $date = $filter->date;//Short filter date
        $date->field = $date->field ?? 'created_at';
        if (isset($date->from))//From a date
          $query->whereDate($date->field, '>=', $date->from);
        if (isset($date->to))//to a date
          $query->whereDate($date->field, '<=', $date->to);
      }

      //Order by
      if (isset($filter->order)) {
        $orderByField = $filter->order->field ?? 'is_Folder';//Default field
        $orderWay = $filter->order->way ?? 'desc';//Default way
        $query->orderBy($orderByField, $orderWay);//Add order to query
      }else{
        $query->orderBy('is_Folder', 'desc');//Add order to query
        $query->orderBy('media__files.created_at', 'desc');//Add order to query
      }

      //folder id
      if (isset($filter->folderId) && (string)$filter->folderId != "") {
        $query->where('folder_id', $filter->folderId);

      }

      if (!isset($params->permissions['media.medias.index']) ||
        (isset($params->permissions['media.medias.index']) &&
          !$params->permissions['media.medias.index'])) {
        $query->where("is_folder","!=",0);
      }


      if (!isset($params->permissions['media.folders.index']) ||
        (isset($params->permissions['media.folders.index']) &&
          !$params->permissions['media.folders.index'])) {
        $query->where("is_folder","!=",1);
      }

      //folder name
      if (isset($filter->folderName) && $filter->folderName != "Home") {

        $folder = \DB::table("media__files as files")
          ->where("is_folder",true)
          ->where("filename",$filter->folderName)
          ->first();

        if(isset($folder->id)){
          $query->where('folder_id',$filter->folderId ?? $folder->id);
        }
      }

      //is Folder
      $query->where('is_folder',true);

      //is Folder
      if (isset($filter->zone)) {
        $filesIds = \DB::table("media__imageables as imageable")
          ->where('imageable.zone',$filter->zone)
          ->where('imageable.imageable_id',$filter->entityId)
          ->where('imageable.imageable_type',$filter->entity)
          ->get()->pluck("file_id")->toArray();
        $query->whereIn("id",$filesIds);
      }

      //add filter by search
      if (isset($filter->search) && $filter->search) {
        //find search in columns
        $query->where(function ($query) use ($filter) {
          $query->where('id', 'like', '%' . $filter->search . '%')
            ->orWhere('name', 'like', '%' . $filter->search . '%')
            ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
            ->orWhere('created_at', 'like', '%' . $filter->search . '%');
        });
      }
    }

    $this->validateIndexAllPermission($query,$params);
    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);

    //dd($query->toSql(), $query->getBindings());
    /*== REQUEST ==*/
    if (isset($params->page) && $params->page) {
      return $query->paginate($params->take);
    } else {
      $params->take ? $query->take($params->take) : false;//Take
      return $query->get();
    }
  }


    /**
     * @param $query
     * @param $params
     * @return void
     */
    function validateIndexAllPermission(&$query, $params)
  {
    // filter by permission: index all leads

    if (!isset($params->permissions['media.folders.index-all']) ||
      (isset($params->permissions['media.folders.index-all']) &&
        !$params->permissions['media.folders.index-all'])) {
      $user = $params->user;
      $role = $params->role;
      // if is salesman or salesman manager or salesman sub manager
      $query->where('created_by', $user->id);


    }
  }

}
