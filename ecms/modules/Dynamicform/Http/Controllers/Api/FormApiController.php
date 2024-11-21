<?php

namespace Modules\Dynamicform\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Mockery\CountValidator\Exception;
use Modules\Dynamicform\Entities\Form;
use Modules\Dynamicform\Http\Requests\CreateFormRequest;
use Modules\Dynamicform\Http\Requests\UpdateFormRequest;
use Modules\Dynamicform\Repositories\FormRepository;
use Modules\Dynamicform\Transformers\FormTransformer;

class FormApiController extends Controller
{
    /**
     * @var FormRepository
     */
    private FormRepository $form;

    public function __construct(FormRepository $form)
    {
        $this->form = $form;
    }

    /**
     * Get listing of the resource
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $includes = explode(',', $request->input('include'));

            $params = json_decode(json_encode(
                ['filter' =>
                    [
                        'search' => $request->input('search'),
                        'companies' => $request->input('companies')
                    ],
                'include' => $includes,
                'page' => $request->input('page'),
                'take' => $request->input('limit')
                ]));
            $forms = $this->form->getItemsBy($params);

            $response = ["data" => FormTransformer::collection($forms)];
            $response["meta"] = ["page" => $this->pageTransformer($forms)];

        } catch (Exception $e) {

            \Log::Error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];

        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
     * Get a resource item
     * @param string $criteria
     * @return JsonResponse
     */
    public function show(Form $form): JsonResponse
    {
        try {

            $response = ["data" => new FormTransformer($form)];

        } catch (Exception $e) {

            \Log::Error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];

        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        \DB::beginTransaction();

        try {

            $data = $request->input('attributes') ?? [];

            $this->validateRequestApi(new CreateFormRequest($data));

            $form = $this->form->create($data);

            $response = ["data" => new FormTransformer($form)];

            \DB::commit();

        } catch (Exception $e) {

            \Log::Error($e);
            \DB::rollback();
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];

        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);

    }

    /**
     * Update the specified resource in storage..
     *
     * @param string $criteria
     * @param Request $request
     * @return JsonResponse
     */
    public function update(string $criteria, Request $request): JsonResponse
    {
        \DB::beginTransaction();

        try {

            $data = $request->input('attributes') ?? [];

            $this->validateRequestApi(new UpdateFormRequest($data));

            $params = $this->getParamsRequest($request);

            $form = $this->form->getItem($params);

            if (!$form) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('dynamicform::forms.title.forms')]), 404);

            $this->form->update($form, $request->all());

            $response = ["data" => trans('core::core.messages.resource updated', ['name' => trans('dynamicform::forms.title.forms')])];

            \DB::commit();

        } catch (Exception $e) {

            \Log::Error($e);
            \DB::rollback();
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];

        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $criteria
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy($form): JsonResponse
    {
        \DB::beginTransaction();

        try {

            if (!$form) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('dynamicform::forms.title.forms')]), 404);

            $this->form->destroy($form);

            $response = ["data" => trans('core::core.messages.resource deleted', ['name' => trans('dynamicform::forms.title.forms')])];

            \DB::commit();

        } catch (Exception $e) {

            \Log::Error($e);
            \DB::rollback();
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];

        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Form $form
     * @return JsonResponse
     */
    public function state(Form $form): JsonResponse
    {
        if (!$form) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $form->active = $form->active == 0 ? 1 : 0;
        $form->save();
        return response()->json(['message' => 'Registro borrado exitosamente'], 200);
    }

    protected function pageTransformer($data): array
    {
        return [
            "total" => $data->total(),
            "lastPage" => $data->lastPage(),
            "perPage" => $data->perPage(),
            "currentPage" => $data->currentPage()
        ];
    }

}
