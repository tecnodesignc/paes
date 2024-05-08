@extends('layouts.master')
@section('title')
    Ver Respuestas
@endsection

@section('css')
    {!! Theme::style('libs/sweetalert2/sweetalert2.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/alertifyjs/alertifyjs.min.css?v='.config('app.version')) !!}
    <link rel="stylesheet" href="{{Theme::url('libs/flatpickr/flatpickr.min.css')}}">
    {!! Theme::style('libs/@simonwep/@simonwep.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/gridjs/gridjs.min.css?v='.config('app.version')) !!}
    <link href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" rel="stylesheet">
    {{-- {!! Theme::style('libs/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css?v='.config('app.version')) !!} --}}
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Respuestas
        @endslot
        @slot('title')
            Ver Respuestas
        @endslot
    @endcomponent

    <div class="row">
        <div class="d-print-none mb-2">
            <div class="float-end">
                <button type="button" class="btn btn-secondary" onclick="goBack()">Volver Atrás</button>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                    <div class="p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="font-size-16 mb-1">Respuestas</h5>
                                <p class="text-muted text-truncate mb-0">Listado de personas que contestaron el formulario</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 border-top">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="position-relative">
                                            <div class="modal-button">
                                                <div class="row align-items-start">

                                                    <div class="col-sm-auto">
                                                        <div class="d-flex gap-2">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="datepicker-range" style="width: 250px;">
                                                                <span class="input-group-text"><i class="bx bx-calendar-event"></i></span>
                                                            </div>
                                                            <div class="dropdown">
                                                                <a class="btn btn-link text-body shadow-none dropdown-toggle" href="#"
                                                                   role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                                </a>

                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li>
                                                                        <button id="today" class="dropdown-item">Hoy</button>
                                                                    </li>
                                                                    <li>
                                                                        <button id="yesterday" class="dropdown-item">Ayer</button>
                                                                    </li>
                                                                    <li>
                                                                        <button id="thirtyday" class="dropdown-item">30 dias</button>
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
@endsection
@section('script')
    <script src="{{ Theme::url('libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script src="{{ Theme::url('libs/@simonwep/@simonwep.min.js') }}"></script>
    <script src="{{ Theme::url('js/app.js')}}"></script>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/sweetalert2/sweetalert2.min.js') }}"></script>
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
                    // {
                    //     id: 'id',
                    //     name: '#',
                    //     width: '50px',
                    //     sort: {
                    //         enabled: false
                    //     },
                    //     formatter: (function (cell) {
                    //         return gridjs.html('<div class="form-check font-size-16"><input class="form-check-input" type="checkbox" id="orderidcheck' + cell + '"><label class="form-check-label" for="orderidcheck' + cell + '">' + cell + '</label></div>');
                    //     })
                    // },
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
                            let hasAccessDestroy = {{$currentUser->hasAccess('dynamicform.formresponses.destroy') ? 'true' : 'false'}};

                            if (hasAccessDestroy ) {
                                actionHtml += '<a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Borrar" class="text-danger" onclick="deleteResponse(event, '+ cell +')" ><i class="mdi mdi-delete mdi-24px"></i></a>';
                            }

                            actionHtml += '</div>';
                            return gridjs.html(actionHtml);
                        })
                    }

                ],
            pagination: {
                limit: 12,
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
                    $companies=company()->id?company()->id:array_values(companies()->map(function ($company){
                        return $company->id;
                    })->toArray());
                    $params=['include'=>'form,user,company','form_id'=>$form->id,'companies'=>$companies];
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

        function deleteResponse(event, field) {
            event.preventDefault(); // Evita que el navegador siga el enlace
            console.log(field);
            Swal.fire({
                title: "¿Estás seguro de que quieres eliminar este campo?",
                text: "Esta acción no se puede revertir!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Eliminar!",
                cancelButtonText: "Cancelar"
                }).then((result) => {
                if (result.isConfirmed) {

                    // Generar la URL de la solicitud DELETE con el ID del formulario y la ID del campo
                    var route = `{{ route('api.dynamicform.formresponse.destroy', ['responses' => ':formresponseId']) }}`;
                    route = route.replace(':formresponseId', field);

                    axios.delete(route, {
                        headers: {
                            'Authorization': `Bearer {{$currentUser->getFirstApiKey()}}`,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        // Verificar si la solicitud fue exitosa
                        if (response.status === 200) {
                            Swal.fire({
                                title: "Eliminado!",
                                text: "Campo eliminado exitosamente.",
                                icon: "success"
                            });
                            // Actualizamos la tabla después de la eliminación
                            gridresponse.forceRender();
                        } else {
                            // Manejar el caso en que la solicitud no fue exitosa
                            throw new Error('Error al eliminar el campo');
                        }
                    })
                    .catch(error => {
                        // Manejar errores
                        console.error(error);
                        Swal.fire('Error al eliminar el campo', error);
                    });
                }
            });
        }

    </script>

    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>

    <style>
        .fade:not(.show) {
            opacity: 1;
        }
    </style>
@endsection
