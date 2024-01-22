@extends('layouts.master')
@section('title')
    Completar Evento {{$event->description}}
@endsection

@section('css')
    <link rel="stylesheet" href="{{Theme::url('libs/gridjs/gridjs.min.css')}}">
    <link rel="stylesheet" href="{{Theme::url('libs/flatpickr/flatpickr.min.css')}}">
    <link href="{{Theme::url('libs/alertifyjs/alertifyjs.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{Theme::url('libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@php
    $company = $event->company_id;
@endphp
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Mantenimeinto
        @endslot
        @slot('title')
            Completar Evento {{$event->description}}
        @endslot
    @endcomponent
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
                                    <h5 class="font-size-16 mb-1"> Completar Evento</h5>
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
                            {!! Form::open(['route' => ['maintenance.event.update',$event->id], 'method' => 'put']) !!}
                            <input type="hidden" name="status" value="2">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body ">
                                            @if(isset($event->form_verify) && !empty($event->form_verify))
                                                @foreach($event->form_verify as $i=>$item)
                                                    <div class="row font-size-20 mb-3">
                                                        <div class="col-1">
                                                            <label class="form-check-label" for="formCheckRight1">
                                                                {{$i+1}}
                                                            </label>
                                                        </div>
                                                        <div class="col-5">
                                                            <label class="form-check-label" for="formCheckRight1">
                                                                {{$item['question']}}
                                                            </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                   id="form_verify[{{$i}}][answer]" required>
                                                        </div>
                                                    </div>

                                                @endforeach

                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--
                                                <label class="form-label" for="guia">Cédula De Ciudadanía</label>
                                                <input id="identification" name="identification"
                                                       placeholder="Agrega Cédula De Ciudadanía"
                                                       type="text"
                                                       value="{{old('identification',$event->identification)}}"
                                                       class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="guia">Nombre</label>
                                                <input id="first_name" name="first_name" placeholder="Agrega Nombre"
                                                       type="text"
                                                       value="{{old('first_name',$event->user->first_name)}}"
                                                       class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="guia">Apellido</label>
                                                <input id="last_name" name="last_name" placeholder="Agrega Apellido"
                                                       type="text"
                                                       value="{{old('last_name',$event->user->last_name)}}"
                                                       class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="guia">Correo Electrónico</label>
                                                <input id="email" name="email" placeholder="Agrega Correo Electrónico"
                                                       value="{{old('email',$event->user->email)}}"
                                                       type="text"
                                                       class="form-control">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="guia">Teléfono</label>
                                                <input id="phone" name="phone" placeholder="Agrega Teléfono" type="text"
                                                       value="{{old('phone',$event->phone)}}"
                                                       class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="guia">Punto</label>
                                                <input id="pick_up_point" name="pick_up_point"
                                                       placeholder="Agrega Nombre de dispositivo" type="text"
                                                       value="{{old('pick_up_point',$event->pick_up_point)}}"
                                                       class="form-control">
                                            </div>
                                            <div class="mb-3 {{ $errors->has("route_id") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="route_id">Ruta</label>
                                                <select class="form-control" data-trigger name="route_id"
                                                        id="route_id">
                                                    <option value="">Seleccione Ruta</option>
                                                    @foreach($routes as $route)
                                                        <option value="{{$route->id}}" {{$route->id == old('route_id',$event->route_id) ? 'selected' : ''}}>{{$route->name}}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('route_id', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            @if($currentUser->hasAccess('sass.companies.index'))
                                                <div
                                                        class="mb-3 {{ $errors->has("company_id") ? ' was-validated' : '' }}">
                                                    <label class="form-label" for="company_id">Compañia</label>
                                                    <select class="form-control" data-trigger name="company_id"
                                                            id="company_id">
                                                        <option value="">Seleccione Compañia</option>
                                                        @foreach($companies as $company)
                                                            <option
                                                                    value="{{$company->id}}" {{$company->id == old('company_id',$event->company_id) ? 'selected' : ''}} >{{$company->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    {!! $errors->first('route_id', '<div class="invalid-feedback">:message</div>') !!}
                                                </div>
                                            @else
                                                <input type="hidden" name="company_id"
                                                       value="{{$event->company_id}}">
                                            @endif
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <div
                                                            class="checkbox{{ $errors->has('activated') ? ' has-error' : '' }}">
                                                        <?php $oldValue = (bool)$event->user->isActivated() ? 'checked' : ''; ?>
                                                        <label for="is_activated">
                                                            <input id="is_activated"
                                                                   name="is_activated"
                                                                   type="checkbox"
                                                                   class="form-check-input"
                                                                   {{ old('activated', $oldValue) }}
                                                                   value="1"/>
                                                            {{ trans('user::users.form.is activated') }}
                                                            {!! $errors->first('activated', '<span class="help-block">:message</span>') !!}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>--}}
                            <div class="row mb-4">
                                <div class="col text-end">
                                    <a href="{{route('maintenance.event.index')}}" class="btn btn-danger"> <i
                                                class="bx bx-x me-1"></i>
                                        Cancelar </a>
                                    <button type="submit" class="btn btn-success"><i class=" bx bx-file me-1"></i>
                                        Guardar
                                    </button>
                                </div> <!-- end col -->
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
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
                                    <h5 class="font-size-16 mb-1">Documentos y Fotografias</h5>
                                    <p class="text-muted text-truncate mb-0">Listado de Archivos</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                </div>

                            </div>

                        </div>
                    </a>

                    <div id="addproduct-alert-collapse" class="collapse" data-bs-parent="#addproduct-accordion">
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
                                                                <button
                                                                        class="btn btn-success waves-effect waves-light mb-2 me-2"
                                                                        id="add-file" onclick="openModal()">
                                                                    <i
                                                                            class="mdi mdi-plus me-1"></i> Agregar Archivo
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="table-files"></div>
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
    <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id=orderdetailsModalLabel">Cargar Archivos </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="text-muted">
                                <h5 class="font-size-15 mb-2">Cargar Archivo</h5>
                                <form class="dropzone" id="event_file"
                                      action="#" method="post">
                                    <div class="fallback">
                                        <input name="file" type="file">
                                        <input name="documentable_id" type="hidden" value="{{$event->id}}">
                                    </div>
                                    <div class="dz-message needsclick">
                                        <div class="mb-3">
                                            <i class="display-4 text-muted mdi mdi-cloud-upload"></i>
                                        </div>
                                        <h4>Suelte los archivos aquí o haga clic para cargar.</h4>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cancel-modal-order" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ Theme::url('libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ Theme::url('js/app.js') }}"></script>
    <script src="{{ Theme::url('libs/dropzone/dropzone.min.js') }}"></script>
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
        Dropzone.autoDiscover = false;
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
                        id: 'extension',
                        name: 'Nombre ',
                        formatter: (function (cell) {
                            switch (cell) {
                                case 'application/pdf':
                                    return gridjs.html('<i class="mdi text-danger mdi-file-pdf" style="font-size: 43px"></i>')
                                    break;
                                case 'image/png':
                                    return gridjs.html('<i class="mdi text-muted mdi-image-edit-outline" style="font-size: 43px"></i>')
                                    break;
                                case 'image/jpg':
                                    return gridjs.html('<i class="mdi text-success mdi-image" style="font-size: 43px"></i>')
                                    break;
                                default:
                                    return gridjs.html('<i class="mdi text-secondary mdi-file-document-outline" style="font-size: 43px"></i>')
                            }

                        })
                    },
                    {
                        id: 'name',
                        name: 'Nombre del Archivo ',
                    },
                    {
                        id: "route",
                        name: "Descargar",
                        sort: {
                            enabled: false
                        },
                        formatter: (function (cell) {
                            return gridjs.html('<div class="d-flex gap-3"><a href="' + cell + '" data-bs-toggle="tooltip" data-bs-placement="top" title="download" class="text-success" target="_blank"><i class="mdi mdi-cloud-download-outline font-size-18"></i></a></div>');
                        })
                    }

                ],
            pagination: {
                limit: 12,
                server: {
                    url: (prev, page, limit) => `${prev}?&limit=${limit}&page=${page + 1}`
                }
            },
            sort: true,
            search: true,
            server: {
                url: '{{route('api.transport.document.index',['documentable_id'=>$event->id,'documentable_type'=>'Modules\\Maintenance\\Entities\\Event'])}}',
                headers: {
                    Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                    'Content-Type': 'application/json'
                },
                then: data => data.data,
                total: data => data.meta.page.total
            }
        }).render(document.getElementById("table-files"));
        function openModal() {
            $('#addDocumentModal').modal('show')
            let token = "{{$currentUser->getFirstApiKey() }}";
            let image = '';
            let myDropzone = new Dropzone("#event_file", {
                url: "{{route('api.transport.document.store')}}",
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                },
                method: 'post',
                autoUpload: true,
                uploadMultiple: false,
                paramName: 'file',
                params: {'documentable_id': {{$event->id}}, 'documentable_type':'Modules\\Maintenance\\Entities\\Event'}
            })
            myDropzone.on("success", function (file, response) {
                console.log(response)
                alertify.success('Archiovo Guardado');
                mygrid.updateConfig({
                    server: {
                        url: '{{route('api.transport.document.index',['documentable_id'=>$event->id,'documentable_type'=>'Modules\\Maintenance\\Entities\\Event'])}}',
                        headers: {
                            Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                            'Content-Type': 'application/json'
                        },
                        then: data => data.data,
                        total: data => data.meta.page.total
                    }
                }).forceRender();

            });
            $('#cancel-modal-vehicle').on('click', function () {
                myDropzone.removeAllFiles();
            });


        }



    </script>
@endsection
