<?php

namespace Modules\Sass\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Sass\Entities\Company;
use Modules\Sass\Http\Requests\CreateCompanyRequest;
use Modules\Sass\Http\Requests\UpdateCompanyRequest;
use Modules\Sass\Repositories\CompanyRepository;
use Modules\Sass\Transformers\CompanyTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;

class CompanyApiController extends BaseApiController
{
    /**
     * @var CompanyRepository
     */
    private CompanyRepository $company;

    public function __construct(CompanyRepository $company)
    {
        parent::__construct();

        $this->company = $company;
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

          $companies = $this->company->getItemsBy($params);

          $response = ["data" => CompanyTransformer::collection($companies)];

          $params->page ? $response["meta"] = ["page" => $this->pageTransformer($companies)] : false;

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

          $company = $this->company->getItem($params);

          if(!$company) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('sass::companies.title.companies')]),404);

          $response = ["data" => new CompanyTransformer($company)];

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

            $this->validateRequestApi(new CreateCompanyRequest($data));

            $company = $this->company->create($data);

            $response = ["data" => new CompanyTransformer($company)];

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

            $this->validateRequestApi(new UpdateCompanyRequest($data));

            $params = $this->getParamsRequest($request);

            $company = $this->company->getItem($params);

            if(!$company) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('sass::companies.title.companies')]),404);

            $this->company->update($company, $request->all());

            $response = ["data" => trans('core::core.messages.resource updated', ['name' => trans('sass::companies.title.companies')])];

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

            $company = $this->company->getItem($params);

            if(!$company) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('sass::companies.title.companies')]),404);

            $this->company->destroy($company);

            $response = ["data" => trans('core::core.messages.resource deleted', ['name' => trans('sass::companies.title.companies')])];

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
