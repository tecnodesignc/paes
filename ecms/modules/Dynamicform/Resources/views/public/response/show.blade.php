@extends('layouts.master')
@section('title')
    Editar Formulario
@endsection

@section('css')
    {!! Theme::style('libs/glightbox/glightbox.min.css?v='.config('app.version')) !!}
    <link href="{{Theme::url('libs/alertifyjs/alertifyjs.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Formularios
        @endslot
        @slot('title')
            Ver Respuesta del Formulario
        @endslot
    @endcomponent
    <div class="row">


    </div>


    <div class="row">
        {{-- <div class="col"> --}}
            <div class="d-print-none mb-2">
                <div class="float-end">
                    <button type="button" class="btn btn-secondary" onclick="goBack()">Volver Atrás</button>
                </div>
            </div>


            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                        <h4 class="float-end font-size-48">{{$form->name}}</h4>
                        <div class="mb-4">
                            <div class="img-fluid">
                                @if($form_response->company->logo!=null)
                                    <a href="{{url($form_response->company->logo)}}" class="thumb preview-thumb image-popup">
                                        <div class="img-fluid">
                                            <img src="{{ url($form_response->company->logo) }}" alt="logo de la empresa" class="img-fluid d-block" width="200" height="100">
                                        </div>
                                    </a>
                                @else
                                    <a href="{{ Theme::url('images/logo2.jpeg') }}" class="thumb preview-thumb image-popup">
                                        <div class="img-fluid">
                                            <img src="{{ Theme::url('images/logo2.jpeg') }}" alt="logo" class="img-fluid d-block" width="200" height="100" />
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="text-muted">
                            <p class="mb-1 font-size-20">{{$form_response->company->name}}</p>
                            <p class="mb-0"><i class="mdi mdi-email-outline me-1 text-danger mdi-24px"></i> {{$form_response->company->email ?? null}}</p>
                            <p><i class="mdi mdi-phone-outline me-1 text-primary mdi-24px"></i>{{$form_response->company->phone ?? null}}</p>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-muted">
                                <h5 class="font-size-28 mb-3"><strong> Colaborador: </strong></h5>

                                <h5 class="font-size-15 mb-1">{{$form_response->data->info->fullName ?? null}}</h5>
                                <p>{{$form_response->data->info->identification ?? null}}</p>

                                 <h5 class="font-size-15 mb-1">Placa del vehículo:</h5>
                                 <p>{{$form_response->data->info->vehicle->label ?? null}}</p>

                                 <h5 class="font-size-15 mb-1">Kilometraje del vehículo:</h5>
                                 <p>{{$form_response->data->info->vehicle->millage ?? null}}</p>

                                 <h5 class="font-size-15 mb-1">Fecha de registro:</h5>
                                 <p>{{$form_response->created_at ?? null}}</p>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                    {{-- <hr class="my-3"> --}}

                    {{-- Card de campos del formulario --}}
                    <div class="row">
                        {{-- Renderizamos los campos del formulario --}}
                        @foreach($form_response->data->answers as $dato)
                            {{-- Incluimos la vista del campo con el valor establecido --}}
                            @include('dynamicform::public.partials.field_response', ['field' => $dato])
                        @endforeach
                    </div>

                    <hr class="my-3">

                    <div class="d-print-none mt-3">
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn-success me-1">
                                <i class="fa fa-print"></i>
                            </a>
                            {{-- <a href="{{route('dynamicform.formresponses.downloadpdf', [$form_response,$form_response->id])}}" class="btn btn-primary w-md">Descargar</a> --}}
                        </div>
                    </div>

                </div>
            </div>
        {{-- </div> --}}
    </div>
@endsection
@section('script')
    <script src="{{ Theme::url('libs/glightbox/glightbox.min.js') }}"></script>
    <script src="{{Theme::url('js/app.js')}}"></script>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>

    <style>
        .fade:not(.show) {
            opacity: 1;
        }
    </style>
@endsection
