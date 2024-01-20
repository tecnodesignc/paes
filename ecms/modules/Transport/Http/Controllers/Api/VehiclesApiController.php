<?php

namespace Modules\Transport\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Transport\Entities\Vehicles;
use Modules\Transport\Http\Requests\CreateVehiclesRequest;
use Modules\Transport\Http\Requests\UpdateVehiclesRequest;
use Modules\Transport\Repositories\VehiclesRepository;
use Modules\Transport\Transformers\VehiclesTransformer;
use Illuminate\Routing\Controller;

class VehiclesApiController extends Controller
{
    /**
     * @var VehiclesRepository
     */
    private VehiclesRepository $vehicles;

    public function __construct(VehiclesRepository $vehicles)
    {
        $this->vehicles = $vehicles;
    }

    /**
    * Get listing of the resource
    *
    * @return JsonResponse
    */
    public function index(Request $request): JsonResponse
    {
        try {

            $includes=explode(',',$request->input('include'));

            $parameters=json_decode(json_encode(['filter'=>['search'=>$request->input('search'),'company_id'=>$request->input('company_id')],'include'=>$includes,'page'=>$request->input('page'),'take'=>$request->input('limit')]));

            $vehicles = $this->vehicles->getItemsBy($parameters);

            $response = ["data" => VehiclesTransformer::collection($vehicles)];

            $response["meta"] = ["page" => $this->pageTransformer($vehicles)];


        } catch (Exception $e) {

            Log::Error($e);
            $status = $e->getCode();
            $response = ["errors" => $e->getMessage()];

        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }
    /**
    * Get a resource item
    * @param string $criteria
    * @return JsonResponse
    */
    public function show(Vehicles $vehicles): JsonResponse
    {
        try {

            $response = ["data" => new VehiclesTransformer($vehicles)];


        } catch (Exception $e) {

            Log::Error($e);
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
    public function store(CreateVehiclesRequest $request): JsonResponse
    {
        \DB::beginTransaction();

        try {

            $vehicles = $this->vehicles->create($request->all());

            $response = ["data" => new VehiclesTransformer($vehicles)];

            \DB::commit();

        } catch (Exception $e) {

            Log::Error($e);
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
    public function update(Vehicles $vehicles, UpdateVehiclesRequest $request): JsonResponse
    {
        \DB::beginTransaction();

        try {

            $this->vehicles->update($vehicles, $request->all());

            $response = ["data" => trans('core::core.messages.resource updated', ['name' => trans('transport::vehicles.title.vehicles')])];

            \DB::commit();

        } catch (Exception $e) {

            Log::Error($e);
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
    public function destroy(Vehicles $vehicles, Request $request): JsonResponse
    {
        \DB::beginTransaction();

        try {

            $this->vehicles->destroy($vehicles);

            $response = ["data" => trans('core::core.messages.resource deleted', ['name' => trans('transport::vehicles.title.vehicles')])];

            \DB::commit();

        } catch (Exception $e) {

            Log::Error($e);
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
