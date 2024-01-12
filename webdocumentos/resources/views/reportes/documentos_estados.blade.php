<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>DocumentosEstado</title>
    <style type="text/css">
        * {
            font-family: sans-serif;
        }

        @page {
            margin-top: 1.5cm;
            margin-bottom: 0.3cm;
            margin-left: 0.3cm;
            margin-right: 0.3cm;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 20px;
            page-break-before: avoid;
        }

        table thead tr th,
        tbody tr td {
            padding: 3px;
            word-wrap: break-word;
        }

        table thead tr th {
            font-size: 7pt;
        }

        table tbody tr td {
            font-size: 6pt;
        }


        .encabezado {
            width: 100%;
        }

        .logo img {
            position: absolute;
            width: 200px;
            height: 90px;
            top: -20px;
            left: 0px;
        }

        h2.titulo {
            width: 450px;
            margin: auto;
            margin-top: 0PX;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14pt;
        }

        .texto {
            width: 250px;
            text-align: center;
            margin: auto;
            margin-top: 15px;
            font-weight: bold;
            font-size: 1.1em;
        }

        .fecha {
            width: 250px;
            text-align: center;
            margin: auto;
            margin-top: 15px;
            font-weight: normal;
            font-size: 0.85em;
        }

        .total {
            text-align: right;
            padding-right: 15px;
            font-weight: bold;
        }

        table {
            width: 100%;
        }

        table thead {
            background: rgb(236, 236, 236)
        }

        tr {
            page-break-inside: avoid !important;
        }

        .centreado {
            padding-left: 0px;
            text-align: center;
        }

        .datos {
            margin-left: 15px;
            border-top: solid 1px;
            border-collapse: collapse;
            width: 250px;
        }

        .txt {
            font-weight: bold;
            text-align: right;
            padding-right: 5px;
        }

        .txt_center {
            font-weight: bold;
            text-align: center;
        }

        .cumplimiento {
            position: absolute;
            width: 150px;
            right: 0px;
            top: 86px;
        }

        .b_top {
            border-top: solid 1px black;
        }

        .gray {
            background: rgb(202, 202, 202);
        }

        .bg-principal {
            background: #1f6764;
            color: white;
        }

        .txt_rojo {}

        .img_celda img {
            width: 45px;
        }

        .salto_pagina {
            page-break-after: always;
        }
    </style>
</head>

<body>
    @inject('configuracion', 'App\Models\Configuracion')
    @if ($filtro != 'Estado' || $estado == 'EN ARCHIVO')
        <div class="encabezado">
            <div class="logo">
                <img src="{{ asset('imgs/' . $configuracion->first()->logo) }}">
                {{ $configuracion->first()->logo }}
            </div>
            <h2 class="titulo">
                {{ $configuracion->first()->razon_social }}
            </h2>
            <h4 class="texto">DOCUMENTOS EN ARCHIVO</h4>
            <h4 class="fecha">Expedido: {{ date('d-m-Y') }}</h4>
        </div>
        <table border="1">
            <thead class="bg-principal">
                <tr>
                    <th width="5%">CÓDIGO</th>
                    <th>DESCRIPCIÓN</th>
                    <th>DEPENDENCIA</th>
                    <th>FUNCIONARIO</th>
                    <th>OFICINA</th>
                    <th>ESTANTE</th>
                    <th>NIVEL</th>
                    <th>DIVISIÓN</th>
                    <th>FECHA</th>
                    <th>HORA</th>
                    <th width="9%">FECHA DE REGISTRO</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $cont = 1;
                @endphp
                @foreach ($documentos_archivo as $documento)
                    <tr>
                        <td class="centreado">{{ $documento->codigo }}</td>
                        <td class="">{{ $documento->descripcion }}</td>
                        <td class="">{{ $documento->dependencia->nombre }}</td>
                        <td class="">{{ $documento->funcionario->full_name }}</td>
                        <td class="">{{ $documento->oficina->nombre }}</td>
                        <td class="">{{ $documento->estante->nombre }}</td>
                        <td class="">{{ $documento->nivel }}</td>
                        <td class="">{{ $documento->division }}</td>
                        <td class="">{{ $documento->fecha }}</td>
                        <td class="">{{ $documento->hora }}</td>
                        <td class="centreado">{{ $documento->fecha_registro }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($filtro != 'Estado')
            <div class="salto_pagina"></div>
        @endif
    @endif
    @if ($filtro != 'Estado' || $estado == 'RESERVADO')
        <div class="encabezado">
            <div class="logo">
                <img src="{{ asset('imgs/' . $configuracion->first()->logo) }}">
                {{ $configuracion->first()->logo }}
            </div>
            <h2 class="titulo">
                {{ $configuracion->first()->razon_social }}
            </h2>
            <h4 class="texto">DOCUMENTOS RESERVADO</h4>
            <h4 class="fecha">Expedido: {{ date('d-m-Y') }}</h4>
        </div>
        <table border="1">
            <thead class="bg-principal">
                <tr>
                    <th width="5%">CÓDIGO DOCUMENTO</th>
                    <th>DESCRIPCIÓN DOCUMENTO</th>
                    <th>OFICINA</th>
                    <th>ESTANTE</th>
                    <th>NIVEL</th>
                    <th>DIVISIÓN</th>
                    <th>FUNCIONARIO RESERVA</th>
                    <th>DESCRIPCIÓN</th>
                    <th>OBSERVACIÓN</th>
                    <th>FECHA RESERVA</th>
                    <th>HORA RESERVA</th>
                    <th width="9%">FECHA DE REGISTRO</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $cont = 1;
                @endphp
                @foreach ($documentos_reservado as $documento)
                    <tr>
                        <td class="centreado">{{ $documento->codigo }}</td>
                        <td class="">{{ $documento->descripcion }}</td>
                        <td class="">{{ $documento->oficina->nombre }}</td>
                        <td class="">{{ $documento->estante->nombre }}</td>
                        <td class="">{{ $documento->nivel }}</td>
                        <td class="">{{ $documento->division }}</td>
                        <td class="">{{ $documento->ultima_reserva->funcionario->full_name }}</td>
                        <td class="">{{ $documento->ultima_reserva->descripcion }}</td>
                        <td class="">{{ $documento->ultima_reserva->observacion }}</td>
                        <td class="">{{ $documento->ultima_reserva->fecha }}</td>
                        <td class="">{{ $documento->ultima_reserva->hora }}</td>
                        <td class="centreado">{{ $documento->fecha_registro }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($filtro != 'Estado')
            <div class="salto_pagina"></div>
        @endif
    @endif
    @if ($filtro != 'Estado' || $estado == 'PRESTADO')
        <div class="encabezado">
            <div class="logo">
                <img src="{{ asset('imgs/' . $configuracion->first()->logo) }}">
                {{ $configuracion->first()->logo }}
            </div>
            <h2 class="titulo">
                {{ $configuracion->first()->razon_social }}
            </h2>
            <h4 class="texto">DOCUMENTOS PRESTADO</h4>
            <h4 class="fecha">Expedido: {{ date('d-m-Y') }}</h4>
        </div>
        <table border="1">
            <thead class="bg-principal">
                <tr>
                    <th width="5%">CÓDIGO DOCUMENTO</th>
                    <th>DESCRIPCIÓN DOCUMENTO</th>
                    <th>OFICINA</th>
                    <th>ESTANTE</th>
                    <th>NIVEL</th>
                    <th>DIVISIÓN</th>
                    <th>FUNCIONARIO PRESTAMO</th>
                    <th>TIPO DE DOCUMENTO</th>
                    <th>CANTIDAD DE DOCUMENTOS</th>
                    <th>DESCRIPCIÓN</th>
                    <th>OBSERVACIÓN</th>
                    <th>FECHA PRESTAMO</th>
                    <th>HORA PRESTAMO</th>
                    <th width="9%">FECHA DE REGISTRO</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $cont = 1;
                @endphp
                @foreach ($documentos_prestado as $documento)
                    <tr>
                        <td class="centreado">{{ $documento->codigo }}</td>
                        <td class="">{{ $documento->descripcion }}</td>
                        <td class="">{{ $documento->oficina->nombre }}</td>
                        <td class="">{{ $documento->estante->nombre }}</td>
                        <td class="">{{ $documento->nivel }}</td>
                        <td class="">{{ $documento->division }}</td>
                        <td class="">{{ $documento->ultimo_prestamo->funcionario->full_name }}</td>
                        <td class="">{{ $documento->ultimo_prestamo->tipo_documento }}</td>
                        <td class="">{{ $documento->ultimo_prestamo->cantidad_documentos }}</td>
                        <td class="">{{ $documento->ultimo_prestamo->descripcion }}</td>
                        <td class="">{{ $documento->ultimo_prestamo->observacion }}</td>
                        <td class="">{{ $documento->ultimo_prestamo->fecha }}</td>
                        <td class="">{{ $documento->ultimo_prestamo->hora }}</td>
                        <td class="centreado">{{ $documento->fecha_registro }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>

</html>
