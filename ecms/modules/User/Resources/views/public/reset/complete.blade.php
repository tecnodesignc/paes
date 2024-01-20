@extends('layouts.master-without_nav')

@section('title')
    {{ trans('user::auth.reset password') }} | @parent
@stop

@section('content')

    <div class="authentication-bg min-vh-100">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                <div class="row justify-content-center my-auto">
                    <div class="col-md-8 col-lg-6 col-xl-5">

                        <div class="text-center mb-4">
                            <a href="{{url('/')}}">
                                <img src="{{ Theme::url('images/logo-sm.svg') }}" alt="" height="22"> <span class="logo-txt">{{ setting('core::site-name') }}</span>
                            </a>
                        </div>

                        <div class="card">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="text-muted">{{ trans('user::auth.reset password') }}</p>
                                </div>
                                <div class="p-2 mt-4">

                                    @if(Session::has('success'))
                                        <div class="alert alert-success text-center">
                                            {{Session::get('success')}}
                                        </div>
                                    @endif

                                        {!! Form::open() !!}

                                        <div class="mb-3">
                                            <label class="form-label" for="userpassword">{{ trans('user::auth.password') }}</label>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  placeholder="{{ trans('user::auth.password') }}"  autocomplete="new-password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="password-confirm">{{ trans('user::auth.password confirmation') }}</label>
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password" placeholder="{{ trans('user::auth.password confirmation') }}">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>

                                        <div class="mt-3 text-end">
                                            <button class="btn btn-primary w-sm waves-effect waves-light" type="submit"> {{ trans('user::auth.reset password') }}</button>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center text-muted p-4">
                         <p> {{date('Y')}} - Todos los derechos reservados <i class="mdi mdi-heart text-danger"></i> Eje Satelital</p> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    <div class="login-logo">
        <a href="{{ url('/') }}">{{ setting('core::site-name') }}</a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">{{ trans('user::auth.reset password') }}</p>
        @include('partials.notifications')

        {!! Form::open() !!}
        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
            <input type="password" class="form-control" autofocus
                   name="password" placeholder="{{ trans('user::auth.password') }}">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error has-feedback' : '' }}">
            <input type="password" name="password_confirmation" class="form-control" placeholder="{{ trans('user::auth.password confirmation') }}">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
        </div>

        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat pull-right">
                    {{ trans('user::auth.reset password') }}
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>--}}
@stop
