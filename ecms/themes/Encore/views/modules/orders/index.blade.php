@extends('layouts.master')
@section('title')
    Envios
@endsection
@section('css')
    <link rel="stylesheet" href="{{Theme::url('libs/gridjs/gridjs.min.css')}}">
    <link rel="stylesheet" href="{{Theme::url('libs/flatpickr/flatpickr.min.css')}}">
    <link href="{{Theme::url('libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{Theme::url('libs/alertifyjs/alertifyjs.min.css')}}" rel="stylesheet" type="text/css"/>
@stop

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Eje Satelital
        @endslot
        @slot('title')
            Envios
        @endslot
    @endcomponent


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="position-relative">
                        <div class="modal-button mt-2">
                            <a href="{{route('orders.order.create')}}"
                               class="btn btn-success waves-effect waves-light mb-2 me-2"><i
                                    class="mdi mdi-plus me-1"></i> Nuevo Envio
                            </a>
                        </div>
                    </div>
                    <div id="table-orders"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addOrderModal" tabindex="-1" aria-labelledby="addOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id=orderdetailsModalLabel">Datalle del Envio <span class="text-primary"
                                                                                               id="order_id"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="font-size-15 mb-2">Guia <span class="text-primary" id="shipping_guide"></span></h5>
                    <h5 class="font-size-15 mb-2">Dispositivo: <span class="text-primary" id="device"></span></h5>
                    <h5 class="font-size-15 mb-2">Estado: <span class="text-primary" id="order-status"></span></h5>
                    <h5 class="font-size-15 mb-4">Empresa de Logística: <span class="text-primary"
                                                                              id="logistics"></span></h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-muted">
                                <h5 class="font-size-15 mb-2">Lugar de Despacho:</h5>
                                <p class="mb-3 mb-1" id="pickup_name"></p>
                            </div>
                            <div class="text-muted">
                                <h5 class="font-size-15 mb-2">Contacto de Despacho: </h5>
                                <p class="mb-2" id="pickup_contact"></p>
                            </div>
                            <div class="text-muted">
                                <h5 class="font-size-15 mb-2">Notas</h5>
                                <p class="mb-1" id="pickup_notes"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted">
                                <h5 class="font-size-15 mb-2">Lugar de Entrega:</h5>
                                <p class="mb-1" id="shipping_name"></p>
                            </div>
                            <div class="text-muted">
                                <h5 class="font-size-15 mb-2">Contacto de Despacho: </h5>
                                <p class="mb-2" id="shipping_contact"></p>
                            </div>
                            <div class="text-muted">
                                <h5 class="font-size-15 mb-2">Notas</h5>
                                <textarea class="form-control" name="shipping_notes" id="shipping_notes"
                                          rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="text-muted">
                                <h5 class="font-size-15 mb-2">Tomar Foto</h5>
                                <form class="dropzone" id="order_image"
                                      action="#" method="post">
                                    <div class="fallback">
                                        <input name="file" type="file">
                                        <input name="order_id" id="modal-order-id" type="hidden">
                                        <input id="modal-order-image" type="hidden">
                                    </div>
                                    <div class="dz-message needsclick">
                                        <div class="mb-3">
                                            <i class="display-4 text-muted mdi mdi-cloud-upload"></i>
                                        </div>

                                        <h4>Drop files here or click to upload.</h4>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="text-muted">
                                <h5 class="font-size-15 mb-2">Firmar</h5>
                                <div class="my-3">
                                    <canvas id="signature" class="mx-auto" width="290" height="150"
                                            style="display: block; border: 2px dashed #e2e5e8"></canvas>
                                    <input id="modal-order-signature" type="hidden">
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <button class="btn btn-danger" type="button" id="clear-signature">Limpiar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="send-modal-order">
                        Recibir
                    </button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
            integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyA6R-7f-ay0zQ84JmeDgZ84fgTMsbIGUA8"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.15.1/echo.js" integrity="sha512-yuWZbP24VbANkhP3HciLWDrwbkdI3wE7Jv/ESEeczJBR8jFYvMBt8qJjuo3oWPNNYZZS8QgxqnDn+jlSDeXpNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/8.0.2/pusher.min.js" integrity="sha512-FFchpqjQzRMR75a1q5Se4RZyBsc7UZhHE8faOLv197JcxmPJT0/Z4tGiB1mwKn+OZMEocLT+MmGl/bHa/kPKuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
                        id: 'shipping_guide',
                        name: 'Guia',
                        formatter: (function (cell) {
                            return gridjs.html('<span class="fw-semibold">' + cell + '</span>');
                        })
                    },
                    {
                        id: "device",
                        name: "Dispositivo",
                        formatter: (function (cell) {
                            switch (cell.status_device) {
                                case "online":
                                    return gridjs.html(cell.imei +' <span class="badge badge-pill badge-soft-success font-size-12"><i class="mdi mdi-access-point"></i></span>');
                                case "offline":
                                    return gridjs.html(cell.imei +' <span class="badge badge-pill badge-soft-danger font-size-12"><i class="mdi mdi-access-point-off"></i></span>');
                                default:
                                    return gridjs.html(cell.imei +' <span class="badge badge-pill badge-soft-success font-size-12"><i class="mdi mdi-access-point-minus"></i></span>');
                            }
                        })
                    },
                    {
                        id: "pickup",
                        name: "Despacho",
                        formatter: (function (cell) {
                            return cell.name;
                        })
                    },
                    {
                        id: "shipping",
                        name: "Entrega",
                        formatter: (function (cell) {
                            return cell.name;
                        })
                    },
                    {
                        id: "logistics",
                        name: "Transportadora"
                    },
                    {
                        id: "historic_pickup",
                        name: "Fecha de Despacho",
                        formatter: (function (cell, row) {
                            let val = cell
                            if (val === null) {
                                return gridjs.html('<button type="button" class="btn btn-primary btn-sm btn-rounded" onclick="updateOrder(' + row.cells[0].data + ',1)">Enviar </button>');
                            } else {
                                return moment(cell.datetime).format('YYYY-MM-DD H:m:s')
                            }
                        })
                    },
                    {
                        id: "historic_shipping",
                        name: "Fecha de Entrega",
                        formatter: (function (cell, row) {
                            let val = cell
                            if (val === null) {
                                return gridjs.html('<button type="button" class="btn btn-primary btn-sm btn-rounded" onclick="openModal(' + row.cells[0].data + ')"  data-whatever="' + row.cells[0].data + '">Recibir</button>');
                            } else {

                                return moment(cell.datetime).format('YYYY-MM-DD H:m:s')
                            }
                        })
                    },

                    {
                        id: "status",
                        name: "Estado",
                        formatter: function formatter(cell) {
                            switch (cell) {
                                case "Entregado":
                                    return gridjs.html('<span class="badge badge-pill badge-soft-success font-size-12">' + cell + '</span>');
                                case "Alistamiento":
                                    return gridjs.html('<span class="badge badge-pill badge-soft-danger font-size-12">' + cell + '</span>');
                                case "En ruta":
                                    return gridjs.html('<span class="badge badge-pill badge-soft-warning font-size-12">' + cell + '</span>');
                                default:
                                    return gridjs.html('<span class="badge badge-pill badge-soft-success font-size-12">' + cell + '</span>');
                            }
                        }
                    },
                    {
                        id: "device",
                        name: "Temperatura",
                        formatter: (function (cell, row) {
                            if(row.cells[7].data === null){
                                if (cell.historic_last !== null) {
                                    let val = cell.historic_last.sensor.filter(item => item.name.indexOf('Temp 1') > -1)
                                    if (val !== null) {
                                        return gridjs.html(
                                            val.map(function (x) {
                                                return '<span class="badge badge-pill badge-soft-success font-size-12">' + x.value.toFixed(2) + ' ' + x.unit + '</span>';
                                            })
                                        )
                                    }
                                }
                            }else{
                                let val = row.cells[7].data.history_data.device.historic_last.sensor.filter(item => item.name.indexOf('Temp 1') > -1)
                                if (val !== null) {
                                    return gridjs.html(
                                        val.map(function (x) {
                                            return '<span class="badge badge-pill badge-soft-success font-size-12">' + x.value.toFixed(2) + ' ' + x.unit + '</span>';
                                        })
                                    )
                                }
                            }

                        })
                    },
                    {
                        id: "device",
                        name: "Hora de Reporte",
                        formatter: (function (cell, row) {
                            if(row.cells[7].data === null){
                                if (cell.historic_last !== null) {
                                    return gridjs.html('<span class="fw-semibold">' + cell.historic_last.time + '</span>');
                                }
                            }else {
                                if (row.cells[7].data.history_data.device.historic_last !== null) {
                                    return gridjs.html('<span class="fw-semibold">' + row.cells[7].data.history_data.device.historic_last.time + '</span>');
                                }
                            }
                        })
                    },
                    {
                        id: "device",
                        name: "Direccion",
                        formatter: (function (cell, row) {
                            if(row.cells[7].data === null){
                            if (cell.historic_last !== null) {
                                return gridjs.html('<div id="address' + row.cells[0].data + '"><button type="button" class="btn btn-primary btn-sm btn-rounded" onclick="geocodeLatLng(' + cell.historic_last.lat + ',' + cell.historic_last.lng + ',' + row.cells[0].data + ')">Ver Dirección</button>');
                            }
                            }else {
                                if (row.cells[7].data.history_data.device.historic_last !== null) {
                                    return gridjs.html('<div id="address' + row.cells[0].data + '"><button type="button" class="btn btn-primary btn-sm btn-rounded" onclick="geocodeLatLng(' + row.cells[7].data.history_data.device.historic_last.lat + ',' + row.cells[7].data.history_data.device.historic_last.lng + ',' + row.cells[0].data + ')">Ver Dirección</button>');
                                }
                            }
                        })
                    },
                    {
                        id: "id",
                        name: "Action",
                        sort: {
                            enabled: false
                        },
                        formatter: (function (cell) {
                            return gridjs.html('<div class="d-flex gap-3"><a href="/orders/orders/' + cell + '/edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" class="text-success"><i class="mdi mdi-eye-outline font-size-18"></i></a><a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a></div>');
                        })
                    }
                ],
            pagination: {
                limit: 12,
                server: {
                    url: (prev, page, limit) => `${prev}?limit=${limit}&page=${page + 1}`
                }
            },
            fixedHeader: true,
            sort: true,
            autoWidth: true,
            style: {
                th: {
                    'white-space': 'initial',
                    'text-align': 'center',
                    'font-size': '13px'
                },
                td: {
                    'font-size': '12px'
                },
            },
            search: true,
            server: {
                url: '{{route('api.orders.order.index',['status'=>request()->get('status')])}}',
                headers: {
                    Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                    'Content-Type': 'application/json'
                },
                then: data => data.data,
                total: data => data.meta.page.total
            }
        }).render(document.getElementById("table-orders"));

        flatpickr('#guia', {
            defaultDate: new Date(),
            dateFormat: "d M, Y",
        });

        function geocodeLatLng(lat, lng, id) {
            loading.show()
            const geocoder = new google.maps.Geocoder();
            const latlng = {
                lat: parseFloat(lat),
                lng: parseFloat(lng),
            };

            geocoder
                .geocode({location: latlng})
                .then((response) => {
                    if (response.results[0]) {
                        document.getElementById('address' + id).innerHTML = "<span>" + response.results[0].formatted_address + "</span>"
                    } else {
                        window.alert("No results found");
                    }
                    loading.hidden()
                })
                .catch(function (e) {
                    console.log("Geocoder failed due to: " + e)
                    alertify.error('Algo Salio Mal');
                    loading.hidden();
                });
        }

        function updateOrder(order_id, status) {
            let token = "{{$currentUser->getFirstApiKey() }}";
            loading.show()
            axios.put('{{route('api.orders.order.store')}}/' + order_id, {
                status: status,
            }, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                }
            }).then(function (response) {
                mygrid.updateConfig({
                    server: {
                        url: '{{route('api.orders.order.index')}}',
                        headers: {
                            Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                            'Content-Type': 'application/json'
                        },
                        then: data => data.data,
                        total: data => data.meta.page.total
                    }
                }).forceRender();
                loading.hidden();
            }).catch(function (error) {
                console.log(error);
                alertify.error('Algo Salio Mal');
                loading.hidden();
            });
        }

        function openModal(order_id) {
            let token = "{{$currentUser->getFirstApiKey() }}";
            const image = '';
            loading.show()
            axios.get('{{route('api.orders.order.index')}}/' + order_id, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                }
            }).then(function (response) {
                loading.hidden()
                $('#shipping_guide').text(response.data.data.shipping_guide);
                $('#device').text(response.data.data.device.name);
                $('#order-status').text(response.data.data.status);
                $('#logistics').text(response.data.data.logistics);
                $('#pickup_name').text(response.data.data.pickup.name);
                $('#pickup_contact').text(response.data.data.pickup.contact);
                $('#pickup_notes').text(response.data.data.pickup_notes);
                $('#shipping_name').text(response.data.data.shipping.name);
                $('#shipping_contact').text(response.data.data.shipping.contact);
                $('#shipping_notes').text(response.data.data.shipping_notes);
                $('#addOrderModal').modal('show')
                let modalorderid = document.getElementById("modal-order-id").value = order_id;
                let image = '';
                let myDropzone = new Dropzone("#order_image", {
                    url: "{{route('api.orders.order.uploadImage')}}",
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                    },
                    method: 'post',
                    autoUpload:true,
                    uploadMultiple: false,
                    paramName: 'file',
                    params: {'order_id': order_id},
                    acceptedFiles: "image/*",
                    maxFiles: 1,
                })
                myDropzone.on("success", function (file, response) {
                    console.log(response)
                    alertify.success('Imagen Guardada');
                    image = response.data.image;
                });
                const canvas = document.getElementById("signature");
                const signaturePad = new SignaturePad(canvas);
                $('#clear-signature').on('click', function () {
                    signaturePad.clear();
                });

                $('#cancel-modal-order').on('click', function () {
                    myDropzone.removeAllFiles();
                });

                $('#send-modal-order').on('click', function () {
                    if (!signaturePad.isEmpty()) {
                        let token = "{{$currentUser->getFirstApiKey() }}";
                        let signature = signaturePad.toDataURL('image/png')
                        loading.show()
                        console.log()
                        axios.put('{{route('api.orders.order.store')}}/' + order_id, {
                            delivery_confirmation: signaturePad.toDataURL('image/png'),
                            image: image,
                            status: 2,
                            shipping_notes:$('#shipping_notes').val()
                        }, {
                            headers: {
                                'Authorization': `Bearer ${token}`,
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '{{csrf_token()}}',
                            }
                        }).then(function (response) {
                            mygrid.updateConfig({
                                server: {
                                    url: '{{route('api.orders.order.index')}}',
                                    headers: {
                                        Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                                        'Content-Type': 'application/json'
                                    },
                                    then: data => data.data,
                                    total: data => data.meta.page.total
                                }
                            }).forceRender();
                            loading.hidden();
                        }).catch(function (error) {
                            console.log(error);
                            alertify.error('Algo Salio Mal');
                        });
                        myDropzone.removeAllFiles();
                        signaturePad.clear();
                        alertify.success('Orden Actualizada');
                        $('#addOrderModal').modal('hide')
                    } else {
                        alertify.error('Documento no firmado');
                    }
                });

            }).catch(function (error) {
                console.log(error);
                alertify.error('Algo Salio Mal');
            });

        }

    </script>
    <script type="application/javascript" async>

        window.Echo = new Echo({
            broadcaster: 'encorecms.alerts',
            key:'{{ config('broadcasting.connections.pusher.key') }}',
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            forceTLS: true
        });
        Echo.channel(`encorecms.alerts`)
            .listen('Modules\Notification\Events\BroadcastAlert', (e) => {
                console.log(e);
         });

    </script>
    <style>
        table.gridjs-table {
            table-layout: auto;
        }

        .gridjs-table th:nth-child(10), th:nth-child(11), th:nth-child(12) {
            background-color: #3980c0;
            color: #fff;
        }
    </style>
@endsection
