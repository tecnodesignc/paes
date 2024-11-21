<?php

namespace Modules\Dynamicform\Http\Controllers;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Dynamicform\Entities\Field;
use Modules\Dynamicform\Http\Requests\CreateFieldRequest;
use Modules\Dynamicform\Http\Requests\UpdateFieldRequest;
use Modules\Dynamicform\Repositories\FieldRepository;
use Modules\Dynamicform\Imports\ImportFields;
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
        return view('dynamicform::public.field.create',compact('form', 'lastOrder'));
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
        return view('dynamicform::public.field.edit', compact('field', 'form'));
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
        $this->field->update($field, $request->all());

        return redirect()->route('dynamicform.form.edit', $field->form_id)->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('dynamicfield::fields.title.fields')]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $formId
     * @param  Field $field
     * @param  Request $request
     * @return JSON
     */

    public function orden($formId, Field $field, Request $request, $ordenValue)
    {
        // Verificar si el valor de orden es válido (1 para aumentar, -1 para disminuir)
        if (isset($ordenValue) && in_array($ordenValue, [1, -1])) {
            // Obtener todos los campos ordenados por su orden actual
            $params = json_decode(json_encode([
                'filter' => [
                    'form_id' => $formId->id,
                    'order'=>['field'=>'order','way'=>'desc']
                    ],
                'include' => ['*'], 'page' => 1, 'take' => 10000
            ]));

            $fiels = $this->field->getItemsBy($params);

            // Encontrar el índice del campo actual en la colección de todos los campos
            $index = $fiels->search(function ($item) use ($field) {
                return $item->id == $field->id;
            });

            // Verificar si el campo actual está en la colección de campos
            if ($index !== false) {
                // Calcular el nuevo índice del campo después de moverlo hacia arriba o hacia abajo
                $newIndex = $index + $ordenValue;

                // Asegurarse de que el nuevo índice esté dentro de los límites de la colección
                if ($newIndex >= 0 && $newIndex < $fiels->count()) {
                    // Intercambiar los valores de orden del campo actual y el campo en el nuevo índice
                    $currentOrder = $field->order;
                    $field->order = $fiels[$newIndex]->order;
                    $field->save();

                    $fiels[$newIndex]->order = $currentOrder;
                    $fiels[$newIndex]->save();
                }
            }
        }

        return response()->json(['message' => trans('core::core.messages.resource updated', ['name' => trans('dynamicfield::fields.title.fields')])]);
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function import($form_id, Request $request)
    {
        try {
            \DB::beginTransaction();
            if ($request->hasFile('excel_file')) {
                $path = $request->file('excel_file');
                $import = new ImportFields($form_id->id);
                Excel::import($import, $path);
                // Obtener los resultados del importador
                $response = $import->getResults();
                \DB::commit();
            }

            return response()->json([
                'message' => 'Excel cargado correctamente',
                'data' => $response,
            ], 200);
        } catch (Exception $e) {
            \DB::rollback();
            \Log::error($e);

            // Devolver el error como una respuesta JSON en caso de excepción
            $status = $e->getCode();
            $response = ["errors" => $e->getMessage()];
            return response()->json($response, $status ?? 200);
        }
    }

}
