<?php

namespace Modules\Page\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\LaravelLocalization;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Page\Entities\Page;
use Modules\Page\Events\PageIsCreating;
use Modules\Page\Events\PageIsUpdating;
use Modules\Page\Events\PageWasCreated;
use Modules\Page\Events\PageWasDeleted;
use Modules\Page\Events\PageWasUpdated;
use Modules\Page\Repositories\PageRepository;

class EloquentPageRepository extends EloquentBaseRepository implements PageRepository
{
    /**
     * Paginate the model to $perPage items per page
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15):  LengthAwarePaginator
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->with('translations')->paginate($perPage);
        }

        return $this->model->paginate($perPage);
    }

    /**
     * Find the page set as homepage
     * @return object
     */
    public function findHomepage():object
    {
        return $this->model->where('is_home', 1)->first();
    }

    /**
     * Count all records
     * @return int
     */
    public function countAll(): int
    {
        return $this->model->count();
    }

    /**
     * Create a resource
     * @param  $data
     * @return Model|Collection|Builder|array|null
     */
    public function create($data): Model|Collection|Builder|array|null
    {
        if (Arr::get($data, 'is_home') === '1') {
            $this->removeOtherHomepage();
        }

        event($event = new PageIsCreating($data));
        $page = $this->model->create($event->getAttributes());

        event(new PageWasCreated($page, $data));

        $page->setTags(Arr::get($data, 'tags', []));

        return $page;
    }

    /**
     * Update a resource
     * @param  $model
     * @param array $data
     * @return Model|Collection|Builder|array|null
     */
    public function update($model, $data): Model|Collection|Builder|array|null
    {
        if (Arr::get($data, 'is_home') === '1') {
            $this->removeOtherHomepage($model->id);
        }

        event($event = new PageIsUpdating($model, $data));
        $model->update($event->getAttributes());

        event(new PageWasUpdated($model, $data));

        $model->setTags(Arr::get($data, 'tags', []));

        return $model;
    }
    /**
     * Destroy a resource
     * @param  $model
     * @return bool
     */
    public function destroy($model): bool
    {
        $model->untag();

        event(new PageWasDeleted($model));

        return $model->delete();
    }

    /**
     * @param $slug
     * @param $locale
     * @return object
     */
    public function findBySlugInLocale($slug, $locale):object
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->whereHas('translations', function (Builder $q) use ($slug, $locale) {
                $q->where('slug', $slug);
                $q->where('locale', $locale);
            })->with('translations')->first();
        }

        return $this->model->where('slug', $slug)->where('locale', $locale)->first();
    }

    /**
     * Set the current page set as homepage to 0
     * @param null $pageId
     */
    private function removeOtherHomepage($pageId = null)
    {
        $homepage = $this->findHomepage();
        if ($homepage === null) {
            return;
        }
        if ($pageId === $homepage->id) {
            return;
        }

        $homepage->is_home = 0;
        $homepage->save();
    }

    /**
     * Paginating, ordering and searching through pages for server side index table
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $pages = $this->allWithBuilder();

        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $pages->whereHas('translations', function ($query) use ($term) {
                $query->where('title', 'LIKE', "%{$term}%");
                $query->orWhere('slug', 'LIKE', "%{$term}%");
            })
                ->orWhere('id', $term);
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            if (Str::contains($request->get('order_by'), '.')) {
                $fields = explode('.', $request->get('order_by'));

                $pages->with('translations')->join('page__page_translations as t', function ($join) {
                    $join->on('page__pages.id', '=', 't.page_id');
                })
                    ->where('t.locale', locale())
                    ->groupBy('page__pages.id')->orderBy("t.{$fields[1]}", $order);
            } else {
                $pages->orderBy($request->get('order_by'), $order);
            }
        }
        //dd($pages->toSql());

//        $pages->with('translations')->join('page__page_translations as t', function ($join) {
//            $join->on('page__pages.id', '=', 't.page_id');
//        })->where('t.locale', locale())
//            ->groupBy('page__pages.id')->orderBy("t.title", 'desc');
        return $pages->paginate($request->get('per_page', 10));
    }

    /**
     * @param Page $page
     * @return Model|Collection|array|Builder|null
     */
    public function markAsOnlineInAllLocales(Page $page): Model|Collection|array|null|Builder
    {
        $data = [];
        foreach (app(LaravelLocalization::class)->getSupportedLocales() as $locale => $supportedLocale) {
            $data[$locale] = ['status' => 1];
        }

        return $this->update($page, $data);
    }

    /**
     * @param Page $page
     * @return Model|Collection|Builder|array|null
     */
    public function markAsOfflineInAllLocales(Page $page):Model|Collection|Builder|array|null
    {
        $data = [];
        foreach (app(LaravelLocalization::class)->getSupportedLocales() as $locale => $supportedLocale) {
            $data[$locale] = ['status' => 0];
        }

        return $this->update($page, $data);
    }

    /**
     * @param array $pageIds [int]
     * @return Model|Collection|Builder|array|null
     */
    public function markMultipleAsOnlineInAllLocales(array $pageIds): Model|Collection|Builder|array|null
    {
        foreach ($pageIds as $pageId) {
            $this->markAsOnlineInAllLocales($this->find($pageId));
        }
    }

    /**
     * @param array $pageIds [int]
     * @return mixed
     */
    public function markMultipleAsOfflineInAllLocales(array $pageIds): mixed
    {
        foreach ($pageIds as $pageId) {
            $this->markAsOfflineInAllLocales($this->find($pageId));
        }
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
            if (isset($filter->search) && $filter->search) {
                //find search in columns
                $term = $filter->search;
                $query->where(function ($subQuery) use ($term) {
                    $subQuery->whereHas('translations', function ($q) use ($term) {
                        $q->where('title', 'LIKE', "%{$term}%");
                        $q->orWhere('slug', 'LIKE', "%{$term}%");
                    })
                        ->orWhere('id', $term);
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
    public function getItem(string $criteria, $params = false): Model|Collection|Builder|array|null
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
                $field = $filter->field;
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);

        /*== REQUEST ==*/
        return $query->where($field ?? 'id', $criteria)->first();
    }


}
