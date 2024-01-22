@extends('layouts.master')
@section('title')
    Reportes
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
            Itinerarios
        @endslot
    @endcomponent


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="position-relative">
                        <div class="modal-button mt-2">
                            <a href="{{route('transport.report.export',$route_itineraries->id)}}"
                               class="btn btn-success waves-effect waves-light mb-2 me-2" target="_blank"><i
                                    class="mdi mdi-cloud-download-outline me-1"></i> Descargar Reporte
                            </a>
                        </div>
                    </div>
                    <div id="table-itinerary"></div>
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
                        id: 'passenger',
                        name: 'Nombre',
                        formatter: (function (cell) {
                            return cell.user.full_name
                        })
                    },
                    {
                        id: 'pick_up',
                        name: 'Punto de Recogida',
                    },
                    {
                        id: 'drop_off',
                        name: 'Punto de Llegada',

                    },
                    {
                        id: 'time_route',
                        name: 'Tiempo de Ruta',
                    },
                    {
                        id: 'tickets_available',
                        name: 'Pasajes Restantes',
                    },
                    {
                        id: 'authorized',
                        name: 'Autorizado',
                        formatter: (function (cell) {

                            return  gridjs.html( cell? '<span class="badge badge-pill badge-soft-success font-size-12">Si</span>' :'<span class="badge badge-pill badge-soft-danger font-size-12">No</span>');
                        })
                    }

                ],
            pagination: {
                limit: 12,
            },
            sort: true,
            search: true,
            data: {!! json_encode($itineraries) !!}
        }).render(document.getElementById("table-itinerary"));


        flatpickr('#guia', {
            defaultDate: new Date(),
            dateFormat: "d M, Y",
        });

    </script>

    <style>
        #qrcode img {
            margin: auto;
        }
    </style>
@endsection
