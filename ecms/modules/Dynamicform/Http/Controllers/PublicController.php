<?php

namespace modules\Dynamicform\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Dynamicform\Repositories\FormResponseRepository;
use Modules\Dynamicform\Transformers\FormResponseTransformer;

class PublicController extends AdminBaseController
{
    private FormResponseRepository $form_response;

    public function __construct(FormResponseRepository $form_response)
    {
        parent::__construct();
        $this->form_response = $form_response;

    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function dashboard():Application|Factory|View
    {

        $params = json_decode(json_encode([
            'filter' => [
                'date' => [
                    'field' => 'start_date',
                    'from' => Carbon::now()->setTime(0, 0, 0)->format('Y-m-d H:i:s'),
                    'to' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                'companies' => company()->id?company()->id:array_values(companies()->where('type',1)->map(function ($company){
                    return $company->id;
                })->toArray())
            ], 'include' => 'form', 'page' => 1, 'take' => 10000
        ]));

        $forms_response=$this->form_response->getItemsBy($params);

        $forms_response=FormResponseTransformer::collection($forms_response);

        return view('modules.dynamic-form.index',compact('forms_response'));
    }

}
