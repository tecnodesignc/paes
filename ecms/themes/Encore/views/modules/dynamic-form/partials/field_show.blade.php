@if(isset($field->type))
    @switch($field->type)
    {{-- Input tipo si/no/no aplica --}}
        @case(5)
            <tr>
                <th scope="row"><h5 class="text-truncate font-size-14 mb-1">{{$field->label}}</h5></th>
                <td>
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="btnradio-{{$field->fiel_id}}" id="btnradio4" autocomplete="off"
                               disabled {{$field->value ===1?'checked':""}}>
                        <label class="btn btn-outline-dark" for="btnradio4">Si</label>

                        <input type="radio" class="btn-check" name="btnradio-{{$field->fiel_id}}" id="btnradio5" autocomplete="off"
                               disabled {{$field->value ===0?'checked':""}}>
                        <label class="btn btn-outline-dark" for="btnradio5">No</label>

                        <input type="radio" class="btn-check" name="btnradio-{{$field->fiel_id}}" id="btnradio6" autocomplete="off"
                               disabled {{$field->value ===2?'checked':""}}>
                        <label class="btn btn-outline-dark" for="btnradio6">N/A</label>
                    </div>

                </td>
                <td>
                    @if(isset($field->image))
                        <a href="{{url($field->image)}}" class="thumb preview-thumb image-popup">
                            <div class="img-fluid">
                                <img src="{{url($field->image)}}" alt="" class="img-fluid d-block">
                            </div>
                        </a>
                    @endif
                </td>
                <td>
                    {{$field->comment??''}}
                </td>
            </tr>
            @break

        {{-- Input tipo text --}}
        @case(0)
            <tr>
                <th scope="row">{{$field->label}}</th>
                <td>
                    <div>
                        <p class="text-muted mb-0">{{$field->value}}</p>
                    </div>
                </td>
            </tr>
            @break

        {{-- Input tipo Area de texto --}}        
        @case(1)
            <tr>
                <th scope="row">{{$field->label}}</th>
                <td>
                    <div>
                        <p class="text-muted mb-0">{{$field->value}}</p>
                    </div>
                </td>
            </tr>
            @break

        {{-- Input tipo Numero--}}
        @case(2)
            <tr>
                <th scope="row">{{$field->label}}</th>
                <td>
                    <div>
                        <p class="text-muted mb-0">{{$field->value}}</p>
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
                        <p class="text-muted mb-0">{{$field->value}}</p>
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
                        <p class="text-muted mb-0">{{$field->value}}</p>
                    </div>
                </td>
            </tr>
            @break
        
        {{-- Input tipo Selector --}}
        @case(6)
            <tr>
                <th scope="row">{{$field->label}}</th>
                <td>
                    <div>
                        <p class="text-muted mb-0">{{$field->value}}</p>
                    </div>
                </td>
            </tr>
            @break

        {{-- Input tipo Selector Multiple --}}
        @case(7)
            <tr>
                <th scope="row">{{$field->label}}</th>
                <td>
                    <div>
                        <p class="text-muted mb-0">{{$field->value}}</p>
                    </div>
                </td>
            </tr>
            @break

        {{-- Input tipo Imagen--}}
        @case(8)
            <tr>
                <th scope="row">{{$field->label}}</th>
                <td>
                    <div>
                        <p class="text-muted mb-0">{{$field->value}}</p>
                    </div>
                </td>
            </tr>
            @break

        {{-- Input tipo Firma --}}
        @case(9)
            <tr>
                {{-- <th scope="row">{{$field->label}}</th> --}}
                <td><p>{{$field->label}}</p>
                    <div>
                        <canvas id="signatureCanvas" class="border border-secondary" width="300" height="200" ></canvas>
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
                    <div>
                        <p class="text-muted mb-0">{{$field->value}}</p>
                    </div>
                </td>
            </tr>
            @break

        {{-- Input tipo Estados --}}
        @case(11)
            <tr>
                <th scope="row">{{$field->label}}</th>
                <td>
                    <div>

                        {!! Form::select('select',$field['selectable'],null) !!}
                        <select class="form-select" name="selectable[]">
                            @foreach($field->selectable as $option)
                                <option value="{{$option}}">{{$option}}</option>
                            @endforeach
                        </select>
                    </div>
                </td>
            </tr>
        @break
    
        
    @endswitch
@endif
