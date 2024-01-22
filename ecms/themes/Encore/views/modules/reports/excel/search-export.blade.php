<table>
    <thead>
    <tr>
        <th style="width: 200px; font-weight: bold; text-align: center">
        Ruta
        </th>
        <th style="width: 120px; font-weight: bold; text-align: center">
        Placa
        </th>
        <th style="width: 200px; font-weight: bold; text-align: center">
        Conductor
        </th>
        <th style="width: 150px;font-weight: bold; text-align: center">
        Fecha de Inicio
        </th>
        <th style="width: 150px;font-weight: bold; text-align: center">
            Hora de Inicio
        </th>
        <th style="width: 150px; font-weight: bold; text-align: center">
        Fecha de Finalización
        </th>
        <th style="width: 150px; font-weight: bold; text-align: center">
            Hora de Finalización
        </th>
        <th style="width: 120px; font-weight: bold; text-align: center">
        Tiempo Total
        </th>
        <th style="width: 120px; font-weight: bold; text-align: center">
            Pasajeros
        </th>
    </tr>
    </thead>
    <tbody>
    @if(count($tours))
        @foreach($tours as $tour)
            <tr>
                <td>
                    {{$tour->route->name}}
                </td>
                <td>
                    {{$tour->vehicle->plate}}
                </td>
                <td>
                    {{$tour->driver->user->present()->fullName}}
                </td>
                <td>
                    {{$tour->start_date->format('Y-m-d')}}
                </td>
                <td>
                    {{$tour->start_date->format('H:i:s')}}
                </td>
                <td>
                    @if($tour->end_date)
                        {{$tour->end_date->format('Y-m-d')}}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if($tour->end_date)
                        {{$tour->end_date->format('H:i:s')}}
                    @else
                        N/A
                    @endif

                </td>
                <td>
                    @if($tour->end_date)
                        {{$tour->end_date->longAbsoluteDiffForHumans($tour->start_date)}}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    {{count($tour->itineraries)}}
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
