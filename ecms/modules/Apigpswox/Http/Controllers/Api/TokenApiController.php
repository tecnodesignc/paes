<?php

namespace Modules\Apigpswox\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Apigpswox\Entities\Token;
use Modules\Apigpswox\Http\Requests\CreateTokenRequest;
use Modules\Apigpswox\Http\Requests\UpdateTokenRequest;
use Modules\Apigpswox\Repositories\TokenRepository;
use Modules\Apigpswox\Transformers\TokenTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;

class TokenController extends BaseApiController
{
    /**
     * @var TokenRepository
     */
    private TokenRepository $token;

    public function __construct(TokenRepository $token)
    {
        parent::__construct();

        $this->token = $token;
    }

    /**
    * Get listing of the resource
    *
    * @return JsonResponse
    */
    public function index(Request $request): JsonResponse
    {
        try {

          $params = $this->getParamsRequest($request);

          tokens = $this->token->getItemsBy($params);

          $response = ["data" => TokenTransformer::collection($tokens)];

          $params->page ? $response["meta"] = ["page" => $this->pageTransformer($tokens)] : false;

        } catch (Exception $e) {

            Log::Error($e);
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

          $token = $this->token->getItem($params);

          if(!$token) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('apigpswox::tokens.title.tokens')]),404);

          $response = ["data" => new TokenTransformer($token)];

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
    public function store(Request $request): JsonResponse
    {
        \DB::beginTransaction();

        try {

            $data = $request->input('attributes') ?? [];

            $this->validateRequestApi(new CreateTokenRequest($data));

            $token = $this->token->create($data);

            $response = ["data" => new TokenTransformer($token)];

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
    public function update(string $criteria, Request $request): JsonResponse
    {
        \DB::beginTransaction();

        try {

            $data = $request->input('attributes') ?? [];

            $this->validateRequestApi(new UpdateTokenRequest($data));

            $params = $this->getParamsRequest($request);

            $token = $this->token->getItem($params);

            if(!$token) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('apigpswox::tokens.title.tokens')]),404);

            $this->token->update($token, $request->all());

            $response = ["data" => trans('core::core.messages.resource updated', ['name' => trans('apigpswox::tokens.title.tokens')];

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
    public function destroy(string $criteria, Request $request): JsonResponse
    {
        \DB::beginTransaction();

        try {

            $params = $this->getParamsRequest($request);

            $token = $this->token->getItem($params);

            if(!$token) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('apigpswox::tokens.title.tokens')]),404);

            $this->token->destroy($token);

            $response = ["data" => trans('core::core.messages.resource deleted', ['name' => trans('apigpswox::tokens.title.tokens')];

            \DB::commit();

        } catch (Exception $e) {

            Log::Error($e);
            \DB::rollback();
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];

        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);

    }
}
