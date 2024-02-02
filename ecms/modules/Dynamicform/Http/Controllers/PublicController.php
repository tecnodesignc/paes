<?php

namespace modules\Dynamicform\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Dynamicform\Http\Requests\CreateFormRequest;
use Modules\Dynamicform\Repositories\FormRepository;
use Modules\Dynamicform\Repositories\FormResponseRepository;

class PublicController extends AdminBaseController
{

    private FormResponseRepository $form_response;
    public function __construct(FormResponseRepository $formresponse)
    {
        parent::__construct();
        $this->form_response = $formresponse;

    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function dashboard():Application|Factory|View
    {
        $fromDate = Carbon::createFromFormat('Y-m-d H:i:s', '2024-01-01 00:00:00');
        $toDate = Carbon::createFromFormat('Y-m-d H:i:s', '2024-02-31 23:59:59');
        
        $params = json_decode(json_encode([
            'filter' => [
                'date' => [
                    'field' => 'created_at',
                    'from' => $fromDate->format('Y-m-d H:i:s'),
                    'to' => $toDate->format('Y-m-d H:i:s')
                
                ],
                'companies' => company()->id?company()->id:array_values(companies()->map(function ($company){
                    return $company->id;
                 })->toArray())
            
            ], 'include' => ['form'], 'page' => 1, 'take' => 10000
        ]));
        
         
        $forms_response=$this->form_response->getItemsBy($params);
        // $response = ["data" => FormResponseTransformer::collection($forms_response)];

        // $forms_response=FormResponseTransformer::collection($forms_response);
        // dd($forms_response);
        return view('modules.dynamic-form.index', compact('forms_response'));
    }

}
