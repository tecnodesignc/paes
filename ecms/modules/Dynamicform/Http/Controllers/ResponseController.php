<?php

namespace modules\Dynamicform\Http\Controllers;

use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Dynamicform\Entities\Field;
use Modules\Dynamicform\Entities\FormResponse;
use Modules\Dynamicform\Http\Requests\CreateFormResponseRequest;
use Modules\Dynamicform\Repositories\FieldRepository;
use Modules\Dynamicform\Entities\Form;
use Modules\Dynamicform\Repositories\FormRepository;
use Modules\Dynamicform\Repositories\FormResponseRepository;
use Modules\Dynamicform\Transformers\FieldTransformer;
use Modules\Dynamicform\Transformers\FormResponseTransformer;
use Mockery\CountValidator\Exception;

class ResponseController extends AdminBaseController
{
    private FormResponseRepository $form_response;
    private FieldRepository $field;

    public function __construct(FormResponseRepository $form_response, FieldRepository $field)
    {
        parent::__construct();
        $this->form_response = $form_response;
        $this->field=$field;

    }

    public function index(Form $form)
    {
        return view('modules.dynamic-form.response.index', compact('form'));
    }

    /**
     * Show the form_response for editing the specified resource.
     *
     * @param Field $form_response
     * @return Application|Factory|View
     */
    public function show(Form $form, FormResponse $form_response): Application|Factory|View
    {
        return view('modules.dynamic-form.response.show', compact('form_response', 'form'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(Form $form):Application|Factory|View
    {
        $params = json_decode(json_encode([
            'filter' => [
                'form_id' => $form->id,
                'order'=>['field'=>'order','way'=>'asc']
                ],
            'include' => ['*'], 'page' => 1, 'take' => 10000
        ]));

        $datos = $this->field->getItemsBy($params);

        $datos = $datos->items();
        return view('modules.dynamic-form.response.create', compact('form','datos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateFormResponseRequest $request
     * @return Response
     */
    public function store(CreateFormResponseRequest $request, $datos): JsonResponse
    {
        \DB::beginTransaction();

        try {

            $data = $request->all();
            $formresponse = $this->form_response->create($data);

            $response = ["data" => new FormResponseTransformer($formresponse)];

            \DB::commit();

            return redirect()->route('dynamicform.form.indexcolaboradoresform')->withSuccess(trans('core::core.messages.resource created', ['name' => trans('dynamicform::forms.title.forms')]));
        } catch (Exception $e) {
            \Log::error($e);
            \DB::rollback();

            // Devolver el error como una respuesta JSON en caso de excepción
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
            return response()->json($response, $status ?? 200);
        }
    }

    /**
     * Download the view from responses to pdf
     *
     * @param FormResponse $form_response
     * @return Pdf
     */
    public function downloadpdf(Form $form, FormResponse $form_response)
    {

    }

}
