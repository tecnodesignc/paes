@extends('layouts.master')
@section('title')
    Editar Conductores
@endsection

@section('css')
    <link href="{{Theme::url('libs/choices.js/choices.js.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{Theme::url('libs/gridjs/gridjs.min.css')}}">
    <link rel="stylesheet" href="{{Theme::url('libs/flatpickr/flatpickr.min.css')}}">
    <link href="{{Theme::url('libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Conductores
        @endslot
        @slot('title')
            Editar Conductor
        @endslot
    @endcomponent
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
                                    <h5 class="font-size-16 mb-1"> Editar Conductor</h5>
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
                            {!! Form::open(['route' => ['transport.driver.update',$driver->id], 'method' => 'put']) !!}
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3 {{ $errors->has("driver_license") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="guia">Licencia de Conducción </label>
                                                <input id="driver_license" name="driver_license"
                                                       placeholder="Agrega Licencia de Conducción"
                                                       type="text"
                                                       value="{{old('driver_license',$driver->driver_license)}}"
                                                       class="form-control">
                                                {!! $errors->first('driver_license', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("first_name") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="guia">Nombre</label>
                                                <input id="first_name" name="first_name" placeholder="Agrega Nombre"
                                                       type="text"
                                                       value="{{old('first_name',$driver->user->first_name)}}"
                                                       class="form-control">
                                                {!! $errors->first('first_name', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("last_name") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="guia">Apellido</label>
                                                <input id="last_name" name="last_name" placeholder="Agrega Apellido"
                                                       type="text"
                                                       value="{{old('last_name',$driver->user->last_name)}}"
                                                       class="form-control">
                                                {!! $errors->first('last_name', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3 {{ $errors->has("email") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="guia">Correo Electrónico</label>
                                                <input id="email" name="email" placeholder="Agrega Correo Electrónico"
                                                       value="{{old('email',$driver->user->email)}}"
                                                       type="text"
                                                       class="form-control">
                                                {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>

                                            <div class="mb-3 {{ $errors->has("phone") ? ' was-validated' : '' }}">
                                                <label class="form-label" for="guia">Teléfono</label>
                                                <input id="phone" name="phone" placeholder="Agrega Teléfono" type="text"
                                                       value="{{old('phone', $driver->phone)}}"
                                                       class="form-control">
                                                {!! $errors->first('phone', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="mb-3">
                                                <label for="companies" class="form-label font-size-13 text-muted">Empresas
                                                    Asignadas</label>
                                                <select class="form-control" name="company_id"
                                                        id="companies"
                                                        placeholder="Selecciones Compañias " >

                                                    @foreach($companies as $company)
                                                        <option
                                                            value="{{$company->id}}" {{old('company_id',$driver->company_id)==$company->id ? 'selected' : ''}} >{{$company->name}}</option>
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
                                                                   {{ old('is_activated',$driver->user->first_name)?'checked':'' }}
                                                                   value="1"/>
                                                            {{ trans('user::users.form.is activated') }}
                                                            {!! $errors->first('is_activated', '<div class="invalid-feedback">:message</div>') !!}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6 class="mb-3">{{ trans('user::users.new password setup') }}</h6>
                                            <div class="form-group mb-3 {{ $errors->has('password') ? ' has-error' : '' }}">
                                                {!! Form::label('password', trans('user::users.form.new password')) !!}
                                                {!! Form::input('password', 'password', '', ['class' => 'form-control']) !!}
                                                {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                                            </div>
                                            <div class="form-group  mb-3{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                                {!! Form::label('password_confirmation', trans('user::users.form.new password confirmation')) !!}
                                                {!! Form::input('password', 'password_confirmation', '', ['class' => 'form-control']) !!}
                                                {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <h6 class="mb-3">{{ trans('user::users.tabs.or send reset password mail') }}</h6>
                                            <a href="{{ route("admin.user.user.sendResetPassword", $driver->user_id) }}" class="btn btn-outline-primary">
                                                {{ trans('user::users.send reset password email') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col text-end">
                                    <a href="{{route('transport.driver.index')}}" class="btn btn-danger"> <i
                                            class="bx bx-x me-1"></i>
                                        Cancelar </a>
                                    <button type="submit" class="btn btn-success"><i class=" bx bx-file me-1"></i>
                                        Guardar
                                    </button>
                                </div> <!-- end col -->
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ Theme::url('libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ Theme::url('js/app.js') }}"></script>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
            integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qr-code-styling@1.6.0-rc.1/lib/qr-code-styling.min.js"></script>
    <script src="{{Theme::url('libs/choices.js/choices.js.min.js') }}"></script>
    <script type="application/javascript" async>
        const loading = new Loader();


        flatpickr('#guia', {
            defaultDate: new Date(),
            dateFormat: "d M, Y",
        });
        const qrCode = new QRCodeStyling({
            width: 300,
            height: 300,
            margin:10,
            type: "svg",
            data:"{{$driver->user->getFirstApiKey()}}",
        });
        qrCode.append(document.getElementById("qrcode"));

        function generateQR() {
            let token = "{{$currentUser->getFirstApiKey() }}";
            loading.show()
            axios.get('{{route('api.user.api.create',[$driver->user->id])}}',{
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                }
            }).then(function (response) {

                let token= response.data.data[0]
                qrCode.update({
                    data: token.access_token
                });
                loading.hidden();
            }).catch(function (error) {
                console.log(error);
                alertify.error('Algo Salio Mal');
                loading.hidden();
            });
        }

        function downloadQr() {
            qrCode.download({ name: "qr", extension: "jpg" });
        }
        let restarQr=document.getElementById("restar-qr");
        let downloadImg=document.getElementById("download-qr");
        restarQr.addEventListener('click',generateQR);
        downloadImg.addEventListener('click',downloadQr);
        document.addEventListener('DOMContentLoaded', function () {
            new Choices('#companies', {
                removeItemButton: true,
            });
        })
    </script>
    <style>
        #qrcode img {
            margin: auto;
        }
    </style>
@endsection
