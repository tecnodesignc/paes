
@if(isset($field->type))
    @switch($field->type)
        {{-- Input tipo Area de texto --}}
        @case(1)
            <div class="row mt-3">
                <div class="col-lg-6 col-md-12">
                    <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                    <textarea class="form-control" rows="5" cols="50" disabled>{{$field->value ?? ''}}</textarea>
                </div>
            </div>
            @break

        {{-- Input tipo Selector --}}
        @case(6)
            <div class="row mt-3">
                <div class="col-lg-6 col-md-12">
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
                <div class="col-lg-6 col-md-12">
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
                <div class="col-lg-6 col-md-12">
                    @if(isset($field->value))
                        <h5 class="font-size-18 mb-1">{{$field->label}}</h5>

                        <a href="{{url($field->value)}}" class="thumb preview-thumb image-popup">
                            <img src="{{url($field->value)}}" alt="" class="img" width="280px" height="280px">
                        </a>
                    @endif
                </div>
            </div>
            @break

        {{-- Input tipo Firma --}}
        @case(9)
            <div class="row mt-3">
                <div class="col-lg-6 col-md-12">
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
                    <input type="text" value="{{$field->value ?? null}}" class="form-control {{isset($field->finding) ? 'border border-danger' : 'border border-success'}}" disabled>
                </div>
                <div class="col-lg-3 col-md-12 text-center d-lg-flex justify-content-center align-items-center">
                    @if(isset($field->image))
                        <a href="{{url($field->image)}}" class="thumb preview-thumb image-popup">
                            <div class="img-fluid" >
                                <img src="{{url($field->image)}}" alt="" class="img-fluid d-block" style="width: 250px; height: 150px;">
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
            <div class="row mt-2 mb-1">
                <div class="col-lg-12 col-md-12 text-center">
                    <hr>
                    <h2 class="mb-2" >{{$field->label}}</h2>
                </div>
            </div>
            @break

        {{-- Input tipo párrafo --}}
        @case(13)
            <div class="row mt-1 mb-1">
                <div class="col-lg-12 col-md-12 text">
                    <p class="mb-2 font-size-18">{{$field->label}}</p>
                </div>
            </div>
            @break

        {{-- Other fields  --}}
        @default
            <div class="row mt-3">
                <div class="col-lg-6 col-md-12">
                    <h5 class="font-size-18 mb-1">{{$field->label}}</h5>
                    <input type="text" value="{{$field->value??null}}" class="form-control border border-secondary" disabled>
                </div>
            </div>
            @break

    @endswitch
@endif
