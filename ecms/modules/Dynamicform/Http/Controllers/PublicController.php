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
use Modules\Dynamicform\Transformers\FormResponseTransformer;

class PublicController extends AdminBaseController
{

    private FormRepository $form;
    private FormResponseRepository $form_response;

    // importamos los repositorios (consumiendo el modelo donde están guardadas las consultas)
    public function __construct(FormResponseRepository $formresponse, FormRepository $form)
    {
        parent::__construct();
        $this->form_response = $formresponse;
        $this->form = $form;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function dashboard():Application|Factory|View
    {
        //consulta para las respuestas
        $from = Carbon::now()->setTime(0, 0, 0)->format('Y-m-d H:i:s');
        $to = Carbon::now()->format('Y-m-d H:i:s');
        $params = json_decode(json_encode([
            'filter' => [
                'date' => [
                    'field' => 'created_at',
                    'from' => $from,
                    'to' => $to
                ],
                'companies' => company()->id?company()->id:array_values(companies()->map(function ($company){
                    return $company->id;
                 })->toArray())

            ], 'include' => ['form','user', 'company'], 'page' => 1, 'take' => 10000
        ]));

        // Obtenemos el modelo de FormResponse y la guardamos en form_response
        $forms_response=$this->form_response->getItemsBy($params);
        // Convertimos el modelo en una colleccion de datos
        $forms_response=collect(json_decode(json_encode(FormResponseTransformer::collection($forms_response))));

        $forms_response_count = $forms_response->count();

        // filtramos los formularios que contengan 1 o mas respuestas negativas
        $forms_response_negative = $forms_response->where('negative_num', '>=', 1);
        // ----- Cantidad formularios contestados hoy con hallazgos
        $conteoPorEmpresa = $forms_response_negative->groupBy('company_id')
        ->map(function ($items) {
            return [
                'name' => $items->first()->form->name,
                'cantidad' => $items->count(),
            ];
        });

        // ----- Cantidad de respuestas negativas x dia
        $forms_response_negative_count_day = $forms_response_negative->count();
        // ----- Datos para cargar en la tabla respuestas negativas x dia
        $forms_response_negatives = [];
        foreach ($forms_response_negative as $forms_response_n) {
            $forms_response_negatives[] = $forms_response_n;
        }

        //consulta para los formularios
        $params_form = json_decode(json_encode([
            'filter' => [
                'companies' => company()->id?company()->id:array_values(companies()->map(function ($company){
                    return $company->id;
                })->toArray()),
                'status' => 1
            ],  'include' => ['*'], 'page' => 1, 'take' => 10000
        ]));

        $forms=$this->form->getItemsBy($params_form);

        // -----todos los formularios activos total
        $forms_active_count=$forms->count();

        return view('dynamicform::public.index', compact('forms_response_negatives', 'forms_active_count', 'forms_response_negative_count_day', 'conteoPorEmpresa', 'forms_response_count'));
    }







}
