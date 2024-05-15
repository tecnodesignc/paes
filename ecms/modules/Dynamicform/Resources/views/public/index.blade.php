@extends('layouts.master')
@section('title')
    {{ trans('dashboard::dashboard.name') }}
@endsection
@section('css')
    <link rel="stylesheet" href="{{Theme::url('libs/gridjs/gridjs.min.css')}}">
    <link rel="stylesheet" href="{{Theme::url('libs/flatpickr/flatpickr.min.css')}}">
@endsection
@section('content')
@php
    use Carbon\Carbon;
@endphp
    @component('components.breadcrumb')
        @slot('li_1')
            Eje Satelital
        @endslot
        @slot('title')
            Dashboard
        @endslot
    @endcomponent

    {{-- componente card para la bienvenida del usuario --}}
    <div class="row ">
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="card bg-primary d-relative h-100">
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
                            <h3 class="text-white "> ¡Bienvenido de nuevo, {{ $currentUser->present()->fullname() }}!</h3>
                            <p class="text-white-50 mt-1 text-size-100">Puedes ver el resumen de los formularios:
                                <br>
                                <strong class="text-white"> {{date('d M Y H:i:s')}}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 ">
            <div class="card d-relative h-100">
                <div class="card-body">
                    <div class="avatar">
                        <span class="avatar-title bg-soft-success rounded">
                            <i class="mdi mdi-format-list-numbered-rtl text-primary font-size-24"></i>
                        </span>
                    </div>
                    <p class="text-muted mt-4 mb-0">Formularios Activos</p>
                    <h4 class="mt-1 mb-0">{{$forms_active_count??0}}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 ">
            <div class="card d-relative h-100">
                <div class="card-body">
                    <div class="avatar">
                        <span class="avatar-title bg-soft-primary rounded">
                            <i class="mdi mdi-clipboard-list-outline text-primary font-size-24"></i>
                        </span>
                    </div>
                    <p class="text-muted mt-4 mb-0">Formularios contestados hoy</p>
                    <h4 class="mt-1 mb-0">{{$forms_response_count??0}}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 ">
            <div class="card d-relative h-100">
                <div class="card-body"  style="max-height: 250px;">
                    <div class="avatar">
                                <span class="avatar-title bg-soft-info rounded">
                                    <i class="mdi mdi-list-status text-primary font-size-24"></i>
                                </span>
                    </div>
                    <p class="text-muted mt-4 mb-0">Respuestas con hallazgos hoy</p>
                    <h4 class="mt-1 mb-0">{{$forms_response_negative_count_day??0}}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Card que hace un listado de los formularios contestados y cuenta de la cantidad de respuestas las cuales tuvieron al menos 1 negativa --}}
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap align-items-center">
                        <h5 class="card-title mb-0">Cantidad formularios contestados hoy con hallazgos</h5>
                    </div>
                </div>

                <div class="card-body px-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                @foreach ($conteoPorEmpresa as $conteoId => $conteo)
                                    <tr class="items-center text-center">
                                        <td width="50%">{{ $conteo['name'] ?? null}}</td>
                                        <td width="50%">{{ $conteo['cantidad'] ?? null}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Cantidad de respuestas por colaborador con la cantidad de hallazgos --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap align-items-center">
                        <h5 class="card-title mb-0">Respuestas x colaborador con cantidad de hallazgos</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="position-relative">
                        <div class="modal-button mt-2">
                            <div class="row align-items-start">
                            </div>
                        </div>
                    </div>
                    <div id="table-response" class="table table-striped table-centered align-middle table-nowrap mb-0"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ Theme::url('libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ Theme::url('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ Theme::url('js/app.js') }}"></script>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="application/javascript" async>

        const gridresponse = new gridjs.Grid({

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
                        id: 'user',
                        name: 'Colaborador',
                        width: '300px',
                        formatter: (function (cell) {
                            return cell.fullname;
                        })
                    },
                    {
                        id: 'negative_num',
                        name: 'Hallazgos',
                        width: '150px',
                    },
                    {
                        id: 'company',
                        name: 'Empresa',
                        width: '200px',
                        formatter: (function (cell) {
                            return cell.name;
                        })
                    },
                    {
                        id: "created_at",
                        name: "registrado el",
                        width: '200px'
                    },
                    {
                        id: "form",
                        name: "Formulario",
                        width: '250px',
                        formatter: (function (cell) {
                            return cell.name;
                        })
                    },
                    {
                        id: "id",
                        name: "Respuesta",
                        width: '100px',
                        sort: {
                            enabled: false
                        },
                        formatter: (function (cell, row) {
                            var form_id = row.cells[4].data.id;
                            return gridjs.html('<div class="d-flex justify-content-center align-item-center"><a href="/preoperativo/form/'+form_id+'/response/' + cell + '/show" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Respuestas" class="text-info"><i class="mdi mdi-eye-outline me-1 mdi-24px"></i></a></div>');
                        })
                    },
                ],
            pagination: true,
            search: true,
            sort: true,
            data: {!! json_encode($forms_response_negatives) !!}
        }).render(document.getElementById("table-response"));
    </script>

    {{-- <script type="application/javascript" async>
        const loading = new Loader();
        flatpickr('#guia', {
            defaultDate: new Date(),
            dateFormat: "d M, Y",
        });


        // mini-1
        var options = {
        series: [{
            data: [23, 2, 36, 22, 30, 12, 38, 78, 21, 34, 65, 12, 38, 78, 21, 23,25, 250]
        }],
        chart: {
            type: 'line',
            height: 61,
            sparkline: {
            enabled: true
            }
        },
        stroke: {
            curve: 'smooth',
            width: 2.5
        },
        tooltip: {
            fixed: {
            enabled: false
            },
            x: {
            show: false
            },
            y: {
            title: {
                formatter: function formatter(seriesName) {
                return '';
                }
            }
            },
            marker: {
            show: false
            }
        }
        };
        var chart = new ApexCharts(document.querySelector("#mini-1"), options);
        chart.render();
    </script> --}}

    <style>
        #qrcode img {
            margin: auto;
        }
    </style>
@endsection
