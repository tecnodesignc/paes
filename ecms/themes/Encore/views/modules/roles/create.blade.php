@extends('layouts.master')

@section('title')
    Crear Rol - @parent
@stop
@section('css')
    <link href="{{ Theme::url('libs/choices.js/choices.js.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{Theme::url('/libs/@simonwep/@simonwep.min.css') }}"/>
    <link rel="stylesheet" href="{{Theme::url('libs/flatpickr/flatpickr.min.css') }}">
@stop

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Eje Satelital
        @endslot
        @slot('title')
            Roles
        @endslot
    @endcomponent

    {{--
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">{{ trans('user::roles.breadcrumb.new') }}</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a
                                href="{{ URL::route('user.user.index') }}">{{ trans('user::roles.breadcrumb.roles') }}</a>
                        </li>
                        <li class="breadcrumb-item active"
                            aria-current="page">{{ trans('user::roles.breadcrumb.new') }} Roles</li>
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
                        <h4>{{ trans('user::roles.breadcrumb.new') }} Roles</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            {!! Form::open(['route' => ['user.role.store'], 'method' => 'post']) !!}
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs nav-primary" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tab_1-1" role="tab"
                               aria-selected="true">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class='bx bx-home font-18 me-1'></i>
                                    </div>
                                    <div class="tab-title">{{ trans('user::roles.tabs.data') }}</div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab_2-2" role="tab" aria-selected="false">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                                    </div>
                                    <div class="tab-title">{{ trans('user::roles.tabs.permissions') }}</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content py-3">
                        <div class="tab-pane fade show active" id="tab_1-1" role="tabpanel">
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <div class='form-group{{ $errors->has("name") ? ' is-invalid' : '' }}'>
                                            {!! Form::label('name', trans('user::roles.form.name')) !!}
                                            {!! Form::text('name', old('name'), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('user::roles.form.name')]) !!}
                                            {!! $errors->first('name', '<span class="invalid-feedback">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group{{ $errors->has('slug') ? ' is-invalid' : '' }}">
                                            {!! Form::label('slug', trans('user::roles.form.slug')) !!}
                                            {!! Form::text('slug', old('slug'), ['class' => 'form-control slug', 'data-slug' => 'target', 'placeholder' => trans('user::roles.form.slug')]) !!}
                                            {!! $errors->first('slug', '<span class="invalid-feedback">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab_2-2" role="tabpanel">
                            @include('permissions.partials.permissions-create')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer py-4">
            <div class="row">
                <div class="col-12">
                    <button type="submit"
                            class="btn btn-primary btn-flat">{{ trans('user::button.create') }}</button>
                    <a class="btn btn-danger pull-right btn-flat"
                       href="{{ route('user.role.index')}}"><i
                            class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('script')
    <script
        src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
        crossorigin="anonymous"></script>
    <script src="{{ Theme::url('libs/choices.js/choices.js.min.js') }}"></script>
    <script src="{{ Theme::url('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.3/icheck.min.js"
            integrity="sha512-RGDpUuNPNGV62jwbX1n/jNVUuK/z/GRbasvukyOim4R8gUEXSAjB4o0gBplhpO8Mv9rr7HNtGzV508Q1LBGsfA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.3/skins/flat/_all.min.css"
          integrity="sha512-uecJk9KsP+KNuHRBJH+SeSrnP+hmP3tAuC7zFdBNYdwjyXCqH4v2MvYAfLYnBCnZIxP3kY1PAuBJGRiceWbjCg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.3/skins/flat/blue.min.css"
          integrity="sha512-NFzPiFD5sIrKyFzW9/n3DgL45vt0/5SL5KbQXsHyf63cQOXR5jjWBvU9mY3A80LOGPJSGApK8rNwk++RwZAS6Q=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <script type="application/javascript" async>
        const loading = new Loader();

        document.addEventListener('DOMContentLoaded', function () {
            loading.hidden()
            var multipleCancelButton = new Choices('#roles', {
                removeItemButton: true
            });
        })
        $(function () {
            "use strict";
            $('[data-slug="source"]').each(function () {
                $(this).slug();
            });
        });
    </script>
    <script>
        $(function () {
            $(document).ready(function () {
                $('.jsSelectAllAllow').on('click', function (event) {
                    event.preventDefault();
                    $(this).closest('.permissionGroup').find('.jsAllow').each(function (index, value) {
                        $(value).iCheck('check');
                    });
                });
                $('.jsSelectAllDeny').on('click', function (event) {
                    event.preventDefault();
                    $(this).closest('.permissionGroup').find('.jsDeny').each(function (index, value) {
                        $(value).iCheck('check');
                    });
                });
                $('.jsSelectAllInherit').on('click', function (event) {
                    event.preventDefault();
                    $(this).closest('.permissionGroup').find('.jsInherit').each(function (index, value) {
                        $(value).iCheck('check');
                    });
                });
            });
        });
    </script>
@stop
