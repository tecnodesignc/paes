@extends('layouts.master')
@section('title')
    Reportes de formularios
@endsection
@section('css')
    <link href="{{Theme::url('libs/alertifyjs/alertifyjs.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{Theme::url('libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Eje Satelital
        @endslot
        @slot('title')
           Reportes
        @endslot
    @endcomponent

    @if(session()->has('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Reporte diario --}}
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-12 justify-content-center align-items-center">
            <div id="addproduct-accordion" class="custom-accordion">
                <div class="card border border-primary">
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
                                    <h2 class="">Reporte diario</h2>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                    <div id="addproduct-productinfo-collapse" class="collapse"
                         data-bs-parent="#addproduct-accordion">
                        <div class="card-body">
                            {!! Form::open(['route' => ['dynamicform.form.download_report_day'], 'method' => 'POST', 'class'=>'needs-validation']) !!}
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="">Formularios</label>
                                        <select name="forms" id="formularios" class="form-control">
                                            @if(empty($forms))
                                                <option disabled>No hay opciones disponibles</option>
                                            @else
                                                <option value="">--Seleccione--</option>
                                                    @foreach($forms as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}</option>
                                                    @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="form-group col-6">
                                            <label class="text-truncate">Vehículo:</label>
                                            <select class="vehicleLabel" id="vehicleLabelDay" name="vehicle"></select>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="">Dia</label>
                                            <input type="date" class="date form-control" name="dateStart">
                                        </div>
                                    </div>

                                    <div class="form-group mt-4">
                                        <div class="d-flex gap-4 justify-content-end">
                                            <button class="btn btn-success" type="submit">Descargar</button>
                                            <button class="btn btn-danger" type="reset">Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Reporte mensual --}}
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-12 justify-content-center align-items-center">
            <div id="reportmonth-accordion" class="custom-accordion">
                <div class="card border border-primary">
                    <a href="#reportmonth-productinfo-collapse" class="text-dark" data-bs-toggle="collapse"
                       aria-expanded="true" aria-controls="reportmonth-productinfo-collapse">
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
                                    <h2 class="">Reporte mensual</h2>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                    <div id="reportmonth-productinfo-collapse" class="collapse"
                         data-bs-parent="#reportmonth-accordion">
                        <div class="card-body">
                            {!! Form::open(['route' => ['dynamicform.form.download_report_month'], 'method' => 'POST', 'class'=>'needs-validation']) !!}
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="">Formularios</label>
                                        <select name="forms" id="formularios" class="form-control" required>
                                            @if(empty($forms))
                                                <option disabled>No hay opciones disponibles</option>
                                            @else
                                                <option value="">--Seleccione--</option>
                                                    @foreach($forms as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}</option>
                                                    @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="form-group col-6">
                                            <label class="text-truncate">Vehículo:</label>
                                            <select class="vehicleLabel" id="vehicleLabelMonth" name="vehicle" required></select>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="dateMonth">Selecciona un mes y año:</label>
                                            <input type="month" id="dateMonth" name="dateMonth" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="form-group mt-4">
                                        <div class="d-flex gap-4 justify-content-end">
                                            <button class="btn btn-success" type="submit">Descargar</button>
                                            <button class="btn btn-danger" type="reset">Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Reporte General --}}
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-12 justify-content-center align-items-center">
            <div id="reportgeneral-accordion" class="custom-accordion">
                <div class="card border border-primary">
                    <a href="#reportgeneral-productinfo-collapse" class="text-dark" data-bs-toggle="collapse"
                        aria-expanded="true" aria-controls="reportgeneral-productinfo-collapse">
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
                                    <h2 class="">Reporte general</h2>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                    <div id="reportgeneral-productinfo-collapse" class="collapse"
                            data-bs-parent="#reportgeneral-accordion">
                        <div class="card-body">
                            {!! Form::open(['route' => ['dynamicform.form.download_report_general'], 'method' => 'POST', 'class'=>'needs-validation']) !!}
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="">Formularios</label>
                                        <select name="forms" id="formularios" class="form-control" required>
                                            @if(empty($forms))
                                                <option disabled>No hay opciones disponibles</option>
                                            @else
                                                <option value="">--Seleccione--</option>
                                                    @foreach($forms as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}</option>
                                                    @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="dateGeneral">Selecciona un mes y año:</label>
                                        <input type="month" id="dateGeneral" name="dateGeneral" class="form-control" required>
                                    </div>

                                    <div class="form-group mt-4">
                                        <div class="d-flex gap-4 justify-content-end">
                                            <button class="btn btn-success" type="submit">Descargar</button>
                                            <button class="btn btn-danger" type="reset">Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ Theme::url('js/app.js') }}"></script>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="application/javascript">
        $(document).ready(function() {

            $('#vehicleLabel').select2({
                // theme: 'bootstrap4',
                placeholder: {id:'-1', text:"--Seleccione--"},
                allowClear: true,
                width: 'resolve', // need to override the changed default
                required: true
            });
            // Verificar si company()->id está definido
            @php
                $companies=company()->id?company()->id:array_values(companies()->map(function ($company){
                    return $company->id;
                })->toArray());
            @endphp

            // if (companyId !== null) {
                // Llama a la API para obtener los datos
                var url = "{{ route('api.dynamicform.formresponse.vehicles', ['companyId' => ':companyId']) }}";
                url = url.replace(':companyId', {{json_encode($companies)}});

                axios.get(url, {
                    headers: {
                        'Authorization': `Bearer {{$currentUser->getFirstApiKey()}}`,
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function(response) {
                    // Procesa los datos de respuesta aquí si es necesario
                    var data = response.data;
                    // Verifica si hay errores en la respuesta
                    if (data.errors) {
                        console.error('Error al obtener los datos:', data.errors);
                        return;
                    }

                    // Llena el select2 con los datos obtenidos
                    $('.vehicleLabel').select2({
                        width: '100%', // need to override the changed default
                        data: Object.keys(data).map(function(key) {
                            return { id: key, text: data[key] };
                        })
                    });

                })
                .catch(function(error) {
                    // Maneja los errores aquí
                    console.error('Error al obtener los datos:', error);
                });
            // }
            // else {
            //
            // }
        })
    </script>
    <style>
        #qrcode img {
            margin: auto;
        }
    </style>
@endsection
