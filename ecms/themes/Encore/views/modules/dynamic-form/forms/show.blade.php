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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script type="application/javascript">


        $(document).ready(function() {
            $('.form-select').select2({
                placeholder: {id:'-1', text:"--Seleccione--"},
                allowClear: true
            });
            $('.form-select-multiple').select2({
                placeholder: "--Seleccione--"
            });

        });

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
  ////////////////////////////////////////////////////////////////////////////////////////

        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureButton = document.getElementById('captureButton');
        const uploadButton = document.getElementById('uploadButton');
        const switchCameraButton = document.getElementById('switchCameraButton');
        const gallery = document.getElementById('gallery');
       
        let imageIndex = 0;
        // Aqui definimos la cantidad de imagenes que se pueden tomar o cargar
        const maxImages = 1;

        // Función para cargar una imagen desde el dispositivo
        function uploadImage() {
            if (imageIndex < maxImages) {
                const input = document.createElement('input');
                input.type = 'file';
                input.accept = 'image/*';
                input.onchange = (event) => {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.readAsDataURL(file);
                        reader.onload = () => {
                            displayImage(reader.result);
                        }
                    }
                };
                input.click();
            } else {
                alert('¡Ya has alcanzado el límite de imágenes!');
            }
        }

        // Función para mostrar una imagen en la galería
        function displayImage(imageData) {
            const image = new Image();
            image.src = imageData;
            const imageContainer = document.createElement('div');
            imageContainer.classList.add('image-container');
            imageContainer.innerHTML = `
                <img src="${imageData}" width="200" height="150" alt="Image ${imageIndex}">
                <a onclick="removeImage(this)" class="btn btn-danger"><i class="fas fa-times-circle"></i></a>
                `;
            gallery.appendChild(imageContainer);
            imageIndex++;
        }

        // Quita la imagen antes de cargarla
        function removeImage(button) {
            const container = button.parentElement;
            container.remove();
            imageIndex--;
        }

        // Función para capturar una imagen desde la cámara
        function captureImage() {
            if (imageIndex < maxImages) {
                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                const imageData = canvas.toDataURL('image/jpeg');
                displayImage(imageData);
            } else {
                alert('¡Ya has alcanzado el límite de imágenes!');
            }
        }

        // Función para obtener la cámara trasera si está disponible
        async function getBackCamera() {
            const devices = await navigator.mediaDevices.enumerateDevices();
            const backCamera = devices.find(device => device.kind === 'videoinput' && !device.label.toLowerCase().includes('front'));
            return backCamera;
        }

        // Función para cambiar entre las cámaras trasera y frontal
        async function switchCamera() {
            if (mediaStream) {
                const backCamera = await getBackCamera();
                if (backCamera) {
                    mediaStream.getTracks().forEach(track => track.stop());
                    navigator.mediaDevices.getUserMedia({ video: { deviceId: backCamera.deviceId } })
                        .then(stream => {
                            video.srcObject = stream;
                            mediaStream = stream;
                        })
                        .catch(error => {
                            console.error('Error al acceder a la cámara trasera: ', error);
                        });
                } else {
                    alert('No se encontró una cámara trasera disponible.');
                }
            }
        }

        /// Obtener la cámara trasera al cargar la página
        document.addEventListener('DOMContentLoaded', async () => {
            const backCamera = await getBackCamera();
            if (backCamera) {
                navigator.mediaDevices.getUserMedia({ video: { deviceId: backCamera.deviceId } })
                    .then(stream => {
                        video.srcObject = stream;
                        mediaStream = stream;
                    })
                    .catch(error => {
                        console.error('Error al acceder a la cámara trasera: ', error);
                    });
            } else {
                console.log('No se encontró una cámara trasera disponible.');
            }
        });

        captureButton.addEventListener('click', captureImage);
        uploadButton.addEventListener('click', uploadImage);
        switchCameraButton.addEventListener('click', switchCamera);
        
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
