<?php

namespace Modules\Maintenance\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Maintenance\Repositories\EventRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentEventRepository extends EloquentBaseRepository implements EventRepository
{


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
        if (in_array('*', $params->include) || empty($params->include)) {//If Request all relationships
            $query->with(['company','eventable']);
        } else {//Especific relationships
            $includeDefault = ['company','eventable'];//Default relationships
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
            if (isset($filter->companies) && !empty($filter->companies)) {
                $companies = is_array($filter->companies) ? $filter->companies : [$filter->companies];
                $query->whereIn('company_id', $companies);
            }
            if (isset($filter->status)) {
                $query->where('status', $filter->status);
            }
            //add filter by search
            if (isset($filter->search) && $filter->search) {
                //find search in columns
                $term = $filter->search;
                $query->where(function ($subQuery) use ($term) {
                    $subQuery->whereHas('translations', function ($q) use ($term) {
                        $q->where('title', 'LIKE', "%{$term}%");
                    })->orWhere('id', $term);
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
