<?php

namespace Modules\Transport\Repositories\Eloquent;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Modules\Transport\Events\DriverIsCreating;
use Modules\Transport\Events\DriverIsUpdating;
use Modules\Transport\Repositories\DriverRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentDriverRepository extends EloquentBaseRepository implements DriverRepository
{
    /**
     * Create a resource
     * @param  $data
     * @return Model|Collection|Builder|array|null
     */
    public function create($data): Model|Collection|Builder|array|null
    {
        $user = event(new DriverIsCreating($data));
        $user = $user[0];
        $data['user_id'] = $user->id;
        $model = $this->model->create($data);
        $model->companies()->sync(Arr::get($data, 'companies', []));
        return $model;
    }

    /**
     * Update a resource
     * @param  $model
     * @param array $data
     * @return Model|Collection|Builder|array|null
     */
    public function update($model, array $data): Model|Collection|Builder|array|null
    {
        event(new  DriverIsUpdating($model, $data));
        $model->update($data);
        $model->companies()->sync(Arr::get($data, 'companies', []));

        return $model;
    }

    /*
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
            $includeDefault = ['user'];//Default relationships
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
            if (isset($filter->company)) {
                $query->where('company_id', $filter->company);
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
                    $subQuery->whereHas('user', function ($q) use ($term) {
                        $q->where('first_name', 'LIKE', "%{$term}%");
                        $q->orWhere('last_name', 'LIKE', "%{$term}%");
                    })->orWhere('driver_license', 'LIKE', "%{$term}%")
                        ->orWhere('phone', 'LIKE', "%{$term}%");
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
