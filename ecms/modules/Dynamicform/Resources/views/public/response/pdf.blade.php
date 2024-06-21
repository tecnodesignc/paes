<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Response {{$form->name ?? null}}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

<style>
    body {
        font-size: 12px; /* Reducir el tamaño de la letra en todo el documento */
        margin: 0.3cm; /* Definir márgenes de la hoja */
    }
    h3 {
        font-size: 16px; /* Reducir el tamaño de los encabezados h3 */
    }
    h6 {
        font-size: 14px; /* Reducir el tamaño de los encabezados h6 */
    }
    p {
        font-size: 12px; /* Reducir el tamaño del texto de los párrafos */
    }
    table {
        font-size: 10px; /* Reducir el tamaño de la letra en las tablas */
    }
</style>
</head>
<body>

    <div class="row mb-0">
        <table class="table table-sm table-borderless">
            <tr>
                <td width="75%">
                    <img src="{{asset($form_response->company->logo)}}" alt="Logo de la empresa" style="width: 370px; height: 100px" >
                </td>
                <td width="25%">
                    <div class="content-flex d-inline text-muted text-right">
                        <h6 class="mb-0">{{$form_response->company->name}}</h6>
                        <p class="mb-0">{{$form_response->company->identification ?? null}}</p>
                        <p class="mb-0">{{$form_response->company->email ?? null}}</p>
                        <p>{{$form_response->company->phone ?? null}}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>


    <div class="row">
        <h3 class="text-center">{{$form->name}}</h3>
        <table class="table table-sm table-borderless">
            <tr>
                <td width="33%">
                    <h6 class="mb-0">Colaborador: </h6>
                    <p>{{$form_response->data->info->fullName ?? null}}</p>
                    <h6 class="mb-0"># Documento: </h6>
                    <p>{{$form_response->data->info->identification ?? null}}</p>
                </td>
                <td width="33%">
                    <h6 class="mb-0">Placa:</h6>
                    <p>{{$form_response->data->info->vehicle->label ?? null}}</p>
                    <h6 class="mb-0">Fecha de registro:</h6>
                    <p>{{$form_response->created_at ?? null}}</p>
                </td>
                <td width="33%">
                    <h6 class="mb-0">Kilometraje:</h6>
                    <p>{{$form_response->data->info->vehicle->millage ?? 0}}</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="row">
        <table class="table table-sm">
            <thead>
              <tr>
                <th scope="col" width="4%">#</th>
                <th scope="col" width="33%">Item</th>
                <th scope="col" width="20%">Respuesta</th>
                <th scope="col" width="10%">Imagen</th>
                <th scope="col" width="33%">Observación</th>
              </tr>
            </thead>
            <tbody>
                @foreach($form_response->data->answers as $dato)
                    @include('dynamicform::public.partials.field_pdf', ['field' => $dato, 'index' => $loop->iteration])
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>
