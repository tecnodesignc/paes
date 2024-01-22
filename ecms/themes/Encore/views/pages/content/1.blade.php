@extends('layouts.master')
@section('title')
    {{ trans('dashboard::dashboard.name') }}
@endsection
@section('css')
    <link rel="stylesheet" href="{{Theme::url('libs/gridjs/gridjs.min.css')}}">
    <link rel="stylesheet" href="{{Theme::url('libs/flatpickr/flatpickr.min.css')}}">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Eje Satelital
        @endslot
        @slot('title')
            Bienvenidos !
        @endslot
    @endcomponent
    @php

        /*    $t = microtime(true);
                   $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
                   $d = new \DateTime(date('Y-m-d H:i:s.' . $micro, $t));

                   dd($d->format("Y_m_d_Hisu_"));*/
    @endphp
    <div class="row">
        <div class="col-xl-4">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="text-center py-3">
                        <ul class="bg-bubbles ps-0">
                            <li><i class="bx bx-grid-alt font-size-24"></i></li>
                            <li><i class="bx bx-tachometer font-size-24"></i></li>
                            <li><i class="bx bx-store font-size-24"></i></li>
                            <li><i class="bx bx-cube font-size-24"></i></li>
                            <li><i class="bx bx-cylinder font-size-24"></i></li>
                            <li><i class="bx bx-command font-size-24"></i></li>
                            <li><i class="bx bx-hourglass font-size-24"></i></li>
                            <li><i class="bx bx-pie-chart-alt font-size-24"></i></li>
                            <li><i class="bx bx-coffee font-size-24"></i></li>
                            <li><i class="bx bx-polygon font-size-24"></i></li>
                        </ul>
                        <div class="main-wid position-relative">
                            <h3 class="text-white">Escritorio</h3>

                            <h3 class="text-white mb-0"> ¡Bienvenido de nuevo, {{ $currentUser->present()->fullname() }}
                                !</h3>

                            <p class="text-white-50 px-4 mt-4">Puedes ver el resumen de los recorridos y estadísticas
                                del dia :
                                <br>
                                <strong class="text-white"> {{date('d M Y H:i:s')}}</strong>

                                <br> O actualizar su perfil</p>

                            <div class="mt-4 pt-2 mb-2">
                                <a href="" class="btn btn-success">Ver Prefil <i
                                            class="mdi mdi-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="avatar">
                                        <span class="avatar-title bg-soft-primary rounded">
                                            <i class="mdi mdi-bus-articulated-front text-primary font-size-24"></i>
                                        </span>
                            </div>
                            <p class="text-muted mt-4 mb-0">Total Conductores</p>
                            <h4 class="mt-1 mb-0">{{driverCount(['companies'=>company()->id])}}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="avatar">
                                        <span class="avatar-title bg-soft-primary rounded">
                                            <i class="mdi mdi-bus-articulated-front text-primary font-size-24"></i>
                                        </span>
                            </div>
                            <p class="text-muted mt-4 mb-0">Total de Vehiculos</p>
                            <h4 class="mt-1 mb-0">{{driverCount(['companies'=>company()->id])}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-8">
            <div class="card">

                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center mb-3">
                        <h5 class="card-title mb-0">Modulos Activos</h5>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-xl-8">
                            <div class="d-flex flex-wrap align-items-center mb-3">
                                <div class="ms-auto">
                                    <div class="card mt-4 maintenance-box">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-9">
                                                    <div class="d-flex ">
                                                        <h5 class="text-primary">01.</h5>
                                                        <div class="flex-1 ms-3">
                                                            <h5 class="font-size-16">Mantenimienton</h5>
                                                            <p class="text-muted mb-0">There are many variations of
                                                                passages of
                                                                Lorem Ipsum available, but the majority have suffered
                                                                alteration.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="">
                                                <span class="avatar-title bg-soft-success rounded">
                                                    <i class="mdi mdi-car-cog text-primary"
                                                       style="font-size: 70px"></i>
                                                </span>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                    <div class="card mt-4 maintenance-box">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-9">
                                                    <div class="d-flex">
                                                        <h5 class="text-primary">02.</h5>
                                                        <div class="flex-1 ms-3">
                                                            <h5 class="font-size-16">
                                                                Preoperativo</h5>
                                                            <p class="text-muted mb-0">Contrary to popular belief, Lorem
                                                                Ipsum
                                                                is not
                                                                simply random text. It has roots in a piece of
                                                                classical.</p>
                                                            <div class="mt-1">
                                                                <a href="{{route('dynamicform.form.index')}}"
                                                                   class="btn btn-primary btn-sm">Entrar</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="">
                                                <span class="avatar-title bg-soft-secondary rounded">
                                                    <i class="mdi mdi-format-list-bulleted-square text-primary"
                                                       style="font-size: 70px"></i>
                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mt-4 maintenance-box">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <h5 class="text-primary">03.</h5>
                                                <div class="flex-1 ms-3">
                                                    <h5 class="font-size-16">
                                                        Do you need Support?</h5>
                                                    <p class="text-muted mb-0">If you are going to use a passage of
                                                        Lorem
                                                    </p>
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
@endsection
@section('script')
    <script src="{{ Theme::url('libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ Theme::url('js/app.js') }}"></script>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
            integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"
            integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="application/javascript" async>
        const loading = new Loader();

        flatpickr('#guia', {
            defaultDate: new Date(),
            dateFormat: "d M, Y",
        });

    </script>

    <style>
        #qrcode img {
            margin: auto;
        }
    </style>
@endsection
