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
                                    <h5 class="font-size-16 mb-1"> Crear Fila para formulario {{$form->name}}</h5>
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
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3 {{ $errors->has("label") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="label">Etiqueta</label>
                                                <input id="label" name="label"
                                                       placeholder="Agrega la etiqueta al campo"
                                                       type="text"
                                                       value="{{old('label')}}"
                                                       class="form-control">
                                                {!! $errors->first('label', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("name") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="name">Nombre</label>
                                                <input id="name" name="name"
                                                       placeholder="Agrega Nombre al campo"
                                                       type="text"
                                                       value="{{old('name')}}"
                                                       class="form-control">
                                                {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("order") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="caption">Order</label>
                                                <input id="order"
                                                       placeholder="Agrega orden"
                                                       type="number"
                                                       value="{{old('order')}}"
                                                       class="form-control">
                                                {!! $errors->first('order', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                                <div class="mb-3 {{ $errors->has("selectable") ? ' was-validated' : '' }}">
                                                    <label for="companies" class="form-label font-size-13 text-muted">Opciones del Campo</label>
                                                    <input class="form-control" id="selectable" name="selectable[]" type="text"
                                                           value="" placeholder="Agregar Opciones "
                                                    />
                                                    </select>
                                                    {!! $errors->first('selectable', '<div class="invalid-feedback">:message</div>') !!}
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Tipo de Campo</label>
                                                <select class="form-select shadow-none" name="type"
                                                        id="type" required>
                                                    <option value="0">Texto</option>
                                                    <option value="1">Area de Texto</option>
                                                    <option value="2">Numero</option>
                                                    <option value="3">Teléfono</option>
                                                    <option value="4">Email</option>
                                                    <option value="5">Si/No</option>
                                                    <option value="6">Selector</option>
                                                    <option value="7">Selector Multiple</option>
                                                    <option value="8">Opciones</option>
                                                    <option value="9">Caja de Selección</option>
                                                    <option value="9">Imagen</option>
                                                    <option value="9">Firma</option>
                                                </select>
                                            </div>
                                            <div class="checkbox{{ $errors->has('required') ? ' was-validated' : '' }}">
                                                <label for="required">
                                                    <input id="required"
                                                           name="required"
                                                           type="checkbox"
                                                           class="form-check-input"
                                                           {{ old('required')?'checked':"" }}
                                                           value="1"/>
                                                    Activo
                                                    {!! $errors->first('activated', '<div class="invalid-feedback">:message</div>') !!}
                                                </label>
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
    <div class="row mb-4">
        <div class="col text-end">
            <a href="{{route('dynamicform.form.edit',[$form->id])}}" class="btn btn-danger"> <i class="bx bx-x me-1"></i>
                Cancelar </a>
            <button type="submit" class="btn btn-success"><i class=" bx bx-file me-1"></i> Guardar</button>
        </div> <!-- end col -->
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
    <script type="application/javascript" async>
        (function () {
            'use strict';
            let token = "{{$currentUser->getFirstApiKey() }}";
            window.addEventListener('load', function () {
                // choices-text-unique-values
                var textUniqueVals = new Choices('#selectable', {
                    paste: false,
                    duplicateItemsAllowed: false,
                    editItems: true,
                });
            })
        })();
    </script>
    <style>
        .fade:not(.show) {
            opacity: 1;
        }
    </style>
@endsection

