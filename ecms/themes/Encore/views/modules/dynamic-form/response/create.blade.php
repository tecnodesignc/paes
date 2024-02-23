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
                        <input type="text" name="identification" id="identification" value="{{$currentUser->driver->driver_license}}" class="form-control" readonly>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-6 col-sm-6">
                        <h5 class="text-truncate font-size-18 mb-1">Vehículo:</h5>
                        <select class="vehicleLabel" id="vehicleLabel"></select>
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




            // Verificar si company()->id está definido
            var companyId = {{ company()->id ? company()->id : 'null' }};
            if (companyId !== null) {
                // Llama a la API para obtener los datos
                var url = "{{ route('api.dynamicform.formresponse.vehicles', ['companyId' => ':companyId']) }}";
                url = url.replace(':companyId', companyId); // Reemplazar el marcador de posición con el companyId

                axios.get(url, {
                    headers: {
                        'Authorization': `Bearer {{$currentUser->getFirstApiKey()}}`,
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function(response) {
                    // Procesa los datos de respuesta aquí si es necesario
                    var data = response.data;
                    // Verifica si hay errores en la respuesta
                    if (data.errors) {
                        console.error('Error al obtener los datos:', data.errors);
                        return;
                    }

                    // Llena el select2 con los datos obtenidos
                    $('.vehicleLabel').select2({
                        width: '100%', // need to override the changed default
                        data: Object.keys(data).map(function(key) {
                            return { id: key, text: data[key] };
                        })
                    });

                })
                .catch(function(error) {
                    // Maneja los errores aquí
                    console.error('Error al obtener los datos:', error);
                });
            }

        });
    </script>

    <script type="application/javascript">

        document.addEventListener('DOMContentLoaded', (e) => {
            const canvases = document.querySelectorAll('.signatureCanvas');

            canvases.forEach(canvas => {
                const ctx = canvas.getContext('2d');
                let isDrawing = false;
                let lastX = null;
                let lastY = null;

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
                    const rect = canvas.getBoundingClientRect();
                    [lastX, lastY] = [e.touches[0].clientX - rect.left, e.touches[0].clientY - rect.top];
                });

                canvas.addEventListener('touchmove', draw);

                canvas.addEventListener('touchend', () => {
                    isDrawing = false;
                });

                // Prevenir el scroll en toda la página mientras se pinta en el canvas
                    document.addEventListener('touchmove', (e) => {
                if (e.target.classList.contains('signatureCanvas')) {
                    e.preventDefault();
                }
            }, { passive: false }); // especificar explícitamente que el evento no es pasivo
            });
        });


        // Función para limpiar el canvas
        function clearCanvas(fieldId) {
            const canvas = document.getElementById('signatureCanvas-'+fieldId);
            const context = canvas.getContext('2d');
            // Limpiar el canvas
            context.clearRect(0, 0, canvas.width, canvas.height);
        }

    </script>

    <script type="application/javascript">
        // LOGICA PARA LA CAMARA
        let imageIndex = 0;
        // Aqui definimos la cantidad de imagenes que se pueden tomar o cargar
        const maxImages = 1;

        // Función para cargar la imagen desde el archivo
        function uploadImage(fieldId, label, type) {
            const gallery = document.getElementById('gallery-' + fieldId);
            const imageIndex = gallery.querySelectorAll('.image-container').length;
            if (imageIndex < maxImages) {
                var input = document.createElement('input');
                input.type = 'file';
                input.accept = 'image/*';
                input.onchange = function(event) {
                    var file = event.target.files[0];
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        var img = new Image();
                        img.onload = function() {
                            const canvasId = 'canvas-' + fieldId;
                            var canvas = document.getElementById(canvasId);
                            var context = canvas.getContext('2d');
                            context.drawImage(img, 0, 0, canvas.width, canvas.height);
                            // Mostrar la previsualización de la imagen en la galería
                            displayImage(event.target.result, fieldId);

                            // Llamar a la función para subir el archivo al almacenamiento
                            uploadImageToServer(fieldId, label, type, canvasId);
                        };
                        img.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                };
                input.click();
            }else{
                alert('¡Ya has alcanzado el límite de imágenes!');
            }
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

        function captureImage(fieldId, label, type) {
            const video = document.getElementById('video-' + fieldId);
            var canvasId = 'canvas-' + fieldId;
            const canvas = document.getElementById(canvasId);
            const gallery = document.getElementById('gallery-' + fieldId);

            const imageIndex = gallery.querySelectorAll('.image-container').length;
            if (imageIndex < maxImages) {
                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                // Llamar a la función para subir el archivo al almacenamiento
                uploadImageToServer(fieldId, label, type, canvasId);
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
                        var selectedOptions = document.querySelectorAll("#btnselect-multiple-" + fieldId + " option:checked");
                        var selectedValues = [];
                        // Recorrer los elementos seleccionados y obtener sus valores
                        selectedOptions.forEach(function(option) {
                            selectedValues.push(option.value);
                        });
                        fieldValue = selectedValues;
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
                    "field_id": parseInt(fieldId),
                    "label": fieldLabel,
                    "type": parseInt(fieldType),
                    "value": fieldValue,
                    "comment": fieldComment && fieldComment.trim() !== '' ? fieldComment : undefined,
                    "image": fieldFoto && fieldFoto.trim() !== '' ? fieldFoto : undefined
                });

            });

            // Eliminar duplicados de respuestas
            formData.answers = eliminarDuplicados(formData.answers);

            return formData;
        }

        // Elimina los datos duplicados
        function eliminarDuplicados(respuestas) {
            var uniqueAnswers = [];
            var seenFieldIds = {};
            respuestas.forEach(function(answer) {
                if (!seenFieldIds.hasOwnProperty(answer.field_id)) {
                    uniqueAnswers.push(answer);
                    seenFieldIds[answer.field_id] = true;
                }
            });
            // Devolver respuestas únicas
            return uniqueAnswers;
        }

        var formImagesAnswers = {
                "answers": []
            };
        // Sube el archivo al almacenamiento
        function uploadImageToServer(id, label, type, canvasId = 'signatureCanvas') {
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

            var signatureFile = dataURLtoFile(imageData, 'img_'+formattedDate+'_'+id+'.png'); // Convertir imageData a un archivo

            var formData = new FormData();

            formData.append('file', signatureFile);
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
                    // Buscar si ya existe un registro con el mismo field_id
                    const existingIndex = formImagesAnswers.answers.findIndex(item => item.field_id === id);
                    if(type == 'image'){
                        if (existingIndex !== -1) {
                            // Si ya existe, actualizar el image
                            formImagesAnswers.answers[existingIndex].image = response.data.data.url;
                        } else {
                            // Si no existe, agregar un nuevo registro
                            formImagesAnswers.answers.push({
                                "field_id": id,
                                "image": response.data.data.url
                            });
                        }
                    } else {
                        if (existingIndex !== -1) {
                            // Si ya existe, actualizar el image
                            formImagesAnswers.answers[existingIndex].value = response.data.data.url;
                        } else {
                            // Añadir la firma
                            formImagesAnswers.answers.push({
                                "field_id": id,
                                "label": label,
                                "type": type,
                                "value": response.data.data.url
                            });
                        }
                    }
                    alert("Guardado correctamente!")
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

        //Evento submit que recopila la data obtenida del formulario, las imagenes capturadas y firma
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector("button[type='submit']").addEventListener("click", function(event) {
                event.preventDefault();
                var formData = collectFormData();
                //recorremos el formulario de respuestas
                formImagesAnswers.answers.forEach(function(imageAnswer) {
                    //validamos el id de la respuesta de la imagen existe contra los datos del form
                    const existingIndex = formData.answers.findIndex(item => item.field_id === imageAnswer.field_id);
                    //validamos si existe entonces actualice el formData con la imagen y sino cree el registro
                    if (existingIndex !== -1) {
                        formData.answers[existingIndex].image = imageAnswer.value;
                    }
                    else {
                        formData.answers.push({
                            field_id: parseInt(imageAnswer.field_id),
                            label: imageAnswer.label,
                            type: parseInt(imageAnswer.type),
                            value: imageAnswer.value,
                            image: imageAnswer.image
                        });
                    }
                });

                // Verificar si company()->id está definido
                var companyId = {{ company()->id ? company()->id : 'null' }};
                if (companyId === null) {
                    // Mostrar una alerta al usuario
                    alert("Debe seleccionar una empresa.");
                    return;
                }

                // Estructura de datos para enviar a la api
                var datos = {
                    form_id: {{$form->id}},
                    user_id: {{$currentUser->getUserId()}},
                    data: formData,
                    company_id: companyId
                };
                console.log(datos);
                var createUrl = "{{ route('api.dynamicform.formresponse.store') }}";
                axios.post(createUrl, datos, {
                    headers: {
                        'Authorization': `Bearer {{$currentUser->getFirstApiKey()}}`,
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    // Verificar si la solicitud fue exitosa
                    if (response.status === 200) {
                        // Redirigir al usuario a otra página
                        window.location.href = "{{ route('dynamicform.form.indexcolaboradoresform') }}";
                    } else {
                        // Manejar el caso en que la solicitud no fue exitosa
                        // console.log(response.status);
                        throw new Error('Error al cargar la imagen');
                    }
                }).catch(error => {
                    // Manejar errores
                    console.log('Error al cargar la data ' + error);
                });

            });// Fin del axios
        }); //fin del documentLoaded

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
