@extends('layouts.master-without_nav')

@section('title')
    {{ trans('user::auth.login') }} | @parent
@stop

@section('content')

    <div class="authentication-bg min-vh-100">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                <div class="row justify-content-center my-auto">
                    <div class="col-md-8 col-lg-6 col-xl-5">

                        <div class="text-center mb-4">
                            <a href="index">
                                <img src="{{ Theme::url('images/logo-sm.svg') }}" alt="" height="22"> <span
                                    class="logo-txt">Eje Satelital</span>
                            </a>
                        </div>

                        <div class="card">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Bienvenido!</h5>
                                    <p class="text-muted">{{ trans('user::auth.sign in welcome message') }}</p>
                                </div>
                                <div class="p-2 mt-4">

                                    @if (Session::has('success'))
                                        <div class="alert alert-success text-center">
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif
                                    {!! Form::open(['route' => 'login.post']) !!}

                                    <div class="mb-3">
                                        <label class="form-label" for="username">{{ trans('user::auth.email') }}</label>
                                        <input name="email" type="email"
                                               class="form-control @error('email') is-invalid @enderror" id="username"
                                               value="{{ old('email') }}"
                                               placeholder="{{ trans('user::auth.email') }}" autocomplete="email"
                                               autofocus>
                                        {!! $errors->first('email', ' <span class="invalid-feedback" role="alert"><strong>:message</strong></span>') !!}
                                    </div>

                                    <div class="mb-3">
                                        <div class="float-end">
                                                <a class="btn btn-link" href="{{ route('reset')}}">
                                                    {{ trans('user::auth.forgot password') }}
                                                </a>
                                        </div>
                                        <label class="form-label" for="userpassword">{{ trans('user::auth.password') }}</label>
                                        <input type="password" name="password"
                                               class="form-control  @error('password') is-invalid @enderror"
                                               id="userpassword" placeholder="{{ trans('user::auth.password') }}"
                                               aria-label="Password" aria-describedby="password-addon">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                               for="remember"> {{ trans('user::auth.remember me') }} </label>
                                    </div>

                                    <div class="mt-3 text-end">
                                        <button class="btn btn-primary w-sm waves-effect waves-light"
                                                type="submit">{{ trans('user::auth.login') }}</button>
                                    </div>

                                    {{-- <div class="mt-4 text-center">
                                        <div class="signin-other-title">
                                            <h5 class="font-size-14 mb-3 title">Sign in with</h5>
                                        </div>

                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <a href="javascript:void()"
                                                   class="social-list-item bg-primary text-white border-primary">
                                                    <i class="mdi mdi-facebook"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void()"
                                                   class="social-list-item bg-info text-white border-info">
                                                    <i class="mdi mdi-twitter"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void()"
                                                   class="social-list-item bg-danger text-white border-danger">
                                                    <i class="mdi mdi-google"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>--}}
                                    @if (config('encore.user.config.allow_user_registration'))
                                        <div class="mt-4 text-center">
                                            <p class="mb-0">Do not have an account ? <a href="{{ route('register')}}"
                                                                                        class="fw-medium text-primary"> {{ trans('user::auth.register')}}</a>
                                            </p>
                                        </div>
                                    @endif
                                    {{Form::close()}}
                                </div>

                            </div>
                        </div>

                    </div><!-- end col -->
                </div><!-- end row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center text-muted p-4">
                        <p>  {{date('Y')}} - Todos los derechos reservados <i class="mdi mdi-heart text-danger"></i> Eje Satelital</p>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- end container -->
    </div>


{{--    <div class="login-logo">
        <a href="{{ url('/') }}">{{ setting('core::site-name') }}</a>
    </div>
    &lt;!&ndash; /.login-logo &ndash;&gt;
    <div class="login-box-body">
        <p class="login-box-msg">{{ trans('user::auth.sign in welcome message') }}</p>
        @include('partials.notifications')
        {!! Form::open(['route' => 'login.post']) !!}
        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
            <input type="email" class="form-control" autofocus
                   name="email" placeholder="{{ trans('user::auth.email') }}" value="{{ old('email')}}">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

        </div>
        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
            <input type="password" class="form-control"
                   name="password" placeholder="{{ trans('user::auth.password') }}" value="{{ old('password')}}">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="remember_me"> {{ trans('user::auth.remember me') }}
                    </label>
                </div>
            </div>
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">
                    {{ trans('user::auth.login') }}
                </button>
            </div>
        </div>
        </form>

        <a href="{{ route('reset')}}">{{ trans('user::auth.forgot password') }}</a><br>
        @if (config('encore.user.config.allow_user_registration'))
            <a href="{{ route('register')}}" class="text-center">{{ trans('user::auth.register')}}</a>
        @endif
    </div>--}}
@stop
