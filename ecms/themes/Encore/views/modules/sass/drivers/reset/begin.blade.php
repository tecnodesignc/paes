@extends('layouts.master-without_nav')

@section('title')
    {{ trans('user::auth.reset password') }} | @parent
@stop

@section('body')
    <body class="auth-body-bg">
    @endsection


@section('content')

    <div class="authentication-bg min-vh-100">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                <div class="row justify-content-center my-auto">
                    <div class="col-md-8 col-lg-6 col-xl-5">

                        <div class="text-center mb-4">
                            <a href="{{url('/')}}">
                                <img src="{{Theme::url('/images/logo-sm.svg') }}" alt="" height="22"> <span class="logo-txt">Eje Satelital</span>
                            </a>
                        </div>

                        <div class="card">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary"> Reiniciar Contraseña</h5>
                                    <p class="text-muted">{{ trans('user::auth.to reset password complete this form') }}</p>
                                </div>
                                <div class="p-2 mt-4">
                                    {!! Form::open(['route' => 'reset.post','class'=>'form-horizontal']) !!}
                                        <div class="mb-3">
                                            <label for="username">{{ trans('user::auth.email') }}</label>
                                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" @if (old('email')) value="{{ old('email') }}" @endif id="email" placeholder="{{ trans('user::auth.email') }}" autocomplete="email" autofocus>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mt-3 text-end">
                                            <button class="btn btn-primary w-sm waves-effect waves-light" type="submit"> {{ trans('user::auth.reset password') }}</button>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <p class="mb-0"><a href="{{ route('login') }}" class="fw-medium text-primary"> {{ trans('user::auth.I remembered my password') }} </a></p>
                                        </div>
                                    {!! Form::close() !!}
                                </div>

                            </div>
                        </div>

                    </div><!-- end col -->
                </div><!-- end row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center text-muted p-4">
                            <p class="text-white-50">© {{date('Y')}} - Todos los derechos reservados <i class="mdi mdi-heart text-danger"></i> Eje Satelital</p>
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
        <p class="login-box-msg">{{ trans('user::auth.to reset password complete this form') }}</p>
        @include('partials.notifications')

        {!! Form::open(['route' => 'reset.post']) !!}
            <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control" autofocus
                       name="email" placeholder="{{ trans('user::auth.email') }}" value="{{ old('email')}}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat pull-right">
                        {{ trans('user::auth.reset password') }}
                    </button>
                </div>
            </div>
        {!! Form::close() !!}

        <a href="{{ route('login') }}" class="text-center">{{ trans('user::auth.I remembered my password') }}</a>
    </div>--}}
@stop
