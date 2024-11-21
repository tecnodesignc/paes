@extends('modules.dynamic-form.layouts.master')
@section('title')
    Formularios
@endsection
@section('css')
    <link href="{{Theme::url('libs/alertifyjs/alertifyjs.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{Theme::url('libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Eje Satelital
        @endslot
        @slot('title')
            Formularios
        @endslot
    @endcomponent

    <div class="row">
        @foreach ($forms as $form)
        <a href="{{ route('dynamicform.formresponses.create', $form->id)}}" class="col-lg-4 col-sm-12">
            <div class="card text-center" style="color: {{$form->color}}">
                <div class="card-body d-flex justify-content-start align-items-center">
                    <i class="{{ $form->icon }} me-5 display-6"></i>
                    <p class="text-truncate display-7">{{$form->name}}</p>
                </div>
            </div>
        </a>
        @endforeach
    </div>

@endsection
@section('script')
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="{{ Theme::url('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ Theme::url('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ Theme::url('js/app.js') }}"></script>
    <script type="application/javascript" async>

    </script>

@endsection
