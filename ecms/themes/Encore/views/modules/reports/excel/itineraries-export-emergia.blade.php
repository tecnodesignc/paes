<table>
    <thead>
    <tr>
        <th style="width: 150px; font-weight: bold; text-align: center">
            Fecha Inicio Ruta
        </th>
        <th style="width: 150px; font-weight: bold; text-align: center">
            Hora Inicio Ruta
        </th>
        <th style="width: 150px; font-weight: bold; text-align: center">
            Fecha Fin Ruta
        </th>
        <th style="width: 150px; font-weight: bold; text-align: center">
            Hora Fin Ruta
        </th>
        <th style="width: 200px; font-weight: bold; text-align: center">
            Ruta
        </th>
        <th style="width: 150px;font-weight: bold; text-align: center">
            Placa del Vehículo
        </th>
        <th style="width: 120px; font-weight: bold; text-align: center">
            Fecha
        </th>
        <th style="width: 120px; font-weight: bold; text-align: center">
            Mes
        </th>
        <th style="width: 120px; font-weight: bold; text-align: center">
            Duracion
        </th>
        <th style="width: 250px;font-weight: bold; text-align: center">
            Colaborador
        </th>
        <th style="width: 120px; font-weight: bold; text-align: center">
            Servicio
        </th>
    </tr>
    </thead>
    <tbody>
    @if(count($itineraries))
        @foreach($itineraries as $itinerary)
            <tr>

                <td>
                    {{$itinerary->created_at->format('Y-m-d')}}
                </td>
                <td>
                    {{$itinerary->created_at->format('H:i:s')}}
                </td>
                <td>
                    {{$tour->end_date->format('Y-m-d')}}
                </td>
                <td>
                    {{$tour->end_date->format('H:i:s')}}
                </td>
                <td>
                    {{$tour->route->name}}
                </td>
                <td>
                    {{$tour->vehicle->plate}}
                </td>
                <td>
                    {{$tour->start_date->isoFormat('YYYY-MM-DD')}}
                </td>

                <td>
                    {{$tour->start_date->isoFormat('MMMM')}}
                </td>
                <td>
                    {{$itinerary->present()->time_route}}
                </td>
                <td>
                    {{$itinerary->passenger->user->present()->fullName}}
                </td>
                <td>
                    {{$itinerary->passenger->service}}
                </td>

            </tr>
        @endforeach
    @endif
    </tbody>
</table>
