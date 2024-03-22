<?php

namespace Modules\Dynamicform\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Dynamicform\Events\FormResponsesWasCreated;
use Modules\Dynamicform\Repositories\FormResponseRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentFormResponseRepository extends EloquentBaseRepository implements FormResponseRepository
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

            // Filter by companies
            if(isset($filter->companies)){
                $companies = is_array($filter->companies) ? $filter->companies : [$filter->companies];
                $query->whereIn('company_id',$companies);
            }

            // Filter by form id
            if(isset($filter->form_id)){
                $query->where('form_id', $filter->form_id);
            }

            //add filter by search
            if (isset($filter->search) && $filter->search) {
                //find search in columns
                $term = $filter->search;
                $query->where(function ($subQuery) use ($term) {
                    // $subQuery->whereHas('translations', function ($q) use ($term) {
                        $subQuery->where('data', 'LIKE', "%{$term}%")->orWhere('id', $term);
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
     * Create a resource
     * @param  $data
     * @return Model|Collection|Builder|array|null
     */
    public function create($data): Model|Collection|Builder|array|null
    {
        // \Log::info('error en eloquent repository');
        $formresponse = $this->model->create($data);
        event(new FormResponsesWasCreated($formresponse, $data));
        return $formresponse;
    }

}
