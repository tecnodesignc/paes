@extends('layouts.master')
@section('title')
    Crear Formulario de Preoperativo
@endsection

@section('css')
    {!! Theme::style('libs/sweetalert2/sweetalert2.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/dropzone/dropzone.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/alertifyjs/alertifyjs.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/@simonwep/@simonwep.min.css?v='.config('app.version')) !!}
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
            Crear Formulario
        @endslot
    @endcomponent
    {!! Form::open(['route' => ['dynamicform.form.store'], 'method' => 'post', 'class'=>'needs-validation']) !!}
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
                                    <h5 class="font-size-16 mb-1"> Crear Formulario de Preoperativo</h5>
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
                                            <div class="mb-3 {{ $errors->has("name") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="name">Nombre</label>
                                                <input id="name" name="name"
                                                       placeholder="Agrega Nombre del Formulario"
                                                       type="text"
                                                       value="{{old('name')}}"
                                                       class="form-control"
                                                       required>
                                                {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("caption") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="caption">Descripción</label>
                                                <textarea id="caption"
                                                          name="caption"
                                                          placeholder="Agrega Descripción Corta"
                                                          rows="3"
                                                          class="form-control" required>{{old('caption')}}</textarea>
                                                {!! $errors->first('caption', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>

                                            <div class="mb-3 {{ $errors->has("companies") ? ' was-validated' : '' }}" style="{{$currentUser->hasAccess('sass.companies.indexall') || (companies()->count() > 0)?"display:block":"display:none"}}">
                                                <label for="companies" class="form-label font-size-13 text-muted">Empresas Asignadas</label>
                                                <select required name="companies[]" id="companies" class="form-control companies" multiple="multiple" >
                                                    {{-- por defecto se seleccionará la empresa que tiene en la variable de sesión, verifica si esa empresa está presente en la variable de sesión y, en ese caso, agregar el atributo selected al elemento <option> --}}
                                                    @foreach(companies() as $company)
                                                        <option value="{{$company->id}}" {{ (in_array($company->id, old('companies', [])) || $company->id == session('company')) ? 'selected' : '' }}>
                                                            {{$company->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('route_id', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>

                                            <div class="mb-3 {{ $errors->has("company_create") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="company_create">Empresa Admin</label>
                                                <select class="form-control company_create" data-trigger name="company_create"
                                                        id="company_create" required>
                                                    @foreach(companies() as $company)
                                                        <option value="{{$company->id}}" {{$company->id == old('company_create', $form->company_create ?? null) ? 'selected' : ''}} >{{$company->name}}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('route_id', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3 {{ $errors->has("color") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="color">Color</label>
                                                <input type="hidden" name="color" id="color" value="">
                                                <div class="color-picker"></div>
                                                {!! $errors->first('color', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("icon") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="icon">Icono</label>
                                                <div class="input-group input-group-lg">
                                                    <input id="icon" name="icon"
                                                           placeholder="iconos"
                                                           type="hidden"
                                                           value="{{old('icon','fas fa-car')}}"
                                                           class="form-control"
                                                           data-placement="bottomRight"

                                                    >
                                                    <span class="input-group-addon input-group-text"></span>
                                                </div>
                                                {!! $errors->first('color', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="checkbox{{ $errors->has('active') ? ' was-validated' : '' }}">
                                                <label for="active">
                                                    <input id="active"
                                                           name="active"
                                                           type="checkbox"
                                                           class="form-check-input"
                                                           checked
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
            <a href="{{route('dynamicform.form.index')}}" class="btn btn-danger"> <i class="bx bx-x me-1"></i>
                Cancelar </a>
            <button type="submit" class="btn btn-success"><i class=" bx bx-file me-1"></i> Guardar</button>
        </div> <!-- end col -->
    </div>
    {!! Form::close() !!}

@endsection
@section('script')
    <script src="{{ Theme::url('libs/@simonwep/@simonwep.min.js') }}"></script>
    <script src="{{ Theme::url('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{Theme::url('js/app.js')}}"></script>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ Theme::url('libs/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="application/javascript" async>
        (function () {
            'use strict';
            let token = "{{$currentUser->getFirstApiKey() }}";
            window.addEventListener('load', function () {
                var nanoPickr = Pickr.create({
                    el: '.color-picker',
                    theme: 'nano',
                    default: '#03A9F4',
                    swatches: [
                        'rgba(244, 67, 54, 1)',
                        'rgba(233, 30, 99, 1)',
                        'rgba(156, 39, 176,1)',
                        'rgba(103, 58, 183, 1)',
                        'rgba(63, 81, 181, 1)',
                        'rgba(33, 150, 243, 1)',
                        'rgba(3, 169, 244, 1)'
                    ],
                    defaultRepresentation: 'HEXA',
                    components: {

                        // Main components
                        preview: true,
                        opacity: true,
                        hue: true,

                        // Input / output Options
                        interaction: {
                            hex: true,
                            rgba: false,
                            hsva: false,
                            input: true,
                            clear: true,
                            save: true
                        }
                    }
                });
                nanoPickr.on('save', (color, instance) => {
                    const data= nanoPickr.getSelectedColor().toHEXA().toString(0)
                    $("#color").val(data)
                }).on('init', instance => {
                    const color= nanoPickr.getSelectedColor().toHEXA().toString(0)
                    $("#color").val(color)
                })
                $('#icon').iconpicker({
                    placement: 'bottomRight',
                });
                $('.companies').select2({
                    placeholder: "--Seleccione--",
                    width: '100%'
                });
                $('.company_create').select2({
                    width: '100%'
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

