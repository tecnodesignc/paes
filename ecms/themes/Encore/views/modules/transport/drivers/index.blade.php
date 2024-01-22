@extends('layouts.master')
@section('title')
    Conductores
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
           {{company()->id?company()->name:'Eje Satelital'}}
        @endslot
        @slot('title')
            Conductores
        @endslot
    @endcomponent


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="position-relative">
                        <div class="modal-button mt-2">
                            <a href="{{route('transport.driver.create')}}"
                               class="btn btn-success waves-effect waves-light mb-2 me-2"><i
                                    class="mdi mdi-plus me-1"></i> Nuevo Conductor
                            </a>
                        </div>
                    </div>
                    <div id="table-driver"></div>
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
    <script src="https://cdn.jsdelivr.net/npm/qr-code-styling@1.6.0-rc.1/lib/qr-code-styling.min.js"></script>

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
                        id: 'driver_license',
                        name: 'Licencia de Transito ',
                        formatter: (function (cell) {
                            return cell;
                        })
                    },
                    {
                        id: 'user',
                        name: 'Nombre ',
                        formatter: (function (cell) {
                            return cell.first_name;
                        })
                    },
                    {
                        id: 'user',
                        name: 'Apellido ',
                        formatter: (function (cell) {
                            return cell.last_name;
                        })
                    },
                    {
                        id: 'phone',
                        name: 'Telefono',
                        formatter: (function (cell) {
                            return cell;
                        })
                    },
                    {
                        id: 'user',
                        name: 'Email',
                        formatter: (function (cell) {
                            return cell.email;
                        })
                    },
                    {
                        id: "user",
                        name: "Estado",
                        formatter: (function (cell) {

                            return gridjs.html(cell.is_activated ? '<span class="badge badge-pill badge-soft-success font-size-12">Actvio</span>' : '<span class="badge badge-pill badge-soft-danger font-size-12">Inactivo</span>');
                        })
                    },
                    {
                        id: "created_at",
                        name: "Creado el",
                        formatter: (_, cell) => moment(cell).format('YYYY-MM-DD')
                    },
                    {
                        id: 'companies',
                        name: 'Empresas asignadas',
                        formatter: (function (cell) {
                          const bussisnes = cell.map((item)=>{
                                return   '<span class="badge badge-pill badge-soft-success font-size-12">'+item.name+'</span>'
                            })
                            return gridjs.html(bussisnes)
                        })
                    },
                    {
                        id: "id",
                        name: "Action",
                        sort: {
                            enabled: false
                        },
                        formatter: (function (cell) {
                            return gridjs.html('<div class="d-flex gap-3"><a href="/transport/drivers/' + cell + '/edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" class="text-success"><i class="mdi mdi-eye-outline font-size-18"></i></a><a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a></div>');
                        })
                    },
                    {
                        id: "user",
                        name: "QR",
                        sort: {
                            enabled: false
                        },
                        formatter: (function (cell) {
                            return gridjs.html('<button type="button" class="btn btn-outline-primary waves-effect waves-light" onclick="viewQr(`' + cell.api_key + '`)"><i class="mdi mdi-qrcode-scan font-size-26"></i></button>');
                        })
                    },

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
                    $params=['include'=>"user,companies"];
                        if(!$currentUser->hasAccess('sass.companies.index') || company()->id){
                             $params=['include'=>'user,companies','companies'=>company()->id];
                        }
                @endphp
                url: '{!!route('api.transport.driver.index',$params)!!}',
                headers: {
                    Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                    'Content-Type': 'application/json'
                },
                then: data => data.data,
                total: data => data.meta.page.total
            }
        }).render(document.getElementById("table-driver"));

        flatpickr('#guia', {
            defaultDate: new Date(),
            dateFormat: "d M, Y",
        });

        function viewQr(token) {
            const qrCode = new QRCodeStyling({
                width: 300,
                height: 300,
                margin:10,
                type: "svg",
                data:token,
            });
            Swal.fire({
                title: 'Codigo QR',
                icon: 'info',
                html: '<div id="qrcode"></div>',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonColor: "#3980c0",
                cancelButtonColor: "#f34e4e",
                confirmButtonText: 'Descargar',
                cancelButtonText: 'Cerrar',
                allowOutsideClick: false,
                didOpen:function () {
                    qrCode.append(document.getElementById("qrcode"));
                },
            }).then(function (result) {
                if (result.isConfirmed) {
                    qrCode.download({ name: "qr", extension: "jpg" });
                }
            })

        }

        {{--     function geocodeLatLng(lat, lng, id) {
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
                        alertify.error('Algo Salio Mal'                      loading.hidden();
                    });
            }

            {{--    function updateOrder(order_id, status) {
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
    --}}
    </script>

    <style>
        #qrcode img {
            margin: auto;
        }
    </style>
@endsection
