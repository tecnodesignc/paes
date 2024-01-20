<?php

namespace Modules\Transport\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Transport\Entities\Document;
use Modules\Transport\Http\Requests\CreateDocumentRequest;
use Modules\Transport\Http\Requests\UpdateDocumentRequest;
use Modules\Transport\Repositories\DocumentRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class DocumentController extends AdminBaseController
{
    /**
     * @var DocumentRepository
     */
    private $document;

    public function __construct(DocumentRepository $document)
    {
        parent::__construct();

        $this->document = $document;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$documents = $this->document->all();

        return view('transport::admin.documents.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('transport::admin.documents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateDocumentRequest $request
     * @return Response
     */
    public function store(CreateDocumentRequest $request)
    {
        $this->document->create($request->all());

        return redirect()->route('admin.transport.document.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('transport::documents.title.documents')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Document $document
     * @return Response
     */
    public function edit(Document $document)
    {
        return view('transport::admin.documents.edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Document $document
     * @param  UpdateDocumentRequest $request
     * @return Response
     */
    public function update(Document $document, UpdateDocumentRequest $request)
    {
        $this->document->update($document, $request->all());

        return redirect()->route('admin.transport.document.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('transport::documents.title.documents')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Document $document
     * @return Response
     */
    public function destroy(Document $document)
    {
        $this->document->destroy($document);

        return redirect()->route('admin.transport.document.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('transport::documents.title.documents')]));
    }
}
