@if(isset($field->type))
    @switch($field->type)
    {{-- Input tipo si/no/no aplica --}}
        @case(5)
        <div class="row mt-3">
            <div class="col-lg-6 col-md-12">
                <h5 class="text-truncate font-size-18 mb-1">{{$field->label}}</h5>
                <div class="btn-group border border-primary" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="btnradio-{{$field->id}}" id="btnradio-{{$field->id}}-1" autocomplete="off"
                            {{$field->value === 1 ? 'checked' : ''}}>
                    <label class="btn btn-outline-dark  mb-0" for="btnradio-{{$field->id}}-1">Si</label>

                    <input type="radio" class="btn-check" name="btnradio-{{$field->id}}" id="btnradio-{{$field->id}}-2" autocomplete="off"
                            {{$field->value === 0 ? 'checked' : ''}}>
                    <label class="btn btn-outline-dark  mb-0" for="btnradio-{{$field->id}}-2">No</label>

                    <input type="radio" class="btn-check" name="btnradio-{{$field->id}}" id="btnradio-{{$field->id}}-3" autocomplete="off"
                            {{$field->value === 2 ? 'checked' : ''}}>
                    <label class="btn btn-outline-dark  mb-0" for="btnradio-{{$field->id}}-3">N/A</label>
                </div>
            </div>
            @if(isset($field->image))
            <div class="col-lg-3 col-md-12">
                    <a href="{{url($field->image)}}" class="thumb preview-thumb image-popup">
                        <div class="img-fluid">
                            <img src="{{url($field->image)}}" alt="" class="img-fluid d-block">
                        </div>
                    </a>
                </div>
                @endif
            <div class="col-lg-3 col-md-12">
                    <textarea class="form-control" id="btncomment-{{$field->id}}" name="btncomment-{{$field->id}}" rows="2" cols="50">{{$field->comment??''}}</textarea>
            </div>
        </div>
        
            @break

        {{-- Input tipo text --}}
        @case(0)
            <tr>
                <th scope="row">{{$field->label}}</th>
                <td>
                   <input type="text" name="btntext-{{$field->id}}" id="" class="form-control">
                </td>
            </tr>
            @break

        {{-- Input tipo Area de texto --}}        
        @case(1)
            <tr>
                <td>
                    <p>{{$field->label}}</p>
                    <textarea class="form-control" id="btntextarea-{{$field->id}}" name="btntextarea-{{$field->id}}" rows="5" cols="50">{{$field->value ?? ''}}</textarea>
                </td>
            </tr>
            @break


        {{-- Input tipo Numero--}}
        @case(2)
            <tr>
                <th scope="row">{{$field->label}}</th>
                <td>
                    <div>
                        <input type="number" name="btnnumber-{{$field->id}}" id="" class="form-control">
                    </div>
                </td>
            </tr>
            @break

        {{-- Input tipo Teléfono --}}
        @case(3)
            <tr>
                <th scope="row">{{$field->label}}</th>
                <td>
                    <div>
                        <input type="tel" name="btntel-{{$field->id}}" id="" class="form-control" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" size='10'>
                    </div>
                </td>
            </tr>
            @break

        {{-- Input tipo Email --}}
        @case(4)
            <tr>
                <th scope="row">{{$field->label}}</th>
                <td>
                    <div>
                        <input type="email" name="btnemail-{{$field->id}}" id="" class="form-control" pattern=".+@example\.com" size="30">
                    </div>
                </td>
            </tr>
            @break
        
        {{-- Input tipo Selector --}}
        @case(6)
            <tr>
                <th scope="row">{{$field->label}}</th>
                <td>
                    @php
                        $options = $field->selectable[0];
                        $options = explode(',', $options);
                    @endphp
                    <select class="form-select" name="btnselect-{{$field->id}}" style="width: 100%; height: 150px;" >
                        <option value="">--Seleccione--</option>
                        @foreach($options as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            @break



        {{-- Input tipo Selector Multiple --}}
        @case(7)
            <tr>
                <th scope="row">{{$field->label}}</th>
                   <td>
                   <select class="form-select-multiple" name="btnselect-multiple{{$field->id}}[]" style="width: 100%; height: 150px;" multiple>
                            @php
                                $options = $field->selectable[0];
                                $options = explode(',', $options);
                            @endphp
                                @foreach($options as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                    </select>
                </td>
            </tr>
            @break

        {{-- Input tipo Imagen--}}
        @case(8)
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <p>{{$field->label}}</p>
                            </div>
                            <div class="card-body">
                                <video id="video" width="240" height="240" autoplay></video>
                            </div>
                            <div class="card-footer">
                                <button id="captureButton" class="btn btn-primary"><i class="fas fa-camera"></i> Capturar imagen</button>
                                <button id="uploadButton" class="btn btn-info"><i class="far fa-images"></i> Cargar imagen</button>
                                <button id="switchCameraButton" class="btn btn-secondary"> <i class="mdi mdi-sync-circle"></i> Cambiar Cámara</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="gallery"></div>
                                <canvas id="canvas" width="240" height="240" style="display: none;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            @break

        {{-- Input tipo Firma --}}
        @case(9)
            <tr>
                {{-- <th scope="row">{{$field->label}}</th> --}}
                <td>
                    <div>
                        <p>{{$field->label}}</p>
                        <canvas id="signatureCanvas" class="border border-secondary" width="425px" height="150px" ></canvas>
                    </div>
                    <div class="d-flex gap-4">
                        <button class="btn btn-secondary" >Guardar</button>
                        <button class="btn btn-danger" onclick="document.getElementById('signatureCanvas').getContext('2d').clearRect(0, 0, document.getElementById('signatureCanvas').width, document.getElementById('signatureCanvas').height)">Cancelar</button>
                    </div>
                </td>
            </tr>
            @break

        {{-- Input tipo Opciones --}}
        @case(10)
            <tr>
                <th scope="row">{{$field->label}}</th>
                <td>
                    <div class="btn-group" role="group" aria-label="Opciones">
                        @foreach($field->selectable as $options)
                            @php
                                $options = explode(',', $options);
                            @endphp
                            @foreach($options as $option)
                                <input type="radio" id="option_{{ $field->id }}_{{ $option }}" name="option_{{ $field->id }}" value="{{ $option }}">
                                <label for="option_{{ $field->id }}_{{ $option }}" class="btn btn-secondary-outline">{{ $option }}</label>
                            @endforeach
                        @endforeach
                    </div>
                </td>
            </tr>
            @break

        {{-- Input tipo Estados --}}
        @case(11)
            <tr>
                <th scope="row">{{$field->label}}</th>
                <td>
                    <div class="btn-group border border-primary" role="group" aria-label="Opciones">
                        @foreach($field->selectable as $options)
                            @php
                                $options = explode(',', $options);
                            @endphp
                            @foreach($options as $option)
                                <input type="radio" id="option_{{ $field->id }}_{{ $option }}" name="option_{{ $field->id }}" value="{{ $option }}" class="btn-check">
                                <label class="btn btn-outline-dark mb-0" for="option_{{ $field->id }}_{{ $option }}" >{{ $option }}</label>
                                
                            @endforeach
                        @endforeach
                    </div>
                </td>
            </tr>
            @break
  
    @endswitch
@endif
