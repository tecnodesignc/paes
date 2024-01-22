@extends('layouts.master')
@section('title')
    {{ trans('user::users.title.users') }} - @parent
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
            Usuarios
        @endslot
    @endcomponent


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="position-relative">
                        <div class="modal-button mt-2">
                            <a href="{{ route('user.user.create') }}"
                               class="btn btn-success waves-effect waves-light mb-2 me-2"><i
                                    class="mdi mdi-plus me-1"></i> {{ trans('user::users.button.new-user') }}
                            </a>
                        </div>
                    </div>
                    <div id="table-user"></div>
                </div>
            </div>
        </div>
    </div>

 {{--   <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-12 d-none d-sm-flex align-items-center my-3">
                    <div class="ps-3">
                        <h4> {{ trans('user::users.title.users') }}</h4>
                    </div>
                    <div class="ms-auto ">
                        <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                            <a href="" class="btn btn-primary btn-flat"
                               style="padding: 4px 10px;">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="user" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>{{ trans('user::users.table.first-name') }}</th>
                        <th>{{ trans('user::users.table.last-name') }}</th>
                        <th>{{ trans('user::users.table.email') }}</th>
                        <th>{{ trans('user::users.table.created-at') }}</th>
                        <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (isset($users))
                        @foreach ($users as $user)
                            <td>
                                <a href="{{ route('user.user.edit', [$user->id]) }}">
                                    {{ $user->id }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('user.user.edit', [$user->id]) }}">
                                    {{ $user->first_name }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('user.user.edit', [$user->id]) }}">
                                    {{ $user->last_name }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('user.user.edit', [$user->id]) }}">
                                    {{ $user->email }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('user.user.edit', [$user->id]) }}">
                                    {{ $user->created_at }}
                                </a>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('user.user.edit', [$user->id]) }}" class="btn btn-outline-secondary"><i class="bx bx-pencil"></i></a>
                                    @if ($user->id != $currentUser->id)
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete-confirmation" data-action-target="{{ route('user.user.destroy', [$user->id]) }}"><i class="bx bx-trash-alt"></i></button>
                                    @endif
                                </div>
                            </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>{{ trans('user::users.table.first-name') }}</th>
                        <th>{{ trans('user::users.table.last-name') }}</th>
                        <th>{{ trans('user::users.table.email') }}</th>
                        <th>{{ trans('user::users.table.created-at') }}</th>
                        <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>--}}
    @include('core::partials.delete-modal')
    @include('partials.delete-modal')
@stop

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
            sort: {
                multiColumn: false,
                server: {
                    url: (prev, columns) => {
                        if (!columns.length) return prev;

                        const col = columns[0];
                        const dir = col.direction === 1 ? 'asc' : 'desc';
                        let colName = ['name', 'rarity'][col.index];

                        return `${prev}&order=${colName}&way=${dir}`;
                    }
                }
            },
            columns:
                [
                    {
                        id: 'id',
                        name: '#',
                        formatter: (function (cell) {
                            return gridjs.html('<div class="form-check font-size-16"><input class="form-check-input" type="checkbox" id="orderidcheck' + cell + '"><label class="form-check-label" for="orderidcheck' + cell + '">' + cell + '</label></div>');
                        })
                    },
                    {
                        id: 'first_name',
                        name: '{{ trans('user::users.table.first-name') }}',
                        formatter: (function (cell) {
                            return cell;
                        })
                    },
                    {
                        id: 'last_name',
                        name: '{{ trans('user::users.table.last-name') }}',
                        formatter: (function (cell) {
                            return cell;
                        })
                    },
                    {
                        id: 'email',
                        name: '{{ trans('user::users.table.email') }}',
                        formatter: (function (cell) {
                            return cell;
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
                        formatter: (_, cell) => moment(cell).format('YYYY-MM-DD')
                    },
                    {
                        id: "id",
                        name: "Action",
                        sort: {
                            enabled: false
                        },
                        formatter: (function (cell) {
                            return gridjs.html('<div class="d-flex gap-3"><a href="/user/users/' + cell + '/edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" class="text-success"><i class="mdi mdi-eye-outline font-size-18"></i></a>  <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete-confirmation" data-action-target="/user/users/' + cell + '"><i class="bx bx-trash-alt"></i></button></div>');
                        })
                    }

                ],
            pagination: {
                limit: 25,
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
                    $params=['include'=>"companies",'roles'=>[1,4,5]];
                        if(!$currentUser->hasAccess('sass.companies.index') || company()->id){
                             $params=['include'=>"companies",'companies'=>[company()->id],'roles'=>[1,4,5]];
                        }
                @endphp
                url: '{!!route('api.user.user.index',$params)!!}',
                headers: {
                    Authorization: `Bearer {{$currentUser->getFirstApiKey()}}`,
                    'Content-Type': 'application/json'
                },
                then: data => data.data,
                total: data => data.meta.total
            }
        }).render(document.getElementById("table-user"));

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
