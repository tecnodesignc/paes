@extends('layouts.master')
@section('title')
    Eventos
@endsection
@section('css')
    {!! Theme::style('libs/fullcalendar/fullcalendar.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/alertifyjs/alertifyjs.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/flatpickr/flatpickr.min.css?v='.config('app.version')) !!}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.6.6/dragula.css"
          integrity="sha512-gGkweS4I+MDqo1tLZtHl3Nu3PGY7TU8ldedRnu60fY6etWjQ/twRHRG2J92oDj7GDU2XvX8k6G5mbp0yCoyXCA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
@stop

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            {{company()->id?company()->name:'Eje Satelital'}}
        @endslot
        @slot('title')
            Eventos
        @endslot
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="position-relative">
                            <div class="modal-button mt-2">
<!--                                <button data-bs-toggle="modal" data-bs-target="#add-new-task-modal"
                                        class="btn btn-success waves-effect waves-light mb-2 me-2"><i
                                            class="mdi mdi-plus me-1"></i> Nuevo Evento
                                </button>-->
                            </div>
                        </div>
                        <div class="row mt-5 pt-5">
                            <div class="col-12">
                                <div class="board">
                                    <div class="tasks" data-plugin="dragula"
                                         data-containers="[&quot;pending&quot;, &quot;scheduled&quot;, &quot;done&quot;, &quot;expired&quot;, &quot;canceled&quot;]">
                                        <h5 class="mt-0 task-header text-uppercase">Pendientes (<span
                                                    id="pending-count">0</span>)</h5>
                                        <div id="pending" class="task-list-items">

                                        </div> <!-- end company-list-1-->
                                    </div>

                                    <div class="tasks">
                                        <h5 class="mt-0 task-header text-uppercase">Programada (<span
                                                    id="scheduled-count">0</span>)
                                        </h5>

                                        <div id="scheduled" class="task-list-items">


                                        </div> <!-- end company-list-2-->
                                    </div>


                                    <div class="tasks">
                                        <h5 class="mt-0 task-header text-uppercase">Realizadas (<span
                                                    id="done-count">0</span>)</h5>
                                        <div id="done" class="task-list-items">

                                        </div> <!-- end company-list-3-->
                                    </div>

                                    <div class="tasks">
                                        <h5 class="mt-0 task-header text-uppercase">Vencidas (<span
                                                    id="expired-count">0</span>)</h5>
                                        <div id="expired" class="task-list-items">

                                        </div> <!-- end company-list-4-->
                                    </div>
                                    <div class="tasks">
                                        <h5 class="mt-0 task-header text-uppercase">Canceladas (<span
                                                    id="canceled-count">0</span>)</h5>
                                        <div id="canceled" class="task-list-items">

                                        </div> <!-- end company-list-4-->
                                    </div>
                                </div> <!-- end .board-->
                            </div> <!-- end col -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row-->
    </div>
    <div class="modal fade" id="add-new-task-modal" tabindex="-1"
         aria-labelledby="NewTaskModalLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="NewTaskModalLabel">Crear Nueva Tarea</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation p-2" name="event-form" id="form-event" novalidate>
                        <div class="row">
                            <div class="{{empty(company()->id)?'col-md-6':'col-12'}}">
                                <div class="mb-3">
                                    <label class="form-label">Tipo de Evento</label>
                                    <select class="form-select shadow-none" name="event-type"
                                            id="event-type" required>
                                        <option value="0">Tarea</option>
                                        <option value="1">Recordatorio</option>
                                        {{--<option value="2">Mantenimiento Preventivo</option>
                                        <option value="3">Mantenimiento Correctivo</option>--}}
                                    </select>
                                </div>
                            </div>
                            @if(empty(company()->id))
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="company_id">Compañia</label>
                                        <select class="form-control" data-trigger name="company_id"
                                                id="company_id">
                                            <option value="">Seleccione Compañia</option>
                                            @foreach(companies()->where('type',1) as $company)
                                                <option value="{{$company->id}}" {{$company->id == old('company_id') ? 'selected' : ''}} >{{$company->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            @else
                                <input type="hidden" name="company_id" value="{{company()->id}}">
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="task-description" class="form-label">Descripcción</label>
                                    <input type="text" class="form-control form-control-light" name="description"
                                           id="task-description"
                                           placeholder="Descripcción ">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Fecha</label>
                                    <input id="alert" name="alert"
                                           placeholder="Agrega Fecha de Vencimiento"
                                           type="text"
                                           class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lista de Validación</label>
                            <div id="inputFormRow">
                                <div class="input-group mb-3">
                                    <input type="text" id="form_verify" name="form_verify[question][]"
                                           class="form-control m-input" placeholder="Agregar Validación"
                                           autocomplete="off">
                                    <div class="input-group-append">
                                        <button id="removeRow" type="button" class="btn btn-danger">Eliminar</button>
                                    </div>
                                </div>
                            </div>

                            <div id="newRow"></div>
                            <button id="addRow" type="button" class="btn btn-info">Agregar</button>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="event-end" class="form-label">Finalizar Evento Por</label>
                                    <select class="form-select form-control-light" id="event-end">
                                        <option value="0">Fecha</option>
                                        <option value="1">Kilómetros</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="task-priority" class="form-label">Limite</label>
                                    <input class="form-control" placeholder="Agregar Kilómetros"
                                           type="number" name="limits" id="limits" required value=""/>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="update-task-modal" tabindex="-1"
         aria-labelledby="UpdateTaskModalLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="UpdateTaskModalLabel">Actualizar Tarea</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation p-2" name="event-form-update" id="form-event-update" novalidate>
                        <div class="row">
                            <div class="{{empty(company()->id)?'col-md-6':'col-12'}}">
                                <div class="mb-3">
                                    <label class="form-label">Tipo de Evento</label>
                                    <select class="form-select shadow-none" name="event-type"
                                            id="event-type" required>
                                        <option value="0">Tarea</option>
                                        <option value="1">Recordatorio</option>
                                        <option value="2">Mantenimiento Preventivo</option>
                                        <option value="3">Mantenimiento Correctivo</option>
                                    </select>
                                </div>
                            </div>
                            @if(empty(company()->id))
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="company_id">Compañia</label>
                                        <select class="form-control" data-trigger name="company_id"
                                                id="company_id">
                                            <option value="">Seleccione Compañia</option>
                                            @foreach(companies()->where('type',1) as $company)
                                                <option value="{{$company->id}}" {{$company->id == old('company_id') ? 'selected' : ''}} >{{$company->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            @else
                                <input type="hidden" name="company_id" value="{{company()->id}}">
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="task-description" class="form-label">Descripcción</label>
                                    <input type="text" class="form-control form-control-light" name="description"
                                           id="task-description"
                                           placeholder="Descripcción ">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Fecha</label>
                                    <input id="alert" name="alert"
                                           placeholder="Agrega Fecha de Vencimiento"
                                           type="text"
                                           class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lista de Validación</label>
                            <div id="inputFormRow">
                                <div class="input-group mb-3">
                                    <input type="text" id="form_verify" name="form_verify[question][]"
                                           class="form-control m-input" placeholder="Agregar Validación"
                                           autocomplete="off">
                                    <div class="input-group-append">
                                        <button id="removeRow" type="button" class="btn btn-danger">Eliminar</button>
                                    </div>
                                </div>
                            </div>

                            <div id="newRow"></div>
                            <button id="addRow" type="button" class="btn btn-info">Agregar</button>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="event-end" class="form-label">Finalizar Evento Por</label>
                                    <select class="form-select form-control-light" id="event-end">
                                        <option value="0">Fecha</option>
                                        <option value="1">Kilómetros</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6"  id="limits" style="display: none">
                                <div class="mb-3">
                                    <label for="task-priority" class="form-label">Limite</label>
                                    <input class="form-control" placeholder="Agregar Kilómetros"
                                           type="number" name="limits" required value=""/>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection
@section('script')
    {!! Theme::script('js/app.js?v='.config('app.version')) !!}
    {!! Theme::script('libs/alertifyjs/alertifyjs.min.js?v='.config('app.version')) !!}
    {!! Theme::script('libs/flatpickr/flatpickr.min.js?v='.config('app.version')) !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
            integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.6.6/dragula.min.js"
            integrity="sha512-MrA7WH8h42LMq8GWxQGmWjrtalBjrfIzCQ+i2EZA26cZ7OBiBd/Uct5S3NP9IBqKx5b+MMNH1PhzTsk6J9nPQQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script type="application/javascript" async>
        const loading = new Loader();
        !function ($) {
            "use strict";

            let Dragula = function () {
                this.$body = $("body")
            };


            /* Initializing */
            Dragula.prototype.init = function () {

                $('[data-plugin="dragula"]').each(function () {
                    let token = "{{$currentUser->getFirstApiKey() }}";
                    let containersIds = $(this).data("containers");
                    let containers = [];
                    if (containersIds) {
                        for (let i = 0; i < containersIds.length; i++) {
                            containers.push($("#" + containersIds[i])[0]);
                        }
                    } else {
                        containers = [$(this)[0]];
                    }
                    // if handle provided
                    let handleClass = $(this).data("handleclass");

                    // init dragula
                    if (handleClass) {
                        dragula(containers, {
                            moves: function (el, container, handle) {
                                return handle.classList.contains(handleClass);
                            }
                        });
                    } else {
                        dragula(containers).on('drop', function (e, el, source, handle) {
                            console.log(e.dataset.itemId)
                            console.log(el.id)
                            console.log(source.id)
                            console.log(handle)

                            if(el.id==='done'){
                                location.href ='{{route('maintenance.event.index')}}'+'/done/'+e.dataset.itemId

                            }else{
                                // Obtener el ID del contenedor destino
                                // Construir la URL de la petición
                                const url = '{{route('api.maintenance.event.store')}}/';

                                // Construir los datos de la petición
                                const data = {
                                    status: getStatus(el.id),
                                };

                                // Enviar la petición Axios
                                axios.put(url + e.dataset.itemId, data, {
                                    headers: {
                                        'Authorization': `Bearer ${token}`,
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                                    }
                                }).then(response => {
                                    // Procesar la respuesta del servidor
                                    console.log('Item movido exitosamente');
                                }).catch(error => {
                                    console.error(error);
                                });
                            }

                        });
                    }

                });
            },
                //init dragula
                $.Dragula = new Dragula, $.Dragula.Constructor = Dragula
        }(window.jQuery), function ($) {
            "use strict";
            $.Dragula.init();
            getEvents('pending')
            getEvents('scheduled')
            getEvents('done')
            getEvents('expired')
            getEvents('canceled')
        }(window.jQuery);

        function getEvents(status, page=1) {
            let token = "{{$currentUser->getFirstApiKey() }}";
            let statusId = getStatus(status);
            let companies = {!!json_encode(company()->id?company()->id:array_values(companies()->map(function ($company){
                                        return $company->id;
                                      })->toArray()))!!}
            axios.get('{{route('api.maintenance.event.index')}}?status=' + statusId + '&companies='+companies+'&page=' + page + '&limit=12', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                }
            }).then(function (response) {
                response.data.data.forEach(function (itemData, index) {
                    addItemToView(itemData, status)
                })
                document.getElementById(status+'-count').innerHTML=response.data.meta.page.total;
            }).catch(function (error) {
                console.error(error);
            });

        }

        function addItemToView(itemData, status) {
            // Construye el HTML del elemento
            const itemHtml = `
    <div class="card mb-0" id="${itemData.id}" >
      <div class="card-body p-3">
        <small class="float-end text-muted">${itemData.limits == null ? moment(itemData.alert).format("DD MMM YYYY") : itemData.limits + ' km'}</small>
        <span class="badge text-bg-${itemData.type_class}">${itemData.type_name}</span>

        <h5 class="mt-2 mb-2">
          <a href="#" data-bs-toggle="modal" data-bs-target="#task-detail-modal" data-task-id="${itemData.id}"
             class="text-body">${itemData.description}</a>
        </h5>
        <p class="mt-2 mb-2">
          ${itemData.vehicle.plate}
        </p>
        <div class="dropdown float-end">
          <a href="#" class="dropdown-toggle text-muted arrow-none"
             data-bs-toggle="dropdown" aria-expanded="false">
            <i class="mdi mdi-dots-vertical font-18"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-end">
            <a href="EditEvent(${itemData})" class="dropdown-item " data-bs-toggle="modal" data-bs-target="#task-edit-modal" data-task-id="${itemData.id}"><i
                      class="mdi mdi-pencil me-1"></i>Editar</a>
            <a href="{{route('maintenance.event.index')}}/done/${itemData.id}" class="dropdown-item text-success"><i
                      class="mdi mdi-check me-1"></i>${itemData.status!==2?'Completar':'Visualizar'}</a>
            <a href="#" onclick="updateEvent(${itemData.id},'canceled')" class="dropdown-item text-danger"><i
                      class="mdi mdi-cancel me-1"></i>Cancelar</a>
          </div>
        </div>

        <p class="mb-0">
          <img src="${itemData.company.logo}"
               alt="user-img" class="avatar-xs rounded-circle me-1">
          <span class="align-middle">${itemData.company.name}</span>
        </p>
      </div> </div>`;
            const itemElement = document.createElement('div');
            itemElement.dataset.itemId = itemData.id
            itemElement.innerHTML = itemHtml;

            // Agrega el elemento DOM al contenedor deseado
            const container = document.getElementById(status);
            container.appendChild(itemElement);
        }

        document.addEventListener("DOMContentLoaded", function () {
            var formEvent = document.getElementById('form-event');
            var forms = document.getElementsByClassName('needs-validation');
            var selectedEvent = null;
            var newEventData = null;
            $("#addRow").click(function () {
                var html = '';
                html += '<div id="inputFormRow">';
                html += '<div class="input-group mb-3">';
                html += '<input type="text" name="form_verify[question][]" class="form-control m-input" placeholder="Agregar Validación" autocomplete="off">';
                html += '<div class="input-group-append">';
                html += '<button id="removeRow" type="button" class="btn btn-danger">Eliminar</button>';
                html += '</div>';
                html += '</div>';

                $('#newRow').append(html);
            });

            // remove row
            $(document).on('click', '#removeRow', function () {
                $(this).closest('#inputFormRow').remove();
            });
            flatpickr('#alert', {
                locale: "es",
                dateFormat: "Y-m-d",
            });
            let eventEnd = document.getElementById('event-end').value

            function addNewEvent(info) {
                addEvent.show();
                formEvent.classList.remove("was-validated");
                formEvent.reset();
                selectedEvent = null;
                newEventData = info;
            }

            formEvent.addEventListener('submit', function (ev) {
                ev.preventDefault();
                let eventType = document.getElementById('event-type').value;
                let taskDescription = document.getElementById('task-description').value
                let alert = document.getElementById('alert').value;
                let form_verify = document.getElementsByName('form_verify[question][]')
                let eventEnd = document.getElementById('event-end').value
                let limits = document.getElementById('limits').value
                let company = document.getElementById('company_id').value
                let formVerify = "";
                let end = form_verify.length-1;
                for (let i = 0; i < form_verify.length; i++) {
                    let a = form_verify[i];
                    formVerify = formVerify
                        + a.value;
                    if (i !== end) {
                        console.log(i, form_verify.length)
                        formVerify = formVerify + ","
                    }
                }
                // validation
                if (forms[0].checkValidity() === false) {
                    forms[0].classList.add('was-validated');
                } else {
                    var newEvent = {
                        type: eventType,
                        description: taskDescription,
                        alert: alert,
                        alert_active: eventEnd,
                        status: 0,
                        limits: limits,
                        formVerify: formVerify,
                        eventable_id: company,
                        eventable_type: 'Modules\\Sass\\Entities\\Company',
                        company_id: company,
                    }
                    addEvent(newEvent);
                }
            });
        });

        function addEvent(newEvent) {
            let token = "{{$currentUser->getFirstApiKey() }}";
            loading.show()
            console.log(newEvent);
            axios.post('{{route('api.maintenance.event.store')}}', newEvent, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                }
            }).then(function (response) {
                formClear()
                addItemToView(response.data.data, 'pending')
                alertify.success('Evento Agregado');
                loading.hidden();
            }).catch(function (error) {
                console.log(error);
                alertify.error('Algo Salio Mal');
            });
            loading.hidden()
            alertify.success('Nueva Tarea Creada');
            $('#add-new-task-modal').modal('hide')
        }

        function updateEvent(id,status) {
            let token = "{{$currentUser->getFirstApiKey() }}";
            loading.show()
            // Obtener el ID del contenedor destino
            // Construir la URL de la petición
            const url = '{{route('api.maintenance.event.store')}}/';

            // Construir los datos de la petición
            const data = {
                status: getStatus(status),
            };

            // Enviar la petición Axios
            axios.put(url + id, data, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                }
            }).then(response => {
                // Procesar la respuesta del servidor
                alertify.success('Evento Actualizado');
                window.location.reload()
            }).catch(error => {
                console.error(error);
            });

        }
        function getStatus(status) {
            switch (status) {
                case 'pending':
                    statusId = 0;
                    break
                case 'scheduled':
                    statusId = 1;
                    break
                case 'done':
                    statusId = 2;
                    break
                case 'expired':
                    statusId = 3;
                    break
                case 'canceled':
                    statusId = 4;
                    break
                default:
                    statusId = 0;
            }
            return statusId
        }
        function formClear() {
            document.getElementById('event-type').value=0
            document.getElementById('task-description').value=""
            document.getElementById('alert').value=""
            document.getElementById('event-end').value=""
            document.getElementById('limits').value=""
            document.getElementById('company_id').value=""
            let form_verify = document.getElementsByName('form_verify[question][]')
            for (let i = 0; i < form_verify.length; i++) {
                let a = form_verify[i];
                $(a).closest('#inputFormRow').remove();
            }
        }

    </script>
    <script type="application/javascript">
        document.addEventListener("DOMContentLoaded", function (event) {
            $('#event-end').change(function () {
                if (this.value) {
                    $('#limits').css('display', 'block')
                } else {
                    $('#limits').css('display', 'none')
              }

            });
        })
    </script>
    <style>


        .board {
            display: block;
            white-space: nowrap;
            overflow-x: auto
        }

        .tasks {
            display: inline-block;
            width: 19%;
            padding: 0 1rem 1rem 1rem;
            border: 1px solid #dee2e6;
            vertical-align: top;
            margin-bottom: 1.5rem;
            border-radius: 0.25rem;
        }

        .tasks.tasks:not(:last-child) {
            margin-right: 1.25rem
        }

        .tasks .card {
            white-space: normal;
            margin-top: 1rem
        }

        .small, small {
            font-size: .75rem;
        }

        .tasks .task-header {
            background-color: #f6f7fb;
            padding: 1rem;
            margin: 0 -1rem;
            font-size: .936rem;
        }

        .tasks .h5, .tasks h5 {
            font-size: .936rem;
        }

        .tasks p span {
            font-size: 0.9rem
        }

        .task-list-items {
            min-height: 100px;
            position: relative
        }

        .task-list-items:before {
            content: "No Tasks";
            position: absolute;
            line-height: 110px;
            width: 100%;
            text-align: center;
            font-weight: 600
        }

        .task-modal-content .form-control-light {
            background-color: #eef2f7 !important;
            border-color: #eef2f7 !important
        }

        .gantt-task-details {
            min-width: 220px
        }

        @media (max-width: 991.98px) {
            .board {
                display: contents;
            }

            .tasks {
                display: block;
                width: 100%;
            }
        }
    </style>
@endsection
