@extends('modules.dynamic-form.layouts.master')
@section('title')
    Formularios
@endsection
@section('css')
    {!! Theme::style('libs/sweetalert2/sweetalert2.min.css?v=' . config('app.version')) !!}
    {!! Theme::style('libs/alertifyjs/alertifyjs.min.css?v=' . config('app.version')) !!}
    <link rel="stylesheet" href="{{ Theme::url('libs/flatpickr/flatpickr.min.css') }}">
    {!! Theme::style('libs/@simonwep/@simonwep.min.css?v=' . config('app.version')) !!}
    {!! Theme::style('libs/gridjs/gridjs.min.css?v=' . config('app.version')) !!}
@stop

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Eje Satelital
        @endslot
        @slot('title')
            Formularios
        @endslot
    @endcomponent

    <div class="row justify-content-center">
        {{-- <div class="col-md-6 col-sm-12 justify-content-center align-items-center"> --}}
        <div id="addproduct-accordion" class="custom-accordion">
            <div class="card border border-primary">
                <a href="#addproduct-productinfo-collapse" class="text-dark" data-bs-toggle="collapse" aria-expanded="true"
                    aria-controls="addproduct-productinfo-collapse">
                    <div class="p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm">
                                    <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                        <i class="mdi mdi-notebook"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h2 class="">Ver respuestas anteriores</h2>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="mdi mdi-chevron-up accor-down-icon"></i>
                            </div>
                        </div>
                    </div>
                </a>
                <div id="addproduct-productinfo-collapse" class="collapse" data-bs-parent="#addproduct-accordion">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="position-relative">
                                            <div class="modal-button">
                                                <div class="row align-items-start">

                                                    <div class="col-sm-auto">
                                                        <div class="d-flex">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    id="datepicker-range">
                                                                <span class="input-group-text"><i
                                                                        class="bx bx-calendar-event"></i></span>
                                                            </div>
                                                            <div class="dropdown">
                                                                <a class="btn btn-link text-body shadow-none dropdown-toggle"
                                                                    href="#" role="button" data-bs-toggle="dropdown"
                                                                    aria-expanded="false">
                                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                                </a>

                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li>
                                                                        <button id="today"
                                                                            class="dropdown-item">Hoy</button>
                                                                    </li>
                                                                    <li>
                                                                        <button id="yesterday"
                                                                            class="dropdown-item">Ayer</button>
                                                                    </li>
                                                                    <li>
                                                                        <button id="thirtyday" class="dropdown-item">30
                                                                            dias</button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end row -->
                                            </div>
                                        </div>

                                        <div id="table-response"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- </div> --}}
    </div>

    <div class="row">
        @foreach ($forms as $form)
            <a href="{{ route('dynamicform.formresponses.create', $form->id) }}" class="col-lg-4 col-sm-12">
                <div class="card text-center" style="color: {{ $form->color }}">
                    <div class="card-body d-flex justify-content-start align-items-center">
                        <i class="{{ $form->icon }} me-5 display-6"></i>
                        <p class="text-truncate display-7">{{ $form->name }}</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

@endsection
@section('script')
    <script src="{{ Theme::url('libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script src="{{ Theme::url('libs/@simonwep/@simonwep.min.js') }}"></script>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ Theme::url('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
        integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="application/javascript" async>

        let initDate=moment().subtract(7,'d').format('YYYY-MM-DD');
        let endDate=moment().format('YYYY-MM-DD HH:mm:ss');
        flatpickr('#datepicker-range', {
            locale: "es",
            defaultDate: [initDate, endDate],
            dateFormat: "Y-m-d",
            mode: "range"
        });
        let range={from:initDate,to:endDate};

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
                        id: 'form',
                        name: 'Formulario',
                        width: '300px',
                        formatter: (function (cell) {
                            return cell.name;
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
                        width: '300px',
                        formatter: (function (cell) {
                            return cell.name;
                        })
                    },
                    {
                        id: "created_at",
                        name: "Creado el",
                        width: '200px',
                    },
                    {
                        id: "id",
                        name: "Acciones",
                        width: '100px',
                        sort: {
                            enabled: false
                        },
                        formatter: (function (cell) {
                            actionHtml = '<div class="d-flex justify-content-center align-items-center gap-4"><a href="/preoperativo/form/{{$form->id}}/response/' + cell + '/show" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Respuestas" class="text-info"><i class="mdi mdi-eye-outline me-1 mdi-24px"></i></a>';
                            actionHtml += '</div>';
                            return gridjs.html(actionHtml);
                        })
                    }
                ],
            pagination: {
                limit: 5,
                server: {
                    url: (prev, page, limit) => `${prev}&limit=${limit}&page=${page + 1}`
                }
            },
            search: {
                debounceTimeout: 1000,
                server: {
                    url: (prev, keyword) => `${prev}&search=${keyword}`
                }
            },
            sort: true,
            server: {
                @php
                    $companies = $currentUser->driver->company->id ? $currentUser->driver->company->id : null;
                    $params=['include'=>'form,user,company','user_id'=>$currentUser->id,'companies'=>$companies];
                @endphp
                url: '{!!route('api.dynamicform.formresponse.index',$params)!!}&date='+JSON.stringify(range),
                headers: {
                    Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                    'Content-Type': 'application/json'
                },
                then: data => data.data,
                total: data => data.meta.page.total
            }
        }).render(document.getElementById("table-response"));

        let dateRange=document.getElementById("datepicker-range");
        let inputFilter=document.getElementById("filter");
        dateRange.addEventListener('change', function () {
           let dateR= dateRange.value.split(' ');
            initDate=dateR[0];
           if(dateR[2]){
               endDate=dateR[2];
           }else{
               endDate=dateR[0];
           }

            range={from:initDate,to:endDate};
            gridresponse.updateConfig({
                server: {
                    url: '{!!route('api.dynamicform.formresponse.index',$params)!!}&date='+JSON.stringify(range),
                    headers: {
                        Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                        'Content-Type': 'application/json'
                    },
                    then: data => data.data,
                    total: data => data.meta.page.total
                }
            }).forceRender();
        });


        let today=document.getElementById("today");

        today.addEventListener('click',function () {
            initDate=moment().format('YYYY-MM-DD');
            initDate=initDate+' 00:00:00'
            endDate=moment().format('YYYY-MM-DD HH:mm:ss');
            range={from:initDate,to:endDate};
            gridresponse.updateConfig({
                server: {
                    url: '{!!route('api.dynamicform.formresponse.index',$params)!!}&date='+JSON.stringify(range),
                    headers: {
                        Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                        'Content-Type': 'application/json'
                    },
                    then: data => data.data,
                    total: data => data.meta.page.total
                }
            }).forceRender();

            flatpickr('#datepicker-range', {
                locale: "es",
                defaultDate: [initDate, endDate],
                dateFormat: "Y-m-d",
                mode: "range"
            });
        });

        let yesterday=document.getElementById("yesterday");

        yesterday.addEventListener('click',function () {
            initDate=moment().subtract(1,'d').format('YYYY-MM-DD');
            initDate=initDate+' 00:00:00'
            endDate=moment().subtract(1,'d').format('YYYY-MM-DD');
            endDate=endDate+' 23:59:59'
            range={from:initDate,to:endDate};
            gridresponse.updateConfig({
                server: {
                    url: '{!!route('api.dynamicform.formresponse.index',$params)!!}&date='+JSON.stringify(range),
                    headers: {
                        Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                        'Content-Type': 'application/json'
                    },
                    then: data => data.data,
                    total: data => data.meta.page.total
                }
            }).forceRender();

            flatpickr('#datepicker-range', {
                locale: "es",
                defaultDate: [initDate, endDate],
                dateFormat: "Y-m-d",
                mode: "range"
            });
        });

        let thirtyday=document.getElementById("thirtyday");

        thirtyday.addEventListener('click',function () {
            initDate=moment().subtract(30,'d').format('YYYY-MM-DD');
            initDate=initDate+' 00:00:00'
            endDate=moment().format('YYYY-MM-DD HH:mm:ss');
            range={from:initDate,to:endDate};
            gridresponse.updateConfig({
                server: {
                    url: '{!!route('api.dynamicform.formresponse.index',$params)!!}&date='+JSON.stringify(range),
                    headers: {
                        Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                        'Content-Type': 'application/json'
                    },
                    then: data => data.data,
                    total: data => data.meta.page.total
                }
            }).forceRender();

            flatpickr('#datepicker-range', {
                locale: "es",
                defaultDate: [initDate, endDate],
                dateFormat: "Y-m-d",
                mode: "range"
            });
        });

    </script>
    <style>
        .fade:not(.show) {
            opacity: 1;
        }
    </style>
@endsection
