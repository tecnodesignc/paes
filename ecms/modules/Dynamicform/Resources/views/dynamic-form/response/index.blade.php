@extends('layouts.master')
@section('title')
    Ver Respuestas
@endsection

@section('css')
    {!! Theme::style('libs/sweetalert2/sweetalert2.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/alertifyjs/alertifyjs.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/@simonwep/@simonwep.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/gridjs/gridjs.min.css?v='.config('app.version')) !!}
    <link href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" rel="stylesheet">
    {!! Theme::style('libs/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css?v='.config('app.version')) !!}
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
        <div class="col-lg-12">
            <div class="card">
                    <div class="p-4">

                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="font-size-16 mb-1">Respuestas</h5>
                                <p class="text-muted text-truncate mb-0">Listado de personas que contestaron el formulario</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border-top">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
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
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ Theme::url('libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/@simonwep/@simonwep.min.js') }}"></script>
    <script src="{{ Theme::url('js/app.js')}}"></script>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
            integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

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
                        width: '150px',
                        order: true
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
                url: '{!!route('api.dynamicform.formresponse.index',$params)!!}',
                headers: {
                    Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                    'Content-Type': 'application/json'
                },
                then: data => data.data,
                total: data => data.meta.page.total
            }
        }).render(document.getElementById("table-response"));


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
                     // Realizar la solicitud DELETE con Axios
                    axios.delete(`/preoperativo/form/{{$form->id}}/response/${field}/borrar`, {
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
    <style>
        .fade:not(.show) {
            opacity: 1;
        }
    </style>
@endsection
