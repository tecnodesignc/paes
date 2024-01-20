<?php

namespace Modules\Transport\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Blog\Events\VehicleWasDeleted;
use Modules\Transport\Events\VehicleWasCreated;
use Modules\Transport\Events\VehicleWasUpdated;
use Modules\Transport\Repositories\VehiclesRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentVehiclesRepository extends EloquentBaseRepository implements VehiclesRepository
{

    /**
     * Find a resource by an array of attributes
     * @param array $attributes
     * @return Model|Collection|Builder|array|null
     */
    public function findByAttributes(array $attributes): Model|Collection|Builder|array|null
    {
        $query = $this->buildQueryByAttributes($attributes);

        return $query->first();
    }

    private function buildQueryByAttributes(array $attributes, string $orderBy = null, string $sortOrder = 'asc', array $with = array()): Builder
    {
        $query = $this->model->query()->with($with);

        if (method_exists($this->model, 'translations')) {
            $query = $query->with('translations');
        }

        foreach ($attributes as $field => $value) {

            $query = $query->where($field, $value);
        }

        if (null !== $orderBy) {
            $query->orderBy($orderBy, $sortOrder);
        }

        return $query;
    }


    /**
     * Create a resource
     * @param  $data
     * @return Model|Collection|Builder|array|null
     */
    public function create($data): Model|Collection|Builder|array|null
    {
        $vehicle = $this->model->create($data);
        event(new VehicleWasCreated($vehicle, $data));
        return $vehicle;
    }

    /**
     * Update a resource
     * @param  $model
     * @param array $data
     * @return Model|Collection|Builder|array|null
     */
    public function update($model, array $data): Model|Collection|Builder|array|null
    {
        $model->update($data);
        event(new VehicleWasUpdated($model, $data));
        return $model;
    }

    /**
     * Destroy a resource
     * @param  $model
     * @return bool
     */
    public function destroy($model): bool
    {
        event(new VehicleWasDeleted($model->id, get_class($model)));
        return $model->delete();
    }


    /**
     * Get resources by an array of attributes
     * @param bool|object $params
     * @return LengthAwarePaginator|Collection
     */
    public function getItemsBy(bool|object $params = false): Collection|LengthAwarePaginator
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with([]);
        } else {//Especific relationships
            $includeDefault = ['company'];//Default relationships
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
            if (isset($filter->company_id)) {
                $query->where('company_id', $filter->company_id);
            }


            //Order by
            if (isset($filter->order)) {
                $orderByField = $filter->order->field ?? 'created_at';//Default field
                $orderWay = $filter->order->way ?? 'desc';//Default way
                $query->orderBy($orderByField, $orderWay);//Add order to query
            }

            //add filter by search
            if (isset($filter->search) && $filter->search) {
                //find search in columns
                $term = $filter->search;
                $query->where(function ($subQuery) use ($term) {
                    $subQuery->Where('plate', 'LIKE', "%{$term}%")
                        ->orWhere('brand', 'LIKE', "%{$term}%")
                        ->orWhere('model', 'LIKE', "%{$term}%")
                        ->orWhere('class', 'LIKE', "%{$term}%")
                        ->orWhere('imei', 'LIKE', "%{$term}%")
                        ->orWhere('capacity', 'LIKE', "%{$term}%");
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

}
