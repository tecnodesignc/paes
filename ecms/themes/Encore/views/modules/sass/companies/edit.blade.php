@extends('layouts.master')
@section('title')
    Editar Empresa
@endsection

@section('css')
   {!! Theme::style('libs/alertifyjs/alertifyjs.min.css') !!}

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Empresas
        @endslot
        @slot('title')
            Editar Empresa {{$company->name}}
        @endslot
    @endcomponent
    {!! Form::open(['route' => ['sass.company.update',$company->id], 'method' => 'put']) !!}
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
                                    <h5 class="font-size-16 mb-1">Editar Empresa {{$company->name}}</h5>
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

                            <div class="mb-3">
                                <label class="form-label" for="name">Nombre</label>
                                {!! Form::text('name', old('name',$company->name), ['class' => 'form-control', 'placeholder' => 'Agrega Nombre']) !!}
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="identification">NIT</label>
                                {!! Form::text('identification', old('identification',$company->identification), ['class' => 'form-control', 'placeholder' => 'Agrega NIT']) !!}
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">Correo Electrónico</label>
                                {!! Form::text('email', old('email', $company->email), ['class' => 'form-control', 'placeholder' => 'Agrega Email']) !!}
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="address">Dirección</label>
                                {!! Form::text('address', old('address',$company->address), ['class' => 'form-control', 'placeholder' => 'Agrega Dirección']) !!}
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="phone">Teléfono</label>
                                {!! Form::tel('phone', old('phone',$company->phone), ['class' => 'form-control', 'placeholder' => 'Agrega Teléfono']) !!}
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="website">Sitio Web</label>
                                {!! Form::text('website', old('website'), ['class' => 'form-control', 'placeholder' => 'Agrega Sitio Web']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <a href="#addproduct-alert-collapse" class="text-dark collapsed" data-bs-toggle="collapse"
                       aria-haspopup="true" aria-expanded="false" aria-haspopup="true"
                       aria-controls="addproduct-alert-collapse">
                        <div class="p-4">

                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm">
                                        <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                            02
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="font-size-16 mb-1">Configuración de Empresa</h5>
                                    <p class="text-muted text-truncate mb-0">Configuración adicional de
                                        administración </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                </div>

                            </div>

                        </div>
                    </a>

                    <div id="addproduct-alert-collapse" class="collapse" data-bs-parent="#addproduct-accordion">
                        <div class="p-4 border-top">
                            <div class="row">
                                {{--                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0">Configuración General</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                @php
                                                    $number_passenger=$company->settings->number_passenger??0;
                                                @endphp
                                                <label class="form-label" for="settings[number_passenger]">Numero de
                                                    Pasajes por Colaborador</label>
                                                {!! Form::text('settings[number_passenger]', old('settings[number_passenger]',$number_passenger), ['class' => 'form-control', 'placeholder' => 'Numero de Pasajes']) !!}
                                            </div>
                                            <div class=" mb-3">
                                                <div class="checkbox">
                                                    @php
                                                    $count_passenger=$company->settings->count_passenger??0;
                                                    @endphp
                                                    {{&#45;&#45;                                                    <input type="hidden" value="{{$count_passenger }}"
                                                           name="settings[count_passenger]"/>&#45;&#45;}}
                                                    <label for="settings[count_passenger]">
                                                        <input id="count_passenger"
                                                               name="settings[count_passenger]"
                                                               type="checkbox"
                                                               class="form-check-input"
                                                               {{ old('settings[count_passenger]',$count_passenger) ? 'checked' : '' }}
                                                               value="1"/>
                                                        Contar Pasajes
                                                        {!! $errors->first('count_passenger', '<span class="help-block">:message</span>') !!}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class=" mb-3">
                                                <div class="checkbox">
                                                    @php
                                                        $route_validate=$company->settings->route_validate??0;
                                                    @endphp
                                               {{&#45;&#45;     <input type="hidden" value="{{$route_validate}}"
                                                           name="settings[route_validate]"/>&#45;&#45;}}
                                                    <label for="route_validate">
                                                        <input id="count_passenger"
                                                               name="settings[route_validate]"
                                                               type="checkbox"
                                                               class="form-check-input"
                                                               {{ old('settings[route_validate]',$route_validate)? 'checked' : '' }}
                                                               value="1"/>
                                                        Validar ruta al Colaborador
                                                        {!! $errors->first('route_validate', '<span class="help-block">:message</span>') !!}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class=" mb-3">
                                                <div class="checkbox">
                                                    @php
                                                        $send_email=$company->settings->send_email??0;
                                                    @endphp
                                                    <input type="hidden" value="{{$send_email }}"
                                                           name="settings[send_email]"/>
                                                    <label for="settings[send_email]">
                                                        <input id="send_email"
                                                               name="settings[send_email]"
                                                               type="checkbox"
                                                               class="form-check-input"
                                                               {{ old('settings[send_email]',$send_email) ? 'checked' : ''}}
                                                               value="1"/>
                                                        Enviar QR por Email
                                                        {!! $errors->first('send_email', '<span class="help-block">:message</span>') !!}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class=" mb-3">
                                                <div class="checkbox">
                                                    @php
                                                        $send_whatsapp=$company->settings->send_whatsapp??0;
                                                    @endphp
                                                 {{&#45;&#45; <input type="hidden" value="{{ $send_whatsapp}}"
                                                           name="settings[send_whatsapp]"/>&#45;&#45;}}
                                                    <label for="send_whatsapp">
                                                        <input id="send_whatsapp"
                                                               name="settings[send_whatsapp]"
                                                               type="checkbox"
                                                               class="form-check-input"
                                                               {{ old('settings[send_whatsapp]',$send_whatsapp )? 'checked' : '' }}
                                                               value="1"/>
                                                        Enviar QR por Whatsapp
                                                        {!! $errors->first('send_whatsapp', '<span class="help-block">:message</span>') !!}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>--}}
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0">Configuración Cuenta de Rastreo</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                @php
                                                    $user_tracking=$company->settings->user_tracking??'';
                                                @endphp
                                                <label class="form-label" for="settings[user_tracking]">Usuario</label>
                                                {!! Form::text('settings[user_tracking]', old('settings[user_tracking]',$user_tracking), ['class' => 'form-control', 'placeholder' => 'Numero de Pasajes','id'=>'user_tracking']) !!}
                                            </div>
                                            @php
                                                $password_tracking=$company->settings->password_tracking??'';
                                            @endphp
                                            <div class="mb-3">
                                                <label class="form-label" for="settings[password_tracking]">Contraseña</label>
                                                <input type="password" class="form-control" id="password_tracking"  name="settings[password_tracking]" value="{{old('password_tracking',$password_tracking)}}" placeholder="*********">
                                            </div>
                                            @php
                                                $user_api_hash=$company->settings->user_api_hash??'';
                                            @endphp
                                            <div class="mb-3">
                                                <button type="button" onclick="tokenGenerate()" id="btnTokenGenerate"
                                                        class="btn btn-success waves-effect waves-light mb-2 me-2">
                                                    Generar Token
                                                </button>
                                            </div>
                                            <div class="mb-3" id="getToken">
                                                <label class="form-label" for="settings[user_api_hash]">User API
                                                    Hash</label>
                                                <input type="password" class="form-control"
                                                       name="settings[user_api_hash]"
                                                       id="user_api_hash"
                                                       value="{){old('settings[user_api_hash]',$user_api_hash)}}"
                                                       placeholder="*********">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0">Configuración de envío de Email</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                @php
                                                    $email_host=$company->settings->email_host??'';
                                                @endphp
                                                <label class="form-label" for="settings[email_host]">Servidor de
                                                    Email</label>
                                                {!! Form::text('settings[email_host]', old('settings[email_host]',$email_host ), ['class' => 'form-control', 'placeholder' => 'Servidor de Email']) !!}
                                            </div>
                                            <div class="mb-3">
                                                 @php
                                                    $email_port = $company->settings->email_port??'';
                                                @endphp
                                                <label class="form-label" for="settings[email_port]">Puerto de
                                                    Email</label>
                                                {!! Form::number('settings[email_port]', old('settings[email_port]',$email_port ), ['class' => 'form-control', 'placeholder' => 'Puerto de Email']) !!}
                                            </div>
                                            <div class="mb-3">
                                                 @php
                                                    $email_username = $company->settings->email_username??'';
                                                @endphp
                                                <label class="form-label" for="settings[email_username]">Nombre de usuario </label>
                                                {!! Form::text('settings[email_username]', old('settings[email_username]',$email_username ), ['class' => 'form-control', 'placeholder' => 'info@ejemplo.com']) !!}
                                            </div>
                                            <div class="mb-3">
                                                 @php
                                                    $email_password = $company->settings->email_password??'';
                                                @endphp
                                                <label class="form-label" for="settings[email_password]">Contraseña </label>
                                                {!! Form::text('settings[email_password]', old('settings[email_password]',$email_password ), ['class' => 'form-control', 'placeholder' => '**********']) !!}
                                            </div>
                                            <div class="mb-3">
                                                 @php
                                                    $email_encryption = $company->settings->email_encryption??'';
                                                @endphp
                                                <label class="form-label" for="settings[email_encryption]">Encriptación
                                                    de
                                                    Email</label>
                                                {!! Form::text('settings[email_encryption]', old('settings[email_encryption]',$email_encryption ), ['class' => 'form-control', 'placeholder' => 'TLS, SSL']) !!}
                                            </div>
                                            <div class="mb-3">
                                                 @php
                                                    $email_from_address = $company->settings->email_from_address??'';
                                                @endphp
                                                <label class="form-label" for="settings[email_from_address]">Dirección de
                                                    envío de
                                                    Email</label>
                                                {!! Form::email('settings[email_from_address]', old('settings[email_from_address]',$email_from_address ), ['class' => 'form-control', 'placeholder' => 'Dirección de envío']) !!}
                                            </div>
                                            <div class="mb-3">
                                                 @php
                                                    $email_from_name = $company->settings->email_from_name??'';
                                                @endphp
                                                <label class="form-label" for="settings[email_from_name]">Remitentes</label>
                                                {!! Form::text('settings[email_from_name]', old('settings[email_from_name]',$email_from_name ), ['class' => 'form-control', 'placeholder' => 'Nombre de envío de  Email']) !!}
                                            </div>
                                            <div class="mb-3">
                                                 @php
                                                    $email_subject = $company->settings->email_subject??'';
                                                @endphp
                                                <label class="form-label" for="settings[email_subject]">Asunto</label>
                                                {!! Form::text('settings[email_subject]', old('settings[email_subject]',$email_subject ), ['class' => 'form-control', 'placeholder' => 'Asunto']) !!}
                                            </div>
                                            <div class="mb-3">
                                                 @php
                                                    $email_message = $company->settings->email_message??'';
                                                @endphp
                                                <label class="form-label" for="settings[email_message]">Mensaje </label>
                                                {!! Form::textarea('settings[email_message]', old('settings[email_message]',$email_message ), ['class' => 'form-control', 'rows'=>2]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0">Configuración de envío de Whatsapp</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                 @php
                                                    $whatsapp_token = $company->settings->whatsapp_token??'';
                                                @endphp
                                                <label class="form-label" for="settings[whatsapp_token]">Whatsapp
                                                    Token</label>
                                                {!! Form::text('settings[whatsapp_token]', old('settings[whatsapp_token]',$whatsapp_token ), ['class' => 'form-control', 'placeholder' => 'Whatsapp Token']) !!}
                                            </div>
                                            <div class="mb-3">
                                                 @php
                                                    $whatsapp_sender = $company->settings->whatsapp_sender??'';
                                                @endphp
                                                <label class="form-label" for="settings[whatsapp_sender]">Whatsapp de
                                                    Envio</label>
                                                {!! Form::text('settings[whatsapp_sender]', old('settings[whatsapp_sender]',$whatsapp_sender ), ['class' => 'form-control', 'placeholder' => 'Whatsapp de Envio']) !!}
                                            </div>
                                            <div class="mb-3">
                                                 @php
                                                    $whatsapp_message = $company->settings->whatsapp_message??'';
                                                @endphp
                                                <label class="form-label" for="settings[whatsapp_message]">Mensaje de
                                                    Whatsapp</label>
                                                {!! Form::textarea('settings[whatsapp_message]', old('settings[whatsapp_message]',$whatsapp_message ), ['class' => 'form-control', 'rows'=>2]) !!}
                                            </div>
                                            <div class="mb-3">
                                                 @php
                                                    $whatsapp_template = $company->settings->whatsapp_template??'';
                                                @endphp
                                                <label class="form-label" for="settings[whatsapp_template]">Template de
                                                    Whatsapp</label>
                                                {!! Form::text('settings[whatsapp_template]', old('settings[whatsapp_template]',$whatsapp_template ), ['class' => 'form-control', 'placeholder' => 'Template de Whatsapp']) !!}
                                            </div>
                                            <div class="mb-3">
                                                 @php
                                                    $whatsapp_version = $company->settings->whatsapp_version??'';
                                                @endphp
                                                <label class="form-label" for="settings[whatsapp_version]">Version del
                                                    API de
                                                    Whatsapp</label>
                                                {!! Form::text('settings[whatsapp_version]', old('settings[whatsapp_version]',$whatsapp_version ), ['class' => 'form-control', 'placeholder' => 'v16.0']) !!}
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
            <a href="{{route('sass.company.index')}}" class="btn btn-danger"> <i class="bx bx-x me-1"></i> Cancelar </a>
            <button type="submit" class="btn btn-success"><i class=" bx bx-file me-1"></i> Guardar</button>
        </div> <!-- end col -->
    </div>
    {!! Form::close() !!}
@stop

@section('script')
    <script
        src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
        crossorigin="anonymous"></script>
    <script src="{{ Theme::url('libs/choices.js/choices.js.min.js') }}"></script>
    <script src="{{ Theme::url('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.3/icheck.min.js"
            integrity="sha512-RGDpUuNPNGV62jwbX1n/jNVUuK/z/GRbasvukyOim4R8gUEXSAjB4o0gBplhpO8Mv9rr7HNtGzV508Q1LBGsfA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.3/skins/flat/_all.min.css"
          integrity="sha512-uecJk9KsP+KNuHRBJH+SeSrnP+hmP3tAuC7zFdBNYdwjyXCqH4v2MvYAfLYnBCnZIxP3kY1PAuBJGRiceWbjCg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.3/skins/flat/blue.min.css"
          integrity="sha512-NFzPiFD5sIrKyFzW9/n3DgL45vt0/5SL5KbQXsHyf63cQOXR5jjWBvU9mY3A80LOGPJSGApK8rNwk++RwZAS6Q=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
            integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script type="application/javascript">
    document.addEventListener("DOMContentLoaded", function (event) {
        $('input[type="checkbox"]').change(function(){
            this.value = (Number(this.checked));
        });
    })
</script>
    <script type="application/javascript">

        const loading = new Loader();

        function tokenGenerate() {
            loading.show()
            const email = document.getElementById('user_tracking').value;
            const password = document.getElementById('password_tracking').value

            const data = {
                email: email,
                password: password
            };
            let token = "{{$currentUser->getFirstApiKey() }}";

            axios.post('{{route('api.apigpswox.token.store')}}', data, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                }
            }).then(function (response) {
                document.getElementById('getToken').style.display = "block";
                document.getElementById('btnTokenGenerate').style.display = "none";
                document.getElementById('user_api_hash').value = response.data.data
                alertify.success('Token Generado Satisfactoriamente');
                loading.hidden();
            }).catch(function (error) {
                console.log(error);
                alertify.error('Algo Salio Mal');
            });
            loading.hidden()
        }

    </script>
    <script type="application/javascript">
        document.addEventListener("DOMContentLoaded", function (event) {

            $('#user_api_hash').change(function(){
                document.getElementById('getToken').style.display = "none";
                document.getElementById('btnTokenGenerate').style.display = "block";
            });
            $('#user_tracking').change(function(){
                if(ValidateEmail(this)){
                    document.getElementById('btnTokenGenerate').disabled = false;
                }else {
                    document.getElementById('btnTokenGenerate').disabled = true;
                }

            });
            $('#password_tracking').change(function(){
                if(this.value.length){
                    document.getElementById('btnTokenGenerate').disabled = false;
                }else {
                    document.getElementById('btnTokenGenerate').disabled = true;
                }
            });

        })

        function ValidateEmail(input) {

            var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

            if (input.value.match(validRegex)) {

                return true;

            } else {
                alertify.success('Invalid email address!');

                return false;

            }

        }
    </script>
@stop

