@extends('layouts.master')
@section('title')
    Crear Conductores
@endsection

@section('css')
    <link href="{{Theme::url('libs/choices.js/choices.js.min.css') }}" rel="stylesheet" type="text/css"/>

@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Conductores
        @endslot
        @slot('title')
            Crear Conductor
        @endslot
    @endcomponent
    {!! Form::open(['route' => ['transport.driver.store'], 'method' => 'post', 'class'=>'needs-validation']) !!}
    <div class="row">
        <div class="col-lg-12">
            <div id="addproduct-accordion" class="custom-accordion">
                <div class="card">
                    <a href="#addproduct-productinfo-collapse" class="text-dark" data-bs-toggle="collapse"
                       aria-expanded="true" aria-controls="addproduct-productinfo-collapse">
                        <div class="p-4">

                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm">
                                        <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                            01
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="font-size-16 mb-1"> Crear Conductor</h5>
                                    <p class="text-muted text-truncate mb-0">Complete toda la información a
                                        continuación</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                </div>

                            </div>

                        </div>
                    </a>
                    <div id="addproduct-productinfo-collapse" class="collapse show"
                         data-bs-parent="#addproduct-accordion">
                        <div class="p-4 border-top">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <div
                                                class="mb-3 {{ $errors->has("driver_license") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="guia">Licencia de Conducción </label>
                                                <input id="driver_license" name="driver_license"
                                                       placeholder="Agrega Licencia de Conducción"
                                                       type="text"
                                                       value="{{old('driver_license')}}"
                                                       class="form-control">
                                                {!! $errors->first('driver_license', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("first_name") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="guia">Nombre</label>
                                                <input id="first_name" name="first_name" placeholder="Agrega Nombre"
                                                       type="text"
                                                       value="{{old('first_name')}}"
                                                       class="form-control">
                                                {!! $errors->first('first_name', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("last_name") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="guia">Apellido</label>
                                                <input id="last_name" name="last_name" placeholder="Agrega Apellido"
                                                       type="text"
                                                       value="{{old('last_name')}}"
                                                       class="form-control">
                                                {!! $errors->first('last_name', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("email") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="guia">Correo Electrónico</label>
                                                <input id="email" name="email" placeholder="Agrega Correo Electrónico"
                                                       value="{{old('email')}}"
                                                       type="text"
                                                       class="form-control">
                                                {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>

                                            <div class="mb-3 {{ $errors->has("phone") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="guia">Teléfono</label>
                                                <input id="phone" name="phone" placeholder="Agrega Teléfono" type="text"
                                                       value="{{old('phone')}}"
                                                       class="form-control">
                                                {!! $errors->first('phone', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3">
                                                <label for="companies" class="form-label font-size-13 text-muted">Empresas
                                                    Asignadas</label>
                                                <select class="form-control" name="company_id"
                                                        id="company_id"
                                                        placeholder="Selecciones Compañía " >
                                                    @foreach($companies as $company)
                                                        <option
                                                            value="{{$company->id}}" {{$company->id === old('company_id') ? 'selected' : ''}}>{{$company->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3 ">
                                                    <div
                                                        class="checkbox{{ $errors->has('activated') ? ' was-validated' : '' }}">
                                                        <label for="is_activated">
                                                            <input id="is_activated"
                                                                   name="is_activated"
                                                                   type="checkbox"
                                                                   class="form-check-input"
                                                                   {{ old('is_activated') }}
                                                                   value="1"/>
                                                            {{ trans('user::users.form.is activated') }}
                                                            {!! $errors->first('activated', '<div class="invalid-feedback">:message</div>') !!}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col text-end">
            <a href="{{route('transport.driver.index')}}" class="btn btn-danger"> <i class="bx bx-x me-1"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-success"><i class=" bx bx-file me-1"></i> Guardar</button>
        </div> <!-- end col -->
    </div>
    {!! Form::close() !!}

@endsection
@section('script')
    <script src="{{Theme::url('libs/choices.js/choices.js.min.js') }}"></script>
    {{--   <script src="{{ URL::asset('assets/js/pages/ecommerce-choices.init.js') }}"></script>--}}
    <script src="{{Theme::url('js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Choices('#companies', {
                removeItemButton: true,
            });
        })
    </script>
@endsection
