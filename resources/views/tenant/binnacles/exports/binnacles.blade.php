<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Bitacora</title>
    </head>
    <body>
        <div>
            <h3 align="center" class="title"><strong>Reporte de Bitacora</strong></h3>

        </div>
        <br>
        @if(!empty($records))
            <div class="">
                <div class=" ">
                    <table class="">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Usuario</th>
                                <th>Fecha</th>
                                <th>Hora Inicio</th>
                                <th>Hora Fin</th>
                                <th>Horas</th>
                                <th>Cliente</th>
                                <th>Categoria(Cuenta)</th>
                                <th>Servicio(C. Costo)</th>
                                <th>Periodo</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $key => $value)
                            <tr>
                                <td class="celda">{{$loop->iteration}}</td>
                                <td class="celda">{{$value->user->name}}</td>
                                <td class="celda">{{Carbon\Carbon::parse($value->date)->format('d/m/Y')}}</td>
                                <td class="celda">{{Carbon\Carbon::parse($value->start_time)->format('h:i A')}}</td>
                                <td class="celda">{{Carbon\Carbon::parse($value->end_time)->format('h:i A')}}</td>
                                <td class="celda">{{$value->hour }}</td>
                                <td class="celda">{{$value->client->name }}</td>
                                <td class="celda">{{$value->category->name }}</td>
                                <td class="celda">{{$value->service->name }}</td>
                                <td class="celda">{{Carbon\Carbon::parse($value->period)->format('m/Y') }}</td>
                                <td class="celda">{{$value->description }}</td>
                                <td class="celda">{{$value->status }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div>
                <p>No se encontraron registros.</p>
            </div>
        @endif
    </body>
</html>
