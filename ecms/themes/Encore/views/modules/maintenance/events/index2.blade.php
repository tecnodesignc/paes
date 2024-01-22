@extends('layouts.master')
@section('title')
   Eventos
@endsection
@section('css')
    {!! Theme::style('libs/fullcalendar/fullcalendar.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/alertifyjs/alertifyjs.min.css?v='.config('app.version')) !!}
    {!! Theme::style('libs/flatpickr/flatpickr.min.css?v='.config('app.version')) !!}
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
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <button class="btn btn-primary w-100" id="btn-new-event"><i class="mdi mdi-plus"></i> Crear Nuevo Evento</button>

                            <div id="external-events">
                                <br>
                                <p class="text-muted">Arrastra y suelta tu evento o haz clic en el calendario</p>
                                <div class="external-event fc-event bg-success" data-class="bg-success">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Nueva Tarea
                                </div>
                                <div class="external-event fc-event bg-info" data-class="bg-info">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Nuevo Recordatorio
                                </div>
                                <div class="external-event fc-event bg-warning" data-class="bg-warning">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Nuevo Mantenimiento Preventivo
                                </div>
                                <div class="external-event fc-event bg-danger" data-class="bg-danger">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Nuevo Mantenimiento Correctivo
                                </div>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-xl-9">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>

            <div style='clear:both'></div>

            <!-- Add New Event MODAL -->
            <div class="modal fade" id="event-modal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header py-3 px-4 border-bottom-0">
                            <h5 class="modal-title" id="modal-title">Eventos</h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-hidden="true"></button>

                        </div>
                        <div class="modal-body p-4">
                            <form class="needs-validation" name="event-form" id="form-event" novalidate>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Fecha</label>
                                            <input id="alert" name="alert"
                                                   placeholder="Agrega Fecha de Vencimiento"
                                                   type="text"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Nombre Del Evento</label>
                                            <input class="form-control" placeholder="Agregar Nombre Del Evento"
                                                   type="text" name="description" id="event-title" required value="" />
                                            <div class="invalid-feedback">Por favor proporcione un nombre de evento válido</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Tipo de Evento</label>
                                            <select class="form-select shadow-none" name="type"
                                                    id="event-type" required>
                                                <option  value="" selected> --Seleccionar-- </option>
                                                <option value="0">Tarea</option>
                                                <option value="1">Recordatorio</option>
                                                <option value="2">Mantenimiento Preventivo</option>
                                                <option value="3">Mantenimiento Correctivo</option>
                                            </select>
                                            <div class="invalid-feedback">Por favor seleccione un tipo de evento válido</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Finalizar Evento Por</label>
                                            <select class="form-select shadow-none" name="type"
                                                    id="event-end" required>
                                                <option  value="" selected> --Seleccionar-- </option>
                                                <option value="0">Fecha</option>
                                                <option value="1">Kilómetros</option>
                                            </select>
                                            <div class="invalid-feedback">Por favor seleccione un tipo de evento válido</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Finalizar Evento Por Kilómetro</label>
                                            <input class="form-control" placeholder="AgregarKilómetro"
                                                   type="number" name="limits" id="limits" required value="" />
                                            <div class="invalid-feedback">Por favor proporcione un nombre de evento válido</div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Lista de Validación</label>
                                            <div id="inputFormRow">
                                                <div class="input-group mb-3">
                                                    <input type="text" id="form_verify" name="form_verify[question][]" class="form-control m-input" placeholder="Agregar Validación" autocomplete="off">
                                                    <div class="input-group-append">
                                                        <button id="removeRow" type="button" class="btn btn-danger">Eliminar</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="newRow"></div>
                                            <button id="addRow" type="button" class="btn btn-info">Agregar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-danger" id="btn-delete-event">borrar</button>
                                    </div>
                                    <div class="col-6 text-end">
                                        <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success" id="btn-save-event">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> <!-- end modal-content-->
                </div> <!-- end modal dialog-->
            </div>
            <!-- end modal-->
        </div>
    </div>
@endsection
@section('script')
    {!! Theme::script('libs/fullcalendar/fullcalendar.min.js?v='.config('app.version')) !!}
    {!! Theme::script('libs/fullcalendar/fullcalendar.min.js?v='.config('app.version')) !!}
    {!! Theme::script('js/app.js?v='.config('app.version')) !!}
    {!! Theme::script('libs/alertifyjs/alertifyjs.min.js?v='.config('app.version')) !!}
    {!! Theme::script('libs/flatpickr/flatpickr.min.js?v='.config('app.version')) !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
            integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.9/locales-all.global.min.js"></script>
    <script type="application/javascript" async>
        const loading = new Loader();
        document.addEventListener("DOMContentLoaded", function () {
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

            var addEvent = new bootstrap.Modal(document.getElementById('event-modal'), {
                keyboard: false
            })
            document.getElementById('event-modal');
            var modalTitle = document.getElementById('modal-title');
            var formEvent = document.getElementById('form-event');
            var selectedEvent = null;
            var newEventData = null;
            var forms = document.getElementsByClassName('needs-validation');
            var selectedEvent = null;
            var newEventData = null;
            var eventObject = null;
            /* initialize the calendar */

            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
            var Draggable = FullCalendar.Draggable;
            var externalEventContainerEl = document.getElementById('external-events');

            // init dragable
            new Draggable(externalEventContainerEl, {
                itemSelector: '.external-event',
                eventData: function (eventEl) {
                    return {
                        title: eventEl.innerText,
                        start: new Date(),
                        className: eventEl.getAttribute('data-class')
                    };
                }
            });
            let token = "{{$currentUser->getFirstApiKey() }}";
            let defaultEvents = [];
            loading.show()
            axios.get('{{route('api.maintenance.event.index')}}?filter={companies:{{company()->id??companies()->map(function ($item) {
    return $item->id;})}}}', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{){csrf_token()}}',
                }
            }).then(function (response) {
                loading.hidden()
                defaultEvents=response.data.data.map(function (x) {
                    const alert=moment(x)
                    return {
                        id: x.id,
                        title:x.description,
                        start: new Date(alert.format('YYYY'), alert.format('MM'),alert.format('DD')),
                        className: x.className
                    };
                });
            }).catch(function (error) {
                loading.hidden()
                console.log(error);
                alertify.error('Algo Salio Mal');
            });

            var defaultEvents2 = [{
                title: 'All Day Event',
                start: new Date(y, m, 1),
                className: 'bg-primary'
            },
                {
                    title: 'Long Event',
                    start: new Date(y, m, d - 5),
                    end: new Date(y, m, d - 2),
                    className: 'bg-warning'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: new Date(y, m, d - 3, 16, 0),
                    allDay: false,
                    className: 'bg-info'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: new Date(y, m, d + 4, 16, 0),
                    allDay: false,
                    className: 'bg-primary'
                },
                {
                    title: 'Meeting',
                    start: new Date(y, m, d, 10, 30),
                    allDay: false,
                    className: 'bg-success'
                },
                {
                    title: 'Lunch',
                    start: new Date(y, m, d, 12, 0),
                    end: new Date(y, m, d, 14, 0),
                    allDay: false,
                    className: 'bg-danger'
                },
                {
                    title: 'Birthday Party',
                    start: new Date(y, m, d + 1, 19, 0),
                    end: new Date(y, m, d + 1, 22, 30),
                    allDay: false,
                    className: 'bg-success'
                },
                {
                    title: 'Click for Google',
                    start: new Date(y, m, 28),
                    end: new Date(y, m, 29),
                    url: 'http://google.com/',
                    className: 'bg-dark'
                }];

            var draggableEl = document.getElementById('external-events');
            var calendarEl = document.getElementById('calendar');

            function addNewEvent(info) {
                addEvent.show();
                formEvent.classList.remove("was-validated");
                formEvent.reset();
                selectedEvent = null;
                modalTitle.innerText = 'Agregar Evento';
                newEventData = info;
            }

            function getInitialView() {
                if (window.innerWidth >= 768 && window.innerWidth < 1200) {
                    return 'timeGridWeek';
                } else if (window.innerWidth <= 768) {
                    return 'listMonth';
                } else {
                    return 'dayGridMonth';
                }
            }

            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'local',
                locale: 'es',
                editable: true,
                droppable: true,
                selectable: true,
                initialView: getInitialView(),
                themeSystem: 'bootstrap',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                // responsive
                windowResize: function (view) {
                    var newView = getInitialView();
                    calendar.changeView(newView);
                },
                eventDidMount: function (info) {
                    if (info.event.extendedProps.status === 'done') {

                        // Change background color of row
                        info.el.style.backgroundColor = 'red';

                        // Change color of dot marker
                        var dotEl = info.el.getElementsByClassName('fc-event-dot')[0];
                        if (dotEl) {
                            dotEl.style.backgroundColor = 'white';
                        }
                    }
                },
                eventClick: function (info) {
                    console.log(info)
                    selectedEvent = info.event;
                    let eventType=0;
                    switch (selectedEvent.classNames[0]) {
                        case 'bg-success':
                            eventType=0
                             break;
                        case 'bg-info':
                            eventType=1
                            break;
                        case 'bg-warning':
                            eventType=2
                            break;
                        case 'bg-danger':
                            eventType=3
                            break;
                        default:
                           eventType=0
                    }
                    document.getElementById("btn-delete-event").style.display = "block";
                    addEvent.show();
                    formEvent.reset();
                    document.getElementById("event-title").value[0] = "";

                    document.getElementById("event-title").value = selectedEvent.title;
                    document.getElementById('event-type').value = eventType;
                    document.getElementById("alert").value = moment(selectedEvent.start).format('YYYY-MM-DD');
                    newEventData = null;
                    modalTitle.innerText = 'Editar Evento';
                    newEventData = null;
                    flatpickr('#alert', {
                        locale: "es"
                    });
                },
                dateClick: function (info) {
                    document.getElementById("btn-delete-event").style.display = "none";
                    addNewEvent(info);
                },
                events: defaultEvents
            });
            calendar.render();

            /*Add new event*/
            // Form to add new event

            formEvent.addEventListener('submit', function (ev) {
                ev.preventDefault();

                let updatedTitle = document.getElementById("event-title").value;
                let eventType = document.getElementById('event-type').value;
                let alert=document.getElementById('alert').value;
                let form_verify=document.getElementById('form_verify').value

                let updatedCategory ='bg-success';
                console.log(eventType)
                switch (eventType) {
                    case 0:
                        updatedCategory='bg-success';
                        break;
                    case 1:
                        updatedCategory='bg-info';
                        break;
                    case 2:
                        updatedCategory='bg-warning';
                        break;
                    case 3:
                        updatedCategory='bg-danger';
                        break;
                    default:
                        updatedCategory='bg-success';
                }
                // validation
                if (forms[0].checkValidity() === false) {
                    forms[0].classList.add('was-validated');
                } else {
                    if (selectedEvent) {
                        selectedEvent.setProp("title", updatedTitle);
                        selectedEvent.setProp("classNames", [updatedCategory]);




                    } else {

                        var newEvent = {
                            title: updatedTitle,
                            start:  document.getElementById("alert").value,
                            allDay: newEventData.allDay,
                            className: updatedCategory
                        }
                        calendar.addEvent(newEvent);
                    }
                    addEvent.hide();
                }
            });

            document.getElementById("btn-delete-event").addEventListener("click", function (e) {
                if (selectedEvent) {
                    selectedEvent.remove();
                    selectedEvent = null;
                    selectedEvent.hide();
                }
            });
            document.getElementById("btn-new-event").addEventListener("click", function (e) {
                document.getElementById("btn-delete-event").style.display = "none";
                addNewEvent({ date: new Date(), allDay: true });
            });

        });
    </script>

@endsection
