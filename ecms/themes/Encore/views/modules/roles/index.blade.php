@extends('layouts.master')

@section('title')
    {{ trans('user::roles.title.roles') }} - @parent
@stop
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

{{--
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3"> {{ trans('user::roles.title.roles') }}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active"
                        aria-current="page">{{ trans('user::roles.breadcrumb.roles') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

--}}

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-12 d-none d-sm-flex align-items-center my-3">
                    <div class="ps-3">
                        <h4> {{ trans('user::roles.title.roles') }}</h4>
                    </div>
                    <div class="ms-auto ">
                        <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                            <a href="{{ route('user.role.create') }}" class="btn btn-primary btn-flat"
                               style="padding: 4px 10px;">
                                <i class="fa fa-pencil"></i>{{ trans('user::roles.new-role') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="roles" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>{{ trans('user::roles.table.name') }}</th>
                        <th>{{ trans('user::users.table.created-at') }}</th>
                        <th data-sortable="false">{{ trans('user::users.table.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (isset($roles))
                        @foreach ($roles as $role)
                            <tr>
                                <td>
                                    <a href="{{ URL::route('user.role.edit', [$role->id]) }}">
                                        {{ $role->id }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ URL::route('user.role.edit', [$role->id]) }}">
                                        {{ $role->name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ URL::route('user.role.edit', [$role->id]) }}">
                                        {{ $role->created_at }}
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('user.role.edit', [$role->id]) }}"
                                           class="btn btn-outline-secondary"><i class="bx bx-pencil"></i></a>
                                        <button class="btn btn-danger " data-toggle="modal"
                                                data-target="#modal-delete-confirmation"
                                                data-action-target="{{ route('user.role.destroy', [$role->id]) }}">
                                            <i class="bx bx-trash-alt"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>{{ trans('user::roles.table.name') }}</th>
                        <th>{{ trans('user::users.table.created-at') }}</th>
                        <th>{{ trans('user::users.table.actions') }}</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @include('partials.delete-modal')
@stop

@section('script')
    <script src="{{ Theme::url('js/app.js') }}"></script>
    <script type="application/javascript" async>
        const loading = new Loader();
        loading.hidden()
        $(function() {
            "use strict";
           $(document).ready(function() {
                var table = $('#user').DataTable( {
                    lengthChange: false,
                    buttons: ['copy', 'excel', 'pdf', 'print'],
                    order: [[1, 'desc']]
                });

                table.buttons().container()
                    .appendTo( '.col-md-6:eq(0)' );
            } );

        });
    </script>

@stop
