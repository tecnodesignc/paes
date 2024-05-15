@extends('layouts.master')
@section('title')
    Vista previa
@endsection
@section('css')
    <link href="{{Theme::url('libs/alertifyjs/alertifyjs.min.css')}}" rel="stylesheet" type="text/css"/>
    {!! Theme::style('libs/glightbox/glightbox.min.css?v='.config('app.version')) !!}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
    {{-- Cabecera donde irá el título y la empresa del formulario --}}
    <div class="row">

        <div class="d-print-none mb-2">
            <div class="float-end">
                <button type="button" class="btn btn-secondary" onclick="goBack()">Volver Atrás</button>
            </div>
        </div>

        <div class="card border border-primary">
            <div class="card-body m-1">
                <h1 class="text-primary text-center">{{$form->name}}</h1>
            </div>
        </div>
    </div>
    {{-- Card de campos del formulario --}}
    <div class="row">
        <div class="card border border-primary">
            <div class="card-body">
                {{-- Renderizamos los campos del formulario --}}
                @foreach($datos as $dato)
                    @include('modules.dynamic-form.partials.field_show',['field'=>$dato])
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ Theme::url('libs/glightbox/glightbox.min.js') }}"></script>
    <script src="{{ Theme::url('js/app.js') }}"></script>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="application/javascript">

        $(document).ready(function() {
            $('.form-select').select2({
                placeholder: {id:'-1', text:"--Seleccione--"},
                allowClear: true,
                width: 'resolve' // need to override the changed default
            });
            $('.form-select-multiple').select2({
                placeholder: "--Seleccione--",
                width: 'resolve' // need to override the changed default
            });

        });

        document.addEventListener('DOMContentLoaded', (event) => {
            const canvas = document.getElementById('signatureCanvas');
            const ctx = canvas.getContext('2d');
            let isDrawing = false;
            let lastX = 0;
            let lastY = 0;

            function draw(e) {
                if (!isDrawing) return;
                let mouseX, mouseY;
                // Determinar las coordenadas del evento
                if (e.type === 'mousemove' || e.type === 'mousedown' || e.type === 'mouseup' || e.type === 'mouseout') {
                    mouseX = e.offsetX;
                    mouseY = e.offsetY;
                } else if (e.type === 'touchmove' || e.type === 'touchstart' || e.type === 'touchend') {
                    const rect = canvas.getBoundingClientRect();
                    mouseX = e.touches[0].clientX - rect.left;
                    mouseY = e.touches[0].clientY - rect.top;
                }
                ctx.beginPath();
                ctx.moveTo(lastX, lastY);
                ctx.lineTo(mouseX, mouseY);
                ctx.stroke();
                lastX = mouseX;
                lastY = mouseY;
            }

            // Event listeners para el canvas
            canvas.addEventListener('mousedown', (e) => {
                isDrawing = true;
                [lastX, lastY] = [e.offsetX, e.offsetY];
            });

            canvas.addEventListener('mousemove', draw);

            canvas.addEventListener('mouseup', () => {
                isDrawing = false;
            });

            canvas.addEventListener('mouseout', () => {
                isDrawing = false;
            });

            // Event listeners para eventos táctiles
            canvas.addEventListener('touchstart', (e) => {
                isDrawing = true;
                [lastX, lastY] = [e.touches[0].clientX, e.touches[0].clientY];
            });

            canvas.addEventListener('touchmove', draw);

            canvas.addEventListener('touchend', () => {
                isDrawing = false;
            });
        });

        // LOGICA PARA LA CAMARA
        let imageIndex = 0;
        // Aqui definimos la cantidad de imagenes que se pueden tomar o cargar
        const maxImages = 1;

        function uploadImage(fieldId) {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = () => {
                        displayImage(reader.result, fieldId);
                    }
                }
            };
            input.click();
        }

        function displayImage(imageData, fieldId) {
            const gallery = document.getElementById('gallery-' + fieldId);
            const imageIndex = gallery.querySelectorAll('.image-container').length;
            if (imageIndex < maxImages) {
                const image = new Image();
                image.src = imageData;
                const imageContainer = document.createElement('div');
                imageContainer.classList.add('image-container');
                imageContainer.innerHTML = `
                    <img src="${imageData}" width="200" height="150" alt="Image ${imageIndex}">
                    <a onclick="removeImage(this, '${fieldId}')" class="btn btn-danger"><i class="fas fa-times-circle"></i></a>
                    `;
                gallery.appendChild(imageContainer);
            } else {
                alert('¡Ya has alcanzado el límite de imágenes!');
            }
        }

        function removeImage(button, fieldId) {
            const container = button.parentElement;
            container.remove();
        }

        function captureImage(fieldId) {
            const video = document.getElementById('video-' + fieldId);
            const canvas = document.getElementById('canvas-' + fieldId);
            const gallery = document.getElementById('gallery-' + fieldId);

            const imageIndex = gallery.querySelectorAll('.image-container').length;
            if (imageIndex < maxImages) {
                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                const imageData = canvas.toDataURL('image/jpeg');
                displayImage(imageData, fieldId);
            } else {
                alert('¡Ya has alcanzado el límite de imágenes!');
            }
        }

        async function switchCamera(fieldId) {
            const video = document.getElementById('video-' + fieldId);
            const mediaStream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = mediaStream;
        }

        document.addEventListener('DOMContentLoaded', async () => {
            // se puede hacer un bucle sobre todos los field->id para inicializar las cámaras
            const fieldIds = [/* lista de todos los field->id */];
            fieldIds.forEach(async (fieldId) => {
                const video = document.getElementById('video-' + fieldId);
                const mediaStream = await navigator.mediaDevices.getUserMedia({ video: true });
                video.srcObject = mediaStream;
            });
        });

        function cancelCamera(fieldId) {
            const video = document.getElementById('video-' + fieldId);
            const mediaStream = video.srcObject;
            if (mediaStream) {
                mediaStream.getTracks().forEach(track => track.stop());
                video.srcObject = null;
            }
        }

    </script>

    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
    
    <style>
        #qrcode img {
            margin: auto;
        }

        /* .image-container {
            display: inline-block;
            margin: 10px;
        } */
    </style>
@endsection
