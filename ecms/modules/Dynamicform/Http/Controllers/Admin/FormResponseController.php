<?php

namespace Modules\Dynamicform\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Dynamicform\Entities\FormResponse;
use Modules\Dynamicform\Http\Requests\CreateFormResponseRequest;
use Modules\Dynamicform\Http\Requests\UpdateFormResponseRequest;
use Modules\Dynamicform\Repositories\FormResponseRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class FormResponseController extends AdminBaseController
{
    /**
     * @var FormResponseRepository
     */
    private $formresponse;

    public function __construct(FormResponseRepository $formresponse)
    {
        parent::__construct();

        $this->formresponse = $formresponse;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('dynamicform::admin.formresponses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('dynamicform::admin.formresponses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateFormResponseRequest $request
     * @return Response
     */
    public function store(CreateFormResponseRequest $request)
    {
        $this->formresponse->create($request->all());

        return redirect()->route('admin.dynamicform.formresponse.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('dynamicform::formresponses.title.formresponses')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  FormResponse $formresponse
     * @return Response
     */
    public function edit(FormResponse $formresponse)
    {
        return view('dynamicform::admin.formresponses.edit', compact('formresponse'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FormResponse $formresponse
     * @param  UpdateFormResponseRequest $request
     * @return Response
     */
    public function update(FormResponse $formresponse, UpdateFormResponseRequest $request)
    {
        $this->formresponse->update($formresponse, $request->all());

        return redirect()->route('admin.dynamicform.formresponse.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('dynamicform::formresponses.title.formresponses')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  FormResponse $formresponse
     * @return Response
     */
    public function destroy(FormResponse $formresponse)
    {
        $this->formresponse->destroy($formresponse);

        return redirect()->route('admin.dynamicform.formresponse.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('dynamicform::formresponses.title.formresponses')]));
    }
}
