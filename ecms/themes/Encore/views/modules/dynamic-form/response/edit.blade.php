@extends('layouts.master')
@section('title')
    Editar Formulario
@endsection

@section('css')
    {!! Theme::style('libs/glightbox/glightbox.min.css?v='.config('app.version')) !!}
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Formularios
        @endslot
        @slot('title')
            Ver  Respuesta del Formulario
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                        <h4 class="float-end font-size-15">Formulario {{$form_response->id}}</h4>
                        <div class="mb-4">
                            <img src="{{ Theme::url('images/logo.png') }}" alt="logo" height="28"/>
                        </div>
                        <div class="text-muted">
                            <p class="mb-1">{{$form_response->company->name}}</p>
                            <p class="mb-1"><i
                                        class="mdi mdi-email-outline me-1"></i> {{$form_response->company->email}}</p>
                            <p><i class="mdi mdi-phone-outline me-1"></i>{{$form_response->company->phone}}</p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-muted">
                                <h5 class="font-size-16 mb-3">Colaborador:</h5>
                                <h5 class="font-size-15 mb-2">{{$form_response->data->info->fullName}}</h5>
                                <p class="mb-1">{{$form_response->data->info->identification}}</p>
                                {{-- <p class="mb-1">PrestonMiller@armyspy.com</p>
                                 <p>001-234-5678</p>--}}
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-sm-6">
                            <div class="text-muted text-sm-end">
                                <div>
                                    <h5 class="font-size-15 mb-1">Placa de Vehículo:</h5>
                                    <p>{{$form_response->data->info->vehicle->label}}</p>
                                </div>
                                <div class="mt-4">
                                    <h5 class="font-size-15 mb-1">Kilometraje del Vehiculo:</h5>
                                    <p>{{$form_response->data->info->vehicle->millage}}</p>
                                </div>
                                <div class="mt-4">
                                    <h5 class="font-size-15 mb-1">Fecha De registro:</h5>
                                    <p>{{$form_response->created_at->format('Y-m-d')}}</p>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="py-2">
                        <h5 class="font-size-15">Resumen del Formulario</h5>

                        <div class="table-responsive mb-5">
                            <table class="table align-middle table-nowrap table-centered mb-0">
                                <thead>
                                <tr>
                                    <th class="fw-bold">Pregunta</th>
                                    <th class="fw-bold">Respuesta</th>
                                    <th class="fw-bold">Imagen</th>
                                    <th class="fw-bold">Comentario</th>
                                </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                @foreach($form_response->data->answers as $answer)
                                    @include('modules.dynamic-form.partials.field',['fiel'=>$answer])
                                    <!-- end tr -->
                                @endforeach
                                </tbody><!-- end tbody -->
                            </table><!-- end table -->
                        </div><!-- end table responsive -->
                        @foreach($form_response->data->answers as $answer)
                            @if($answer->type === 8)
                                <div class="popup-gallery">
                                    <h5 class="font-size-15">{{$answer->label}}</h5>
                                    <div class="row">
                                        @php
                                            $images=explode(',',$answer->value)
                                        @endphp
                                        @if(count($images)>1)
                                            @foreach($images as $img)
                                                <div class="col-xl-2 col-md-4 col-6">
                                                    <div class="mt-4">
                                                        <a href="{{url($img)}}"
                                                           class="thumb preview-thumb image-popup">
                                                            <div class="img-fluid">
                                                                <img src="{{url($img)}}" alt=""
                                                                     class="img-fluid d-block" width="150px">
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-xl-2 col-md-4 col-6">
                                                <div class="mt-4">
                                                    <a href="{{url($answer->value)}}"
                                                       class="thumb preview-thumb image-popup">
                                                        <div class="img-fluid">
                                                            <img src="{{url($answer->value)}}" alt=""
                                                                 class="img-fluid d-block">
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if($answer->type === 9)
                                <div class="popup-gallery mt-4">
                                    <h5 class="font-size-15">{{$answer->label}}</h5>
                                    <div class="row">
                                        <div class="col-xl-2 col-md-4 col-6">
                                            <div class="mt-4">
                                                <a href="{{url($answer->value)}}"
                                                   class="thumb preview-thumb image-popup">
                                                    <div class="img-fluid">
                                                        <img src="{{url($answer->value)}}" alt=""
                                                             class="img-fluid d-block">
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="d-print-none mt-4">
                            <div class="float-end">
                                <a href="javascript:window.print()" class="btn btn-success me-1"><i
                                            class="fa fa-print"></i></a>
                                <a href="{{route('dynamicform.formresponses.pdf',[$form->id,$form_response->id])}}" class="btn btn-primary w-md">Descargar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ Theme::url('libs/glightbox/glightbox.min.js') }}"></script>
    <script src="{{Theme::url('js/app.js')}}"></script>
    <script type="application/javascript" async>
        (function () {
            'use strict';
            let token = "{{$currentUser->getFirstApiKey() }}";
            window.addEventListener('load', function () {
                // GLightbox Popup
                var lightbox = GLightbox({
                    selector: '.image-popup',
                    title: false,
                });
            })
        })();
    </script>
    <style>
        .fade:not(.show) {
            opacity: 1;
        }
    </style>
@endsection

