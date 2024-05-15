@extends('layouts.master')
@section('title')
    Editar Vehículo
@endsection

@section('css')
    {!! Theme::style('libs/sweetalert2/sweetalert2.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/dropzone/dropzone.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/alertifyjs/alertifyjs.min.css?v='.config('app.version')) !!}
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Vehículos
        @endslot
        @slot('title')
            Editar Vehículo {{$vehicle->plate}}
        @endslot
    @endcomponent
    <div id="addproduct-accordion" class="custom-accordion">
        {!! Form::open(['route' => ['transport.vehicles.update',$vehicle->id], 'method' => 'put']) !!}
        <div class="row">
            <div class="col-lg-12">
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
                                    <h5 class="font-size-16 mb-1"> Editar Vehículos</h5>
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
                                            <div class="mb-3 {{ $errors->has("plate") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="guia">Placa</label>
                                                <input id="plate" name="plate"
                                                       placeholder="Agrega Placa"
                                                       type="text"
                                                       value="{{old('plate',$vehicle->plate)}}"
                                                       class="form-control">
                                                {!! $errors->first('plate', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("brand") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="guia">Marca</label>
                                                <input id="brand" name="brand" placeholder="Agrega Marca"
                                                       type="text"
                                                       value="{{old('brand',$vehicle->brand)}}"
                                                       class="form-control">
                                                {!! $errors->first('brand', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("model") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="model">Modelo</label>
                                                <input id="model" name="model" placeholder="Agrega Modelo"
                                                       type="text"
                                                       value="{{old('model',$vehicle->model)}}"
                                                       class="form-control">
                                                {!! $errors->first('model', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("class") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="class">Clase</label>
                                                <input id="class" name="class" placeholder="Agrega Clase"
                                                       type="text"
                                                       value="{{old('class',$vehicle->class)}}"
                                                       class="form-control">
                                                {!! $errors->first('class', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("reference") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="reference">Referencia</label>
                                                <input id="reference" name="reference" placeholder="Agrega Referencia"
                                                       type="text"
                                                       value="{{old('reference', $vehicle->reference)}}"
                                                       class="form-control">
                                                {!! $errors->first('reference', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("doors") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="doors">Numero de Puertas</label>
                                                <input id="doors" name="doors" placeholder="Agrega Puertas"
                                                       type="number"
                                                       value="{{old('doors', $vehicle->doors)}}"
                                                       class="form-control"
                                                       required>
                                                {!! $errors->first('doors', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("capacity") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="capacity">Capacidad</label>
                                                <input id="capacity" name="capacity" placeholder="Agrega Capacidad"
                                                       type="number"
                                                       value="{{old('capacity',$vehicle->capacity)}}"
                                                       class="form-control">
                                                {!! $errors->first('capacity', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            @if($currentUser->hasAccess('sass.companies.indexall') || (companies()->count() > 0 && empty(company()->id)))
                                                <div
                                                    class="mb-3 {{ $errors->has("company_id") ? ' was-validated' : '' }}">
                                                    <label class="form-label" for="company_id">Compañia</label>
                                                    <select class="form-control" data-trigger name="company_id"
                                                            id="company_id">
                                                        <option value="">Seleccione Compañia</option>
                                                        @foreach(companies() as $company)
                                                            <option
                                                                value="{{$company->id}}" {{$company->id == old('company_id',$vehicle->company_id) ? 'selected' : ''}} >{{$company->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    {!! $errors->first('route_id', '<div class="invalid-feedback">:message</div>') !!}
                                                </div>
                                            @else
                                                <input type="hidden" name="company_id" id="company_id"
                                                       value="{{$vehicle->company_id}}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3 {{ $errors->has("type") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="type">Tipo de Vehiculo</label>
                                                <select class="form-control" data-trigger name="type"
                                                        id="type">
                                                    <option value="">Seleccione Tipo de Vehiculo</option>
                                                    @foreach($types as $i=>$type)
                                                        <option
                                                            value="{{$i}}" {{$i == old('type',$vehicle->type) ? 'selected' : ''}} >{{$type}}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('route_id', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("millage") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="millage">Kilometraje</label>
                                                <input id="millage" name="millage"
                                                       placeholder="Agrega Kilometraje"
                                                       type="number"
                                                       value="{{old('millage',$vehicle->millage)}}"
                                                       class="form-control">
                                                {!! $errors->first('millage', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("box_type") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="box_type">Tipo de Caja</label>
                                                <select class="form-control" data-trigger name="box_type"
                                                        id="box_type">
                                                    <option value="">Seleccione Tipo de Caja</option>
                                                    @foreach($box_types as $i=>$box_type)
                                                        <option
                                                            value="{{$i}}" {{$i == old('box_type',$vehicle->box_type) ? 'selected' : ''}} >{{$box_type}}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('box_type', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div
                                                class="mb-3 {{ $errors->has("transmission_type") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="transmission_type">Tipo de
                                                    Transmision</label>
                                                <select class="form-control" data-trigger name="transmission_type"
                                                        id="transmission_type">
                                                    <option value="">Seleccione Tipo de Transmision</option>
                                                    @foreach($transmission_types as $i=>$transmission_type)
                                                        <option
                                                            value="{{$i}}" {{$i == old('transmission_type',$vehicle->transmission_type) ? 'selected' : ''}} >{{$transmission_type}}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('transmission_type', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div
                                                class="mb-3 {{ $errors->has("property_card") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="property_card">Numero Tarjeta de
                                                    Propiedad</label>
                                                <input id="property_card" name="property_card"
                                                       placeholder="Agrega Tarjeta de Propiedad"
                                                       type="text"
                                                       value="{{old('property_card',$vehicle->property_card)}}"
                                                       class="form-control">
                                                {!! $errors->first('property_card', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3 ">
                                                    <div
                                                        class="checkbox{{ $errors->has('shielding') ? ' was-validated' : '' }}">
                                                        <label for="shielding">
                                                            <input id="shielding"
                                                                   name="shielding"
                                                                   type="checkbox"
                                                                   class="form-check-input"
                                                                   {{ old('shielding',$vehicle->shielding)?'checked':'' }}
                                                                   value="1"/>
                                                            Blindaje
                                                            {!! $errors->first('shielding', '<div class="invalid-feedback">:message</div>') !!}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(!empty($vehicle->main_image->path))
                                                <div class="row mb-3">
                                                    <div class="col-md-3 ">
                                                        <img class="rounded me-2" width="200"
                                                             src="{{$vehicle->main_image->path}}" alt=""
                                                             data-holder-rendered="true">
                                                    </div>
                                                </div>
                                            @else
                                                <div class="dropzone" id="mainImage">
                                                    <input type="hidden" id="medias_single"
                                                           name="medias_single[mainimage]"
                                                           value="">
                                                    <div class="fallback">
                                                        <input name="file" type="file">
                                                    </div>
                                                    <div class="dz-message needsclick">
                                                        <div class="mb-3">
                                                            <i class="display-4 text-muted mdi mdi-cloud-upload"></i>
                                                        </div>
                                                        <h4>Haga clic para agregar imagen.</h4>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="yellow_machinery" style="display: none">
            <div class="col-lg-12">
                <div class="card">
                    <a href="#addyellow-alert-collapse" class="text-dark collapsed" data-bs-toggle="collapse"
                       aria-haspopup="true" aria-expanded="false"
                       aria-controls="addyellow-alert-collapse">
                        <div class="p-4">

                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm">
                                        <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                            01.5
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="font-size-16 mb-1">Maquinaria Amarilla</h5>
                                    <p class="text-muted text-truncate mb-0">Informacion unica para maquinaria
                                        amarilla</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                </div>

                            </div>

                        </div>
                    </a>
                    <div id="addyellow-alert-collapse" class="collapse" data-bs-parent="#addproduct-accordion">
                        <div class="p-4 border-top">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div
                                                class="mb-3 {{ $errors->has("serial_number") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="serial_number">Numero de Serie</label>
                                                <input id="serial_number" name="serial_number"
                                                       placeholder="Agrega Numero de Serie"
                                                       type="text"
                                                       value="{{old('serial_number', $vehicle->serial_number)}}"
                                                       class="form-control">
                                                {!! $errors->first('serial_number', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div
                                                class="mb-3 {{ $errors->has("chassis_number") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="chassis_number">Numero de Chasis</label>
                                                <input id="chassis_number" name="chassis_number"
                                                       placeholder="Agrega Numero de Chasis"
                                                       type="text"
                                                       value="{{old('chassis_number', $vehicle->chassis_number)}}"
                                                       class="form-control">
                                                {!! $errors->first('chassis_number', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div
                                                class="mb-3 {{ $errors->has("engine_number") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="engine_number">Numero de Motor</label>
                                                <input id="engine_number" name="engine_number"
                                                       placeholder="Agrega Numero de Motor"
                                                       type="text"
                                                       value="{{old('engine_number', $vehicle->engine_number)}}"
                                                       class="form-control">
                                                {!! $errors->first('engine_number', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("accessories") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="accessories">Accesorios</label>
                                                <textarea id="accessories" name="accessories"
                                                          rows="3"
                                                          class="form-control">{{old('accessories', $vehicle->accessories)}}</textarea>
                                                {!! $errors->first('accessories', '<div class="invalid-feedback">:message</div>') !!}
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
                <a href="{{route('transport.vehicles.index')}}" class="btn btn-danger"> <i
                        class="bx bx-x me-1"></i>
                    Cancelar </a>
                <button type="submit" class="btn btn-success"><i class=" bx bx-file me-1"></i>
                    Guardar
                </button>
            </div> <!-- end col -->
        </div>
        {!! Form::close() !!}

    </div>

@endsection
@section('script')
    <script src="{{ Theme::url('js/app.js') }}"></script>
    <script src="{{ Theme::url('libs/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
            integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="application/javascript" async>
        const loading = new Loader();

        (function () {
    'use strict';
    Dropzone.autoDiscover = false;
    let token = "{{$currentUser->getFirstApiKey() }}";

    document.addEventListener('DOMContentLoaded', function () {
        const typeElement = document.getElementById('type');
        if (typeElement) {
            const type = typeElement.value;
            if (type == "2") {
                document.getElementById('yellow_machinery').style.display = "block";
            } else {
                document.getElementById('yellow_machinery').style.display = "none";
            }

            typeElement.onchange = function () {
                const type = this.value;
                if (type == "2") {
                    document.getElementById('yellow_machinery').style.display = "block";
                } else {
                    document.getElementById('yellow_machinery').style.display = "none";
                }
            };
        }

        let companySelect = document.getElementById('company_id');
        let mainImage = document.getElementById('mainImage');

        if (companySelect && mainImage) {
            companySelect.onchange = function () {
                let company = this.value;
                if (company) {
                    mainImage.style.display = "block";
                    initializeDropzone(company);
                } else {
                    mainImage.style.display = "none";
                }
            };
        }

        function initializeDropzone(companyId) {
            let myDropzone = new Dropzone("#mainImage", {
                url: "{{route('api.media.store')}}",
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                },
                method: 'post',
                autoUpload: true,
                uploadMultiple: false,
                paramName: 'file',
                params: {'parent_id': 1, 'company_id': companyId},
            });
            myDropzone.on("success", function (file, response) {
                alertify.success('Archivo Guardado');
                document.getElementById('medias_single').value = response.id;
            });
        }

        // Check if company is pre-selected and initialize Dropzone
        let preSelectedCompany = companySelect ? companySelect.value : null;
        if (preSelectedCompany && mainImage) {
            mainImage.style.display = "block";
            initializeDropzone(preSelectedCompany);
        }
    });
})();

    </script>

    <style>
        #qrcode img {
            margin: auto;
        }

        .board {
            display: block;
            white-space: nowrap;
            overflow-x: auto
        }

        .tasks {
            display: inline-block;
            width: 19%;
            padding: 0 1rem 1rem 1rem;
            border: 1px solid #dee2e6;
            vertical-align: top;
            margin-bottom: 1.5rem;
            border-radius: 0.25rem;
        }

        .tasks.tasks:not(:last-child) {
            margin-right: 1.25rem
        }

        .tasks .card {
            white-space: normal;
            margin-top: 1rem
        }

        .small, small {
            font-size: .75rem;
        }

        .tasks .task-header {
            background-color: #f6f7fb;
            padding: 1rem;
            margin: 0 -1rem;
            font-size: .936rem;
        }

        .tasks .h5, .tasks h5 {
            font-size: .936rem;
        }

        .tasks p span {
            font-size: 0.9rem
        }

        .task-list-items {
            min-height: 100px;
            position: relative
        }

        .task-list-items:before {
            content: "No Tasks";
            position: absolute;
            line-height: 110px;
            width: 100%;
            text-align: center;
            font-weight: 600
        }

        .task-modal-content .form-control-light {
            background-color: #eef2f7 !important;
            border-color: #eef2f7 !important
        }

        .gantt-task-details {
            min-width: 220px
        }

        @media (max-width: 991.98px) {
            .board {
                display: contents;
            }

            .tasks {
                display: block;
                width: 100%;
            }
        }
    </style>
@endsection
