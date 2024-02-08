@extends('layouts.master')
@section('title')
    Vista previa
@endsection
@section('css')
    <link href="{{Theme::url('libs/alertifyjs/alertifyjs.min.css')}}" rel="stylesheet" type="text/css"/>
    {!! Theme::style('libs/glightbox/glightbox.min.css?v='.config('app.version')) !!}

@stop

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Formularios
        @endslot
        @slot('title')
           Vista previa
        @endslot
    @endcomponent

    {{-- @foreach ($campos as $campo)
        <p>{{ $campo['id'] }}</p>
    @endforeach --}}

    <div class="row">
        <div class="card border border-primary">
            <div class="card-body">
                {{-- <div class="table-responsive"> --}}
                    <table class="table align-middle table-nowrap table-centered mb-0 table-hover">
                        <thead class="thead-primary">
                            <tr>
                                <th class="fw-bold">Pregunta</th>
                                <th class="fw-bold">Campo</th>
                                <th class="fw-bold">Imagen</th>
                                <th class="fw-bold">Comentario</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($datos as $dato)

                                @include('modules.dynamic-form.partials.field_show',['field'=>$dato])
                              
                            @endforeach
                        </tbody>
                    </table>
                 {{-- </div> --}}
            </div>
        </div>
    </div>
    





@endsection
@section('script')
    <script src="{{ Theme::url('libs/glightbox/glightbox.min.js') }}"></script>
    <script src="{{ Theme::url('js/app.js') }}"></script>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>

    

    @parent
    <script type="application/javascript">
        document.addEventListener('DOMContentLoaded', (event) => {
            const canvas = document.getElementById('signatureCanvas');
            const ctx = canvas.getContext('2d');
            let isDrawing = false;
            let lastX = 0;
            let lastY = 0;
    
            // Event listeners para el canvas
    
            canvas.addEventListener('mousedown', (e) => {
                isDrawing = true;
                [lastX, lastY] = [e.offsetX, e.offsetY];
            });
    
            canvas.addEventListener('mousemove', (e) => {
                if (!isDrawing) return;
                ctx.beginPath();
                ctx.moveTo(lastX, lastY);
                ctx.lineTo(e.offsetX, e.offsetY);
                ctx.stroke();
                [lastX, lastY] = [e.offsetX, e.offsetY];
            });
    
            canvas.addEventListener('mouseup', () => {
                isDrawing = false;
            });
    
            canvas.addEventListener('mouseout', () => {
                isDrawing = false;
            });

        });
    </script>

    <style>
        #qrcode img {
            margin: auto;
        }
    </style>
@endsection
