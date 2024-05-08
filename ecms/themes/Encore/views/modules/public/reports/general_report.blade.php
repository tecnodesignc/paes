@extends('layouts.master')
@section('title')
    Reportes de formularios
@endsection
@section('css')
    <link rel="stylesheet" href="{{Theme::url('libs/gridjs/gridjs.min.css')}}">
    <link rel="stylesheet" href="{{Theme::url('libs/flatpickr/flatpickr.min.css')}}">
    <link href="{{Theme::url('libs/alertifyjs/alertifyjs.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{Theme::url('libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <label for="">Empresas</label>
                        <select name="companies" id="companies" class="form-control">
                            @if(empty($companies))
                                <option disabled>No hay opciones disponibles</option>
                            @else
                                <option value="">--Seleccione--</option>
                                @foreach($companies as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="row">
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
                    <div class="row">
                        <label for="">Colaboradores</label>
                        <select name="users" id="formularios" class="form-control">
                            @if(empty($users))
                                <option disabled>No hay opciones disponibles</option>
                            @else
                                <option value="">--Seleccione--</option>
                                    @foreach($users as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="row">
                        <label for="">Vehículo</label>
                        <select class="vehicleLabel form-control" id="vehicleLabel"></select>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <label for="">Fecha inicio</label>
                            <input type="date" class="date form-control">
                        </div>
                        <div class="col-6">
                            <label for="">Fecha fin</label>
                            <input type="date" class="date form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="table-form"></div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
                    'showing': 'Mostrando',
                    'results': () => 'resultados'
                }
            },
            columns:
                [
                    {
                        id: "id",
                        name: "Respuestas",
                        sort: {
                            enabled: false
                        },
                        width: '100px',
                        formatter: (function (cell) {
                            return gridjs.html('<div class="d-flex justify-content-center align-items-center">' +
                            '<a href="/preoperativo/form/' + cell + '/response" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Respuestas" class="text-primary btn-lg">' +
                            '<i class="mdi mdi-layers-search mdi-24px"></i></a></div>');
                        })
                    },
                    {
                        id: 'name',
                        name: 'Titulo',
                        width: '400px',

                    },
                    {
                        id: 'icon',
                        name: 'Iconos',
                        width: '100px',
                        sort: {
                            enabled: false
                        },
                        formatter: (function (cell) {
                            return gridjs.html('<i class="'+cell+' me-2"></i>');
                        })
                    },
                    {
                        id: 'color',
                        name: 'Color',
                        width: '100px',
                        sort: {
                            enabled: false
                        },
                        formatter: (function (cell) {
                            return gridjs.html('<i class="mdi mdi-water mdi-24px" style="color:' + cell + '"></i>');
                        })
                    },
                    {
                        id: 'active',
                        name: 'Estado',
                        width: '150px',
                        formatter: (function (cell) {
                            return gridjs.html(cell == '1' ? '<span class="badge badge-pill badge-soft-success font-size-12">Habilitado</span>' : '<span class="badge badge-pill badge-soft-danger font-size-12">No Habilitado</span>');
                        })
                    },
                        @if($currentUser->hasAccess('sass.companies.index') && empty(company()->id))
                    {
                        id: 'companies',
                        name: 'Empresas asignadas',
                        width: '200px',
                        formatter: (function (cell) {
                            const bussisnes = cell.map((item)=>{
                                return   '<span class="badge badge-pill badge-soft-success font-size-12">'+item.name+'</span>'
                            })
                            return gridjs.html(bussisnes)
                        })
                    },
                        @endif
                    {
                        id: "created_at",
                        name: "Creado el",
                        width: '150px',
                        formatter:(cell)=> moment(cell).format( 'YYYY-MM-DD')
                    },
                    {
                        id: "company_create",
                        hidden: true
                    },
                    {
                        id: "id",
                        name: "Acciones",
                        sort: {
                            enabled: false
                        },
                        width: '150px',
                        formatter: (cell, row) => {
                            let company={{company()->id??0}};
                            let actionsHtml = '<div class="d-flex justify-content-center align-items-center gap-4">';
                            actionsHtml += '<a href="/preoperativo/form/'+ row.cells[0].data + '/show" data-bs-toggle="tooltip" data-bs-placement="top" title="Vista previa" class="text-info"><i class="mdi mdi-eye-outline me-1 mdi-24px"></i></a>';
                            let hasAccessEdit = {{$currentUser->hasAccess('dynamicform.forms.edit') ? 'true' : 'false'}};
                            let hasAccessIndexall = {{$currentUser->hasAccess('dynamicform.forms.indexall') ? 'true' : 'false'}};

                            if (hasAccessEdit ) {
                                if (company == row.cells[6].data){
                                    actionsHtml +=
                                    '<a href="/preoperativo/form/' + row.cells[0].data + '/edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" class="text-success btn-lg"><i class="mdi mdi-clipboard-edit-outline mdi-24px"></i></a>'
                                    + '<a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Borrar" onclick="deleteField(event, '+ row.cells[0].data +')" >' + (row.cells[4].data == '1' ? '<i class="mdi mdi-lock-open mdi-24px"></i>' : '<i class="mdi mdi-lock mdi-24px text-secondary"></i>') + '</a>';
                                }
                            }
                            actionsHtml += '</div>';
                            return gridjs.html(actionsHtml);
                        },
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
                    if($currentUser->hasAccess('dynamicform.forms.indexall')){
                        $companies=company()->id?company()->id:null;
                    }else{
                        $companies=company()->id?company()->id:array_values(companies()->map(function ($company){
                            return $company->id;
                        })->toArray());
                    }
                    $params=['include'=>'companies','companies'=>$companies];
                @endphp
                url: '{!!route('api.dynamicform.form.index',$params)!!}',
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
            },
            style: {
                table: {
                    'overflow-x': 'auto',  // scrolling horizontal
                    'max-height': '400px', // establece la altura máxima para scrolling vertical
                }
            },
        }).render(document.getElementById("table-form"));

        function deleteField(event, field) {
            event.preventDefault(); // Evita que el navegador siga el enlace

            Swal.fire({
                title: "¿Estás seguro de que quieres cambiar el estado de este formulario?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Cambiar!",
                cancelButtonText: "Cancelar"
                }).then((result) => {
                if (result.isConfirmed) {
                    // Realizar la solicitud DELETE con Axios
                    axios.put(`/preoperativo/form/${field}/borrar`, {
                        headers: {
                            'Authorization': `Bearer {{$currentUser->getFirstApiKey()}}`,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        // Verificar si la solicitud fue exitosa
                        if (response.status === 200) {
                            Swal.fire({
                                title: "Actualizado!",
                                text: "Campo actualizado exitosamente.",
                                icon: "success"
                            });
                            // Actualizamos la tabla después de la eliminación
                            mygrid.forceRender();
                        } else {
                            // Manejar el caso en que la solicitud no fue exitosa
                            throw new Error('Error al eliminar el campo');
                        }
                    })
                    .catch(error => {
                        // Manejar errores
                        console.error(error);
                        Swal.fire('Error al eliminar el campo');
                    });
                }
            });
        }
    </script>


<script type="application/javascript">
    $(document).ready(function() {
        // Verificar si company()->id está definido
        var companyId = {{ $currentUser->driver->company->id  ? $currentUser->driver->company->id  : null }};
            if (companyId !== null) {
                // Llama a la API para obtener los datos
                var url = "{{ route('api.dynamicform.formresponse.vehicles', ['companyId' => ':companyId']) }}";
                url = url.replace(':companyId', companyId); // Reemplazar el marcador de posición con el companyId

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
            }
        })
    </script>
    <style>
        #qrcode img {
            margin: auto;
        }
    </style>
@endsection
