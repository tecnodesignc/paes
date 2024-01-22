@extends('layouts.master')
@section('title')
    Crear Consulta
@endsection

@section('css')
    <link rel="stylesheet" href="{{Theme::url('libs/gridjs/gridjs.min.css')}}">
    <link rel="stylesheet" href="{{Theme::url('libs/flatpickr/flatpickr.min.css')}}">
    <link href="{{Theme::url('libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{Theme::url('libs/alertifyjs/alertifyjs.min.css')}}" rel="stylesheet" type="text/css"/>
@stop

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
           Reportes
        @endslot
        @slot('title')
          Crear Consulta
        @endslot
    @endcomponent
    {!! Form::open(['route' => ['transport.report.search'], 'method' => 'get', 'class'=>'needs-validation']) !!}
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
                                    <h5 class="font-size-16 mb-1"> Consulta</h5>
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
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="guia">Fecha </label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="date" id="datepicker-range">
                                                        <span class="input-group-text"><i class="bx bx-calendar-event"></i></span>
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="guia">Placa</label>
                                                    <select class="form-control" data-trigger name="vehicle_id"
                                                            id="vehicle_id">
                                                        <option value="">Seleccione Vehículo</option>
                                                        @foreach($vehicles as $vehicle)
                                                            <option value="{{$vehicle->id}}">{{$vehicle->plate}} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="shipping-location">Ruta</label>
                                                    <select class="form-control" data-trigger name="route_id"
                                                            id="route_id">
                                                        <option value="">Seleccione Ruta</option>
                                                        @foreach($routes as $route)
                                                            <option value="{{$route->id}}">{{$route->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="shipping-location">Conductor</label>
                                                    <select class="form-control" data-trigger name="driver_id"
                                                            id="driver_id">
                                                        <option value="">Seleccione Conductor</option>
                                                        @foreach($drivers as $driver)
                                                            <option value="{{$driver->id}}">{{$driver->user->present()->fullName}} </option>
                                                        @endforeach
                                                    </select>
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
            <a href="{{route('transport.driver.index')}}" class="btn btn-danger"> <i class="bx bx-x me-1"></i> Cancelar </a>
            <button type="submit" class="btn btn-success"><i class=" bx bx-file me-1"></i> Consultar</button>
        </div> <!-- end col -->
    </div>
    {!! Form::close() !!}

@endsection
@section('script')
    <script src="{{ Theme::url('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script src="{{ Theme::url('js/app.js') }}"></script>
    <script src="{{ Theme::url('libs/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
            integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="application/javascript" async>

        let initDate=moment().subtract(7,'d').format('YYYY-MM-DD');
        let endDate=moment().format('YYYY-MM-DD HH:mm:ss');

        flatpickr('#datepicker-range', {
            locale: "es",
            defaultDate: [initDate, endDate],
            dateFormat: "Y-m-d",
            mode: "range"
        });
    </script>
@endsection
