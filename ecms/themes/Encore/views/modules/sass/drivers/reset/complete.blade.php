@extends('layouts.account')

@section('title')
    {{ trans('user::auth.reset password') }} | @parent
@stop

@section('content')
    <!--start wrapper-->
    <div class="wrapper">
        <div class="">
            <div class="row g-0 m-0">
                <div class="col-xl-6 col-lg-12">
                    <div class="login-cover-wrapper">
                        <div class="card shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h4>Restaurar Contraseña</h4>
                                    <p>{{ trans('user::auth.reset password') }}</p>
                                    @include('partials.notifications')
                                </div>
                                {!! Form::open(["class"=>"form-body row g-3"]) !!}
                                    <div class="col-12 {{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="inputEmail" class="form-label">{{ trans('user::auth.password') }}</label>
                                        <input name="password" type="password" class="form-control" id="inputEmail" autofocus >
                                        {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                                    </div>
                                    <div class="col-12 {{ $errors->has('password_confirmation') ? ' has-error has-feedback' : '' }}">
                                        <label for="inputPassword" class="form-label">{{ trans('user::auth.password confirmation') }}</label>
                                        <input type="password" name="password_confirmation" class="form-control" id="inputPassword">
                                        {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">{{ trans('user::auth.reset password') }}</button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-12">
                    <div class="position-absolute top-0 h-100 d-xl-block d-none login-cover-img">
                        <div class="text-white p-5 w-100">

                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
    <!--end wrapper-->

@stop
