@extends('layouts.master')

@section('title')
     {{ trans('user::users.title.create') }} - @parent
@stop
@section('css')
    <link href="{{ Theme::url('libs/choices.js/choices.js.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{Theme::url('/libs/@simonwep/@simonwep.min.css') }}"/>
    <link rel="stylesheet" href="{{Theme::url('libs/flatpickr/flatpickr.min.css') }}">
@stop

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Eje Satelital
        @endslot
        @slot('title')
            Usuarios
        @endslot
    @endcomponent

{{--
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ trans('user::users.title.new-user') }}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a
                            href="{{ URL::route('user.user.index') }}">{{ trans('user::users.breadcrumb.users') }}</a>
                    </li>
                    <li class="breadcrumb-item active"
                        aria-current="page">{{ trans('user::users.breadcrumb.new') }}</li>
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
                        <h4>{{ trans('user::users.title.new-user') }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            {!! Form::open(['route' => ['user.user.store'], 'method' => 'post']) !!}
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs nav-primary" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tab_1-1" role="tab"
                               aria-selected="true">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class='bx bx-home font-18 me-1'></i>
                                    </div>
                                    <div class="tab-title">{{ trans('user::users.tabs.data') }}</div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab_2-2" role="tab" aria-selected="false">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                                    </div>
                                    <div class="tab-title">{{ trans('user::users.tabs.roles') }}</div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab_3-3" role="tab" aria-selected="false">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class='bx bx-microphone font-18 me-1'></i>
                                    </div>
                                    <div class="tab-title">{{ trans('user::users.tabs.permissions') }}</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content py-3">
                        <div class="tab-pane fade show active" id="tab_1-1" role="tabpanel">
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <div class='form-group{{ $errors->has("first_name") ? ' is-invalid' : '' }}'>
                                            {!! Form::label('first_name', trans('user::users.form.first-name')) !!}
                                            {!! Form::text('first_name', old('first_name'), ['class' => 'form-control', 'placeholder' => trans('user::users.form.first-name')]) !!}
                                            {!! $errors->first('first_name', '<span class="invalid-feedback">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group{{ $errors->has('last_name') ? ' is-invalid' : '' }}">
                                            {!! Form::label('last_name', trans('user::users.form.last-name')) !!}
                                            {!! Form::text('last_name', old('last_name'), ['class' => 'form-control', 'placeholder' => trans('user::users.form.last-name')]) !!}
                                            {!! $errors->first('last_name', '<span class="invalid-feedback">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                                            {!! Form::label('email', trans('user::users.form.email')) !!}
                                            {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => trans('user::users.form.email')]) !!}
                                            {!! $errors->first('email', '<span class="invalid-feedback">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                                            {!! Form::label('password', trans('user::users.form.password')) !!}
                                            {!! Form::password('password', ['class' => 'form-control']) !!}
                                            {!! $errors->first('password', '<span class="invalid-feedback">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div
                                            class="form-group{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
                                            {!! Form::label('password_confirmation', trans('user::users.form.password-confirmation')) !!}
                                            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                                            {!! $errors->first('password_confirmation', '<span class="invalid-feedback">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $companiesOld=$currentUser->companies;
                                @endphp

                                    <div class="mb-3 {{ $errors->has("company_id") ? ' was-validated' : '' }}">
                                        <label class="form-label" for="company_id">Compañia</label>
                                        <select class="form-control" name="companies[]"
                                                id="companies"
                                                placeholder="Selecciones Compañias " multiple>
                                            @if($currentUser->hasAccess('sass.companies.index'))
                                            @foreach($companies as $company)
                                                <option value="{{$company->id}}"  {{in_array($company->id ,old('companies',[])) ? 'selected' : ''}} >{{$company->name}}</option>
                                            @endforeach
                                            @else
                                                @foreach($companiesOld as $company)
                                                    <option value="{{$company->id}}"  {{in_array($company->id ,old('companies',[])) ? 'selected' : ''}} >{{$company->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        {!! $errors->first('route_id', '<div class="invalid-feedback">:message</div>') !!}
                                    </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab_2-2" role="tabpanel">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('user::users.tabs.roles') }}</label>
                                            <select class="form-control" multiple  data-trigger name="roles[]" id="roles">
                                                @foreach ($roles as $role)
                                                    @if(!$currentUser->hasAccess('sass.companies.index') && ($role->id==1 || $role->id==5 ))
                                                        @php continue @endphp
                                                    @endif
                                                        <option value="{{ $role->id }}" {{in_array($role->id ,old('roles',[])) ? 'selected' : ''}}>{{ $role->name }}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab_3-3" role="tabpanel">
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
                       href="{{ route('user.user.index')}}"><i
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
            new Choices('#companies', {
                removeItemButton: true,
            });
        })
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
