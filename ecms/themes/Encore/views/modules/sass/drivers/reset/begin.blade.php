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
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <h4>Restaurar Contraseña</h4>
                                    <p>{{trans('user::auth.to reset password complete this form') }}</p>
                                    @include('partials.notifications')
                                </div>
                                {!! Form::open(['route' => 'reset.post',"class"=>"form-body row g-3"]) !!}
                                    <div class="col-12 {{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="inputEmail" class="form-label">{{ trans('user::auth.email') }}</label>
                                        <input name="email" type="email" class="form-control" id="inputEmail" placeholder="{{ trans('user::auth.email') }}">
                                        {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary"> {{ trans('user::auth.reset password') }}</button>
                                        </div>
                                    </div>
                                <div class="col-12 col-lg-12 text-center">
                                    <a href="{{ route('login') }}" class="text-center">{{ trans('user::auth.I remembered my password') }}</a>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-12">
                    <div class="position-absolute top-0 h-100 d-xl-block d-none login-cover-img au-reset-password-cover">
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
