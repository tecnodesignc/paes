
@if(isset($field->type))
    @switch($field->type)
        {{-- Input tipo si/no/no aplica --}}
        {{-- @case(5)
            <div class="row mt-3">
                <div class="col-lg-6 col-md-12">
                    <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                    <div class="btn-group border border-primary" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" autocomplete="off"
                           disabled {{$field->value == 1 ? 'checked' : ''}}>
                        <label class="btn btn-outline-dark mb-0">Si</label>

                        <input type="radio" class="btn-check" autocomplete="off"
                            disabled {{$field->value == 0 ? 'checked' : ''}}>
                        <label class="btn {{$field->value == 0 ? 'btn-danger' : 'btn-outline-dark'}}  mb-0">No</label>

                        <input type="radio" class="btn-check" autocomplete="off"
                            disabled {{$field->value == 2 ? 'checked' : ''}}>
                        <label class="btn btn-outline-dark mb-0">N/A</label>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 text-center">
                    @if(isset($field->image))
                        <a href="{{url($field->image)}}" class="thumb preview-thumb image-popup">
                            <div class="img-fluid">
                                <img src="{{url($field->image)}}" alt="" class="img-fluid d-block" style="width: 210px; height: 70px;">
                            </div>
                        </a>
                    @endif
                </div>
                <div class="col-lg-3 col-md-12">
                    @if (isset($field->comment))
                        <textarea class="form-control" rows="2" cols="50", placeholder="Agregar un comentario" disabled>{{$field->comment??''}}</textarea>
                    @endif
                </div>
            </div>
            @break --}}

        {{-- Input tipo text --}}
        @case(0)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                    <input type="text" value="{{$field->value}}" class="form-control" disabled>
                </div>
            </div>
            @break

        {{-- Input tipo Area de texto --}}
        @case(1)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                    <textarea class="form-control" rows="5" cols="50" disabled>{{$field->value ?? ''}}</textarea>
                </div>
            </div>
            @break

        {{-- Input tipo Numero--}}
        @case(2)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                    <input type="number" class="form-control" value="{{$field->value}}" disabled>
                </div>
            </div>
            @break

        {{-- Input tipo Teléfono --}}
        @case(3)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                    <input type="tel"  value="{{$field->value}}" class="form-control" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" size='10' disabled>
                </div>
            </div>
            @break

        {{-- Input tipo Email --}}
        @case(4)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                    <input type="email" value="{{$field->value}}" class="form-control" pattern=".+@example\.com" size="30" disabled>
                </div>
            </div>
            @break

        {{-- Input tipo Selector --}}
        @case(6)
            <div class="row mt-3">
                <div class="col-lg-9 col-md-12">
                    <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                    <input type="text" value="{{$field->value}}" class="form-control" disabled>
                </div>
                <div class="col-lg-3 col-md-12">
                    @if (isset($field->comment))
                        <textarea class="form-control" rows="2" cols="50", placeholder="Agregar un comentario" disabled>{{$field->comment??''}}</textarea>
                    @endif
                </div>
            </div>
            @break

        {{-- Input tipo Selector Multiple --}}
        @case(7)
            <div class="row mt-3">
                <div class="col-lg-9 col-md-12">
                    <h5 class="font-size-18 mb-1">{{$field->label}}</h5>

                    @if(isset($field->value))
                        <div class="gap-1" role="group" aria-label="{{$field->label}}" disabled>
                            @foreach($field->value as $option)
                                <button type="button" class="btn btn-secondary disabled mt-1">{{$option}}</button>
                            @endforeach
                        </div>
                    @else
                        <input type="text" value="" class="form-control" disabled>

                    @endif
                </div>
                <div class="col-lg-3 col-md-12">
                    @if (isset($field->comment))
                        <textarea class="form-control" rows="2" cols="50", placeholder="Agregar un comentario" disabled>{{$field->comment??''}}</textarea>
                    @endif
                </div>
            </div>
            @break

        {{-- Input tipo Imagen--}}
        @case(8)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    @if(isset($field->value))
                        <h5 class="font-size-18 mb-1">{{$field->label}}</h5>

                        <a href="{{url($field->value)}}" class="thumb preview-thumb image-popup">
                            <img src="{{url($field->value)}}" alt="" class="img" width="240px" height="240px">
                        </a>
                    @endif
                </div>
            </div>
            @break

        {{-- Input tipo Firma --}}
        @case(9)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                    @if(isset($field->value))
                        <h5 class="font-size-18 mb-1">{{$field->label}}</h5>

                        <a href="{{url($field->value)}}" class="thumb preview-thumb image-popup">
                            <div class="img-fluid">
                                <img src="{{url($field->value)}}" alt="" class="img-fluid d-block" width="300px" height="200px">
                            </div>
                        </a>
                    @endif
                </div>
            </div>
            @break

        {{-- Input tipo Opciones --}}
        @case(5)
        @case(10)
        @case(11)
            <div class="row mt-3">
                <div class="col-lg-6 col-md-12">
                    <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                    <input type="text" value="{{$field->value ?? null}}" class="form-control {{isset($field->hallazgo) ? 'border border-danger' : 'border border-success'}}" disabled>
                </div>
                <div class="col-lg-3 col-md-12 text-center">
                    @if(isset($field->image))
                        <a href="{{url($field->image)}}" class="thumb preview-thumb image-popup">
                            <div class="img-fluid" >
                                <img src="{{url($field->image)}}" alt="" class="img-fluid d-block" style="width: 210px; height: 70px;">
                            </div>
                        </a>
                    @endif
                </div>
                <div class="col-lg-3 col-md-12">
                    @if (isset($field->comment))
                        <textarea class="form-control" rows="2" cols="50", placeholder="Agregar un comentario" disabled>{{$field->comment??''}}</textarea>
                    @endif
                </div>
            </div>
            @break

        {{-- Input tipo título --}}
        @case(12)
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12 text-center">
                    <hr>
                    <h2 class="mb-2">{{$field->label}}</h2>
                </div>
            </div>
            @break

        {{-- Input tipo párrafo --}}
        @case(13)
        <div class="row mt-3">
            <div class="col-lg-12 col-md-12 text-center">
                <p class="mb-2 ">{{$field->label}}</p>
            </div>
        </div>
        @break

    @endswitch
@endif
