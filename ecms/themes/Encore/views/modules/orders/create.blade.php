@extends('layouts.master')
@section('title') Crear Envíos @endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Envíos @endslot
        @slot('title') Crear Envíos @endslot
    @endcomponent
    {!! Form::open(['route' => ['orders.order.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-lg-12">
            <div id="addproduct-accordion" class="custom-accordion">
                <div class="card">
                    <a href="#addproduct-productinfo-collapse" class="text-dark" data-bs-toggle="collapse" aria-expanded="true" aria-controls="addproduct-productinfo-collapse">
                        <div class="p-4">

                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm">
                                        <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                            01
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="font-size-16 mb-1">Crear Orden</h5>
                                    <p class="text-muted text-truncate mb-0">Complete toda la información a continuación</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                </div>

                            </div>

                        </div>
                    </a>

                    <div id="addproduct-productinfo-collapse" class="collapse show" data-bs-parent="#addproduct-accordion">
                        <div class="p-4 border-top">
                                <div class="row">
                                    <div class="col-lg-4">

                                        <div class="mb-3">
                                            <label class="form-label" for="guia">Guia</label>
                                            {!! Form::text('shipping_guide', old('shipping_guide'), ['class' => 'form-control', 'placeholder' => 'Agrega Guia']) !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-4">

                                        <div class="mb-3">
                                            <label for="choices-single-default" class="form-label">Dispositivos</label>
                                            <select class="form-control" data-trigger name="device_id"
                                                    id="device_id">
                                                <option value="">Selecione Dispositivo</option>
                                                @foreach($devices as $device)
                                                    <option value="{{$device->id}}"  >{{$device->imei}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="logistics">Empresa de Envio</label>
                                            <input id="logistics" name="logistics" placeholder="Escribe empresa de envio" type="text" class="form-control">

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="card-title"><h6 class="font-size-16 mb-1">Información de recogida</h6></div>
                                                <div class="mb-3">
                                                    <input name="pickup_id" type="hidden" class="form-control" value="{{$currentUser->sede->id}}">
                                                    <label class="form-label" for="logistics">Lugar de Recogida</label>
                                                    <input type="text" class="form-control" value="{{$currentUser->sede->name}}" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="contact_name">Contacto</label>
                                                    <input type="text" class="form-control" value="{{$currentUser->sede->contact}}" disabled>
                                                 </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="contact_phone">Numero de contacto</label>
                                                    <input type="text" class="form-control" value="{{$currentUser->sede->phone}}" disabled>
                                                   </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="pickup_notes">Descripción del Producto</label>
                                                    {!! Form::textarea('pickup_notes', old('pickup_notes'), ['class' => 'form-control', 'placeholder' => 'Notas de Producto']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="card-title"><h6 class="font-size-16 mb-1">Información de Entrega</h6></div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="shipping-location">Lugar de Entrega</label>
                                                    <select class="form-control" data-trigger name="shipping_id"
                                                            id="shipping_id" onchange="selectSede()" >
                                                        <option value="">Selecione Sede de Entrega</option>
                                                        @foreach($sedes as $sede)
                                                            <option value="{{$sede->id}}">{{$sede->name}}</option>
                                                        @endforeach
                                                    </select>
                                                   </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="shipping-contact">Contacto</label>
                                                    <input type="text" class="form-control" id="shipping-contact" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="shipping-phone">Numero de contacto</label>
                                                    <input type="text" class="form-control" id="shipping-phone" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <a href="#addproduct-alert-collapse" class="text-dark collapsed" data-bs-toggle="collapse" aria-haspopup="true" aria-expanded="false" aria-haspopup="true" aria-controls="addproduct-alert-collapse">
                        <div class="p-4">

                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm">
                                        <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                            02
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="font-size-16 mb-1">Alertas de envío</h5>
                                    <p class="text-muted text-truncate mb-0">Activar rango para alertas de temperatura</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                </div>

                            </div>

                        </div>
                    </a>

                    <div id="addproduct-alert-collapse" class="collapse" data-bs-parent="#addproduct-accordion">
                        <div class="p-4 border-top">
                            <div class="mb-3 row">
                                <label class="form-label col-md-2" for="logistics.twotoeight" style="margin-bottom: 0.5rem">2.0 grados / 8.0 grados</label>
                                <div class="col-md-10">
                                <input type="checkbox" id="alert-twotoeight" name="alerts[twotoeight]" switch="none" checked />
                                <label for="alert-twotoeight" data-on-label="On" data-off-label="Off"></label>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="form-label col-md-2" for="fivetotwenty" style="margin-bottom: 0.5rem">-5.0 grados / 20.0 grados</label>
                                <div class="col-md-10">
                                    <input type="checkbox" id="alert-fivetotwenty" name="alerts[fivetotwenty]" switch="none"/>
                                    <label for="alert-fivetotwenty" data-on-label="On" data-off-label="Off"></label>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="form-label col-md-2" for="logistics" style="margin-bottom: 0.5rem">3.0 grados / 7.0 grados</label>
                                <div class="col-md-10">
                                    <input type="checkbox" id="alert-treetoseven" name="alerts[treetoseven]" switch="none" />
                                    <label for="alert-treetoseven" data-on-label="On" data-off-label="Off"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col text-end">
            <a href="{{route('orders.order.index')}}" class="btn btn-danger"> <i class="bx bx-x me-1"></i> Cancelar </a>
            <button type="submit" class="btn btn-success"> <i class=" bx bx-file me-1"></i> Guardar </button>
        </div> <!-- end col -->
    </div>
    {!! Form::close() !!}

@endsection
@section('script')
   {{-- <script src="{{ URL::asset('assets/libs/choices.js/choices.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/ecommerce-choices.init.js') }}"></script>--}}
    <script src="{{Theme::url('js/app.js') }}"></script>
    <script>
        function selectSede() {
            const sedes={!! json_encode($sedes) !!};
            const id = document.getElementById('shipping_id').value;
            let sede=sedes.find(function (x){
                return x.id===parseInt(id);
            })
            document.getElementById('shipping-phone').value=sede.phone;
            document.getElementById('shipping-contact').value=sede.contact
        }
    </script>
@endsection
