@extends('layouts.master')
@section('title')
    Formularios de Preoperativo
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
           Formularios de Preoperativo
        @endslot
    @endcomponent


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="position-relative">
                        <div class="modal-button mt-2">
                            <a href="{{route('dynamicform.form.create')}}"
                               class="btn btn-success waves-effect waves-light mb-2 me-2"><i
                                        class="mdi mdi-plus me-1"></i> Nuevo Formulario
                            </a>
                        </div>
                    </div>
                    <div id="table-form"></div>
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
                        id: 'name',
                        name: 'Titulo',

                    },
                    {
                        id: 'icon',
                        name: 'Iconos',
                        formatter: (function (cell) {
                            return gridjs.html('<i class="'+cell+' me-2"></i>');
                        })
                    },
                    {
                        id: 'color',
                        name: 'Color',
                        formatter: (function (cell) {
                            return gridjs.html('<span class="badge rounded-pill text-white  font-size-12" style="background:'+cell+'"></span>');
                        })
                    },
                    {
                        id: 'active',
                        name: 'Estado',
                        formatter: (function (cell) {

                            return gridjs.html(cell? '<span class="badge badge-pill badge-soft-success font-size-12">Actvio</span>' : '<span class="badge badge-pill badge-soft-danger font-size-12">Inactivo</span>');
                        })
                    },
                        @if($currentUser->hasAccess('sass.companies.index') && empty(company()->id))
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
                        @endif
                    {
                        id: "created_at",
                        name: "Creado el",
                        formatter:(cell)=> moment(cell).format( 'YYYY-MM-DD')
                    },
                    {
                        id: "id",
                        name: "Action",
                        sort: {
                            enabled: false
                        },
                        formatter: (function (cell) {
                            return gridjs.html('<div class="d-flex gap-3"><a href="/preoperativo/form/' + cell + '/edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" class="text-success"><i class="mdi mdi-eye-outline font-size-18"></i></a>'
                                +'<a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a></div>');
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
                    $companies=company()->id?company()->id:array_values(companies()->map(function ($company){
                                         return $company->id;
                                       })->toArray());
                     $params=['include'=>'companies','companies'=>$companies];
                @endphp
                url: '{!!route('api.dynamicform.form.index',$params)!!}',
                headers: {
                    Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                    'Content-Type': 'application/json'
                },
                then: data => data.data,
                total: data => data.meta.page.total
            }
        }).render(document.getElementById("table-form"));

    </script>

    <style>
        #qrcode img {
            margin: auto;
        }
    </style>
@endsection
