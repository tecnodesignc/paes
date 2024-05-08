@if(isset($field->type))
    @switch($field->type)
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
        @case(1)
            <tr>
                {{-- hola {{$field->type}} --}}
                <th scope="row">{{$field->label}}</th>
                <td>
                    <div>
                        <p class="text-muted mb-0">{{$field->value}}</p>
                    </div>
                </td>
            </tr>
            @break
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
    @endswitch
@endif
