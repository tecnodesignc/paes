<?php

namespace Modules\Dynamicform\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Dynamicform\Entities\Form;
use Modules\Dynamicform\Http\Requests\CreateFormRequest;
use Modules\Dynamicform\Http\Requests\UpdateFormRequest;
use Modules\Dynamicform\Repositories\FieldRepository;
use Modules\Dynamicform\Repositories\FormRepository;
use Illuminate\Http\Request;
class FormController extends AdminBaseController
{
    private FormRepository $form;
    private FieldRepository $field;

  
    public function __construct(FormRepository $form, FieldRepository $field)
    {
        parent::__construct();
        $this->form=$form;
        $this->field=$field;

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
     * Show the form for editing the specified resource.
     *
     * @param  Form $form
     * @return Response
     */
    public function show(Form $form) :Factory|View
    {   

        $params = json_decode(json_encode([
            'filter' => [
                'form_id' => $form->id,
                'order'=>['field'=>'order','way'=>'asc']
                ], 
            'include' => ['*'], 'page' => 1, 'take' => 10000
        ]));

        $datos = $this->field->getItemsBy($params);
   
        $datos = $datos->items();
        // dd($datos[0]->selectable[0]);
                // Valor original
        // $value = 'BUENO,REGULAR, MALO,NO APLICA,NO TIENE';

        // Convertir la cadena en un array usando la coma como delimitador
        // $options = explode(',', $value);
        // $options = json_decode(json_encode($datos->items(), true));
        // foreach ($options as $key => $value) {
         
        //     foreach ($value->selectable as $value) {
        //         dd(  $split = explode(',', $value));
        //     }
        // }
        // dd($options);
        return view('modules.dynamic-form.forms.show', compact('datos'));
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
    public function edit(Form $form) :Factory|View
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
        $form->update(['active' => 0]);
        return redirect()->route('dynamicform.form.index')->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('dynamicform::forms.title.forms')]));
    }
}
