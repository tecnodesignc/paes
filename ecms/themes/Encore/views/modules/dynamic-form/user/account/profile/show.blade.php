@extends('modules.dynamic-form.layouts.master')
@section('title')
    Perfil de Usuario | @parent
@endsection
@section('css')
    <link href="{{ Theme::url('libs/choices.js/choices.js.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{Theme::url('/libs/@simonwep/@simonwep.min.css') }}"/>
    <link rel="stylesheet" href="{{Theme::url('libs/flatpickr/flatpickr.min.css') }}">
@stop

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
          Cuenta
        @endslot
        @slot('title')
          Perfil de Usuario
        @endslot
    @endcomponent
    <div class="row mb-4">
        <div class="col-xl-8">
            <div class="card mb-0">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#edit" role="tab">
                            <i class="bx bx-user-circle font-size-20"></i>
                            <span class="d-none d-sm-block">Perfil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#notification" role="tab">
                            <i class="bx bx-mail-send font-size-20"></i>
                            <span class="d-none d-sm-block">Notificaciones</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#token" role="tab">
                            <i class="bx bx-code-block font-size-20"></i>
                            <span class="d-none d-sm-block">Tokens</span>
                        </a>
                    </li>
                </ul>
                <!-- Tab content -->
                <div class="tab-content p-4">
                    <div class="tab-pane active" id="edit" role="tabpanel">
                        <div>
                            <div>
                                <h5 class="font-size-16 mb-4">Información de Perfil</h5>
                                <div class="row my-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">{{trans('user::users.form.full-name')}}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{$currentUser->present()->fullName()}}
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">{{trans('user::users.form.email')}}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{$currentUser->email}}
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">{{trans('user::users.form.phone')}}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{$currentUser->driver->phone??''}}
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">bio</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{$currentUser->fields->bio??''}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="notification" role="tabpanel">
                        <div>
                            <h5 class="font-size-16 mb-3">Notificaciones</h5>
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap">
                                    <tbody>
                                    @foreach($notifications as $notification)
                                        <tr>
                                            <td>
                                                <div class="avatar-sm">
                                                <span
                                                    class="avatar-title rounded-circle bg-primary text-white font-size-14">
                                                    {!! $notification->icon_class !!}
                                                </span>
                                                </div>
                                            </td>
                                            <td><h5 class="font-size-14 m-0"><a href="{!! $notification->link !!}" class="text-dark">{{ $notification->title }}</a></h5></td>
                                            <td>
                                                <div>
                                                    {{ $notification->message }}
                                                </div>
                                            </td>
                                            <td>
                                                <i class="mdi mdi-circle-medium font-size-18 text-success align-middle me-1"></i>
                                                {{ $notification->time_ago }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="token" role="tabpanel">
                        <div>
                            <h5 class="font-size-16 mb-3">Tokens</h5>
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap">
                                    <tbody>
                                    @foreach($tokens as $token)
                                        <tr>
                                            <td>
                                                <div>
                                                    <a href="javascript: void(0);"
                                                       class="badge bg-soft-primary text-primary font-size-11"> {{$token->access_token}}</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card overflow-hidden">
                <div class="profile-user"></div>
                <div class="card-body">
                    <div class="profile-content text-center">
                        <div class="profile-user-img">
                            <img
                                src="{{$currentUser->present()->gravatar()}}"
                                alt="{{$currentUser->present()->fullName()}}"
                                class="avatar-lg rounded-circle img-thumbnail">
                        </div>

                        <div class="mt-4">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#profile-edit"><i class="mdi mdi-pencil me-1"></i>Editar Perfil
                            </button>
                        </div>

                        <h5 class="mt-3 mb-1">{{ $currentUser->present()->fullName()}}</h5>
                        <p class="text-muted">{{$currentUser->fiels->position??$currentUser->roles[0]->name}}</p>

                        <p class="text-muted mb-1">
                           {!!$currentUser->fiels->bio??''!!}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="profile-edit" tabindex="-1" aria-labelledby="exampleModalPopoversLabel"
         aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalPopoversLabel">Update Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {!! Form::open(['route' => ['account.profile.update'], 'method' => 'put', 'id'=>"registrationForm"]) !!}
                <div class="card">
                    <div class="card-body">
                            <div class="row mb-4">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Nombre</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{ucfirst($currentUser->first_name)}}" name="name"
                                           class="form-control" id="horizontal-firstname-input">
                                </div>
                            </div><!-- end row -->
                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Apellido</label>
                            <div class="col-sm-9">
                                <input type="text" value="{{ucfirst($currentUser->last_name)}}" name="name"
                                       class="form-control" id="horizontal-firstname-input">
                            </div>
                        </div><!-- end row -->

                            <div class="row mb-4">
                                <label for="horizontal-email-input" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" name="email" value="{{ucfirst($currentUser->email)}}"
                                           class="form-control" id="horizontal-email-input">
                                </div>
                            </div>
                        <div class="row mb-4">
                            <label for="horizontal-email-input" class="col-sm-3 col-form-label">Bio</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="fields['bio']">
                                    {{$currentUser->fields->bio??''}}
                                </textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="horizontal-email-input" class="col-sm-3 col-form-label">Contraseña</label>
                            <div class="col-sm-9">
                                <input type="password" name="password"
                                       class="form-control" id="horizontal-email-input">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="horizontal-email-input" class="col-sm-3 col-form-label">Confirmación de contraseña</label>
                            <div class="col-sm-9">
                                <input type="password" name="password_confirmation"
                                       class="form-control" id="horizontal-email-input">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="avatar" class="col-sm-3">Imagen de Perfil</label>
                            <div class="col-sm-9">
                                <!--                                    <div class="input-group">
                                        <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                               id="useravatar" name="avatar" autofocus>
                                        <label class="input-group-text" for="avatar">Subir</label>
                                    </div>-->
                                <div class="text-start mt-2">
                                    <img
                                        src="{{$currentUser->present()->gravatar()}}"
                                        alt="{{$currentUser->present()->fullName()}}"
                                        class="rounded-circle avatar-lg">
                                </div>
                                <div class="text-danger" role="alert" id="avatarError"
                                     data-ajax-feedback="avatar"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="updateprofile">Guardar Cambios</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
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

            <script type="application/javascript" async>
                const loading = new Loader();

                document.addEventListener('DOMContentLoaded', function () {

                    loading.hidden()
                    var multipleCancelButton = new Choices('#roles', {
                        removeItemButton: true
                    });
                })
            </script>
@stop
