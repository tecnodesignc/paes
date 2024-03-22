<?php

namespace Modules\Dynamicform\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Mockery\CountValidator\Exception;
use Modules\Dynamicform\Entities\FormResponse;
use Modules\Dynamicform\Http\Requests\CreateFormResponseRequest;
use Modules\Dynamicform\Http\Requests\UpdateFormResponseRequest;
use Modules\Dynamicform\Repositories\FormResponseRepository;
use Modules\Dynamicform\Transformers\FormResponseTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Media\Helpers\FileHelper;
use Modules\Transport\Transformers\VehiclesTransformer;
use Modules\User\Contracts\Authentication;

use Modules\Transport\Repositories\VehiclesRepository;

class FormResponseApiController extends Controller
{
    /**
     * @var FormResponseRepository
     */
    private FormResponseRepository $formresponse;

    /**
     * @var VehiclesRepository
     */
    private VehiclesRepository $vehicle;


    /**
     * @var Factory
     */
    private Factory $filesystem;
    public function __construct(FormResponseRepository $formresponse, Factory $filesystem, VehiclesRepository $vehicle)
    {
        $this->formresponse = $formresponse;
        $this->auth = app(Authentication::class);
        $this->filesystem = $filesystem;
        $this->vehicle=$vehicle;

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

            $params = json_decode(json_encode(['filter' =>
            [
                'search' => $request->input('search'),
                'companies' => $request->input('companies'),
                'form_id' => $request->input('form_id')
            ],
            'include' => $includes, 'page' => $request->input('page'), 'take' => $request->input('limit')]));

            $formresponses = $this->formresponse->getItemsBy($params);
            // dd($includes, $params, $formresponses);

            $response = ["data" => FormResponseTransformer::collection($formresponses)];

            $response["meta"] = ["page" => $this->pageTransformer($formresponses)];

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

            $formresponse = $this->formresponse->getItem($params);

            if (!$formresponse) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('dynamicform::formresponses.title.formresponses')]), 404);

            $response = ["data" => new FormResponseTransformer($formresponse)];

        } catch (Exception $e) {

            \Log::Error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];

        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }


    public function uploadImage(Request $request)
    {
        try {

            $file = $request->file('file');
            $extension = $file->getClientMimeType();

            if ($extension == 'image/jpeg') {
                $image = \Image::make($request->file('file'));

                $imageSize = (object)config('encore.media.config.imageSize');
                $watermark = (object)config('encore.media.config.watermark');

                $image->resize($imageSize->width, $imageSize->height, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                if ($watermark->activated) {
                    $image->insert(url($watermark->url), $watermark->position, $watermark->x, $watermark->y);
                }
                $filePath = $file->getPathName();
                \File::put($filePath, $image->stream('jpg', $imageSize->quality));
            }
            $fileName = FileHelper::slug($file->getClientOriginalName());
            $user = Auth::user();
            $path = '/assets/forms/images/' . $user->id . '/' . $fileName;
            $stream = fopen($file->getRealPath(), 'r+');
            $this->filesystem->disk(config('encore.media.config.filesystem'))->writeStream($path, $stream, [
                'visibility' => 'public',
                'mimetype' => $file->getClientMimeType(),
            ]);

            $response = ["data" => ['url' => $path]];

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
    public function store(CreateFormResponseRequest $request): JsonResponse
    {
        \DB::beginTransaction();

        try {

            $data = $request->all();
            $formresponse = $this->formresponse->create($data);

            $response = ["data" => new FormResponseTransformer($formresponse)];

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

            $this->validateRequestApi(new UpdateFormResponseRequest($data));

            $params = $this->getParamsRequest($request);

            $formresponse = $this->formresponse->getItem($params);

            if (!$formresponse) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('dynamicform::formresponses.title.formresponses')]), 404);

            $this->formresponse->update($formresponse, $request->all());

            $response = ["data" => trans('core::core.messages.resource updated', ['name' => trans('dynamicform::formresponses.title.formresponses')])];

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

            $formresponse = $this->formresponse->getItem($params);

            if (!$formresponse) throw new Exception(trans('core::core.exceptions.item no found', ['item' => trans('dynamicform::formresponses.title.formresponses')]), 404);

            $this->formresponse->destroy($formresponse);

            $response = ["data" => trans('core::core.messages.resource deleted', ['name' => trans('dynamicform::formresponses.title.formresponses')])];

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
     * Get listing of the resource
     *
     * @return JsonResponse
     */
    public function vehicles($companyId): JsonResponse
    {
        try {

            $response=$this->vehicle->all()->where('company_id',$companyId)->pluck('plate','plate');

        } catch (Exception $e) {

            \Log::Error($e);
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
