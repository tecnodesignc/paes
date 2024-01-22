@extends('layouts.master')
@section('title')
    Ver Envío {{$order->shipping_guide}}
@endsection

@section('css')
    <link rel="stylesheet" href="{{Theme::url('libs/gridjs/gridjs.min.css')}}">
    <link rel="stylesheet" href="{{Theme::url('libs/flatpickr/flatpickr.min.css')}}">
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Envíos
        @endslot
        @slot('title')
            Editar Envío {{$order->shipping_guide}}
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
                                    <h5 class="font-size-16 mb-1">Editar Orden {{$order->shipping_guide}}</h5>
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
                                <div class="col-lg-3">

                                    <div class="mb-3">
                                        <label class="form-label" for="guia">Guia</label>
                                        <input type="text" class="form-control" value="{{$order->shipping_guide}}"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label for="choices-single-default" class="form-label">Dispositivos</label>
                                        <input type="text" class="form-control" value="{{$order->device->imei}}"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="logistics">Empresa de Envio</label>
                                        <input type="text" class="form-control" value="{{$order->logistics}}" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="logistics">Estado</label>
                                        <input type="text" class="form-control" value="{{$order->present()->status}}"
                                               disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-title"><h6 class="font-size-16 mb-1">Información de
                                                    recogida</h6></div>
                                            <div class="mb-3">
                                                <input name="pickup_id" type="hidden" class="form-control"
                                                       value="{{$order->pickup->id}}">
                                                <label class="form-label" for="logistics">Lugar de Recogida</label>
                                                <input type="text" class="form-control" value="{{$order->pickup->name}}"
                                                       disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="contact_name">Contacto</label>
                                                <input type="text" class="form-control"
                                                       value="{{$order->pickup->contact}}" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="contact_phone">Numero de contacto</label>
                                                <input type="text" class="form-control"
                                                       value="{{$order->pickup->phone}}" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="pickup_notes">Descripción del
                                                    Producto</label>
                                                <textarea rows="3" class="form-control"
                                                          disabled>{{$order->pickup_notes}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-title"><h6 class="font-size-16 mb-1">Información de
                                                    Entrega</h6></div>
                                            <div class="mb-3">
                                                <label class="form-label" for="shipping-location">Lugar de
                                                    Entrega</label>
                                                <input type="text" class="form-control"
                                                       value="{{$order->shipping->name}}" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="contact_name">Contacto</label>
                                                <input type="text" class="form-control"
                                                       value="{{$order->shipping->contact}}" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="contact_phone">Numero de contacto</label>
                                                <input type="text" class="form-control"
                                                       value="{{$order->shipping->phone}}" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="pickup_notes">Descripción del
                                                    Producto</label>
                                                <textarea rows="3" class="form-control"
                                                          disabled>{{$order->shipping_notes}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="card-title"><h6 class="font-size-16 mb-1">Sensores</h6>
                                                <p class="text-muted text-truncate mb-0">Última
                                                    Actualización: <span
                                                        class="badge badge-soft-success"> {{$order->status===2?$order->present()->historic_shipping['history_data']['device']['historic_last']['time'] :$order->device->present()->lastHistoric->time}} </span> </p>
                                            </div>
                                            @if($order->status===2)

                                                @foreach($order->present()->historic_shipping['history_data']['device']['sensors'] as $i=>$sensor)
                                                    <div class="{{$i?"mt-3 border-top pt-3":""}}">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="d-flex">
                                                                <i class="mdi mdi-circle font-size-10 mt-1 text-primary"></i>
                                                                <div class="flex-1 ms-2">
                                                                    <p class="mb-0">{{$sensor['name']}}</p>
                                                                </div>
                                                            </div>
                                                            <div>
                                                            <span
                                                                class="badge badge-soft-primary">{{$sensor['value']}} {{$sensor['unit_of_measurement']}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                            @foreach($order->device->present()->lastHistoric->sensor as $i=>$sensor)
                                                <div class="{{$i?"mt-3 border-top pt-3":""}}">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex">
                                                            <i class="mdi mdi-circle font-size-10 mt-1 text-primary"></i>
                                                            <div class="flex-1 ms-2">
                                                                <p class="mb-0">{{$sensor['name']}}</p>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <span
                                                                class="badge badge-soft-primary">{{$sensor['value']}} {{$sensor['unit']}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                    <h5 class="font-size-16 mb-1">Histoial</h5>
                                    <p class="text-muted text-truncate mb-0">Historico de temperatura y seguimiento</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                </div>

                            </div>

                        </div>
                    </a>

                    <div id="addproduct-alert-collapse" class="collapse" data-bs-parent="#addproduct-accordion">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Historico de Teperatura</h4>
                                    </div><!-- end card header -->
                                    <div class="card-body">
                                        <div id="area_chart_basic" data-colors='["#3980c0", "#33a186"]'
                                             class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div><!--end card-->
                            </div><!--end col-->
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Historico de Alertas</h4>
                                    </div><!-- end card header -->
                                    <div class="card-body">
                                        <div id="table-order-alert"></div>

                                    </div>
                                </div><!--end card-->
                            </div><!--end col-->
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Historial Ubicación de dispositivos</h4>
                                        <p class="card-title-desc text-success fw-bold">On line</p>
                                    </div>
                                    <div class="card-body">
                                        <div id="gmaps-markers" class="gmaps" style="height: 600px"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <a href="#historyorder-alert-collapse" class="text-dark collapsed" data-bs-toggle="collapse"
                       aria-haspopup="true" aria-expanded="false" aria-haspopup="true"
                       aria-controls="addproduct-alert-collapse">
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
                                    <h5 class="font-size-16 mb-1">Histoial de la Orden</h5>
                                    <p class="text-muted text-truncate mb-0">Historico del envio</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                </div>

                            </div>

                        </div>
                    </a>
                    <div id="historyorder-alert-collapse" class="collapse" data-bs-parent="#historyorder-accordion">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div id="table-history-orders"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                @if($order->status===2)
                <div class="card">
                    <a href="#completeorder-alert-collapse" class="text-dark collapsed" data-bs-toggle="collapse"
                       aria-haspopup="true" aria-expanded="false" aria-haspopup="true"
                       aria-controls="completeorder-alert-collapse">
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
                                    <h5 class="font-size-16 mb-1">Orden Entregada</h5>
                                    <p class="text-muted text-truncate mb-0">Anexos a la orden en el momento de la entrega</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                </div>

                            </div>

                        </div>
                    </a>
                    <div id="completeorder-alert-collapse" class="collapse" data-bs-parent="#completeorder-accordion">
                        <div class="row">
                            @if(isset($order->image))
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Galeria de Imagen</h4>
                                    </div><!-- end card header -->
                                    <div class="card-body">
                                        <img src="{{url($order->image)}}" alt="imagen" class="img-responsive w-50" >
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Firma</h4>
                                    </div><!-- end card header -->
                                    <div class="card-body">
                                        <img src="{{$order->delivery_confirmation}}" alt="Firma">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col text-end">
            <a href="{{route('orders.order.index')}}" class="btn btn-danger"> <i class="bx bx-x me-1"></i> Salir </a>
        </div> <!-- end col -->
    </div>

@endsection
@section('script')
    <script src="{{ Theme::url('libs/gridjs/gridjs.min.js') }}"></script>
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyA6R-7f-ay0zQ84JmeDgZ84fgTMsbIGUA8"></script>
    <script src="{{ Theme::url('libs/gmaps/gmaps.min.js') }}"></script>
    <script src="{{ Theme::url('libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{Theme::url('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
            integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script type="application/javascript" async>

        function getChartColorsArray(chartId) {
            if (document.getElementById(chartId) !== null) {
                let colors = document.getElementById(chartId).getAttribute("data-colors");
                colors = JSON.parse(colors);
                return colors.map(function (value) {
                    let newValue = value.replace(" ", "");
                    if (newValue.indexOf("--") != -1) {
                        let color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
                        if (color) return color;
                    } else {
                        return newValue;
                    }
                });
            }
        }


        function chartData() {
            let barchartColors = getChartColorsArray("area_chart_basic");
            let from = "{{$order->histories()->where('history_type','En ruta')->orderBy('created_at','asc')->first()->datetime??date('Y-m-d H:i:s')}}";
            let to = "{{$order->histories()->where('history_type','Entregado')->orderBy('created_at','asc')->first()->datetime??date('Y-m-d H:i:s')}}"
            let device = "{{$order->device_id}}";
            let token = "{{$currentUser->getFirstApiKey() }}";
            axios.get('{{route('api.dispositives.historic.index')}}?device_id=' + device + '&from=' + from + '&to=' + to + '&limit=400', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                }
            }).then(function (response) {

                MapGenerate(response.data.data);

                let labels = response.data.data.map(function (x) {
                    return moment(x.time).format('YYYY-MM-DD H:m:s')
                });
                let series = response.data.data.map(function (x) {
                    let val = x.sensor.find(item => item.name.indexOf('Temp 1') > -1)
                    return parseFloat(val.value).toFixed(2)

                });
                let alerts = {!! json_encode(alertTransform($order->alerts)) !!};
                let annotations = [];
                Object.keys(alerts).forEach(function (key, index) {
                    let Color = Math.floor(Math.random() * 16777215).toString(16)
                    annotations.push({
                        y: alerts[key].from,
                        borderColor: "#" + Color,
                        label: {
                            show: true,
                            text: 'Alerta ' + alerts[key].from + ' a ' + alerts[key].to + ' Mínimo',
                            style: {
                                color: "#fff",
                                background: "#" + Color
                            }
                        }
                    }, {
                        y: alerts[key].to,
                        borderColor: "#" + Color,
                        label: {
                            show: true,
                            text: 'Alerta ' + alerts[key].from + ' a ' + alerts[key].to + ' Maximo',
                            style: {
                                color: "#fff",
                                background: "#" + Color
                            }
                        }
                    })
                });
                let options = {
                    series: [{
                        name: "Temperatura",
                        data: series
                    }],
                    chart: {
                        type: 'area',
                        height: 450,
                        zoom: {
                            autoScaleYaxis: true
                        }
                    },
                    annotations: {
                        yaxis: annotations,
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth'
                    },

                    title: {
                        text: 'Historico de Teperatura',
                        align: 'left',
                        style: {
                            fontWeight: 500,
                        },
                    },
                    labels: labels,
                    xaxis: {
                        type: 'float',
                    },
                    yaxis: {
                        opposite: true,
                        min: 0
                    },
                    legend: {
                        horizontalAlign: 'left'
                    },
                    colors: ["#038edc"]
                };

                let chart = new ApexCharts(document.querySelector("#area_chart_basic"), options);
                chart.render();
            })
                .catch(function (error) {
                    console.error(error);
                });


        }

        document.addEventListener("DOMContentLoaded", function (event) {
            new gridjs.Grid({
                columns:
                    [
                        {
                            id: 'shipping_guide',
                            name: 'Guia',
                        },
                        {
                            id: "date",
                            name: "Fecha",
                        },
                        {
                            id: "time",
                            name: "Hora"
                        },
                        {
                            id: 'historic',
                            name: 'Temperatura',
                            formatter: (function (cell) {
                                let val = cell.sensor.filter(item => item.name.indexOf('Temp 1') > -1)
                                return gridjs.html(
                                    val.map(function (x) {
                                        console.log(parseFloat(x.value).toFixed(2) )
                                        return '<span class="badge badge-pill badge-soft-success font-size-12">' + parseFloat(x.value).toFixed(2) + ' ' + x.unit + '</span>';
                                    })
                                )
                            })
                        },
                        {
                            id: "historic",
                            name: "Ubicación",
                            formatter: (function (cell) {
                                if (cell !== null) {
                                    return gridjs.html('<div id="address' + cell?.device_id + '"><button type="button" class="btn btn-primary btn-sm btn-rounded" onclick="geocodeLatLng(' + cell?.lat + ',' + cell?.lng + ',' + cell?.device_id + ')">Ver Dirección</button>');
                                }
                            })
                        },
                    ],
                height: 380,
                pagination: {
                    limit: 12,
                    server: {
                        url: (prev, page, limit) => `${prev}&limit=${limit}&page=${page + 1}`
                    }
                },
                sort: true,
                search: true,

                server: {
                    url: '{{route('api.dispositives.alert.index')}}?order_id={{$order->id}}',
                    headers: {
                        Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                        'Content-Type': 'application/json'
                    },
                    then: data => data.data,
                    total: data => data.meta.page.total
                }
            }).render(document.getElementById("table-order-alert"));

            chartData();

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
                            id: 'history_data',
                            name: 'Guia',
                            formatter: (function (cell) {
                                return gridjs.html('<span class="fw-semibold">' + cell.shipping_guide + '</span>');
                            })
                        },
                        {
                            id: "history_type",
                            name: "Estado de la Orden",
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
                        }, {
                        id: "history_message",
                        name: "Nota"
                    },
                        {
                            id: "user",
                            name: "Usuario",
                            formatter: (function (cell) {
                                return cell.first_name + ' ' + cell.last_name;
                            })
                        },
                        {
                            id: "created_at",
                            name: "Fecha de Actualización",
                            formatter: (function (cell, row) {
                                return moment(cell).format('YYYY-MM-DD hh:m:s a')
                            })
                        }
                    ],
                pagination: {
                    limit: 12,
                },
                fixedHeader: true,
                sort: true,
                autoWidth: true,
                search: true,
                data: {!!json_encode(\Modules\Orders\Transformers\HistoryOrderTransformer::collection($order->histories)) !!}
            }).render(document.getElementById("table-history-orders"));


        })

        function geocodeLatLng(lat, lng, id) {
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
                })
                .catch((e) => window.alert("Geocoder failed due to: " + e));
        }

        function MapGenerate(alerts) {
            const map = new google.maps.Map(document.getElementById('gmaps-markers'), {
                center: {lat: parseFloat(alerts[0].lat), lng: parseFloat(alerts[0].lng)},
                zoom: 14
            });
            let bounds = new google.maps.LatLngBounds();

            const flightPlanCoordinates = alerts.map(function (x) {
                var pt = new google.maps.LatLng(parseFloat(x.lat), parseFloat(x.lng))
                bounds.extend(pt);
                return {lat: parseFloat(x.lat), lng: parseFloat(x.lng)}
            });

            const flightPath = new google.maps.Polyline({
                path: flightPlanCoordinates,
                geodesic: true,
                strokeColor: "#038edc",
                strokeOpacity: 1.0,
                strokeWeight: 3,
            });
            map.fitBounds(bounds);
            flightPath.setMap(map);
        }
    </script>

@endsection
