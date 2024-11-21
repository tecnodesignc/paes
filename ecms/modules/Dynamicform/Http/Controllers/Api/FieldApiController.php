<?php

namespace Modules\Dynamicform\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Mockery\CountValidator\Exception;
use Modules\Dynamicform\Entities\Field;
use Modules\Dynamicform\Entities\Form;
use Modules\Dynamicform\Http\Requests\CreateFieldRequest;
use Modules\Dynamicform\Http\Requests\UpdateFieldRequest;
use Modules\Dynamicform\Repositories\FieldRepository;
use Modules\Dynamicform\Transformers\FieldTransformer;
class FieldApiController extends Controller
{
    /**
     * @var FieldRepository
     */
    private FieldRepository $field;

    public function __construct(FieldRepository $field)
    {
        $this->field = $field;
    }

    /**
     * Get listing of the resource
     *
     * @return JsonResponse
     */
    public function index(Request $request, Form $form): JsonResponse
    {
        try {
            $includes = explode(',', $request->input('include'));

            $params = json_decode(json_encode(['filter' => [
                'search' => $request->input('search'),
                'companies' => $request->input('companies'),
                'form_id' => $form->id,
                'order'=>$request->input('order')
            ],
            'include' => $includes, 'page' => $request->input('page'), 'take' => $request->input('limit')]));

            $fields = $this->field->getItemsBy($params);

            $response = ["data" => FieldTransformer::collection($fields)];

            $response["meta"] = ["page" => $this->pageTransformer($fields)];

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
    public function show(Form $form, Field $field): JsonResponse
    {
        try {

            $response = ["data" => new FieldTransformer($field)];

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

            $this->validateRequestApi(new CreateFieldRequest($data));

            $field = $this->field->create($data);

            $response = ["data" => new FieldTransformer($field)];

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

            $this->validateRequestApi(new UpdateFieldRequest($data));

            $params = $this->getParamsRequest($request);

            $field = $this->field->getItem($params);

            if (!$field) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('dynamicform::fields.title.fields')]), 404);

            $this->field->update($field, $request->all());

            $response = ["data" => trans('core::core.messages.resource updated', ['name' => trans('dynamicform::fields.title.fields')])];

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
     * @param  Field $field
     * @return Response
     */
    public function destroy($form, Field $field): JsonResponse
    {
        \DB::beginTransaction();

        try {

            // $params = $this->getParamsRequest($request);

            // $field = $this->field->getItem($params);

            if (!$field) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('dynamicform::fields.title.fields')]), 404);

            $this->field->destroy($field);

            $response = ["data" => trans('core::core.messages.resource deleted', ['name' => trans('dynamicform::fields.title.fields')])];

            \DB::commit();

        } catch (Exception $e) {

            \Log::Error($e);
            \DB::rollback();
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];

        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);

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
