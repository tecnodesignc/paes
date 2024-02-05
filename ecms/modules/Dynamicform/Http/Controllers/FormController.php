<?php

namespace Modules\Dynamicform\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Dynamicform\Entities\Form;
use Modules\Dynamicform\Http\Requests\CreateFormRequest;
use Modules\Dynamicform\Http\Requests\UpdateFormRequest;
use Modules\Dynamicform\Repositories\FormRepository;
use Illuminate\Http\Request;
class FormController extends AdminBaseController
{
    private FormRepository $form;
  
    public function __construct(FormRepository $form)
    {
        parent::__construct();
        $this->form=$form;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index():Application|Factory|View
    {

        return view('modules.dynamic-form.forms.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create():Application|Factory|View
    {
        return view('modules.dynamic-form.forms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateFormRequest $request
     * @return Response
     */
    public function store(CreateFormRequest $request)
    {
        $form = $this->form->create($request->all());

        // Obtener el ID del formulario recién creado
        $formId = $form->id;

        // Redirigir al usuario a la página de edición del formulario recién creado
        return redirect()->route('dynamicform.form.edit', ['form' => $formId])
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('dynamicform::forms.title.forms')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Form $form
     * @return Response
     */
    public function edit(Form $form)
    {
        return view('modules.dynamic-form.forms.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Form $form
     * @param  UpdateFormRequest $request
     * @return Response
     */
    public function update(Form $form, UpdateFormRequest $request)
    {
        // $this->form->update($form, $request->all());

        return redirect()->route('dynamicform.form.index')->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('dynamicform::forms.title.forms')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Form $form
     * @return Response
     */
    public function destroy(Form $form)
    {
        // $this->form->destroy($form);
        $form->update(['active' => 0]);
        return redirect()->route('dynamicform.form.index')->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('dynamicform::forms.title.forms')]));
    }
}
