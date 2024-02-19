@if(isset($field->type))
    @switch($field->type)
        {{-- Input tipo si/no/no aplica --}}
        @case(5)
            <div class="row mt-3">
                <div class="col-lg-6 col-md-12">
                    <h5 class="text-truncate font-size-18 mb-1">{{$field->label}}</h5>
                    <div class="btn-group border border-primary" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check dynamic-field" name="btnradio-{{$field->id}}" id="btnradio-{{$field->id}}-1" autocomplete="off" value="1" data-field-type="5" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}"
                                {{$field->value === 1 ? 'checked' : ''}}>
                        <label class="btn btn-outline-dark mb-0" for="btnradio-{{$field->id}}-1">Si</label>

                        <input type="radio" class="btn-check dynamic-field" name="btnradio-{{$field->id}}" id="btnradio-{{$field->id}}-2" autocomplete="off" value="0" data-field-type="5" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}"
                                {{$field->value === 0 ? 'checked' : ''}}>
                        <label class="btn btn-outline-dark mb-0" for="btnradio-{{$field->id}}-2">No</label>

                        <input type="radio" class="btn-check dynamic-field" name="btnradio-{{$field->id}}" id="btnradio-{{$field->id}}-3" autocomplete="off" value="2" data-field-type="5" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}"
                                {{$field->value === 2 ? 'checked' : ''}}>
                        <label class="btn btn-outline-dark mb-0" for="btnradio-{{$field->id}}-3">N/A</label>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 text-center">
                    @if(isset($field->image))
                        <a href="{{url($field->image)}}" class="thumb preview-thumb image-popup">
                            <div class="img-fluid">
                                <img src="{{url($field->image)}}" alt="" class="img-fluid d-block">
                            </div>
                        </a>
                    @else
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal-{{$field->id}}"><i class="fas fa-camera"></i></button>

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
                                        <video id="video-{{$field->id}}" width="240" height="240" autoplay></video>
                                        <canvas id="canvas-{{$field->id}}" width="240" height="240" style="display: none;"></canvas>
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
                    <textarea class="form-control" id="btncomment-{{$field->id}}" name="btncomment-{{$field->id}}" rows="2" cols="50", placeholder="Agregar un comentario">{{$field->comment??''}}</textarea>
                </div>
            </div>
            @break

        {{-- Input tipo text --}}
        @case(0)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    <h5 class="text-truncate font-size-18 mb-1">{{$field->label}}</h5>
                    <input type="text" name="btntext-{{$field->id}}" id="btntext-{{$field->id}}" class="form-control dynamic-field"  data-field-type="{{$field->type}}" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}">
                </div>
            </div>
            @break

        {{-- Input tipo Area de texto --}}
        @case(1)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    <h5 class="text-truncate font-size-18 mb-1">{{$field->label}}</h5>
                    <textarea class="form-control dynamic-field" id="btntextarea-{{$field->id}}" name="btntextarea-{{$field->id}}" rows="5" cols="50"
                        data-field-type="{{$field->type}}" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}"
                    >{{$field->value ?? ''}}</textarea>
                </div>
            </div>

            @break


        {{-- Input tipo Numero--}}
        @case(2)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    <h5 class="text-truncate font-size-18 mb-1">{{$field->label}}</h5>
                    <input type="number" name="btnnumber-{{$field->id}}" id="btnnumber-{{$field->id}}" class="form-control dynamic-field" data-field-type="2" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}">
                </div>
            </div>
            @break

        {{-- Input tipo Teléfono --}}
        @case(3)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    <h5 class="text-truncate font-size-18 mb-1">{{$field->label}}</h5>
                    <input type="tel" name="btntel-{{$field->id}}" id="btntel-{{$field->id}}" class="form-control dynamic-field" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" size='10' data-field-type="3" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}">
                </div>
            </div>
            @break

        {{-- Input tipo Email --}}
        @case(4)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    <h5 class="text-truncate font-size-18 mb-1">{{$field->label}}</h5>
                    <input type="email" name="btnemail-{{$field->id}}" id="btnemail-{{$field->id}}" class="form-control dynamic-field" pattern=".+@example\.com" size="30" data-field-type="4" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}">
                </div>
            </div>
            @break

        {{-- Input tipo Selector --}}
        @case(6)
            <div class="row mt-3">
                <div class="col-lg-6 col-md-12">
                    <h5 class="text-truncate font-size-18 mb-1">{{$field->label}}</h5>
                    @php
                        $options = $field->selectable[0];
                        $options = explode(',', $options);
                    @endphp
                    <select class="form-select dynamic-field" name="btnselect-{{$field->id}}" id="btnselect-{{$field->id}}" style="width: 100%;" data-field-type="6" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}" >
                        <option value="">--Seleccione--</option>
                        @foreach($options as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-12">
                    @if(isset($field->image))
                        <a href="{{url($field->image)}}" class="thumb preview-thumb image-popup">
                            <div class="img-fluid">
                                <img src="{{url($field->image)}}" alt="" class="img-fluid d-block">
                            </div>
                        </a>
                    @endif
                </div>
                <div class="col-lg-3 col-md-12">
                    <textarea class="form-control" id="btncomment-{{$field->id}}" name="btncomment-{{$field->id}}" rows="2" cols="50", placeholder="Agregar un comentario">{{$field->comment??''}}</textarea>
                </div>
            </div>
            @break

        {{-- Input tipo Selector Multiple --}}
        @case(7)
            <div class="row mt-3">
                <div class="col-lg-6 col-md-12">
                    <h5 class="text-truncate font-size-18 mb-1">{{$field->label}}</h5>
                    <select class="form-select-multiple dynamic-field" name="btnselect-multiple-{{$field->id}}[]" id="btnselect-multiple-{{$field->id}}" style="width: 100%; height: 150px;" multiple="multiple" data-field-type="7" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}">
                        @php
                            $options = $field->selectable[0];
                            $options = explode(',', $options);
                        @endphp
                            @foreach($options as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-12">
                    @if(isset($field->image))
                        <a href="{{url($field->image)}}" class="thumb preview-thumb image-popup">
                            <div class="img-fluid">
                                <img src="{{url($field->image)}}" alt="" class="img-fluid d-block">
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
                            <h5 class="text-truncate font-size-18 mb-1">{{$field->label}}</h5>
                            <a class="waves-effect text-danger m-3 mt-1" onclick="cancelCamera('{{$field->id}}')">Cerrar camara</a>
                        </div>

                        <video id="video-{{$field->id}}" width="240" height="240" autoplay></video>
                        <div class="card-footer">
                            <button type="button" id="captureButton-{{$field->id}}" class="btn btn-primary" onclick="captureImage('{{$field->id}}')"><i class="fas fa-camera"></i> Capturar imagen</button>
                            <button type="button" id="uploadButton-{{$field->id}}" class="btn btn-info" onclick="uploadImage('{{$field->id}}')"><i class="far fa-images"></i> Cargar imagen</button>
                            <button type="button" id="switchCameraButton-{{$field->id}}" class="btn btn-secondary" onclick="switchCamera('{{$field->id}}')"> <i class="mdi mdi-sync-circle"></i> Cambiar Cámara</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="canvas-{{$field->id}}" width="240" height="240" style="display: none;"></canvas>
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
                        <h5 class="text-truncate font-size-18 mb-1">{{$field->label}}</h5>
                        <canvas id="signatureCanvas" class="border border-secondary" width="300px" height="200px"></canvas>
                    </div>
                    <div class="d-flex gap-4">
                        <button type="button" class="btn btn-secondary" onclick="uploadImageToServer({{ intval($field->id) }}, '{{$field->label}}', {{$field->type}})">Guardar</button>
                        <button type="button" class="btn btn-danger" onclick="clearCanvas({{ intval($field->id) }})">Cancelar</button>
                    </div>
                </div>
            </div>
            @break

        {{-- Input tipo Opciones --}}
        @case(10)
        @case(11)
            <div class="row mt-3">
                <div class="col-lg-6 col-md-12">
                    <h5 class="text-truncate font-size-18 mb-1">{{$field->label}}</h5>
                    <div class="btn-group border border-primary d-flex flex-wrap" role="group" aria-label="Opciones">
                        @foreach($field->selectable as $options)
                            @php
                                $options = explode(',', $options);
                            @endphp
                            @foreach($options as $option)
                                <input type="radio" class="btn-check dynamic-field" id="option_{{ $field->id }}_{{ $option }}" name="option_{{ $field->id }}" value="{{ $option }}" data-field-type="{{$field->type}}" data-field-id="{{$field->id}}" data-field-label="{{$field->label}}">
                                <label for="option_{{ $field->id }}_{{ $option }}" class="btn btn-outline-dark mb-0">{{ $option }}</label>
                            @endforeach
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 text-center">
                    @if(isset($field->image))
                        <a href="{{url($field->image)}}" class="thumb preview-thumb image-popup">
                            <div class="img-fluid">
                                <img src="{{url($field->image)}}" alt="" class="img-fluid d-block">
                            </div>
                        </a>
                    @else
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal-{{$field->id}}"><i class="fas fa-camera"></i></button>

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
                                        <video id="video-{{$field->id}}" width="240" height="240" autoplay></video>
                                        <canvas id="canvas-{{$field->id}}" width="240" height="240" style="display: none;"></canvas>
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
                    <textarea class="form-control" id="btncomment-{{$field->id}}" name="btncomment-{{$field->id}}" rows="2" cols="50", placeholder="Agregar un comentario">{{$field->comment??''}}</textarea>
                </div>
            </div>
            @break

        {{-- Input tipo text --}}
        @case(12)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12 text-center">
                    <hr>
                    <h2 class="mb-2">{{$field->label}}</h2>
                </div>
            </div>
            @break


    @endswitch
@endif
