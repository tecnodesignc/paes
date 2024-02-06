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
<div class="row d-relative align-items-stretch">
    <div class="col-lg-4 col-md-12">
        <div class="card bg-primary h-100">
            <div class="card-body  text-center">
                {{-- <div class="text-center py-1"> --}}
                    <div class="main-wid position-relative">
                        <h3 class="text-white mt-5 "> ¡Bienvenido de nuevo, {{ $currentUser->present()->fullname() }}!</h3>
                        <p class="text-white-50 mt-4 text-size-100">Puedes ver el resumen de los formularios a la fecha :
                            <br>
                            <strong class="text-white"> {{date('d M Y H:i:s')}}</strong>
                        </p>
                    </div>
                {{-- </div> --}}
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-12">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex">
                    <div class="avatar">
                        <span class="avatar-title bg-soft-warning rounded">
                            <i class="mdi mdi-alert-circle-outline text-warning font-size-24"></i>
                        </span>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0">Formularios con hallazgos</p>
                        <h4 class="">{{negativeResponseCount(['companies'=>company()->id])}} {{--<sup class="text-success fw-medium font-size-14"><i class="mdi mdi-arrow-down"></i> 10%</sup>--}}</h4>
                    </div>
                </div>
                <div>
                    <div class="py-3 my-1">
                        <div id="mini-1" data-colors='["#3980c0"]'></div>
                    </div>
                    <ul class="list-inline d-flex justify-content-between justify-content-center mb-0">
                        <li class="list-inline-item"><a href="" class="text-muted">Dia</a></li>
                        <li class="list-inline-item"><a href="" class="text-muted">Semana</a></li>
                        <li class="list-inline-item"><a href="" class="text-muted">Mes</a></li>
                        <li class="list-inline-item"><a href="" class="text-muted">Año</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

    
    <div class="row mt-2">
        {{-- Card de bienvenida --}}
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="avatar">
                                <span class="avatar-title bg-soft-primary rounded">
                                    <i class="mdi mdi-bus-articulated-front text-primary font-size-24"></i>
                                </span>
                    </div>
                    <p class="text-muted mt-4 mb-0">Formularios Activos</p>
                    <h4 class="mt-1 mb-0">{{$forms_active_count??0}}</h4>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="avatar">
                                <span class="avatar-title bg-soft-primary rounded">
                                    <i class="mdi mdi-bus-articulated-front text-primary font-size-24"></i>
                                </span>
                    </div>
                    <p class="text-muted mt-4 mb-0">Formularios contestados hoy</p>
                    <h4 class="mt-1 mb-0">{{$forms_response_count??0}}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body"  style="max-height: 250px;">
                    <div class="avatar">
                                <span class="avatar-title bg-soft-primary rounded">
                                    <i class="mdi mdi-bus-articulated-front text-primary font-size-24"></i>
                                </span>
                    </div>
                    <p class="text-muted mt-4 mb-0">Formularios contestados con hallazgos hoy</p>
                    <h4 class="mt-1 mb-0">{{$forms_response_negative_count_day??0}}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
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
    


    <div class="row">
        <div class="p-4 border-top">
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
                            <div id="table-response"></div>
                        </div>
                    </div>
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
    {{-- <script src="{{ Theme::url('libs/sweetalert2/sweetalert2.min.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
      
    {{-- <script src="{{ Theme::url('js/pages/dashboard.init.js') }}"></script> --}}
    {{-- <script src="{{ Theme::url('js/pages/chartjs.js') }}"></script> --}}

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
                        id: 'id',
                        name: '#',
                        width: '50px',
                        sort: {
                            enabled: false
                        }
                    },
                    {
                        id: 'user',
                        name: 'Colaborador',
                        width: '350px',
                        formatter: (function (cell) {
                            return cell.fullname;
                        })
                    },
                    {
                        id: 'negative_num',
                        name: 'Respuestas negativas',
                        width: '150px',
                    },
                    {
                        id: 'company',
                        name: 'Empresa',
                        width: '150px',
                        formatter: (function (cell) {
                            return cell.name;
                        })
                    },
                    {
                        id: "created_at",
                        name: "registrado el",
                        width: '200px',
                        formatter: (cell) => moment(cell).format('YYYY-MM-DD')
                    },
                    {
                        id: "form",
                        name: "Formulario",
                        width: '200px',
                        formatter: (function (cell) {
                            return cell.name;
                        })
                    },
                    {
                        id: "id",
                        name: "Ver respuestas",
                        width: '100px',
                        sort: {
                            enabled: false
                        },
                        formatter: (function (cell, row) {
                            var form_id = row.cells[5].data.id;
                            return gridjs.html('<div class="d-flex align-item-center"><a href="/preoperativo/form/'+form_id+'/response/' + cell + '/show" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Respuestas" class="text-info"><i class="mdi mdi-eye-outline me-1 mdi-24px"></i></a></div>');
                        })
                    }
    
                ],
            pagination: 12,
            search: true,
            sort: true,
            data: {!! json_encode($forms_response_negatives) !!}
        }).render(document.getElementById("table-response"));
    </script>
        
    {{-- <script type="application/javascript" async>
        fetch('{!! route('api.dynamicform.formresponse.indexResponseNegatives', $params) !!}', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer {{ $currentUser->getFirstApiKey() }}`,
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener los datos del servidor');
            }
            return response.json();
        })
        .then(data => {
            // Aquí puedes manejar los datos recibidos del servidor
            console.log(data);
        })
        .catch(error => {
            console.error('Error al consumir la API:', error);
        });

    </script> --}}

    <script type="application/javascript" async>
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


    </script>



    <style>
        #qrcode img {
            margin: auto;
        }
    </style>
@endsection
