@extends('layouts.master-without_nav')
@section('title')
    {{ trans('user::auth.register') }} | @parent
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
                                <img src="{{ Theme::url('images/logo-sm.svg') }}" alt="{{ setting('core::site-name') }}" height="22"> <span class="logo-txt">Eje Satelital</span>
                            </a>
                        </div>

                        <div class="card">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">{{ trans('user::auth.register') }}</h5>
                                    <p class="text-muted">Registrate en nuestra plataforma.</p>
                                </div>
                                <div class="p-2 mt-4">

                                    @if(Session::has('success'))
                                        <div class="alert alert-success text-center">
                                            {{Session::get('success')}}
                                        </div>
                                    @endif
                                        {!! Form::open(['route' => 'register.post','class'=>'form-horizontal']) !!}
                                        <div class="mb-3">
                                            <label class="form-label" for="useremail">{{ trans('user::auth.email') }}</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="useremail" value="{{ old('email') }}" name="email" placeholder="{{ trans('user::auth.email') }}" autofocus>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="userpassword">{{ trans('user::auth.password') }}</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="userpassword" name="password" placeholder="{{ trans('user::auth.password') }}" autofocus>
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="password-confirm">{{ trans('user::auth.password confirmation') }}</label>
                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="confirmpassword" name="password_confirmation" placeholder="{{ trans('user::auth.password confirmation') }}" autofocus>
                                            @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <input type="hidden" class="form-control @error('company_id') is-invalid @enderror" id="company_id" name="company_id" value="{{ $company_id ?? null }}" autocomplete="off">
                                            @error('company_id')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>

                                        <div class="mt-3 text-end">
                                            <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">{{ trans('user::auth.register me') }}</button>
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
                            <p>  {{date('Y')}} - Todos los derechos reservados <i class="mdi mdi-heart text-danger"></i> Eje Satelital</p>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- end container -->
    </div>

@stop
