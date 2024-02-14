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
           Contestar Formulario
        @endslot
    @endcomponent
    {{-- Cabecera donde irá el título y la empresa del formulario --}}
    <div class="row">
        <div class="card border border-primary">
            <div class="card-body m-1">
                <h1 class="text-primary text-center">{{$form->name}}</h1>
            </div>
        </div>
    </div>

    {!! Form::open(['route' => ['dynamicform.formresponses.store', $form], 'method' => 'post', 'class'=>'needs-validation']) !!}
    @csrf
    <div class="row">
        <div class="card border border-primary">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <h5 class="text-truncate font-size-18 mb-1">Nombre completo:</h5>
                        <input type="text" name="fullName" id="" value="{{ucfirst($currentUser->present()->fullName())}}" class="form-control" readonly>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <h5 class="text-truncate font-size-18 mb-1">Identificación:</h5>
                        <input type="text" name="identification" id="" value="" class="form-control" readonly>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-6 col-sm-6">
                        <h5 class="text-truncate font-size-18 mb-1">Vehículo:</h5>
                        <select class="form-control" name="label">
                            <option value="">--Seleccione--</option>
                            {{-- @foreach($options as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <h5 class="text-truncate font-size-18 mb-1">Kilometraje:</h5>
                        <input type="text" name="millage" id="" class="form-control">
                    </div>
                </div>
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
    {{-- Card con los botones que guardan las respuestas --}}
    <div class="row">
        <div class="card border border-primary">
            <div class="card-body">
                <div class="d-flex gap-4 justify-content-center">
                    <button class="btn btn-success" type="submit">Enviar respuestas</button>
                    <button class="btn btn-danger" type="reset">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@endsection
@section('script')
    <script src="{{ Theme::url('libs/glightbox/glightbox.min.js') }}"></script>
    <script src="{{ Theme::url('js/app.js') }}"></script>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="application/javascript">

        $(document).ready(function() {
            $('.form-select').select2({
                // theme: 'bootstrap4',
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

        //Apagamos la camara
        function cancelCamera(fieldId) {
            const video = document.getElementById('video-' + fieldId);
            const mediaStream = video.srcObject;
            if (mediaStream) {
                mediaStream.getTracks().forEach(track => track.stop());
                video.srcObject = null;
            }
        }

    </script>
    <script type="application/javascript">

        // Recolectar los datos del formulario
        function collectFormData() {
        // Objeto para almacenar los datos del formulario
        var formData = {
            "info": {
            "fullName": document.getElementById("fullName").value,
            "identification": document.getElementById("identification").value,
            "vehicle": {
                "value": document.getElementById("vehicleValue").value,
                "label": document.getElementById("vehicleLabel").value,
                "millage": document.getElementById("vehicleMillage").value
            }
            },
            "answers": []
        };

        // Recolectar respuestas de campos dinámicos
        var fields = document.querySelectorAll(".dynamic-field");
        fields.forEach(function(field) {
            var fieldId = field.getAttribute("data-field-id");
            var fieldType = field.getAttribute("data-field-type");
            var fieldValue = "";

            // Recolectar valor dependiendo del tipo de campo
            switch (fieldType) {
            case "text":
            case "textarea":
            case "number":
            case "tel":
            case "email":
                fieldValue = field.value;
                break;
            case "radio":
                var selectedRadio = field.querySelector("input[type=radio]:checked");
                if (selectedRadio) {
                fieldValue = selectedRadio.value;
                }
                break;
            // Añadir más casos según sea necesario para otros tipos de campos
            }

            // Añadir respuesta al array de respuestas
            formData.answers.push({
            "field_id": fieldId,
            "value": fieldValue
            });
        });

        return formData;
        }

        // Evento para manejar el envío del formulario
        document.getElementById("submitForm").addEventListener("click", function(event) {
        event.preventDefault();
        var formData = collectFormData();
        console.log(formData); // Aquí puedes hacer lo que quieras con el objeto de datos
        });




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
