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
    {!! Form::open(['route' => ['dynamicform.form.update',$form->id], 'method' => 'post', 'class'=>'needs-validation']) !!}
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
                                    <h5 class="font-size-16 mb-1"> Editar Formulario de Preoperativo</h5>
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
                                                <input type="hidden" name="color" id="color" value="">
                                                <div class="color-picker"></div>
                                                {!! $errors->first('color', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("icon") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="icon">Icono</label>
                                                <div class="input-group input-group-lg">
                                                    <input id="icon" name="icon"
                                                           placeholder="iconos"
                                                           type="hidden"
                                                           value="{{old('icon',$form->icon)}}"
                                                           class="form-control"
                                                           data-placement="bottomRight"

                                                    >
                                                    <span class="input-group-addon input-group-text"></span>
                                                </div>
                                                {!! $errors->first('color', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div
                                                    class="checkbox{{ $errors->has('active') ? ' was-validated' : '' }}">
                                                <label for="active">
                                                    <input id="active"
                                                           name="active"
                                                           type="checkbox"
                                                           class="form-check-input"
                                                           {{ old('active',boolval($form->active))?'checked':'' }}
                                                           value="1"/>
                                                    Activo
                                                    {!! $errors->first('activated', '<div class="invalid-feedback">:message</div>') !!}
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
    <div class="row mb-4">
        <div class="col text-end">
            <a href="{{route('transport.vehicles.index')}}" class="btn btn-danger"> <i class="bx bx-x me-1"></i>
                Cancelar </a>
            <button type="submit" class="btn btn-success"><i class=" bx bx-file me-1"></i> Guardar</button>
        </div> <!-- end col -->
    </div>
    {!! Form::close() !!}
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
                                <h5 class="font-size-16 mb-1">Filas</h5>
                                <p class="text-muted text-truncate mb-0">Configuracion de filas del formulario</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <div id="addproduct-alert-collapse" class="collapse"
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
                                                            <a href="{{route('dynamicform.field.create',[$form->id])}}"
                                                               class="btn btn-success waves-effect waves-light mb-2 me-2"
                                                               id="add-file">
                                                                <i
                                                                        class="mdi mdi-plus me-1"></i> Agregar
                                                                Fila
                                                            </a>
                                                            <button
                                                                    class="btn btn-primary waves-effect waves-light mb-2 me-2"
                                                                    id="add-file" onclick="openModalEvent()"
                                                                    type="button">
                                                                <i
                                                                        class="mdi mdi-calendar me-1"></i> Importar
                                                                Filas
                                                            </button>
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <a href="#response-alert-collapse" class="text-dark collapsed" data-bs-toggle="collapse"
                   aria-haspopup="true" aria-expanded="false" aria-haspopup="true"
                   aria-controls="response-alert-collapse">
                    <div class="p-4">

                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm">
                                    <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                        03
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="font-size-16 mb-1">Respuestas</h5>
                                <p class="text-muted text-truncate mb-0">Listado de Respuestas del formulario</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <div id="response-alert-collapse" class="collapse"
                     data-bs-parent="#addproduct-accordion">
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
    </div>
@endsection
@section('script')
    <script src="{{ Theme::url('libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/@simonwep/@simonwep.min.js') }}"></script>
    <script src="{{ Theme::url('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{Theme::url('js/app.js')}}"></script>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ Theme::url('libs/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js') }}"></script>
    <script src="{{Theme::url('libs/choices.js/choices.js.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
            integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="application/javascript" async>
        (function () {
            'use strict';
            let token = "{{$currentUser->getFirstApiKey() }}";
            window.addEventListener('load', function () {
                var nanoPickr = Pickr.create({
                    el: '.color-picker',
                    theme: 'nano',
                    default: '#03A9F4',
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
                        id: 'id',
                        name: '#',
                        sort: {
                            enabled: false
                        },
                        formatter: (function (cell) {
                            return gridjs.html('<div class="form-check font-size-16"><input class="form-check-input" type="checkbox" id="orderidcheck' + cell + '"><label class="form-check-label" for="orderidcheck' + cell + '">' + cell + '</label></div>');
                        })
                    },
                    {
                        id: 'label',
                        name: 'Etiqueta',

                    },
                    {
                        id: 'name',
                        name: 'name',

                    },
                    {
                        id: 'type',
                        name: 'Tipo',
                    },
                    {
                        id: 'order',
                        name: 'Orden',
                    },
                    {
                        id: "created_at",
                        name: "Creado el",
                        formatter: (_, cell) => moment(cell).format('YYYY-MM-DD')
                    },
                    {
                        id: "id",
                        name: "Action",
                        sort: {
                            enabled: false
                        },
                        formatter: (function (cell) {
                            return gridjs.html('<div class="d-flex gap-3"><a href="/preoperativo/form/{{$form->id}}/field/' + cell + '/edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" class="text-success"><i class="mdi mdi-eye-outline font-size-18"></i></a><a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a></div>');
                        })
                    }

                ],
            pagination: {
                limit: 12,
                server: {
                    url: (prev, page, limit) => `${prev}&limit=${limit}&page=${page + 1}`
                }
            },
            sort: true,
            search: {
                server: {
                    url: (prev, keyword) => `${prev}&search=${keyword}`
                }
            },
            server: {
                @php
                     $params=['include'=>'form','form'=>$form->id];
                @endphp
                url: '{!!route('api.dynamicform.field.index',$params)!!}',
                headers: {
                    Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                    'Content-Type': 'application/json'
                },
                then: data => data.data,
                total: data => data.meta.page.total
            }
        }).render(document.getElementById("table-fields"));

    </script>
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
                        sort: {
                            enabled: false
                        },
                        formatter: (function (cell) {
                            return gridjs.html('<div class="form-check font-size-16"><input class="form-check-input" type="checkbox" id="orderidcheck' + cell + '"><label class="form-check-label" for="orderidcheck' + cell + '">' + cell + '</label></div>');
                        })
                    },
                    {
                        id: 'user',
                        name: 'Colaborador',
                        formatter: (function (cell) {
                            return cell.fullname;
                        })
                    },
                    {
                        id: 'negative_num',
                        name: 'Respuestas Negativas',

                    },
                    {
                        id: 'company',
                        name: 'Empresa',
                        formatter: (function (cell) {
                            return cell.name;
                        })
                    },
                    {
                        id: "created_at",
                        name: "Creado el",
                        formatter: (_, cell) => moment(cell).format('YYYY-MM-DD')
                    },
                    {
                        id: "id",
                        name: "Action",
                        sort: {
                            enabled: false
                        },
                        formatter: (function (cell) {
                            return gridjs.html('<div class="d-flex gap-3"><a href="/preoperativo/form/{{$form->id}}/response/' + cell + '/edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" class="text-success"><i class="mdi mdi-eye-outline font-size-18"></i></a><a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a></div>');
                        })
                    }

                ],
            pagination: {
                limit: 12,
                server: {
                    url: (prev, page, limit) => `${prev}&limit=${limit}&page=${page + 1}`
                }
            },
            sort: true,
            search: {
                server: {
                    url: (prev, keyword) => `${prev}&search=${keyword}`
                }
            },
            server: {
                @php
                    $companies=company()->id?company()->id:array_values(companies()->where('type',1)->map(function ($company){
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

    </script>
    <style>
        .fade:not(.show) {
            opacity: 1;
        }
    </style>
@endsection

