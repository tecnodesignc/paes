@extends('layouts.master')
@section('title')
    Vehículos
@endsection
@section('css')
    <link rel="stylesheet" href="{{Theme::url('libs/gridjs/gridjs.min.css')}}">
    <link rel="stylesheet" href="{{Theme::url('libs/flatpickr/flatpickr.min.css')}}">
    <link href="{{Theme::url('libs/alertifyjs/alertifyjs.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{Theme::url('libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@stop

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Eje Satelital
        @endslot
        @slot('title')
            Vehículos
        @endslot
    @endcomponent


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="position-relative">
                        <div class="modal-button mt-2">
                            <a href="{{route('transport.vehicles.create')}}"
                               class="btn btn-success waves-effect waves-light mb-2 me-2"><i
                                    class="mdi mdi-plus me-1"></i> Nuevo Vehículo
                            </a>
                        </div>
                    </div>
                    <div id="table-vehicle"></div>
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
        const mygrid = new gridjs.Grid({
            language: {
                'search': {
                    'placeholder': 'Buscar...'
                },
                'pagination': {
                    'previous': 'Prev.',
                    'next': 'Sig.',
                    'to': 'de',
                    'showing': 'Mostrando',
                    'results': () => 'resultados'
                }
            },
            columns:
                [
                    {
                        id: 'id',
                        name: '#',
                        sort: {
                            enabled: false
                        },
                        width: '50px'
                    },
                    {
                        id: 'plate',
                        name: 'Placa',
                        width: '120px'
                    },
                    {
                        id: 'brand',
                        name: 'Marca',
                        width: '120px'
                    },
                    {
                        id: 'model',
                        name: 'Modelo',
                        width: '120px'
                    },
                    {
                        id: 'class',
                        name: 'Clase',
                        width: '120px'
                    },
                    {
                        id: 'imei',
                        name: 'Dispositivo',
                        width: '120px'
                    },
                    {
                        id: 'capacity',
                        name: 'Capacidad',
                        width: '120px'
                    },
                        @if($currentUser->hasAccess('sass.companies.index') && empty(company()->id))
                    {
                        id: 'company',
                        name: 'Empresa asignada',
                        formatter: (function (cell) {
                            return cell.name
                        }),
                        width: '350px'
                    },
                        @endif
                    {
                        id: "created_at",
                        name: "Creado el",
                        formatter: (_, cell) => moment(cell).format('YYYY-MM-DD'),
                        width: '150px'
                    },
                    {
                        id: "id",
                        name: "Acciones",
                        sort: {
                            enabled: false
                        },
                        formatter: (function (cell, row) {
                            let actionsHtml = '<div class="d-flex justify-content-center align-items-center gap-4">';
                            let hasAccessEdit = {{$currentUser->hasAccess('transport.vehicles.edit') ? 'true' : 'false'}};
                            let hasAccessDestroy = {{ $currentUser->hasAccess('transport.vehicles.destroy') ? 'true' : 'false' }};
                            if (hasAccessEdit){
                                actionsHtml +=
                                '<a href="/transport/vehicles/' + row.cells[0].data + '/edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" class="text-success btn-lg"><i class="mdi mdi-clipboard-edit-outline mdi-24px"></i></a>';
                            }
                            if (hasAccessDestroy){
                                actionsHtml += '<a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Borrar" class="text-danger" onclick="softDelete(event, '+ row.cells[0].data +')" ><i class="mdi mdi-delete mdi-24px"></i></a>';
                            }
                            actionsHtml += '</div>';
                            return gridjs.html(actionsHtml);

                        }),
                        width: '120px'
                    }

                ],
            pagination: {
                limit: 12,
                server: {
                    url: (prev, page, limit) => `${prev}&limit=${limit}&page=${page + 1}`
                }
            },
            sort: true,
            server: {
                @php
                    $companies=company()->id?company()->id:array_values(companies()->map(function ($company){
                                          return $company->id;
                                        })->toArray());
                    $params=['include'=>'company','company_id'=>$companies];
                @endphp
                url: '{!!route('api.transport.vehicles.index',$params)!!}',
                headers: {
                    Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                    'Content-Type': 'application/json'
                },
                then: data => data.data,
                total: data => data.meta.page.total
            },
            search: {
                debounceTimeout: 1000,
                server: {
                    url: (prev, keyword) => `${prev}&search=${keyword}`
                }
            }
        }).render(document.getElementById("table-vehicle"));

        flatpickr('#guia', {
            defaultDate: new Date(),
            dateFormat: "d M, Y",
        });

        function softDelete(event, id) {
            event.preventDefault();
            Swal.fire({
                title: "¿Estás seguro de que quieres eliminar este registro?",
                text: "Esta acción no se puede revertir!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Eliminar!",
                cancelButtonText: "Cancelar"
                }).then((result) => {
                if (result.isConfirmed) {
                    var route = `{{ route('api.transport.vehicles.destroy', ['vehicle' => ':id']) }}`.replace(':id', id);
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
                                text: "Registro eliminado exitosamente.",
                                icon: "success"
                            });
                            // Actualizamos la tabla después de la eliminación
                            mygrid.forceRender();
                        } else {
                            // Manejar el caso en que la solicitud no fue exitosa
                            throw new Error('Error al eliminar el registro');
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: "Ops...",
                            text: 'No se puede borrar un vehículo que ya tiene formularios, deshabilitelo!',
                            icon: "warning"
                        });
                    });
                }
            });
        }

    </script>

    <style>
        #qrcode img {
            margin: auto;
        }
    </style>
@endsection
