@extends('layouts.master')
@section('title')
    Editar Vehículo
@endsection

@section('css')
    {!! Theme::style('libs/gridjs/gridjs.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/flatpickr/flatpickr.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/sweetalert2/sweetalert2.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/dropzone/dropzone.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/alertifyjs/alertifyjs.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/flatpickr/flatpickr.min.css?v='.config('app.version')) !!}
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
                        <div class="position-relative">
                            <div class="modal-button mt-2">
                                <div class="row align-items-start">
                                    <div class="col-sm">
                                        <div>
                                            <button
                                                    class="btn btn-primary waves-effect waves-light mb-2 me-2"
                                                    id="add-file" onclick="openModalEvent(null,{{$vehicle->id}},'Modules\\Transport\\Entities\\Vehicles')" type="button" >
                                                <i
                                                        class="mdi mdi-calendar me-1"></i> Nuevo Evento
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                            <div class="mb-3 {{ $errors->has("imei") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="imei">Imei de Dispositivo</label>
                                                <input id="imei" name="imei" placeholder="Agrega Imei de Dispositivo"
                                                       type="text"
                                                       value="{{old('imei',$vehicle->imei)}}"
                                                       class="form-control">
                                                {!! $errors->first('imei', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("capacity") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="capacity">Capacidad</label>
                                                <input id="capacity" name="capacity" placeholder="Agrega Capacidad"
                                                       type="number"
                                                       value="{{old('capacity',$vehicle->capacity)}}"
                                                       class="form-control">
                                                {!! $errors->first('capacity', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            @if($currentUser->hasAccess('sass.companies.indexall') || (companies() > 0 && empty(company()->id)))
                                                <div class="mb-3 {{ $errors->has("company_id") ? ' was-validated' : '' }}">
                                                    <label class="form-label" for="company_id">Compañia</label>
                                                    <select class="form-control" data-trigger name="company_id"
                                                            id="company_id">
                                                        <option value="">Seleccione Compañia</option>
                                                        @foreach(companies() as $company)
                                                            <option value="{{$company->id}}" {{$company->id == old('company_id',$vehicle->company_id) ? 'selected' : ''}} >{{$company->name}}</option>
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
                                                        <option value="{{$i}}" {{$i == old('type',$vehicle->type) ? 'selected' : ''}} >{{$type}}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('route_id', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("mileage") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="mileage">Kilometraje</label>
                                                <input id="mileage" name="mileage"
                                                       placeholder="Agrega Kilometraje"
                                                       type="number"
                                                       value="{{old('mileage',$vehicle->mileage)}}"
                                                       class="form-control">
                                                {!! $errors->first('mileage', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("box_type") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="box_type">Tipo de Caja</label>
                                                <select class="form-control" data-trigger name="box_type"
                                                        id="box_type">
                                                    <option value="">Seleccione Tipo de Caja</option>
                                                    @foreach($box_types as $i=>$box_type)
                                                        <option value="{{$i}}" {{$i == old('box_type',$vehicle->box_type) ? 'selected' : ''}} >{{$box_type}}</option>
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
                                                        <option value="{{$i}}" {{$i == old('transmission_type',$vehicle->transmission_type) ? 'selected' : ''}} >{{$transmission_type}}</option>
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
                       aria-haspopup="true" aria-expanded="false" aria-haspopup="true"
                       aria-controls="addyellow-alert-collapse">
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
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <a href="#addfuel-alert-collapse" class="text-dark collapsed" data-bs-toggle="collapse"
                       aria-haspopup="true" aria-expanded="false" aria-haspopup="true"
                       aria-controls="addfuel-alert-collapse">
                        <div class="p-4">

                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm">
                                        <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                            03
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="font-size-16 mb-1">Llantas</h5>
                                    <p class="text-muted text-truncate mb-0">Verificación de estado de llantas</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                </div>
                            </div>
                        </div>
                    </a>

                    <div id="addfuel-alert-collapse" class="collapse"
                         data-bs-parent="#addproduct-accordion">
                        <div class="p-4 border-top">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="position-relative">
                                                <div class="modal-button mt-2">
                                                    <div class="row align-items-start">
                                                        <div class="col-sm">
                                                            <div>
                                                                <button
                                                                        class="btn btn-success waves-effect waves-light mb-2 me-2"
                                                                        id="add-file" type="button"  onclick="openModalTires()">
                                                                    <i
                                                                            class="mdi mdi-plus me-1"></i> Agregar
                                                                    Nuevas llantas
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div id="Axles_vehicle">
                                                        <div class="row">
                                                            <div class="col-12 mb-1 pt-5"><h5>Eje 1</h5></div>
                                                            <div class="col-3">
                                                                <div class="mb-5">
                                                                    <select class="form-control " data-trigger name="axles[1][rim][1]"
                                                                            id="company_id">
                                                                        <option value="">Seleccionar Llanta</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-5">
                                                                    <button
                                                                            class="btn btn-primary waves-effect waves-light mb-2 me-2"
                                                                            id="add-file" onclick="openModalEvent('Cambio o remplazo de llanta',{{$vehicle->id}})" type="button" >
                                                                        <i
                                                                                class="mdi mdi-calendar me-1"></i> Nuevo Evento
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 pt-5">
                                                                <img src="{{Theme::url('images/axles-single.png')}}" alt="" style="width: 100%">
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="mb-5">
                                                                    <select class="form-control" data-trigger name="company_id"
                                                                            id="company_id">
                                                                        <option value="">Seleccionar Llanta</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-5">
                                                                    <button
                                                                            class="btn btn-primary waves-effect waves-light mb-2 me-2"
                                                                            id="add-file" type="button" onclick="openModalTires()">
                                                                        <i
                                                                                class="mdi mdi-calendar me-1"></i> Nuevo Evento
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row" id="btn_axles_trailer">
                                                        <div class="col-12 mt-4 mb-4">
                                                            <button type="button"
                                                                    class="btn btn-success waves-effect waves-light mb-2 me-2"
                                                                    id="add-file" onclick="addTrailer()">
                                                                <i
                                                                        class="mdi mdi-plus me-1"></i> agregar Eje
                                                            </button>
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
        <div class="row">
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
                                    <h5 class="font-size-16 mb-1">Documentos</h5>
                                    <p class="text-muted text-truncate mb-0">Listado de Documentos</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                </div>
                            </div>
                        </div>
                    </a>

                    <div id="addproduct-alert-collapse" class="collapse"
                         data-bs-parent="#addproduct-accordion">
                        <div class="p-4 border-top">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="position-relative">
                                                <div class="modal-button mt-2">
                                                    <div class="row align-items-start">
                                                        <div class="col-sm">
                                                            <div>
                                                                <button
                                                                        class="btn btn-success waves-effect waves-light mb-2 me-2"
                                                                        id="add-file" onclick="openModal()">
                                                                    <i
                                                                            class="mdi mdi-plus me-1"></i> Agregar
                                                                    Archivo
                                                                </button>
                                                                <button
                                                                        class="btn btn-primary waves-effect waves-light mb-2 me-2"
                                                                        id="add-file" onclick="openModalEvent()" type="button" >
                                                                    <i
                                                                            class="mdi mdi-calendar me-1"></i> Nuevo Evento
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="table-files"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <a href="#addfuel-alert-collapse" class="text-dark collapsed" data-bs-toggle="collapse"
                       aria-haspopup="true" aria-expanded="false" aria-haspopup="true"
                       aria-controls="addfuel-alert-collapse">
                        <div class="p-4">

                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm">
                                        <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                            03
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="font-size-16 mb-1">Combustible</h5>
                                    <p class="text-muted text-truncate mb-0">Listado de Tanqueo de Combustible</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                </div>
                            </div>
                        </div>
                    </a>

                    <div id="addfuel-alert-collapse" class="collapse"
                         data-bs-parent="#addproduct-accordion">
                        <div class="p-4 border-top">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="position-relative">
                                                <div class="modal-button mt-2">
                                                    <div class="row align-items-start">
                                                        <div class="col-sm">
                                                            <div>
                                                                <button
                                                                        class="btn btn-success waves-effect waves-light mb-2 me-2"
                                                                        id="add-file" onclick="openModalFuel()">
                                                                    <i
                                                                            class="mdi mdi-plus me-1"></i> Agregar
                                                                    Tanqueo de Conbustible
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="table-fuel"></div>
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
    <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addOrderModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id=orderdetailsModalLabel">Cargar Archivos </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="text-muted">
                                <h5 class="font-size-15 mb-2">Cargar Documentos</h5>
                                <input name="vehicle_id" type="hidden" value="{{$vehicle->id}}">
                                <div class="mb-3">
                                    <label class="form-label" for="guia">Nombre del Documento</label>
                                    <input id="name" name="name"
                                           placeholder="Agrega Nombre"
                                           type="text"
                                           class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="guia">Fecha de Vencimiento</label>
                                    <input id="expiration_date" name="expiration_date"
                                           placeholder="Agrega Fecha de Vencimiento"
                                           type="text"
                                           class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="guia">Valor Pagado</label>
                                    <input id="amount" name="amount"
                                           placeholder="Agrega Valor Pagado"
                                           type="text"
                                           class="form-control">
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 ">
                                        <div
                                                class="checkbox">
                                            <label for="alert">
                                                <input id="alert"
                                                       name="alert"
                                                       type="checkbox"
                                                       class="form-check-input"
                                                       value="1"/>
                                                Generar Alerta
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="btn_vehicle_file">
                                    <div class="col-12 mt-4 mb-4">
                                        <button type="button"
                                                class="btn btn-success waves-effect waves-light mb-2 me-2"
                                                id="add-file" onclick="addDoc()">
                                            <i
                                                    class="mdi mdi-plus me-1"></i> Agregar Archivo
                                        </button>
                                    </div>
                                </div>
                                <form class="dropzone" id="vehicle_file"
                                      action="#" method="post" style="display: none">
                                    <div class="fallback">
                                        <input name="file" type="file">
                                    </div>
                                    <div class="dz-message needsclick">
                                        <div class="mb-3">
                                            <i class="display-4 text-muted mdi mdi-cloud-upload"></i>
                                        </div>
                                        <h4>Suelte los archivos aquí o haga clic para cargar.</h4>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cancel-modal-order" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="AxlesModal" tabindex="-1" aria-labelledby="axlesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
            <div class="modal-content">
                {!! Form::open(['route' => ['transport.vehicles.update',$vehicle->id], 'method' => 'put']) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id=orderdetailsModalLabel">Ejes y llantas </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class=" bx bx-file me-1"></i>
                        Guardar
                    </button>
                    <button type="button" id="cancel-modal-order" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="modal fade" id="addFuelModal" tabindex="-1" aria-labelledby="addFuelModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id=addFuelModalLabel">Cargar Conbustible </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="text-muted">
                                <div class="mb-3">
                                    <label class="form-label" for="fuel_date">Fecha de Tanqueo</label>
                                    <input id="fuel_date" name="fuel_date"
                                           placeholder="Agrega Fecha de Tanqueo"
                                           type="text"
                                           class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="quantity">Cantidad</label>
                                    <input id="quantity" name="quantity"
                                           placeholder="Agrega quantity"
                                           type="number"
                                           class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="value">Valor Pagado</label>
                                    <input id="value" name="value"
                                           placeholder="Agrega Valor"
                                           type="number"
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-success waves-effect waves-light mb-2 me-2"
                            id="btn-add-fiel" onclick="addFuel()">
                        <i
                                class="mdi mdi-plus me-1"></i> Guardar
                    </button>
                    <button type="button" id="cancel-modal-order" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-new-task-modal" tabindex="-1"
         aria-labelledby="NewTaskModalLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="NewTaskModalLabel">Crear Nueva Tarea</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation p-2" name="event-form" id="form-event" novalidate>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Tipo de Evento</label>
                                    <select class="form-select shadow-none" name="event-type"
                                            id="event-type" required>
                                        <option value="0">Tarea</option>
                                        <option value="1">Recordatorio</option>
                                        <option value="2">Mantenimiento Preventivo</option>
                                        <option value="3">Mantenimiento Correctivo</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="company_id" value="{{$vehicle->company->id}}">
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="task-description" class="form-label">Descripcción</label>
                                    <input type="text" class="form-control form-control-light" name="description"
                                           id="task-description"
                                           placeholder="Descripcción ">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Fecha</label>
                                    <input id="alert" name="alert"
                                           placeholder="Agrega Fecha de Vencimiento"
                                           type="text"
                                           class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lista de Validación</label>
                            <div id="inputFormRow">
                                <div class="input-group mb-3">
                                    <input type="text" id="form_verify" name="form_verify[question][]"
                                           class="form-control m-input" placeholder="Agregar Validación"
                                           autocomplete="off">
                                    <div class="input-group-append">
                                        <button id="removeRow" type="button" class="btn btn-danger">Eliminar</button>
                                    </div>
                                </div>
                            </div>

                            <div id="newRow"></div>
                            <button id="addRow" type="button" class="btn btn-info">Agregar</button>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="event-end" class="form-label">Finalizar Evento Por</label>
                                    <select class="form-select form-control-light" id="event-end">
                                        <option value="0">Fecha</option>
                                        <option value="1">Kilómetros</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="task-priority" class="form-label">Limite</label>
                                    <input class="form-control" placeholder="Agregar Kilómetros"
                                           type="number" name="limits" id="limits" required value=""/>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection
@section('script')
    <script src="{{ Theme::url('libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ Theme::url('js/app.js') }}"></script>
    <script src="{{ Theme::url('libs/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ Theme::url('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
            integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script type="application/javascript" async>
        const loading = new Loader();
        Dropzone.autoDiscover = false;
        const mygrid = new gridjs.Grid({
            language: {
                'search': {
                    'placeholder': 'Buscar...'
                },
                'pagination': {
                    'previous': 'Prev.',
                    'next': 'Sig.',
                    'showing': 'Mostrando',
                    'results': () => 'resultados'
                }
            },
            columns:
                [
                    {
                        id: 'extension',
                        name: 'icono ',
                        formatter: (function (cell) {
                            switch (cell) {
                                case 'application/pdf':
                                    return gridjs.html('<i class="mdi text-danger mdi-file-pdf" style="font-size: 43px"></i>')
                                    break;
                                case 'image/png':
                                    return gridjs.html('<i class="mdi text-muted mdi-image-edit-outline" style="font-size: 43px"></i>')
                                    break;
                                case 'image/jpg':
                                    return gridjs.html('<i class="mdi text-success mdi-image" style="font-size: 43px"></i>')
                                    break;
                                default:
                                    return gridjs.html('<i class="mdi text-secondary mdi-file-document-outline" style="font-size: 43px"></i>')
                            }

                        })
                    },
                    {
                        id: 'name',
                        name: 'Nombre del Archivo ',
                    },
                    {
                        id: 'expiration_date',
                        name: 'Fecha de Vencimiento ',
                    },
                    {
                        id: 'amount',
                        name: 'Valor Pagado',
                    },
                    {
                        id: "alert",
                        name: "Alerta",
                        sort: {
                            enabled: false
                        },
                        formatter: (function (cell, row) {
                            if (cell.value) {
                                return gridjs.html('<span class="badge badge-pill badge-soft-' + cell.class_alert + ' font-size-12">' + cell.status_alert + '</span>');
                            }
                        })
                    },
                    {
                        id: "route",
                        name: "Descargar",
                        sort: {
                            enabled: false
                        },
                        formatter: (function (cell) {
                            return gridjs.html('<div class="d-flex gap-3"><a href="' + cell + '" data-bs-toggle="tooltip" data-bs-placement="top" title="download" class="text-success" target="_blank"><i class="mdi mdi-cloud-download-outline font-size-18"></i></a></div>');
                        })
                    }

                ],
            pagination: {
                limit: 12,
                server: {
                    url: (prev, page, limit) => `${prev}&limit=${limit}&page=${page + 1}`
                }
            },
            sort: true,
            search: true,
            server: {
                url: '{{route('api.transport.document.index',['documentable_id'=>$vehicle->id,'documentable_type'=>'Modules\Transport\Entities\Vehicles'])}}',
                headers: {
                    Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                    'Content-Type': 'application/json'
                },
                then: data => data.data,
                total: data => data.meta.page.total
            }
        }).render(document.getElementById("table-files"));
        flatpickr('#expiration_date');
        function openModal() {
            $('#addDocumentModal').modal('show')
            flatpickr('#guia', {
                defaultDate: new Date(),
                dateFormat: "d M, Y",
            });
        }
        function addDoc() {
            document.getElementById('vehicle_file').style.display = "block";
            document.getElementById('btn_vehicle_file').style.display = "none";
            let token = "{{$currentUser->getFirstApiKey() }}";
            let image = '';
            let alert = document.getElementById('alert');
            if (alert.checked) {
                alert = 1
            } else {
                alert = 0
            }
            let expiration_date = document.getElementById('expiration_date').value;
            let amount = document.getElementById('amount').value;
            let name = document.getElementById('name').value;
            let myDropzoneDoc = new Dropzone("#vehicle_file", {
                url: "{{route('api.transport.document.store')}}",
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                },
                method: 'post',
                autoUpload: true,
                uploadMultiple: false,
                paramName: 'file',
                params: {
                    'documentable_id': {{$vehicle->id}},
                    'documentable_type': "Modules\\Transport\\Entities\\Vehicles",
                    'name': name,
                    'alert': alert,
                    'expiration_date': expiration_date,
                    'amount': amount
                },
            })
            myDropzoneDoc.on("success", function (file, response) {
                console.log(response)
                alertify.success('Archivo Guardado');
                mygrid.updateConfig({
                    server: {
                        url: '{{route('api.transport.document.index',['vehicle_id'=>$vehicle->id])}}',
                        headers: {
                            Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                            'Content-Type': 'application/json'
                        },
                        then: data => data.data,
                        total: data => data.meta.page.total
                    }
                }).forceRender();
                myDropzoneDoc.removeAllFiles();
                document.getElementById('alert').checked = false;
                document.getElementById('expiration_date').value = null;
                document.getElementById('amount').value = null;
                document.getElementById('name').value = null;
                $('#addDocumentModal').modal('hidde')
            });
        }
        function openModalAxles() {
            $('#AxlesModal').modal('show')
            flatpickr('#axles_date');
        }
        function addTrailer(type) {

            const itemHtml1 = `
    <div class="card mb-0" id="${itemData.id}" >
      <div class="card-body p-3">
        <small class="float-end text-muted">${itemData.limit == null ? moment(itemData.alert).format("DD MMM YYYY") : itemData.limit + ' km'}</small>
        <span class="badge text-bg-${itemData.type_class}">${itemData.type_name}</span>

        <h5 class="mt-2 mb-2">
          <a href="#" data-bs-toggle="modal" data-bs-target="#task-detail-modal" data-task-id="${itemData.id}"
             class="text-body">${itemData.description}</a>
        </h5>
        <div class="dropdown float-end">
          <a href="#" class="dropdown-toggle text-muted arrow-none"
             data-bs-toggle="dropdown" aria-expanded="false">
            <i class="mdi mdi-dots-vertical font-18"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-end">
            <a href="javascript:void(0);" class="dropdown-item " data-bs-toggle="modal" data-bs-target="#task-edit-modal" data-task-id="${itemData.id}"><i
                      class="mdi mdi-pencil me-1"></i>Editar</a>
            <a href="{{route('maintenance.event.index')}}/done/${itemData.id}" class="dropdown-item text-success"><i
                      class="mdi mdi-check me-1"></i>${itemData.status!==2?'Completar':'Visualizar'}</a>
            <a href="#" onclick="updateEvent(${itemData.id},'canceled')" class="dropdown-item text-danger"><i
                      class="mdi mdi-cancel me-1"></i>Cancelar</a>
          </div>
        </div>

        <p class="mb-0">
          <img src="${itemData.company.logo}"
               alt="user-img" class="avatar-xs rounded-circle me-1">
          <span class="align-middle">${itemData.company.name}</span>
        </p>
      </div> </div>`;
            const itemElement = document.createElement('div');
            itemElement.dataset.itemId = itemData.id
            itemElement.innerHTML = itemHtml;

            // Agrega el elemento DOM al contenedor deseado
            const container = document.getElementById(status);
            container.appendChild(itemElement);
        }
        function openModalEvent(description,eventable_id,eventable_type) {
            $('#add-new-task-modal').modal('show')

        }
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
        const mygridfuel = new gridjs.Grid({
            language: {
                'search': {
                    'placeholder': 'Buscar...'
                },
                'pagination': {
                    'previous': 'Prev.',
                    'next': 'Sig.',
                    'showing': 'Mostrando',
                    'results': () => 'resultados'
                }
            },
            columns:
                [
                    {
                        id: 'fuel_date',
                        name: 'Fecha ',
                        formatter: (function (cell) {
                            return moment(cell).format('YYYY-MM-DD')
                        })
                    },
                    {
                        id: 'quantity',
                        name: 'Cantidad (G) ',
                    },
                    {
                        id: 'value',
                        name: 'Valor',
                    },

                ],
            pagination: {
                limit: 12,
                server: {
                    url: (prev, page, limit) => `${prev}&limit=${limit}&page=${page + 1}`
                }
            },
            sort: true,
            search: true,
            server: {
                url: '{{route('api.maintenance.fueltank.index',['filter'=>['vehicle_id'=>$vehicle->id]])}}',
                headers: {
                    Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                    'Content-Type': 'application/json'
                },
                then: data => data.data,
                total: data => data.meta.page.total
            }
        }).render(document.getElementById("table-fuel"));
        function openModalFuel() {
            $('#addFuelModal').modal('show')
            flatpickr('#guia', {
                defaultDate: new Date(),
                dateFormat: "d M, Y",
            });
        }
        function addFuel() {
            let token = "{{$currentUser->getFirstApiKey() }}";
            let fuel_date = document.getElementById('fuel_date').value;
            let quantity = document.getElementById('quantity').value;
            let value = document.getElementById('value').value;
            let vehicle_id = {{$vehicle->id}};
            axios.post('{{route('api.maintenance.fueltank.store')}}',{
                fuel_date:fuel_date,
                quantity: quantity,
                value: value,
                vehicle_id:vehicle_id
            }, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                }
            }).then(function (response) {
                mygridfuel.updateConfig({
                    server: {
                        url: '{{route('api.maintenance.fueltank.index',['filter'=>['vehicle_id'=>$vehicle->id]])}}',
                        headers: {
                            Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                            'Content-Type': 'application/json'
                        },
                        then: data => data.data,
                        total: data => data.meta.page.total
                    }
                }).forceRender();
                loading.hidden();
                document.getElementById('fuel_date').value=null;
                document.getElementById('quantity').value=null;
                document.getElementById('value').value=null;
                $('#addFuelModal').modal('hidde')
            }).catch(function (error) {
                console.log(error);
                alertify.error('Algo Salio Mal');
            });
        }
        <!--event-->
        document.addEventListener("DOMContentLoaded", function () {
            var formEvent = document.getElementById('form-event');
            var forms = document.getElementsByClassName('needs-validation');
            var selectedEvent = null;
            var newEventData = null;
            $("#addRow").click(function () {
                var html = '';
                html += '<div id="inputFormRow">';
                html += '<div class="input-group mb-3">';
                html += '<input type="text" name="form_verify[question][]" class="form-control m-input" placeholder="Agregar Validación" autocomplete="off">';
                html += '<div class="input-group-append">';
                html += '<button id="removeRow" type="button" class="btn btn-danger">Eliminar</button>';
                html += '</div>';
                html += '</div>';

                $('#newRow').append(html);
            });

            // remove row
            $(document).on('click', '#removeRow', function () {
                $(this).closest('#inputFormRow').remove();
            });
            flatpickr('#alert', {
                locale: "es",
                dateFormat: "Y-m-d",
            });
            let eventEnd = document.getElementById('event-end').value

            function addNewEvent(info) {
                addEvent.show();
                formEvent.classList.remove("was-validated");
                formEvent.reset();
                selectedEvent = null;
                newEventData = info;
            }

            formEvent.addEventListener('submit', function (ev) {
                ev.preventDefault();
                let eventType = document.getElementById('event-type').value;
                let taskDescription = document.getElementById('task-description').value
                let alert = document.getElementById('alert').value;
                let form_verify = document.getElementsByName('form_verify[question][]')
                let eventEnd = document.getElementById('event-end').value
                let limits = document.getElementById('limits').value
                let company = document.getElementById('company_id').value
                let formVerify = "";
                let end = form_verify.length-1;
                for (let i = 0; i < form_verify.length; i++) {
                    let a = form_verify[i];
                    formVerify = formVerify
                        + a.value;
                    if (i !== end) {
                        console.log(i, form_verify.length)
                        formVerify = formVerify + ","
                    }
                }
                // validation
                if (forms[0].checkValidity() === false) {
                    forms[0].classList.add('was-validated');
                } else {
                    var newEvent = {
                        type: eventType,
                        description: taskDescription,
                        alert: alert,
                        alert_active: eventEnd,
                        status: 0,
                        limits: limits,
                        formVerify: formVerify,
                        eventable_id: company,
                        eventable_type: 'Modules\\Sass\\Entities\\Company',
                        company_id: company,
                    }
                    addEvent(newEvent);
                }
            });
        });

        function addEvent(newEvent) {
            let token = "{{$currentUser->getFirstApiKey() }}";
            loading.show()
            axios.post('{{route('api.maintenance.event.store')}}', newEvent, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                }
            }).then(function (response) {
                formClear()
                alertify.success('Evento Agregado');
                loading.hidden();
            }).catch(function (error) {
                console.log(error);
                alertify.error('Algo Salio Mal');
            });
            loading.hidden()
            alertify.success('Nueva Tarea Creada');
            $('#add-new-task-modal').modal('hide')
        }

        function updateEvent(id,status) {
            let token = "{{$currentUser->getFirstApiKey() }}";
            loading.show()
            // Obtener el ID del contenedor destino
            // Construir la URL de la petición
            const url = '{{route('api.maintenance.event.store')}}/';

            // Construir los datos de la petición
            const data = {
                status: getStatus(status),
            };

            // Enviar la petición Axios
            axios.put(url + id, data, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                }
            }).then(response => {
                // Procesar la respuesta del servidor
                alertify.success('Evento Actualizado');
                window.location.reload()
            }).catch(error => {
                console.error(error);
            });

        }
        function getStatus(status) {
            switch (status) {
                case 'pending':
                    statusId = 0;
                    break
                case 'scheduled':
                    statusId = 1;
                    break
                case 'done':
                    statusId = 2;
                    break
                case 'expired':
                    statusId = 3;
                    break
                case 'canceled':
                    statusId = 4;
                    break
                default:
                    statusId = 0;
            }
            return statusId
        }
        function formClear() {
            document.getElementById('event-type').value=0
            document.getElementById('task-description').value=""
            document.getElementById('alert').value=""
            document.getElementById('event-end').value=""
            document.getElementById('limits').value=""
            document.getElementById('company_id').value=""
            let form_verify = document.getElementsByName('form_verify[question][]')
            for (let i = 0; i < form_verify.length; i++) {
                let a = form_verify[i];
                $(a).closest('#inputFormRow').remove();
            }
        }
    </script>
    <style>
        #qrcode img {
            margin: auto;
        }
    </style>
@endsection
