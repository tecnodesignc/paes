@extends('layouts.account')
@section('title')
    {{ trans('user::auth.register') }} | @parent
@stop

@section('content')

    <div class="row g-0 m-0">
        <div class="col-xl-6 col-lg-12">
            <div class="login-cover-wrapper">
                <div class="card shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <h4>Crea Tu Cuenta</h4>
                            <p>{{ trans('user::auth.register') }}</p>
                            @include('partials.notifications')
                        </div>
                        {!! Form::open(['route' => 'register.post','class'=>'form-body row g-3']) !!}
                        <div class="col-12 {{ $errors->has('email') ? ' has-error has-feedback' : '' }}">
                            <label for="inputEmail" class="form-label">{{ trans('user::auth.email') }}</label>
                            <input name="email" type="email" class="form-control" id="email" value="{{ old('email') }}">
                            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="col-12 {{ $errors->has('password') ? ' has-error has-feedback' : '' }}">
                            <label for="inputPassword" class="form-label">{{ trans('user::auth.password') }}</label>
                            <input type="password" name="password" class="form-control" id="inputPassword">
                            {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div
                            class="col-12 {{ $errors->has('password_confirmation') ? ' has-error has-feedback' : '' }}">
                            <label for="inputPassword"
                                   class="form-label">{{ trans('user::auth.password_confirmation') }}</label>
                            <input type="password" name="password_confirmation" class="form-control" id="inputPassword">
                            {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
                        </div>
<!--                        <div class="col-12 col-lg-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    I agree the Terms and Conditions
                                </label>
                            </div>
                        </div>-->
                        <div class="col-12 col-lg-12">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning">{{ trans('user::auth.register me') }}</button>
                            </div>
                        </div>
<!--                        <div class="col-12 col-lg-12">
                            <div class="position-relative border-bottom my-3">
                                <div class="position-absolute seperator translate-middle-y">or continue with</div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-12">
                            <div
                                class="social-login d-flex flex-row align-items-center justify-content-center gap-2 my-2">
                                <a href="javascript:;" class=""><img src="assets/images/icons/facebook.png" alt=""></a>
                                <a href="javascript:;" class=""><img src="assets/images/icons/apple-black-logo.png"
                                                                     alt=""></a>
                                <a href="javascript:;" class=""><img src="assets/images/icons/google.png" alt=""></a>
                            </div>
                        </div>-->
                        <div class="col-12 col-lg-12 text-center">
                            <p class="mb-0">{{ trans('user::auth.I already have a membership') }} <a href="{{ route('login') }}">{{ trans('user::auth.login') }}</a></p>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12">
            <div class="position-absolute top-0 h-100 d-xl-block d-none register-cover-img">
                <div class="text-white p-5 w-100">

                </div>
            </div>
        </div>
    </div>
    <!--end row-->

{{--    <div class="register-logo">
        <a href="{{ url('/') }}">{{ setting('core::site-name') }}</a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">{{ trans('user::auth.register') }}</p>
        @include('partials.notifications')
        {!! Form::open(['route' => 'register.post']) !!}
        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error has-feedback' : '' }}">
            <input type="email" name="email" class="form-control" autofocus
                   placeholder="{{ trans('user::auth.email') }}" value="{{ old('email') }}">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error has-feedback' : '' }}">
            <input type="password" name="password" class="form-control"
                   placeholder="{{ trans('user::auth.password') }}">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
        </div>
        <div
            class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error has-feedback' : '' }}">
            <input type="password" name="password_confirmation" class="form-control"
                   placeholder="{{ trans('user::auth.password confirmation') }}">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="row">
            <div class="col-xs-12">
                <button type="submit"
                        class="btn btn-primary btn-block btn-flat">{{ trans('user::auth.register me') }}</button>
            </div>
        </div>
        {!! Form::close() !!}

        <a href="{{ route('login') }}" class="text-center">{{ trans('user::auth.I already have a membership') }}</a>
    </div>--}}
@stop
