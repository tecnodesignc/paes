<?php

namespace Modules\Transport\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Transport\Entities\Driver;
use Modules\Transport\Http\Requests\CreateDriverRequest;
use Modules\Transport\Http\Requests\UpdateDriverRequest;
use Modules\Transport\Repositories\DriverRepository;
use Modules\Transport\Transformers\DriverTransformer;
use Illuminate\Routing\Controller;


class DriverApiController extends Controller
{
    /**
     * @var DriverRepository
     */
    private DriverRepository $driver;

    public function __construct(DriverRepository $driver)
    {
        $this->driver = $driver;
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

            $drivers = $this->driver->getItemsBy($parameters);

            $response = ["data" => DriverTransformer::collection($drivers)];

            $response["meta"] = ["page" => $this->pageTransformer($drivers)];

        } catch (Exception $e) {

            \Log::Error($e);
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
    public function show(Driver $driver): JsonResponse
    {
        try {

            $response = ["data" => new DriverTransformer($driver)];

        } catch (Exception $e) {

            Log::Error($e);
            $status = $e->getCode();
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
    public function store(CreateDriverRequest $request): JsonResponse
    {
        \DB::beginTransaction();

        try {
            $data=$request->all();
            $data['password']=$this->generatePassword();
            $data['roles']=[3];

            $driver =$this->driver->create($data);

            $response = ["data" => new DriverTransformer($driver)];

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
    public function update(Driver $driver, UpdateDriverRequest $request): JsonResponse
    {
        \DB::beginTransaction();

        try {
            $data=$request->all();
            $data['roles']=[3];
            if (empty($data['is_activated']))$data['is_activated']=false;
            $this->driver->update($driver, $data);
            $response = ["data" => trans('core::core.messages.resource updated', ['name' => trans('transport::driver.title.driver')])];

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
    public function destroy(Driver $driver, Request $request): JsonResponse
    {
        \DB::beginTransaction();

        try {


            $this->driver->destroy($driver);

            $response = ["data" => trans('core::core.messages.resource deleted', ['name' => trans('transport::driver.title.driver')])];

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
