@extends('layouts.master')
@section('title')
    Editar Formulario
@endsection

@section('css')
    {!! Theme::style('libs/sweetalert2/sweetalert2.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/dropzone/dropzone.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/alertifyjs/alertifyjs.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/@simonwep/@simonwep.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/choices.js/choices.js.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/gridjs/gridjs.min.css?v='.config('app.version')) !!}
    <link href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" rel="stylesheet">
    {!! Theme::style('libs/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css?v='.config('app.version')) !!}
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Formularios
        @endslot
        @slot('title')
            Editar Formulario
        @endslot
    @endcomponent
    {!! Form::open(['route' => ['dynamicform.form.update', $form->id], 'method' => 'put', 'class'=>'needs-validation']) !!}
    @csrf
    {{-- COMPONENTE DEL FORMULARIO --}}
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
                                    <h5 class="font-size-16 mb-1"> Editar {{ $form->name ?? "Formulario"}}</h5>
                                    <p class="text-muted text-truncate mb-0">Complete toda la información a continuación</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                </div>

                            </div>

                        </div>
                    </a>
                    <div id="addproduct-productinfo-collapse" class="collapse"
                         data-bs-parent="#addproduct-accordion">
                        <div class="p-4 border-top">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3 {{ $errors->has("name") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="name">Nombre</label>
                                                <input id="name" name="name"
                                                       placeholder="Agrega Nombre del Formulario"
                                                       type="text"
                                                       value="{{old('name',$form->name)}}"
                                                       class="form-control">
                                                {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("caption") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="caption">Descripción</label>
                                                <textarea id="caption"
                                                          name="caption"
                                                          placeholder="Agrega Descripción Corta"
                                                          rows="3"
                                                          class="form-control">{{old('caption',$form->caption)}}</textarea>
                                                {!! $errors->first('caption', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("companies") ? ' was-validated' : '' }}"
                                                 style="{{$currentUser->hasAccess('sass.companies.indexall')|| (companies() > 0 && empty(company()->id))?"display:block":"display:none"}}">
                                                <label for="companies" class="form-label font-size-13 text-muted">Empresas
                                                    Asignadas</label>
                                                <select class="form-control" name="companies[]"
                                                        id="companies"
                                                        placeholder="Selecciones Compañias " multiple>
                                                    @php
                                                        $companiesOld=$form->companies->map(function ($company){
                                                            return $company->id;
                                                        })->toArray();
                                                    @endphp
                                                    @foreach(companies() as $company)
                                                        <option
                                                                value="{{$company->id}}" {{in_array($company->id ,old('companies',$companiesOld)) ? 'selected' : ''}} >{{$company->name}}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('route_id', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="mb-3 {{ $errors->has("color") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="color">Color</label>
                                                <input type="hidden" name="color" id="color" value="{{old('color', $form->color)}}">
                                                <div class="color-picker"></div>
                                                {!! $errors->first('color', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("icon") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="icon">Icono</label>
                                                <div class="input-group input-group-lg">
                                                    <input id="icon" name="icon"
                                                           placeholder="iconos"
                                                           type="hidden"
                                                           value="{{old('icon', $form->icon)}}"
                                                           class="form-control"
                                                           data-placement="bottomRight"

                                                    >
                                                    <span class="input-group-addon input-group-text"></span>
                                                </div>
                                                {!! $errors->first('color', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="checkbox{{ $errors->has('active') ? ' was-validated' : '' }}">
                                                <label for="active">
                                                    <input id="active"
                                                           name="active"
                                                           type="checkbox"
                                                           class="form-check-input"
                                                           {{ $form->active  ? 'checked' : '' }}
                                                           value="1"/>
                                                    Activo
                                                    {!! $errors->first('active', '<div class="invalid-feedback">:message</div>') !!}
                                                </label>
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
    {{-- FIN DEL COMPONENTE DEL FORMULARIO --}}
    
    {{-- BOTONES DE ACCIONES --}}
    <div class="row mb-4">
        <div class="col text-end">
            <a href="{{route('dynamicform.form.index')}}" class="btn btn-danger"> <i class="bx bx-x me-1"></i> Cancelar </a>
            <button type="submit" class="btn btn-success"><i class=" bx bx-file me-1"></i> Guardar</button>
        </div> 
    </div>
    {{-- FIN DE BOTONES DE ACCIONES --}}
    {!! Form::close() !!}

    {{-- COMPONENTE DE PREGUNTAS --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <a href="#addproduct-alert-collapse" class="text-dark collapsed" data-bs-toggle="collapse"
                   aria-haspopup="true" aria-expanded="false" aria-haspopup="true"
                   aria-controls="addproduct-alert-collapse">
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
                                <h5 class="font-size-16 mb-1">Agregar campos</h5>
                                <p class="text-muted text-truncate mb-0">Configuracion de campos del formulario</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <div id="addproduct-alert-collapse" class="collapse show"
                     data-bs-parent="#addproduct-accordion">
                    <div class="p-4 border-top">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="position-relative">
                                            <div class="modal-button mt-2">
                                                <div class="row align-items-start">
                                                    <div class="col-sm">
                                                        <div>
                                                            
                                                            <a href="{{route('dynamicform.form.show',[$form->id])}}"
                                                                title="Vista previa" 
                                                                class="btn btn-info waves-effect waves-light mb-2 me-2">
                                                                <i class="mdi mdi-eye-outline me-1"></i>Vista previa
                                                            </a>

                                                            <a href="{{route('dynamicform.field.create',[$form->id])}}"
                                                                title="Agregar campos"
                                                                class="btn btn-primary waves-effect waves-light mb-2 me-2"
                                                                id="add-file">
                                                            <i class="mdi mdi-plus me-1"></i> Agregar </a>
                                                                
                                                            {{-- <button type="button" class="btn btn-primary waves-effect waves-light mb-2 me-2" id="open-modal-button" data-bs-toggle="modal" data-bs-target="#table-modal">
                                                                <i class="mdi mdi-calendar me-1"></i> Importar campos
                                                            </button> --}}
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="table-fields"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- FIN DEL COMPONENTE DE PREGUNTAS --}}


    <!-- MODAL PARA MOSTRAR LA TABLA DE FILES-->
<div class="modal fade" id="table-modal" tabindex="-1" role="dialog" aria-labelledby="table-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="table-modal-label">Tabla de Campos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="position-relative">
                    <div class="modal-button mt-2">
                        <div class="row align-items-start">
                            <div class="col-sm">
                                <div>
                                    <a href="{{route('dynamicform.field.create',[$form->id])}}"
                                       class="btn btn-primary waves-effect waves-light mb-2 me-2"
                                       id="add-file">
                                    <i class="mdi mdi-plus me-1"></i> Agregar </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="table-fields2"></div>
            </div>
        </div>
    </div>
</div>
<!-- FIN MODAL -->


@endsection
@section('script')
    <script src="{{ Theme::url('libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/@simonwep/@simonwep.min.js') }}"></script>
    <script src="{{ Theme::url('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ Theme::url('js/app.js')}}"></script>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ Theme::url('libs/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js') }}"></script>
    <script src="{{ Theme::url('libs/choices.js/choices.js.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
            integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    {{-- JS PARA EDICION DEL FORM --}}
    <script type="application/javascript" async>
        (function () {
            'use strict';
            let token = "{{$currentUser->getFirstApiKey() }}";
            window.addEventListener('load', function () {
                document.getElementById('add-file').focus();
                var nanoPickr = Pickr.create({
                    el: '.color-picker',
                    theme: 'nano',
                    default: '{{$form->color}}',
                    swatches: [
                        'rgba(244, 67, 54, 1)',
                        'rgba(233, 30, 99, 1)',
                        'rgba(156, 39, 176,1)',
                        'rgba(103, 58, 183, 1)',
                        'rgba(63, 81, 181, 1)',
                        'rgba(33, 150, 243, 1)',
                        'rgba(3, 169, 244, 1)'
                    ],
                    defaultRepresentation: 'HEXA',
                    components: {

                        // Main components
                        preview: true,
                        opacity: true,
                        hue: true,

                        // Input / output Options
                        interaction: {
                            hex: true,
                            rgba: false,
                            hsva: false,
                            input: true,
                            clear: true,
                            save: true
                        }
                    }
                });
                nanoPickr.on('save', (color, instance) => {
                    const data = nanoPickr.getSelectedColor().toHEXA().toString(0)
                    $("#color").val(data)
                }).on('init', instance => {
                    const color = nanoPickr.getSelectedColor().toHEXA().toString(0)
                    console.log();
                    $("#color").val(color)
                })
                $('#icon').iconpicker({
                    placement: 'bottomRight',
                });
                new Choices('#companies', {
                    removeItemButton: true,
                });
            })
        })();
    </script>
    {{-- FIN DE JS PARA EDICION DEL FORM --}}

    {{-- JS PARA RENDERIZAR LA TABLA DE CAMPOS --}}
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
                        id: 'order',
                        name: 'Orden',
                        width: '100px',

                    },
                    {
                        id: 'label',
                        name: 'Etiqueta',
                        width: '400px',
                    },          
                    {
                        id: 'required',
                        name: 'Requerido',
                        width: '150px',
                        formatter: (function (cell) {
                            return gridjs.html(cell == '1' ? '<span class="badge badge-pill badge-soft-success font-size-12">Requerido</span>' : '<span class="badge badge-pill badge-soft-secondary font-size-12">Opcional</span>');
                        })
                    },
                    {
                        id: "created_at",
                        name: "Creado el",
                        width: '150px',
                        formatter: (_, cell) => moment(cell).format('YYYY-MM-DD')
                    },
                    {
                        id: "id",
                        name: "Action",
                        width: '110px',
                        sort: {
                            enabled: false
                        },
                        formatter: (function (cell) {
                            return gridjs.html('<div class="d-flex gap-3">'
                                + '<a href="/preoperativo/form/{{$form->id}}/field/' + cell + '/edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" class="text-success"><i class="mdi mdi-clipboard-edit-outline mdi-24px" ></i></a>'
                                + '<a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Borrar" class="text-danger"  onclick="deleteField(event, '+ cell +')" ><i class="mdi mdi-delete mdi-24px"></i></a>'
                                + '<a href="/preoperativo/form/{{$form->id}}/field/' + cell + '/orden/1" data-bs-toggle="tooltip" data-bs-placement="top" title="Subir" class="text-secondary"><i class="mdi mdi-arrow-up-bold-circle-outline mdi-24px"></i></a>'
                                + '<a href="/preoperativo/form/{{$form->id}}/field/' + cell + '/orden/-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Bajar" class="text-secondary"><i class="mdi mdi-arrow-down-bold-circle-outline mdi-24px"></i></a>'
                                + '</div>');
                        })
                    }

                ],
            pagination: {
                limit: 10,
                server: {
                    url: (prev, page, limit) => `${prev}&limit=${limit}&page=${page + 1}`
                }
            },
            sort: true,
            search: {
                debounceTimeout: 300, // Tiempo de espera en milisegundos (300 ms = 0.3 segundos)
                server: {
                    url: (prev, keyword) => `${prev}&search=${keyword}`
                }
            },
            server: {
                @php
                     $params=['include'=>'form','form'=>$form->id, 'order'=>['field'=>'order','way'=>'asc']];
                @endphp
                url: '{!!route('api.dynamicform.field.index',$params)!!}',
                headers: {
                    Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                    'Content-Type': 'application/json'
                },
                then: data => data.data,
                total: data => data.meta.page.total
            },   
            style: {
                table: {
                    'overflow-x': 'auto',  // scrolling horizontal
                    'max-height': '400px', // establece la altura máxima para scrolling vertical
                }
            }
        }).render(document.getElementById("table-fields"));

        function deleteField(event, field) {
            event.preventDefault(); // Evita que el navegador siga el enlace

            if (confirm("¿Estás seguro de que quieres eliminar este campo?")) {
                // Realizar la solicitud DELETE con Axios
                axios.delete(`/preoperativo/form/{{$form->id}}/field/${field}/borrar`, {
                    headers: {
                        'Authorization': `Bearer {{$currentUser->getFirstApiKey()}}`,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    // Verificar si la solicitud fue exitosa
                    if (response.status === 200) {
                        alert('Campo eliminado exitosamente');
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
                    alert('Error al eliminar el campo');
                });
            }
        }

    </script>
    {{-- FIN DE JS DEL RENDERIZADO DE LA TABLA DE CAMPOS --}}


    {{-- CODIGO PARA HACER LAS IMPORTACIONES DESDE EL FULL DE PREGUNTAS QUE TENGA CREADA ESA EMPRESA --}}
  <script type="application/javascript" async>
    // document.addEventListener("DOMContentLoaded", function () {
    //     // Escuchar el evento mostrado de la modal
    //     $('#table-modal').on('shown.bs.modal', function () {
    //         // Renderizar la tabla dentro de la modal
    //         renderizarTabla();
    //     });

    //     // Escuchar el evento ocultado de la modal
    //     $('#table-modal').on('hidden.bs.modal', function () {
    //         // Borrar el contenido de la tabla
    //         document.getElementById("table-fields2").innerHTML = '';
    //     });
    // });

 

// function renderizarTabla() {
    // const loading = new Loader();
    // const mygrid = new gridjs.Grid({
    //         // Configuración de la tabla...
    //         language: {
    //             'search': {
    //                 'placeholder': 'Buscar...'
    //             },
    //             'pagination': {
    //                 'previous': 'Prev.',
    //                 'next': 'Sig.',
    //                 'showing': 'Mostrando',
    //                 'results': () => 'resultados'
    //             }
    //         },
    //         columns:
    //             [
    //                 {
    //                 id: 'id',
    //                 name: '#',
    //                 sort: {
    //                     enabled: false
    //                 },
    //                 formatter: (function (cell) {
    //                     return gridjs.html('<div class="form-check font-size-16"><input class="form-check-input" type="checkbox" id="orderidcheck' + cell + '"><label class="form-check-label" for="orderidcheck' + cell + '">' + cell + '</label></div>');
    //                     })
    //                 },
    //                 {
    //                     id: 'order',
    //                     name: 'Orden',
    //                 },
    //                 {
    //                     id: 'label',
    //                     name: 'Etiqueta',

    //                 },          
    //                 {
    //                     id: 'required',
    //                     name: 'Requerido',
    //                     formatter: (function (cell) {
    //                         return gridjs.html(cell == '1' ? '<span class="badge badge-pill badge-soft-success font-size-12">Requerido</span>' : '<span class="badge badge-pill badge-soft-secondary font-size-12">Opcional</span>');
    //                     })
    //                 },
    //                 {
    //                     id: "created_at",
    //                     name: "Creado el",
    //                     formatter: (_, cell) => moment(cell).format('YYYY-MM-DD')
    //                 }
    //             ],
    //         pagination: {
    //             limit: 12,
    //             server: {
    //                 url: (prev, page, limit) => `${prev}&limit=${limit}&page=${page + 1}`
    //             }
    //         },
    //         sort: {
    //             initialColumn: 'order', // Columna inicial de ordenamiento
    //             initialDirection: 'asc' // Dirección inicial de ordenamiento
    //         },
    //         search: {
    //             debounceTimeout: 300, // Tiempo de espera en milisegundos (300 ms = 0.3 segundos)
    //             server: {
    //                 url: (prev, keyword) => `${prev}&search=${keyword}`
    //             }
    //         },
    //         server: {
    //             @php
    //                 $params=['include'=>'form','form'=>$form->id, 'order'=>['field'=>'order','way'=>'asc']];
    //             @endphp
    //             url: '{!!route('api.dynamicform.field.index',$params)!!}',
    //             headers: {
    //                 Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
    //                 'Content-Type': 'application/json'
    //             },
    //             then: data => data.data,
    //             total: data => data.meta.page.total
    //         },
    //         style: {
    //             table: {
    //                 'overflow-x': 'auto',  // scrolling horizontal
    //                 'max-height': '400px', // establece la altura máxima para scrolling vertical
    //             }
    //         },
    //     }).render(document.getElementById("table-fields2"));
    // }
</script>


    <style>
        .fade:not(.show) {
            opacity: 1;
        }
    </style>
@endsection