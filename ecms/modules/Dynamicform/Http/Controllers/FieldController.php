<?php

namespace Modules\Dynamicform\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Dynamicform\Entities\Field;
use Modules\Dynamicform\Http\Requests\CreateFieldRequest;
use Modules\Dynamicform\Http\Requests\UpdateFieldRequest;
use Modules\Dynamicform\Repositories\FieldRepository;
use Modules\Dynamicform\Entities\Form;

class FieldController extends AdminBaseController
{
    private FieldRepository $field;
    public function __construct(FieldRepository $field)
    {
        parent::__construct();
        $this->field=$field;

    }

    /**
     * Show the field for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(Form $form):Application|Factory|View
    {
        $lastOrder = Field::where('form_id', $form->id)->orderByDesc('order')->value('order');
        return view('modules.dynamic-form.field.create',compact('form', 'lastOrder'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateFieldRequest $request
     * @return Response
     */
    public function store(Form $form,CreateFieldRequest $request)
    {
        $this->field->create($request->all());

        return redirect()->route('dynamicform.form.edit',[$form->id])
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('dynamicfield::fields.title.fields')]));
    }

    /**
     * Show the field for editing the specified resource.
     *
     * @param  Field $field
     * @return Response
     */
    public function edit(Form $form, Field $field)
    {
        return view('modules.dynamic-form.field.edit', compact('field', 'form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Field $field
     * @param  UpdateFieldRequest $request
     * @return Response
     */
    public function update($formId, Field $field, UpdateFieldRequest $request)
    {

        // dd($request);
        $this->field->update($field, $request->all());

        return redirect()->route('dynamicform.form.edit', $field->form_id)->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('dynamicfield::fields.title.fields')]));
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  Field $field
     * @return Response
     */
    public function destroy(Field $field)
    {
        $this->field->destroy($field);

        return redirect()->route('admin.dynamicfield.field.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('dynamicfield::fields.title.fields')]));
    }
}
