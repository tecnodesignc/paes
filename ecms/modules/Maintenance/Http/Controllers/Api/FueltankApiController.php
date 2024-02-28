<?php

namespace Modules\Maintenance\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Mockery\CountValidator\Exception;
use Modules\Maintenance\Entities\Fueltank;
use Modules\Maintenance\Http\Requests\CreateFueltankRequest;
use Modules\Maintenance\Http\Requests\UpdateFueltankRequest;
use Modules\Maintenance\Repositories\FueltankRepository;
use Modules\Maintenance\Transformers\FueltankTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\User\Contracts\Authentication;

class FueltankApiController extends BaseApiController
{
    /**
     * @var FueltankRepository
     */
    private FueltankRepository $fueltank;

    public function __construct(FueltankRepository $fueltank)
    {
        parent::__construct();

        $this->fueltank = $fueltank;
        $this->auth = app(Authentication::class);
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

            $params = json_decode(json_encode(['filter' => ['search' => $request->input('search'), 'companies' => $request->input('companies'), 'status' => $request->input('status')], 'include' => ['*'], 'page' => $request->input('page'), 'take' => $request->input('limit')]));

            $fueltanks = $this->fueltank->getItemsBy($params);

            $response = ["data" => FueltankTransformer::collection($fueltanks)];

            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($fueltanks)] : false;

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
    public function show(string $criteria, Request $request): JsonResponse
    {
        try {

            $params = $this->getParamsRequest($request);

            $fueltank = $this->fueltank->getItem($params);

            if (!$fueltank) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('maintenance::fueltanks.title.fueltanks')]), 404);

            $response = ["data" => new FueltankTransformer($fueltank)];

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
    public function store(CreateFueltankRequest $request): JsonResponse
    {
        \DB::beginTransaction();

        try {

            $data = $request->all() ?? [];
            $data['type'] = 1;
            $fueltank = $this->fueltank->create($data);

            $response = ["data" => new FueltankTransformer($fueltank)];

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

            $this->validateRequestApi(new UpdateFueltankRequest($data));

            $params = $this->getParamsRequest($request);

            $fueltank = $this->fueltank->getItem($params);

            if (!$fueltank) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('maintenance::fueltanks.title.fueltanks')]), 404);

            $this->fueltank->update($fueltank, $request->all());

            $response = ["data" => trans('core::core.messages.resource updated', ['name' => trans('maintenance::fueltanks.title.fueltanks')])];

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
    public function destroy(string $criteria, Request $request): JsonResponse
    {
        \DB::beginTransaction();

        try {

            $params = $this->getParamsRequest($request);

            $fueltank = $this->fueltank->getItem($params);

            if (!$fueltank) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('maintenance::fueltanks.title.fueltanks')]), 404);

            $this->fueltank->destroy($fueltank);

            $response = ["data" => trans('core::core.messages.resource deleted', ['name' => trans('maintenance::fueltanks.title.fueltanks')])];

            \DB::commit();

        } catch (Exception $e) {

            \Log::Error($e);
            \DB::rollback();
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];

        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);

    }
}
