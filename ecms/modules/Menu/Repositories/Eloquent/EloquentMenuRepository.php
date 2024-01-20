<?php

namespace Modules\Menu\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Menu\Events\MenuIsCreating;
use Modules\Menu\Events\MenuIsUpdating;
use Modules\Menu\Events\MenuWasCreated;
use Modules\Menu\Events\MenuWasUpdated;
use Modules\Menu\Repositories\MenuRepository;

class EloquentMenuRepository extends EloquentBaseRepository implements MenuRepository
{
    /**
     * @param $data
     * @return Model|Collection|Builder|array|null;
     */
    public function create($data): Model|Collection|Builder|array|null
    {
        event($event = new MenuIsCreating($data));
        $menu = $this->model->create($event->getAttributes());

        event(new MenuWasCreated($menu));

        return $menu;
    }

    /**
     * Update a resource
     * @param  $model
     * @param array $data
     * @return Model|Collection|Builder|array|null
     */
    public function update($menu, array $data): Model|Collection|Builder|array|null
    {
        event($event = new MenuIsUpdating($menu, $data));
        $menu->update($event->getAttributes());

        event(new MenuWasUpdated($menu));

        return $menu;
    }

    /**
     * Get all online menus
     * @return object
     */
    public function allOnline(): object
    {
        $locale = App::getLocale();

        return $this->model->whereHas('translations', function (Builder $q) use ($locale) {
            $q->where('locale', "$locale");
            $q->where('status', 1);
        })->with('translations')->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Get resources by an array of attributes
     * @param object $params
     * @return LengthAwarePaginator|Collection
     */
    public function getItemsBy($params = false): LengthAwarePaginator|Collection
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with([]);
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
                $orderByField = $filter->order->field ?? 'created_at';//Default field
                $orderWay = $filter->order->way ?? 'desc';//Default way
                $query->orderBy($orderByField, $orderWay);//Add order to query
            }

            //add filter by search
            if (isset($filter->search)) {
                //find search in columns
                $query->where(function ($query) use ($filter) {
                    $query->whereHas('translations', function ($query) use ($filter) {
                        $query->where('locale', $filter->locale)
                            ->where('title', 'like', '%' . $filter->search . '%');
                    })->orWhere('id', 'like', '%' . $filter->search . '%')
                        ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
                        ->orWhere('created_at', 'like', '%' . $filter->search . '%');
                });
            }

        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);

        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->paginate($params->take);
        } else {
            $params->take ? $query->take($params->take) : false;//Take
            return $query->get();
        }
    }


    /**
     * Find a resource by id or slug
     * @param string $criteria
     * @param object $params
     * @return Model|Collection|Builder|array|null
     */
    public function getItem($criteria, $params = false): Model|Collection|Builder|array|null
    {
        //Initialize query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with([]);
        } else {//Especific relationships
            $includeDefault = [];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);//Add Relationships to query
        }

        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;

            if (isset($filter->field))//Filter by specific field
                $query->where($filter->field, $criteria);
            else//Filter by ID
                $query->where('id', $criteria);
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);

        /*== REQUEST ==*/
        return $query->first();
    }
}
