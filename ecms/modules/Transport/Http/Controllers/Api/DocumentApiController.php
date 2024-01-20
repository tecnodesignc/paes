<?php

namespace Modules\Transport\Http\Controllers\Api;

use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Media\Helpers\FileHelper;
use Modules\Transport\Entities\Document;
use Modules\Transport\Http\Requests\CreateDocumentRequest;
use Modules\Transport\Http\Requests\UpdateDocumentRequest;
use Modules\Transport\Repositories\DocumentRepository;
use Modules\Transport\Transformers\DocumentTransformer;
use Illuminate\Routing\Controller;

class DocumentApiController extends Controller
{
    /**
     * @var DocumentRepository
     */
    private DocumentRepository $document;

    /**
     * @var Factory
     */
    private Factory $filesystem;

    public function __construct(DocumentRepository $document, Factory $filesystem)
    {

        $this->document = $document;
        $this->filesystem = $filesystem;
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
            $includes=explode(',',$request->input('include'));

            $parameters=json_decode(json_encode(['filter'=>['search'=>$request->input('search'),'documentable_id'=>$request->input('documentable_id'),'documentable_type'=>$request->input('documentable_type')],'include'=>$includes,'page'=>$request->input('page'),'take'=>$request->input('limit')]));

            $documents = $this->document->getItemsBy($parameters);

            $response = ["data" => DocumentTransformer::collection($documents)];

            $response["meta"] = ["page" => $this->pageTransformer($documents)];

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
    public function show(Document $document): JsonResponse
    {
        try {

            $response = ["data" => new DocumentTransformer($document)];

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
     * @param CreateDocumentRequest $request
     * @return JsonResponse
     */
    public function store(CreateDocumentRequest $request): JsonResponse
    {
        \DB::beginTransaction();

        try {
            $file = $request->file('file');
            $extension = $file->getClientMimeType();
            $documentable_id = $request->input('documentable_id');
            $name = $request->input('name');
            $expiration_date = $request->input('expiration_date');
            $amount = $request->input('amount');
            $alert = $request->input('alert');
            $documentable_type=$request->input('documentable_type');
            //return [$contentType];

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
            $path = '/assets/documents/' . $documentable_id . '/' . $fileName;
            $stream = fopen($file->getRealPath(), 'r+');
            $this->filesystem->disk(config('encore.media.config.filesystem'))->writeStream($path, $stream, [
                'visibility' => 'public',
                'mimetype' => $file->getClientMimeType(),
            ]);

            $data = [
                'documentable_id' => $documentable_id,
                'documentable_type'=>$documentable_type,
                'name' => $name??$fileName,
                'extension' => $extension,
                'route' => $path,
                'expiration_date' => $expiration_date,
                'amount' => $amount,
                'alert' => $alert,
            ];


            $document = $this->document->create($data);

            $response = ["data" => new DocumentTransformer($document)];

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
     * @param Document $document
     * @param UpdateDocumentRequest $request
     * @return JsonResponse
     */
    public function update(Document $document, UpdateDocumentRequest $request): JsonResponse
    {
        \DB::beginTransaction();

        try {

            $this->document->update($document, $request->all());

            $response = ["data" => trans('core::core.messages.resource updated', ['name' => trans('transport::documents.title.documents')])];

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
    public function destroy(Document $document, Request $request): JsonResponse
    {
        \DB::beginTransaction();

        try {

            $this->document->destroy($document);

            $response = ["data" => trans('core::core.messages.resource deleted', ['name' => trans('transport::documents.title.documents')])];

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
