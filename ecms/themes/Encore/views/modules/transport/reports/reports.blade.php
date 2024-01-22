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
            Reportes
        @endslot
    @endcomponent


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="position-relative">
                        <div class="modal-button mt-2">
                            @if(company()->id==4)
                                <a href="{{route('transport.report.export-search',request()->all())}}"
                                   class="btn btn-primary waves-effect waves-light mb-2 me-2" target="_blank"><i
                                        class="mdi mdi-cloud-download-outline me-1"></i> Descargar Reporte
                                </a>
                            @else
                                <a href="{{route('transport.report.index')}}"
                                   class="btn btn-success waves-effect waves-light mb-2 me-2"><i
                                        class="mdi mdi-plus me-1"></i> Nueva Busqueda
                                </a>
                            @endif

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
                        id: 'route',
                        name: 'Ruta',
                        formatter: (function (cell) {
                            return gridjs.html('<div>'+cell.start_place+' a '+cell.arrival_place+'</div>')
                        })
                    },
                    {
                        id: 'vehicle',
                        name: 'Marca',
                        formatter: (function (cell) {
                            return cell.plate
                        })
                    },
                    {
                        id: 'driver',
                        name: 'Conductor',
                        formatter: (function (cell) {
                            return cell.user.full_name
                        })
                    },
                    {
                        id: 'start_date',
                        name: 'Fecha de Inicio',
                        formatter: (function (cell) {
                           return  moment(cell).format( 'YYYY-MM-DD HH:mm:ss')
                        })
                    },
                    {
                        id: 'end_date',
                        name: 'Fecha de Finalización',
                        formatter: (function (cell) {
                            return  moment(cell).format( 'YYYY-MM-DD HH:mm:ss')
                        })
                    },
                    {
                        id: "id",
                        name: "Action",
                        sort: {
                            enabled: false
                        },
                        formatter: (function (cell) {
                            return gridjs.html('<div class="d-flex gap-3"><a href="/transport/reports/' + cell + '/view" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" class="text-success"><i class="mdi mdi-eye-outline font-size-18"></i> Ver Pasajero</a></div>');
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
