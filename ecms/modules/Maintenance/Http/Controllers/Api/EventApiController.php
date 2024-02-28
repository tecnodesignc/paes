<?php

namespace Modules\Maintenance\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Mockery\CountValidator\Exception;
use Modules\Maintenance\Entities\Event;
use Modules\Maintenance\Http\Requests\CreateEventRequest;
use Modules\Maintenance\Http\Requests\UpdateEventRequest;
use Modules\Maintenance\Repositories\EventRepository;
use Modules\Maintenance\Transformers\EventTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\User\Contracts\Authentication;

class EventAPIController extends BaseApiController
{
    /**
     * @var EventRepository
     */
    private EventRepository $event;

    public function __construct(EventRepository $event)
    {
        parent::__construct();

        $this->event = $event;
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

            $includes=explode(',',$request->input('include'));

            $params=json_decode(json_encode(['filter'=>['search'=>$request->input('search'),'companies'=>$request->input('companies'),'status'=>$request->input('status'),'vehicle_id'=>$request->input('vehicle')],'include'=>['*'],'page'=>$request->input('page'),'take'=>$request->input('limit')]));

            $events = $this->event->getItemsBy($params);

          $response = ["data" => EventTransformer::collection($events)];

          $params->page ? $response["meta"] = ["page" => $this->pageTransformer($events)] : false;

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
    public function show(Event $event, Request $request): JsonResponse
    {
        try {

          $params = $this->getParamsRequest($request);

          $event = $this->event->getItem($params);

          if(!$event) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('maintenance::events.title.events')]),404);

          $response = ["data" => new EventTransformer($event)];

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
    public function store(CreateEventRequest $request): JsonResponse
    {
        \DB::beginTransaction();

        try {

            $data = $request->all();

            if (isset($data['formVerify'])){
                $questions=explode(',',$request->input('formVerify'));
                foreach ($questions as $i=>$item){
                    $data['form_verify'][$i]['question']=$item;
                }
                unset($data['formVerify']);
            }
            $event = $this->event->create($data);
            $event->load('company');
            $response = ["data" => new EventTransformer($event)];

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
    public function update(Event $event, Request $request): JsonResponse
    {
        \DB::beginTransaction();

        try {
            $data = $request->all();
          if (isset($data['formVerify'])){
              $data['form_verify']['question']=explode(',',$request->input('formVerify'));
              unset($data['formVerify']);
          }
          $this->event->update($event,$data);

            $response = ["data" => trans('core::core.messages.resource updated', ['name' => trans('maintenance::events.title.events')])];

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

            $event = $this->event->getItem($params);

            if(!$event) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('maintenance::events.title.events')]),404);

            $this->event->destroy($event);

            $response = ["data" => trans('core::core.messages.resource deleted', ['name' => trans('maintenance::events.title.events')])];

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
