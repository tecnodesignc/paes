<table>
    <tr>
        <td style="width: 150px; font-weight: bold">Ruta:</td>
        <td style="width: 200px;">{{$tour->route->start_place}} - {{$tour->route->arrival_place}} </td>
        <td style="width: 150px; font-weight: bold">Placa:</td>
        <td style="width: 100px;">{{$tour->vehicle->plate}}</td>
        <td style="width: 100px; font-weight: bold">Conductor:</td>
        <td style="width: 250px;">{{$tour->driver->user->present()->fullName}}</td>
    </tr>
    <tr>
        <td style="font-weight: bold">Fecha de Inicio:</td>
        <td>{{$tour->start_date}}</td>
        <td style="font-weight: bold">Fecha de Finalización:</td>
        <td>{{$tour->end_date}}</td>
        <td style="font-weight: bold">Tiempo Total:</td>
        <td>{{Carbon\Carbon::create($tour->end_date)->longAbsoluteDiffForHumans(Carbon\Carbon::create($tour->start_date))}}</td>
    </tr>
</table>

<table>
    <thead>
    <tr>
        <th style="font-weight: bold">
            Nombre del Pasajero
        </th>
        <th style="font-weight: bold">
            Punto de Recogida
        </th>
        <th style="font-weight: bold">
            Punto de Llegada
        </th>
        <th style="width: 150px;font-weight: bold">
            Tiempo de Ruta
        </th>
        <th style="width: 120px; font-weight: bold">
            Pasajes Restante
        </th>
        <th style="font-weight: bold">
            Autorizado
        </th>
    </tr>
    </thead>
    <tbody>
    @if(count($itineraries))
        @foreach($itineraries as $itinerary)
            <tr>
                <td>
                    {{$itinerary->passenger->user->present()->fullName}}
                </td>
                <td>
                    {{$itinerary->pick_up}}
                </td>
                <td>
                    {{$itinerary->drop_off}}
                </td>
                <td>
                    {{$itinerary->present()->time_route}}
                </td>
                <td style="text-align: center">
                    {{$itinerary->tickets_available}}
                </td>
                <td style="background-color: {{$itinerary->authorized?'#33a186':'#fa6374'}};color: #ffffff">
                    {{$itinerary->authorized?'Si':'No'}}
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
