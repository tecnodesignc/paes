@extends('layouts.account')

@section('title')
    {{ trans('user::auth.login') }} | @parent
@stop

@section('content')

    <div class="row g-0 m-0">
        <div class="col-xl-6 col-lg-12">
            <div class="login-cover-wrapper">
                <div class="card shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <h4>Iniciar Sesión</h4>
                            <p>{{ trans('user::auth.sign in welcome message') }}</p>
                            @include('partials.notifications')
                        </div>
                        {!! Form::open(['route' => 'login.post','class'=>'form-body row g-3']) !!}
                            <div class="col-12 {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="inputEmail" class="form-label">{{ trans('user::auth.email') }}</label>
                                <input name="email" type="email" class="form-control" id="email">
                                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="col-12 {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="form-label">{{ trans('user::auth.password') }}</label>
                                <input name="password" type="password" class="form-control" id="password">
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="remember_me" type="checkbox" role="switch" id="flexSwitchCheckRemember" >
                                    <label class="form-check-label"  for="flexSwitchCheckRemember">{{ trans('user::auth.remember me') }}</label>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 text-end">
                                <a href="{{ route('reset')}}">{{ trans('user::auth.forgot password') }}</a>
                            </div>
                            <div class="col-12 col-lg-12">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Sign In</button>
                                </div>
                            </div>
<!--                            <div class="col-12 col-lg-12">
                                <div class="position-relative border-bottom my-3">
                                    <div class="position-absolute seperator translate-middle-y">or continue with</div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-12">
                                <div class="social-login d-flex flex-row align-items-center justify-content-center gap-2 my-2">
                                    <a href="javascript:;" class=""><img src="assets/images/icons/facebook.png" alt=""></a>
                                    <a href="javascript:;" class=""><img src="assets/images/icons/apple-black-logo.png" alt=""></a>
                                    <a href="javascript:;" class=""><img src="assets/images/icons/google.png" alt=""></a>
                                </div>
                            </div>-->
                        @if (config('encore.user.config.allow_user_registration'))
                            <div class="col-12 col-lg-12 text-center">
                                <p class="mb-0">Don't have an account? <a href="{{ route('register')}}">{{ trans('user::auth.register')}}</a></p>
                            </div>
                        @endif

                        {{ Form::close() }}
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
@stop
