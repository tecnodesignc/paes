@if(isset($fiel->type))
    @switch($fiel->type)
        @case(5)
            <tr>
                <th scope="row"><h5 class="text-truncate font-size-14 mb-1">{{$fiel->label}}</h5></th>
                <td>
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="btnradio-{{$fiel->fiel_id}}" id="btnradio4" autocomplete="off"
                               disabled {{$fiel->value ===1?'checked':""}}>
                        <label class="btn btn-outline-secondary" for="btnradio4">Si</label>

                        <input type="radio" class="btn-check" name="btnradio-{{$fiel->fiel_id}}" id="btnradio5" autocomplete="off"
                               disabled {{$fiel->value ===0?'checked':""}}>
                        <label class="btn btn-outline-secondary" for="btnradio5">No</label>

                        <input type="radio" class="btn-check" name="btnradio-{{$fiel->fiel_id}}" id="btnradio6" autocomplete="off"
                               disabled {{$fiel->value ===2?'checked':""}}>
                        <label class="btn btn-outline-secondary" for="btnradio6">N/A</label>
                    </div>

                </td>
                <td>
                    @if(isset($fiel->image))
                        <a href="{{url($fiel->image)}}" class="thumb preview-thumb image-popup">
                            <div class="img-fluid">
                                <img src="{{url($fiel->image)}}" alt="" class="img-fluid d-block">
                            </div>
                        </a>
                    @endif
                </td>
                <td>
                    {{$fiel->comment??''}}
                </td>
            </tr>
            @break
        @case(1)
            <tr>
                hola {{$fiel->type}}
                <th scope="row">{{$fiel->label}}</th>
                <td>
                    <div>
                        <p class="text-muted mb-0">{{$fiel->value}}</p>
                    </div>
                </td>
            </tr>
            @break
        @case(2)
            <tr>
                <th scope="row">{{$fiel->label}}</th>
                <td>
                    <div>
                        <p class="text-muted mb-0">{{$fiel->value}}</p>
                    </div>
                </td>
            </tr>
            @break
        @case(3)
            <tr>
                <th scope="row">{{$fiel->label}}</th>
                <td>
                    <div>
                        <p class="text-muted mb-0">{{$fiel->value}}</p>
                    </div>
                </td>
            </tr>
            @break
        @case(4)
            <tr>
                <th scope="row">{{$fiel->label}}</th>
                <td>
                    <div>
                        <p class="text-muted mb-0">{{$fiel->value}}</p>
                    </div>
                </td>
            </tr>
            @break
    @endswitch
@endif
