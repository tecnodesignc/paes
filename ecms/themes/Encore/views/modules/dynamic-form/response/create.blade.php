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

    <form  id="dynamic-form" >
    @csrf
    <div class="row">
        <div class="card border border-primary">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <h5 class="text-truncate font-size-18 mb-1">Nombre completo:</h5>
                        <input type="text" name="fullName" id="fullName" value="{{ucfirst($currentUser->present()->fullName())}}" class="form-control" readonly>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <h5 class="text-truncate font-size-18 mb-1">Identificación:</h5>
                        <input type="text" name="identification" id="identification" value="" class="form-control" readonly>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-6 col-sm-6">
                        <h5 class="text-truncate font-size-18 mb-1">Vehículo:</h5>
                        <select class="form-control" name="label" id="vehicleLabel">
                            <option value="">--Seleccione--</option>
                            {{-- @foreach($options as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <h5 class="text-truncate font-size-18 mb-1">Kilometraje:</h5>
                        <input type="text" name="millage" id="vehicleMillage" class="form-control">
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

</form>

@endsection
@section('script')
    <script src="{{ Theme::url('libs/glightbox/glightbox.min.js') }}"></script>
    <script src="{{ Theme::url('js/app.js') }}"></script>
    <script src="{{ Theme::url('libs/alertifyjs/alertifyjs.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
    </script>

    <script type="application/javascript">
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
    </script>

    <script type="application/javascript">
        // LOGICA PARA LA CAMARA
        let imageIndex = 0;
        // Aqui definimos la cantidad de imagenes que se pueden tomar o cargar
        const maxImages = 1;

        // Función para cargar la imagen desde el archivo
        function uploadImage(fieldId) {
            var input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = function(event) {
                var file = event.target.files[0];
                var reader = new FileReader();
                reader.onload = function(event) {
                    var img = new Image();
                    img.onload = function() {
                        var canvas = document.getElementById('canvas-' + fieldId);
                        var context = canvas.getContext('2d');
                        context.drawImage(img, 0, 0, canvas.width, canvas.height);

                        // Llamar a la función para subir el archivo al almacenamiento
                        uploadFile(fieldId, file.name, 'image', 'canvas-' + fieldId);
                    };
                    img.src = event.target.result;
                };
                reader.readAsDataURL(file);
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

                const fileName = 'captured_image_';
                // Llamar a la función para subir el archivo al almacenamiento
                uploadFile(fieldId, fileName, 'image', 'canvas-' + fieldId);
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
                    "value": 1,
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
                var fieldLabel = field.getAttribute("data-field-label");
                var fieldFoto;
                var fieldComment;
                var foto;
                var fieldValue;
                // console.log(fieldId + "\n" + fieldType);
                // Recolectar valor dependiendo del tipo de campo
                switch (fieldType) {
                    // Texto
                    case "0":
                        fieldValue = document.getElementById("btntext-" + fieldId).value;
                        break;
                    // Area de texto
                    case "1":
                        fieldValue = document.getElementById("btntextarea-" + fieldId).value;
                        break;
                    // numero
                    case "2":
                        fieldValue = document.getElementById("btnnumber-" + fieldId).value;
                        break;
                    // tel
                    case "3":
                        fieldValue = document.getElementById("btntel-" + fieldId).value;
                        break;
                    // email
                    case "4":
                        fieldValue = document.getElementById("btnemail-" + fieldId).value;
                        break;
                    // inputs si/no/noaplica
                    case "5":
                        // Obtener los valores de los tres radio buttons
                        let radio1 = document.getElementById("btnradio-" + fieldId + "-1").checked;
                        let radio2 = document.getElementById("btnradio-" + fieldId + "-2").checked;
                        let radio3 = document.getElementById("btnradio-" + fieldId + "-3").checked;

                        if (radio1) {
                            fieldValue = 1;
                        } else if (radio2) {
                            fieldValue = 0;
                        } else if (radio3) {
                            fieldValue = 2;
                        }
                        fieldComment = document.getElementById("btncomment-" + fieldId).value;
                        break;
                    // select
                    case "6":
                        fieldValue = document.getElementById("btnselect-" + fieldId).value;
                        fieldComment = document.getElementById("btncomment-" + fieldId).value;
                        break;
                    // select multiple
                    case "7":
                        fieldValue = document.getElementById("btnselect-multiple-" + fieldId).value;
                        fieldComment = document.getElementById("btncomment-" + fieldId).value;
                        break;

                    case "10":
                    case "11":
                        // Obtener los botones de radio para este campo
                        var radioButtons = document.querySelectorAll("input[name='option_" + fieldId + "']:checked");
                        // Obtener el valor seleccionado si hay un botón de radio seleccionado
                        if (radioButtons.length > 0) {
                            fieldValue = radioButtons[0].value;
                        } else {
                            // Si no hay botón de radio seleccionado, asignar un valor predeterminado o null según tu lógica
                            fieldValue = null; // O cualquier otro valor predeterminado
                        }
                        // Obtener el comentario del textarea correspondiente
                        fieldComment = document.getElementById("btncomment-" + fieldId).value;
                        break;
                    }

                // Añadir respuesta al array de respuestas
                formData.answers.push({
                    "field_id": fieldId,
                    "label": fieldLabel,
                    "type": fieldType,
                    "value": fieldValue,
                    "comment": fieldComment && fieldComment.trim() !== '' ? fieldComment : undefined,
                    "image": fieldFoto && fieldFoto.trim() !== '' ? fieldFoto : undefined
                });

            });

            formData = eliminarDuplicados(formData.answers);

            return formData;
        }

        //Elimina los datos duplicados
        function eliminarDuplicados(respuestas) {
            var uniqueAnswers = [];
            var seenFieldIds = {};

            respuestas.forEach(function(answer) {
                if (!seenFieldIds.hasOwnProperty(answer.field_id)) {
                    uniqueAnswers.push(answer);
                    seenFieldIds[answer.field_id] = true;
                }
            });

            return uniqueAnswers;
        }

        //Convertimos la imagen que está en base 64 a archivo
        function dataURLtoFile(dataurl, filename) {
            var arr = dataurl.split(','),
                mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]),
                n = bstr.length,
                u8arr = new Uint8Array(n);
            while (n--) {
                u8arr[n] = bstr.charCodeAt(n);
            }
            return new File([u8arr], filename, { type: mime });
        }

        // Sube el archivo al almacenamiento
        function uploadFile(id, label, type, canvasId = 'signatureCanvas') {
            var formDataAnswers = {
                "answers": []
            };
            event.preventDefault();
            var canvas = document.getElementById(canvasId);
            var cxt = canvas.getContext("2d");
            var imageData = canvas.toDataURL('image/png');

            // Generar un nombre único basado en un timestamp
            const currentDate = new Date();
            const day = String(currentDate.getDate()).padStart(2, '0');
            const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Los meses son indexados desde 0
            const year = String(currentDate.getFullYear()).slice(-2); // Solo toma los últimos dos dígitos del año

            const formattedDate = `${day}-${month}-${year}`;

            var signatureFile = dataURLtoFile(imageData, 'image_'+formattedDate+'_'+label+'.png'); // Convertir imageData a un archivo

            var formData = new FormData();
            formData.append('file', signatureFile);
            // console.log(formData);
            // Realizar la solicitud con Axios
            var uploadImageUrl = "{{ route('api.dynamicform.field.upload-image') }}";
            axios.post(uploadImageUrl, formData, {
                headers: {
                    'Authorization': `Bearer {{$currentUser->getFirstApiKey()}}`,
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                // Verificar si la solicitud fue exitosa
                if (response.status === 200) {
                    // Añadir respuesta al array de respuestas
                    console.log(response.data.data.url);
                    // Añadir la URL de la imagen al objeto de respuestas
                    formDataAnswers.answers.push({
                        "field_id": id,
                        "label": label,
                        "type": type,
                        "value": response.data.data.url
                    });
                    console.log(JSON.stringify(formDataAnswers.answers));
                } else {
                    // Manejar el caso en que la solicitud no fue exitosa
                    // console.log(response.status);
                    throw new Error('Error al cargar la imagen');
                }
            })
            .catch(error => {
                // Manejar errores
                console.error(error);
                // alert('Error al cargar la imagen');
            });
        }

        // Función para limpiar el canvas
        function clearCanvas() {
            const canvas = document.getElementById('signatureCanvas');
            const context = canvas.getContext('2d');
            // Limpiar el canvas
            context.clearRect(0, 0, canvas.width, canvas.height);
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Aquí va tu código JavaScript
            document.querySelector("button[type='submit']").addEventListener("click", function(event) {
                event.preventDefault();
                var formData = collectFormData();
                console.log(JSON.stringify(formData)); // Aquí puedes hacer lo que quieras con el objeto de datos

            });
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
