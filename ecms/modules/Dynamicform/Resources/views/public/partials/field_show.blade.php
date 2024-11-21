@if(isset($field->type))
    @switch($field->type)

        {{-- Input tipo text --}}
        @case(0)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                    <input type="text" name="btntext-{{$field->id}}" id="btntext-{{$field->id}}" class="form-control dynamic-field"  data-field-type="{{$field->type}}" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}" {{$field->required == 1 ? 'required' : ''}}>
                </div>
            </div>
            @break

        {{-- Input tipo Area de texto --}}
        @case(1)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                    <textarea class="form-control dynamic-field" id="btntextarea-{{$field->id}}" name="btntextarea-{{$field->id}}" rows="5" cols="50"
                        data-field-type="{{$field->type}}" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}" {{$field->required == 1 ? 'required' : ''}}
                    >{{$field->value ?? ''}}</textarea>
                </div>
            </div>
            @break

        {{-- Input tipo Numero--}}
        @case(2)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                    <input type="number" step="any" name="btnnumber-{{$field->id}}" id="btnnumber-{{$field->id}}" class="form-control dynamic-field" data-field-type="2" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}" {{$field->required == 1 ? 'required' : ''}}>
                </div>
            </div>
            @break

        {{-- Input tipo Teléfono --}}
        @case(3)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                    <input type="tel" name="btntel-{{$field->id}}" id="btntel-{{$field->id}}" class="form-control dynamic-field" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" size='10' data-field-type="3" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}" {{$field->required == 1 ? 'required' : ''}}>
                </div>
            </div>
            @break

        {{-- Input tipo Email --}}
        @case(4)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                    <input type="email" name="btnemail-{{$field->id}}" id="btnemail-{{$field->id}}" class="form-control dynamic-field" pattern=".+@example\.com" size="30" data-field-type="4" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}" {{$field->required == 1 ? 'required' : ''}}>
                </div>
            </div>
            @break

        {{-- Input tipo Selector --}}
        @case(6)
            <div class="row mt-3">
                <div class="col-lg-7 col-md-12">
                    <h5 class="font-size-18 mb-1">{{$field->label}}</h5>

                    <select class="form-select dynamic-field" name="btnselect-{{$field->id}}" id="btnselect-{{$field->id}}" style="width: 100%;" data-field-type="6" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}" data-field-finding="{{$field->finding}}" {{$field->required == 1 ? 'required' : ''}}>
                        @if(empty($field->selectable[0]))
                            <option disabled>No hay opciones disponibles</option>
                        @else
                            @php
                                $options = explode(',', $field->selectable[0]);
                            @endphp
                            <option value="">--Seleccione--</option>
                            @foreach($options as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-lg-2 col-md-12">
                    @if(isset($field->image))
                        <a href="{{url($field->image)}}" class="thumb preview-thumb image-popup">
                            <div class="img-fluid">
                                <img src="{{url($field->image)}}" alt=""  width="960px" height="940px" class="img-fluid d-block">
                            </div>
                        </a>
                    @endif
                </div>
                <div class="col-lg-3 col-md-12">
                    <textarea class="form-control" id="btncomment-{{$field->id}}" name="btncomment-{{$field->id}}" rows="2" cols="50", placeholder="Agregar un comentario"></textarea>
                </div>
            </div>
            @break

        {{-- Input tipo Selector Multiple --}}
        @case(7)
            <div class="row mt-3">
                <div class="col-lg-7 col-md-12">
                    <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                    <select class="form-select-multiple dynamic-field" name="btnselect-multiple-{{$field->id}}[]" id="btnselect-multiple-{{$field->id}}" style="width: 100%; height: 150px;" multiple="multiple" data-field-type="7" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}" data-field-finding="{{$field->finding}}" {{$field->required == 1 ? 'required' : ''}}>
                        @if(empty($field->selectable[0]))
                            <option disabled>No hay opciones disponibles</option>
                        @else
                            @php
                                $options = explode(',', $field->selectable[0]);
                            @endphp
                                @foreach($options as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-lg-2 col-md-12">
                    @if(isset($field->image))
                        <a href="{{url($field->image)}}" class="thumb preview-thumb image-popup">
                            <div class="img-fluid">
                                <img src="{{url($field->image)}}" alt="" width="960px" height="940px" class="img-fluid d-block">
                            </div>
                        </a>
                    @endif
                </div>
                <div class="col-lg-3 col-md-12">
                    <textarea class="form-control" id="btncomment-{{$field->id}}" name="btncomment-{{$field->id}}" rows="2" cols="50", placeholder="Agregar un comentario">{{$field->comment??''}}</textarea>
                </div>
            </div>
            @break

        {{-- Input tipo Imagen--}}
        @case(8)
            <div class="row mt-3">
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="d-flex justify-content-between">
                            <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                            <a class="waves-effect text-danger m-3 mt-1" onclick="cancelCamera('{{$field->id}}')">Cerrar camara</a>
                        </div>

                        <video id="video-{{$field->id}}" class="form-control" width="250" height="250" autoplay></video>
                        <div class="card-footer">
                            <button type="button" id="captureButton-{{$field->id}}" class="btn btn-primary" onclick="captureImage({{$field->id}}, '{{$field->label}}', {{$field->type}})"><i class="fas fa-camera"></i> Capturar imagen</button>
                            <button type="button" id="uploadButton-{{$field->id}}" class="btn btn-info" onclick="uploadImage({{$field->id}}, '{{$field->label}}', {{$field->type}})"><i class="far fa-images"></i> Cargar imagen</button>
                            <button type="button" id="switchCameraButton-{{$field->id}}" class="btn btn-secondary" onclick="switchCamera({{$field->id}})"> <i class="mdi mdi-sync-circle"></i> Cambiar Cámara</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="canvas-{{$field->id}}" width="480px" height="720px" style="display: none;"></canvas>
                            <div id="gallery-{{$field->id}}"></div>
                        </div>
                    </div>
                </div>
            </div>
            @break

        {{-- Input tipo Firma --}}
        @case(9)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    <div>
                        <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                        <canvas id="signatureCanvas-{{$field->id}}" style="background-color: azure" width="300px" height="200px" class="border border-secondary signatureCanvas"></canvas>
                    </div>
                    <div class="d-flex gap-4">
                        <button type="button" class="btn btn-primary" onclick="uploadImageToServer({{ intval($field->id) }}, '{{$field->label}}', {{$field->type}}, 'signatureCanvas-{{$field->id}}')">Guardar</button>
                        <button type="button" class="btn btn-danger" onclick="clearCanvas({{ intval($field->id) }})">Cancelar</button>
                    </div>
                </div>
            </div>
            <input type="hidden" id="signatureCanvas-{{$field->id}}" name="signatureCanvas-{{$field->id}}" value="" {{$field->required == 1 ? 'required' : ''}}>
            @break



        {{-- Input tipo Opciones --}}
        @case(5)
        @case(10)
        @case(11)
            <div class="row mt-3">
                <div class="col-lg-7 col-md-12">
                    <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                    <div class="btn-group border border-primary d-flex flex-wrap" role="group" aria-label="Opciones">
                        @if(isset($field->selectable) && !empty($field->selectable))
                            @foreach($field->selectable as $options)
                                @php
                                    $options = explode(',', $options);
                                @endphp
                                @foreach($options as $option)
                                    <input type="radio" class="btn-check dynamic-field" id="option_{{ $field->id }}_{{ $option }}" name="option_{{ $field->id }}" value="{{ $option }}" data-field-type="{{$field->type}}" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}" data-field-finding="{{$field->finding}}" {{$field->required == 1 ? 'required' : ''}}>
                                    <label for="option_{{ $field->id }}_{{ $option }}" class="btn btn-outline-dark mb-0">{{ $option }}</label>
                                @endforeach
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-lg-2 col-md-12 text-lg-center">
                    @if(isset($field->image))
                        <a href="{{url($field->image)}}" class="thumb preview-thumb image-popup">
                            <div class="img-fluid">
                                <img src="{{url($field->image)}}" alt="" class="img-fluid d-block">
                            </div>
                        </a>
                    @else
                    <button type="button" class="btn btn-primary mt-lg-4" data-bs-toggle="modal" data-bs-target="#myModal-{{$field->id}}"><i class="fas fa-camera"></i></button>

                    <!-- Modal para tomar la foto -->
                    <div id="myModal-{{$field->id}}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <h3 class="m-3">Subir imagen</h3>
                                <div class="card m-3">
                                    <div class="card-header bg-primary text-white d-flex justify-content-between">
                                        <div>
                                            <p>Subir imagen</p>
                                        </div>
                                        <button type="button" id="captureButton-{{$field->id}}" class="btn btn-primary" onclick="captureImage('{{$field->id}}')"><i class="fas fa-camera"></i></button>
                                        <button type="button" id="uploadButton-{{$field->id}}" class="btn btn-info" onclick="uploadImage('{{$field->id}}')"><i class="fas fa-plus"></i></button>
                                        <button type="button" id="switchCameraButton-{{$field->id}}" class="btn btn-secondary" onclick="switchCamera('{{$field->id}}')"> <i class="mdi mdi-sync-circle"></i></button>

                                    </div>
                                    <div class="card-body">
                                        <video id="video-{{$field->id}}"  width="250px" height="250px" autoplay></video>
                                        <canvas id="canvas-{{$field->id}}"  width="960px" height="940px" style="display: none;"></canvas>
                                        <div id="gallery-{{$field->id}}"></div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <p class="waves-effect text-primary m-3 mt-1" data-bs-dismiss="modal" data-bs-target="#myModal-{{$field->id}}" onclick="cancelCamera('{{$field->id}}')">Cerrar camara</p>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-lg-3 col-md-12">
                    <textarea class="form-control mt-1" id="btncomment-{{$field->id}}" name="btncomment-{{$field->id}}" rows="2" cols="50", placeholder="Agregar un comentario">{{$field->comment??''}}</textarea>
                </div>
            </div>
            @break

        {{-- Input type title --}}
        @case(12)
            <div class="row mt-2">
                <div class="col-lg-12 col-md-12 text-center">
                    <hr>
                    <h2 class="mb-2 dynamic-field" id="h2-{{$field->id}}" data-field-type="{{$field->type}}" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}" >{{$field->label}}</h2>
                </div>
            </div>
            @break

        {{-- Input tipo párrafo --}}
        @case(13)
        <div class="row mt-2">
            <div class="col-lg-12 col-md-12 text">
                <p class="mb-2 dynamic-field font-size-18" id="p-{{$field->id}}" data-field-type="{{$field->type}}" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}" >{{$field->label}}</p>
            </div>
        </div>
        @break

        {{-- Input tipo date --}}
        @case(14)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                    <input type="date" name="btndate-{{$field->id}}" id="btndate-{{$field->id}}" class="form-control dynamic-field"  data-field-type="{{$field->type}}" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}" value="{{date('Y-m-d')??null}}" {{$field->required == 1 ? 'required' : ''}}>
                </div>
            </div>
            @break

        {{-- Input tipo time --}}
        @case(15)
        <div class="row mt-3">
            <div class="col-lg-12 col-md-12">
                <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                <input type="time" name="btntime-{{$field->id}}" id="btntime-{{$field->id}}" class="form-control dynamic-field"  data-field-type="{{$field->type}}" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}" value="{{ date('H:i') ?? null }}" {{$field->required == 1 ? 'required' : ''}}>
            </div>
        </div>
        @break

    @endswitch
@endif
