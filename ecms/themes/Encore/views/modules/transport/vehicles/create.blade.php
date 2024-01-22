@extends('layouts.master')
@section('title')
    Crear Vehículo
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
            Crear Vehículo
        @endslot
    @endcomponent
    {!! Form::open(['route' => ['transport.vehicles.store'], 'method' => 'post', 'class'=>'needs-validation']) !!}
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
                                    <h5 class="font-size-16 mb-1"> Crear Vehículo</h5>
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
                                                <label class="form-label" for="plate">Placa</label>
                                                <input id="plate" name="plate"
                                                       placeholder="Agrega Placa"
                                                       type="text"
                                                       value="{{old('plate')}}"
                                                       class="form-control">
                                                {!! $errors->first('plate', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("brand") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="brand">Marca</label>
                                                <input id="brand" name="brand" placeholder="Agrega Marca"
                                                       type="text"
                                                       value="{{old('brand')}}"
                                                       class="form-control">
                                                {!! $errors->first('brand', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("model") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="model">Modelo</label>
                                                <input id="model" name="model" placeholder="Agrega Modelo"
                                                       type="text"
                                                       value="{{old('model')}}"
                                                       class="form-control">
                                                {!! $errors->first('model', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("class") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="class">Clase</label>
                                                <input id="class" name="class" placeholder="Agrega Clase"
                                                       type="text"
                                                       value="{{old('class')}}"
                                                       class="form-control">
                                                {!! $errors->first('class', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("reference") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="reference">Referencia</label>
                                                <input id="reference" name="reference" placeholder="Agrega Referencia"
                                                       type="text"
                                                       value="{{old('reference')}}"
                                                       class="form-control">
                                                {!! $errors->first('reference', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("doors") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="doors">Numero de Puertas</label>
                                                <input id="doors" name="doors" placeholder="Agrega Puertas"
                                                       type="number"
                                                       value="{{old('doors')}}"
                                                       class="form-control">
                                                {!! $errors->first('doors', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("capacity") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="capacity">Capacidad</label>
                                                <input id="capacity" name="capacity" placeholder="Agrega Capacidad"
                                                       type="number"
                                                       value="{{old('capacity')}}"
                                                       class="form-control">
                                                {!! $errors->first('capacity', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            @if($currentUser->hasAccess('sass.companies.indexall')|| (companies() > 0 && empty(company()->id)))
                                                <div class="mb-3 {{ $errors->has("company_id") ? ' was-validated' : '' }}">
                                                    <label class="form-label" for="company_id">Compañia</label>
                                                    <select class="form-control" data-trigger name="company_id"
                                                            id="company_id">
                                                        <option value="">Seleccione Compañia</option>
                                                        @foreach(companies() as $company)
                                                            <option value="{{$company->id}}" {{$company->id == old('company_id') ? 'selected' : ''}} >{{$company->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    {!! $errors->first('route_id', '<div class="invalid-feedback">:message</div>') !!}
                                                </div>
                                            @else
                                                <input type="hidden" id="company_id" name="company_id"
                                                       value="{{company()->id}}">
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
                                                        <option value="{{$i}}" {{$i == old('type') ? 'selected' : ''}} >{{$type}}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('route_id', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("mileage") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="mileage">Kilometraje</label>
                                                <input id="mileage" name="mileage"
                                                       placeholder="Agrega Kilometraje"
                                                       type="number"
                                                       value="{{old('mileage')}}"
                                                       class="form-control">
                                                {!! $errors->first('mileage', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("box_type") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="box_type">Tipo de Caja</label>
                                                <select class="form-control" data-trigger name="box_type"
                                                        id="box_type">
                                                    <option value="">Seleccione Tipo de Caja</option>
                                                    @foreach($box_types as $i=>$box_type)
                                                        <option value="{{$i}}" {{$i == old('box_type') ? 'selected' : ''}} >{{$box_type}}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('box_type', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("transmission_type") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="transmission_type">Tipo de
                                                    Transmision</label>
                                                <select class="form-control" data-trigger name="transmission_type"
                                                        id="transmission_type">
                                                    <option value="">Seleccione Tipo de Transmision</option>
                                                    @foreach($transmission_types as $i=>$transmission_type)
                                                        <option value="{{$i}}" {{$i == old('transmission_type') ? 'selected' : ''}} >{{$transmission_type}}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('transmission_type', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("property_card") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="property_card">Numero Tarjeta de
                                                    Propiedad</label>
                                                <input id="property_card" name="property_card"
                                                       placeholder="Agrega Tarjeta de Propiedad"
                                                       type="text"
                                                       value="{{old('property_card')}}"
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
                                                                   {{ old('shielding') }}
                                                                   value="1"/>
                                                            Blindaje
                                                            {!! $errors->first('shielding', '<div class="invalid-feedback">:message</div>') !!}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropzone" id="mainImage">
                                                <input type="hidden" id="medias_single" name="medias_single[mainimage]"
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
    <div class="row" id="yellow_machinery" style="display: none">
        <div class="col-lg-12">
            <div class="card">
                <a href="#addproduct-alert-collapse" class="text-dark collapsed" data-bs-toggle="collapse"
                   aria-haspopup="true" aria-expanded="false" aria-haspopup="true"
                   aria-controls="addproduct-alert-collapse">
                    <div class="p-4">

                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm">
                                    <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                        02
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="font-size-16 mb-1">Maquinaria Amarilla</h5>
                                <p class="text-muted text-truncate mb-0">Informacion unica para maquinaria amarilla</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                            </div>

                        </div>

                    </div>
                </a>
                <div id="addproduct-alert-collapse" class="collapse" data-bs-parent="#addproduct-accordion">
                    <div class="p-4 border-top">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3 {{ $errors->has("serial_number") ? ' was-validated' : '' }}">
                                            <label class="form-label" for="serial_number">Numero de Serie</label>
                                            <input id="serial_number" name="serial_number"
                                                   placeholder="Agrega Numero de Serie"
                                                   type="text"
                                                   value="{{old('serial_number')}}"
                                                   class="form-control">
                                            {!! $errors->first('serial_number', '<div class="invalid-feedback">:message</div>') !!}
                                        </div>
                                        <div class="mb-3 {{ $errors->has("chassis_number") ? ' was-validated' : '' }}">
                                            <label class="form-label" for="chassis_number">Numero de Chasis</label>
                                            <input id="chassis_number" name="chassis_number"
                                                   placeholder="Agrega Numero de Chasis"
                                                   type="text"
                                                   value="{{old('chassis_number')}}"
                                                   class="form-control">
                                            {!! $errors->first('chassis_number', '<div class="invalid-feedback">:message</div>') !!}
                                        </div>
                                        <div class="mb-3 {{ $errors->has("engine_number") ? ' was-validated' : '' }}">
                                            <label class="form-label" for="engine_number">Numero de Motor</label>
                                            <input id="engine_number" name="engine_number"
                                                   placeholder="Agrega Numero de Motor"
                                                   type="text"
                                                   value="{{old('engine_number')}}"
                                                   class="form-control">
                                            {!! $errors->first('engine_number', '<div class="invalid-feedback">:message</div>') !!}
                                        </div>
                                        <div class="mb-3 {{ $errors->has("accessories") ? ' was-validated' : '' }}">
                                            <label class="form-label" for="accessories">Accesorios</label>
                                            <textarea id="accessories" name="accessories"
                                                      row="3"
                                                      value="{{old('accessories')}}"
                                                      class="form-control"></textarea>
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
            <a href="{{route('transport.vehicles.index')}}" class="btn btn-danger"> <i class="bx bx-x me-1"></i>
                Cancelar </a>
            <button type="submit" class="btn btn-success"><i class=" bx bx-file me-1"></i> Guardar</button>
        </div> <!-- end col -->
    </div>
    {!! Form::close() !!}

@endsection
@section('script')
    <script src="{{ Theme::url('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{Theme::url('js/app.js')}}"></script>
    <script src="{{ Theme::url('libs/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="application/javascript" async>
        (function () {
            'use strict';
            Dropzone.autoDiscover = false;
            let token = "{{$currentUser->getFirstApiKey() }}";
            window.addEventListener('load', function () {
                document.getElementById('type').onchange = function () {
                    const type = this.value;
                    if (type == "2") {
                        document.getElementById('yellow_machinery').style.display = "block";
                    } else {
                        document.getElementById('yellow_machinery').style.display = "none";
                    }
                };
                let company = document.getElementById('company_id').value;
                if (!company) {
                    document.getElementById('mainImage').style.display = "none";
                    document.getElementById('company_id').onchange = function () {
                        company = this.value;
                        if (company) {
                            document.getElementById('mainImage').style.display = "block";
                            if (document.getElementById('mainImage')) {
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
                                    params: {'parent_id': 1, 'company_id': company},
                                })
                                myDropzone.on("success", function (file, response) {
                                    alertify.success('Archiovo Guardado');
                                    document.getElementById('medias_single').value = response.id
                                });
                            }
                        } else {
                            document.getElementById('mainImage').style.display = "none";
                        }
                    };
                } else {
                    if (document.getElementById('mainImage')) {
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
                            params: {'parent_id': 1, 'company_id': company},
                        })
                        myDropzone.on("success", function (file, response) {
                            alertify.success('Archiovo Guardado');
                            document.getElementById('medias_single').value = response.id
                        });
                    }
                }
            });
        })();
    </script>
@endsection

