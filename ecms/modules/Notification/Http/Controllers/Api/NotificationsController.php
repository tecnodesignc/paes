<?php

namespace Modules\Notification\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\Notification\Transformers\NotificationTransformer;

class NotificationsController extends BaseApiController
{
    /**
     * @var NotificationRepository
     */
    private NotificationRepository $notification;

    public function __construct(NotificationRepository $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function markAsRead(Request $request): JsonResponse
    {
        $updated = $this->notification->markNotificationAsRead($request->get('id'));

        return response()->json(compact('updated'));
    }

    /**
     * Get listing of the resource
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $params = $this->getParamsRequest($request);
            $notifications = $this->notification->getItemsBy($params);
            $response = ["data" => NotificationTransformer::collection($notifications)];
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($notifications)] : false;
        } catch (\Exception $e) {
            Log::Error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
     * Get a resource item
     *
     * @param $criteria
     * @param Request $request
     * @return JsonResponse
     */
    public function show($criteria, Request $request): JsonResponse
    {
        try {
            $params = $this->getParamsRequest($request);
            $notification = $this->notification->getItem($criteria, $params);
            if (!$notification) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('notification::notifications.title.notifications')]), 404);
            $response = ["data" => new NotificationTransformer($notification)];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        return response()->json($response, $status ?? 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        \DB::beginTransaction();
        try {
            $data = $request->input('attributes') ?? [];//Get data
            $this->validateRequestApi(new CreatePostRequest($data));
            $this->notification->create($data);
            $response = ["message" => trans('core::core.messages.resource created', ['name' => trans('notification::notifications.title.notifications')])];
            \DB::commit();
        } catch (\Exception $e) {
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
     * @param $criteria
     * @param Request $request
     * @return JsonResponse
     */
    public function update($criteria, Request $request): JsonResponse
    {
        \DB::beginTransaction();
        try {
            $data = $request->input('attributes') ?? [];//Get data
            $this->validateRequestApi(new CreatePostRequest($data));
            $params = $this->getParamsRequest($request);
            $notification = $this->notification->getItem($criteria, $params);
            if (!$notification) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('notification::notifications.title.notifications')]), 404);
            $this->notification->update($notification, $data);
            $response = ["message" => trans('core::core.messages.resource updated', ['name' => trans('notification::notifications.title.notifications')])];
            \DB::commit();
        } catch (\Exception $e) {
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
     * @param $criteria
     * @param Request $request
     * @return JsonResponse
     */
    public function delete($criteria, Request $request): JsonResponse
    {
        \DB::beginTransaction();
        try {
            $params = $this->getParamsRequest($request);
            $notification = $this->notification->getItem($criteria, $params);
            if (!$notification) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('notification::notifications.title.notifications')]), 404);
            $this->notification->destroy($notification);
            $response = ["message" => trans('core::core.messages.resource deleted', ['name' => trans('notification::notifications.title.notifications')])];
            \DB::commit();
        } catch (\Exception $e) {
            Log::Error($e);
            \DB::rollback();
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }
}
