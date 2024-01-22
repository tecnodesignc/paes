@extends('layouts.master')
@section('title')
    Empresas
@endsection
@section('css')
    <link rel="stylesheet" href="{{Theme::url('libs/gridjs/gridjs.min.css')}}">
    <link rel="stylesheet" href="{{Theme::url('libs/flatpickr/flatpickr.min.css')}}">
@stop

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Eje Satelital
        @endslot
        @slot('title')
            Empresas
        @endslot
    @endcomponent


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="position-relative">
                        <div class="modal-button mt-2">
                            <a href="{{route('sass.company.create')}}" class="btn btn-success waves-effect waves-light mb-2 me-2"><i
                                    class="mdi mdi-plus me-1"></i> Nueva Empresa
                            </a>
                        </div>
                    </div>
                    <div id="table-company"></div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ Theme::url('libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ Theme::url('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function (event) {
            new gridjs.Grid({
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
                            id: 'name',
                            name: 'Nombre',
                            formatter: (function (cell) {
                                return gridjs.html('<span class="fw-semibold">' + cell + '</span>');
                            })
                        },
                        {
                            id: "email",
                            name: "Correo"
                        },
                        {
                            id: "address",
                            name: "Dirección"
                        },
                        {
                            id: "phone",
                            name: "Teléfono"
                        },
                        {
                            id: "created_at",
                            name: "Creado el",
                            formatter:(_,cell)=> moment(cell).format( 'YYYY-MM-DD')
                        },
                        {
                            id: "id",
                            name: "Actiones",
                            sort: {
                                enabled: false
                            },
                            formatter: (function (cell) {
                                return gridjs.html('<div class="d-flex gap-3"><a href="/sass/companies/' + cell + '/edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a><a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a></div>');
                            })
                        }
                    ],
                pagination: {
                    limit: 12
                },
                sort: true,
                search: true,
                data: {!! json_encode($companies) !!}
            }).render(document.getElementById("table-company"));


            flatpickr('#guia', {
                defaultDate: new Date(),
                dateFormat: "d M, Y",
            });
        })
    </script>

@endsection
