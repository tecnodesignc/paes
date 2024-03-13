@extends('layouts.master')
@section('title')
    Crear Fila para formulario {{$form->name}}
@endsection

@section('css')
    {!! Theme::style('libs/sweetalert2/sweetalert2.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/dropzone/dropzone.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/alertifyjs/alertifyjs.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/@simonwep/@simonwep.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/choices.js/choices.js.min.css?v='.config('app.version')) !!}
    <link href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" rel="stylesheet">
    {!! Theme::style('libs/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css?v='.config('app.version')) !!}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Formularios
        @endslot
        @slot('title')
            Crear Fila
        @endslot
    @endcomponent
    {!! Form::open(['route' => ['dynamicform.field.store',[$form->id]], 'method' => 'post', 'class'=>'needs-validation']) !!}
   <input type="hidden" name="form_id" value="{{$form->id}}">
    <div class="row">
        <div class="col-lg-12">
            <div id="addproduct-accordion" class="custom-accordion">
                <div class="card">
                    <a href="#addproduct-productinfo-collapse" class="text-dark" data-bs-toggle="collapse"
                       aria-expanded="true" aria-controls="addproduct-productinfo-collapse">
                        <div class="p-4">

                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm">
                                        <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                            01
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="font-size-16 mb-1"> Crear fila para {{$form->name ?? "Formulario"}}</h5>
                                    <p class="text-muted text-truncate mb-0">Complete toda la información a
                                        continuación</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                </div>
                            </div>

                        </div>
                    </a>
                    <div id="addproduct-productinfo-collapse" class="collapse show"
                         data-bs-parent="#addproduct-accordion">
                        <div class="p-4 border-top">
                            <div class="row d-flex justify-content-center align-items-center">
                                <div class="col-lg-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3 {{ $errors->has('label') ? 'was-validated' : '' }}">
                                                <label class="form-label" for="label"><strong>*</strong>Etiqueta</label>
                                                <input id="label" name="label" placeholder="Agrega la etiqueta al campo" type="text" value="{{ old('label') }}" class="form-control" required>
                                                {!! $errors->first('label', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has('order') ? 'was-validated' : '' }}">
                                                <label class="form-label" for="caption">Posición</label>
                                                <input id="order" placeholder="Agrega orden" name="order" type="number" value="{{ old('order',$lastOrder+1) }}" class="form-control" readonly>
                                                {!! $errors->first('order', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><strong>*</strong>Tipo de Campo</label>
                                                <select class="form-select shadow-none btnseleccion" name="type" id="type" required style="width: 100%;">
                                                    <option value="12">Título</option>
                                                    <option value="13">Párrafo</option>
                                                    <option value="0">Input de Texto</option>
                                                    <option value="1">Area de Texto</option>
                                                    <option value="2">Input de Numero</option>
                                                    <option value="3">Input de Teléfono</option>
                                                    <option value="4">Input de Email</option>
                                                    <option value="14">Input de Fecha</option>
                                                    <option value="15">Input de Hora</option>
                                                    <option value="5">Si/No/No Aplica</option>
                                                    <option value="10">Opciones</option>
                                                    <option value="11">Estados</option>
                                                    <option value="6">Selector</option>
                                                    <option value="7">Selector Multiple</option>
                                                    <option value="8">Imagen</option>
                                                    <option value="9">Firma</option>
                                                </select>
                                            </div>

                                            <div id="limits" class="mb-3" style="display: none;">
                                                <label for="selectable" class="form-label font-size-13 text-muted"><strong>*</strong>Opciones del Campo</label>
                                                <input class="form-control" id="selectable" name="selectable[]" type="text" value="{{ old('selectable') }}" placeholder="Agregar Opciones">
                                                {!! $errors->first('selectable', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>

                                            <div id="divfinding" class="mb-3 {{ $errors->has('finding') ? 'was-validated' : '' }}" style="display: none;">
                                                <label class="form-label" for="caption" title="Ingrese una posición">Hallazgo</label>
                                                <input id="finding" placeholder="Contará finding en la posición" name="finding" type="number" value="{{ old('finding') }}" class="form-control" min="1">
                                                {!! $errors->first('finding', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <hr>
                                            <div class="checkbox {{ $errors->has('required') ? 'was-validated' : '' }}">
                                                <label for="required">
                                                    <input id="required" name="required" type="checkbox" class="form-check-input" {{ old('required') ? 'checked' : '' }}  checked value="1">
                                                    Campo requerido?
                                                    {!! $errors->first('required', '<div class="invalid-feedback">:message</div>') !!}
                                                </label>
                                            </div>

                                        </div>
                                        <div class="card-footer">
                                            <div class="row mb-4">
                                                <div class="col text-end">
                                                    <a href="{{route('dynamicform.form.edit',[$form->id])}}" class="btn btn-danger"> <i class="bx bx-x me-1"></i>
                                                        Cancelar </a>
                                                    <button type="submit" class="btn btn-success"><i class=" bx bx-file me-1"></i> Guardar</button>
                                                </div> <!-- end col -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {!! Form::close() !!}

@endsection
@section('script')
    <script src="{{ Theme::url('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{Theme::url('js/app.js')}}"></script>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{Theme::url('libs/choices.js/choices.js.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="application/javascript">
        $(document).ready(function() {
            $('.btnseleccion').select2();
        });
        document.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                // Cancela el envío del formulario
                event.preventDefault();
            }
        });
        document.addEventListener("DOMContentLoaded", function (event) {
            // Aquí comienza el nuevo código
            let token = "{{$currentUser->getFirstApiKey() }}";
            var textUniqueVals = new Choices('#selectable', {
                paste: false,
                duplicateItemsAllowed: false,
                editItems: true,
            });

            // Función para actualizar la visibilidad y opciones del campo de opciones del campo
            function updateOptionsFieldVisibilityAndOptions() {
                var typeValue = $('#type').val();
                if (typeValue ==='5') {
                    textUniqueVals.removeActiveItems();
                    textUniqueVals.setValue(['SI','NO','NO APLICA'])
                    $('#divfinding').css('display', 'block');
                    $('#limits').css('display', 'block');
                }
                else if (typeValue === '6' || typeValue === '7' ) {
                    // Mostrar las opciones específicas cuando se selecciona 'Estados'
                    $('#limits').css('display', 'block');
                    $('#divfinding').css('display', 'none');
                }
                else if(typeValue === '10' || typeValue === '11'){
                       // Mostrar las opciones específicas cuando se selecciona 'Estados'
                       if (typeValue === '11') {
                            textUniqueVals.removeActiveItems();
                            textUniqueVals.setValue(['BUENO','REGULAR','MALO','NO APLICA', 'NO TIENE'])
                        }
                    $('#limits').css('display', 'block');
                    $('#divfinding').css('display', 'block');
                }
                else {
                    $('#limits').css('display', 'none');
                    $('#divfinding').css('display', 'none');
                }
            }

            // Llamada a la función para actualizar la visibilidad y opciones del campo cuando se carga la página
            updateOptionsFieldVisibilityAndOptions();

            // Escuchar cambios en el campo de selección de tipo
            $('#type').change(function () {
                updateOptionsFieldVisibilityAndOptions();
            });


            // Escuchar el envío del formulario
            $('form').submit(function(event) {
                // Verificar si el campo de selección tiene un valor seleccionado
                if ($('#selectable').val() === null) {
                    // Mostrar un mensaje de error o realizar alguna acción
                    alert('Por favor selecciona una opción');
                    // Detener el envío del formulario
                    event.preventDefault();
                }
            });
        });
    </script>

    <style>
        .fade:not(.show) {
            opacity: 1;
        }
    </style>
@endsection

