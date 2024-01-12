<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class ReporteController extends Controller
{
    public function usuarios(Request $request)
    {
        $filtro =  $request->filtro;
        $usuarios = User::where('id', '!=', 1)->orderBy("paterno", "ASC")->get();

        if ($filtro == 'Tipo de usuario') {
            $request->validate([
                'tipo' => 'required',
            ]);
            $usuarios = User::where('id', '!=', 1)->where('tipo', $request->tipo)->orderBy("paterno", "ASC")->get();
        }

        $pdf = PDF::loadView('reportes.usuarios', compact('usuarios'))->setPaper('legal', 'landscape');

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

        return $pdf->download('Usuarios.pdf');
    }

    public function documentos(Request $request)
    {
        $filtro =  $request->filtro;
        $estante =  $request->estante;

        $documentos = Documento::where("estado", "EN ARCHIVO")->get();

        if ($filtro != 'Todos') {
            $request->validate([
                "estante" => "required"
            ], [
                "estante.required" => "Debes seleccionar un estante"
            ]);
            if ($estante != '') {
                $documentos = Documento::where("estante_id", $estante)->where("estado", "EN ARCHIVO")->get();
            }
        }

        $pdf = PDF::loadView('reportes.documentos', compact('documentos'))->setPaper('legal', 'landscape');

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

        return $pdf->download('documentos.pdf');
    }

    public function documentos_estados(Request $request)
    {
        $filtro =  $request->filtro;
        $funcionario =  $request->funcionario;
        $estado =  $request->estado;
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;

        if ($filtro == 'Funcionario') {
            $request->validate([
                "funcionario" => "required"
            ], [
                "funcionario.required" => "Debes seleccionar un funcionario"
            ]);
        }

        if ($filtro == 'Estado') {
            $request->validate([
                "estado" => "required"
            ], [
                "estado.required" => "Debes seleccionar un estado"
            ]);
        }

        if ($filtro == 'Rango de fechas') {
            $request->validate([
                "fecha_ini" => "required|date",
                "fecha_fin" => "required|date",
            ], [
                "fecha_ini.required" => "Debes ingresar la fecha inicial",
                "fecha_ini.date" => "Debes ingresar una fecha valida",
                "fecha_fin.required" => "Debes ingresar la fecha final",
                "fecha_fin.date" => "Debes ingresar una fecha valida",
            ]);
        }

        $documentos_archivo = Documento::where("estado", "EN ARCHIVO")->get();
        $documentos_reservado = Documento::where("estado", "RESERVADO")->get();
        $documentos_prestado = Documento::where("estado", "PRESTADO")->get();

        if ($filtro != 'Todos') {

            if ($filtro == 'Funcionario') {
                $documentos_archivo = Documento::select("documentos.*")
                    ->where("funcionario_id", $funcionario)
                    ->where("documentos.estado", "EN ARCHIVO")
                    ->get();
                $documentos_reservado = Documento::select("documentos.*")
                    ->join("reserva_documentos", "reserva_documentos.documento_id", "=", "documentos.id")
                    ->where("reserva_documentos.funcionario_id", $funcionario)
                    ->where("documentos.estado", "RESERVADO")
                    ->distinct()
                    ->get();
                $documentos_prestado = Documento::select("documentos.*")
                    ->join("prestamo_documentos", "prestamo_documentos.documento_id", "=", "documentos.id")
                    ->where("prestamo_documentos.funcionario_id", $funcionario)
                    ->where("documentos.estado", "PRESTADO")
                    ->distinct()
                    ->get();
            }
            if ($filtro == 'Rango de fechas') {
                $documentos_archivo = Documento::select("documentos.*")
                    ->whereBetween("fecha_registro", [$fecha_ini, $fecha_fin])
                    ->where("documentos.estado", "EN ARCHIVO")
                    ->get();
                $documentos_reservado = Documento::select("documentos.*")
                    ->join("reserva_documentos", "reserva_documentos.documento_id", "=", "documentos.id")
                    ->whereBetween("reserva_documentos.fecha_registro", [$fecha_ini, $fecha_fin])
                    ->where("documentos.estado", "RESERVADO")
                    ->distinct()
                    ->get();
                $documentos_prestado = Documento::select("documentos.*")
                    ->join("prestamo_documentos", "prestamo_documentos.documento_id", "=", "documentos.id")
                    ->whereBetween("prestamo_documentos.fecha_registro", [$fecha_ini, $fecha_fin])
                    ->where("documentos.estado", "PRESTADO")
                    ->distinct()
                    ->get();
            }
        }

        $pdf = PDF::loadView('reportes.documentos_estados', compact('documentos_archivo', 'documentos_reservado', 'documentos_prestado', 'filtro', 'estado'))->setPaper('legal', 'landscape');

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

        return $pdf->download('documentos_estados.pdf');
    }

    public function cantidad_documentos(Request $request)
    {
        $filtro = $request->filtro;
        $funcionario = $request->funcionario_id;
        $fecha_ini = $request->fecha_ini;
        $fecha_fin = $request->fecha_fin;


        $datos = [];

        $documentos_archivo = Documento::where("estado", "EN ARCHIVO")->get();
        $documentos_reservado = Documento::where("estado", "RESERVADO")->get();
        $documentos_prestado = Documento::where("estado", "PRESTADO")->get();

        if ($filtro != 'Todos') {

            if ($filtro == 'Funcionario') {
                $documentos_archivo = Documento::select("documentos.*")
                    ->where("funcionario_id", $funcionario)
                    ->where("estado", "EN ARCHIVO")
                    ->get();
                $documentos_reservado = Documento::select("documentos.*")
                    ->join("reserva_documentos", "reserva_documentos.documento_id", "=", "documentos.id")
                    ->where("reserva_documentos.funcionario_id", $funcionario)
                    ->where("estado", "RESERVADO")
                    ->distinct()
                    ->get();
                $documentos_prestado = Documento::select("documentos.*")
                    ->join("prestamo_documentos", "prestamo_documentos.documento_id", "=", "documentos.id")
                    ->where("prestamo_documentos.funcionario_id", $funcionario)
                    ->where("estado", "PRESTADO")
                    ->distinct()
                    ->get();
            }
            if ($filtro == 'Rango de fechas') {
                $documentos_archivo = Documento::select("documentos.*")
                    ->whereBetween("fecha_registro", [$fecha_ini, $fecha_fin])
                    ->where("estado", "EN ARCHIVO")
                    ->get();
                $documentos_reservado = Documento::select("documentos.*")
                    ->join("reserva_documentos", "reserva_documentos.documento_id", "=", "documentos.id")
                    ->whereBetween("reserva_documentos.fecha_registro", [$fecha_ini, $fecha_fin])
                    ->where("estado", "RESERVADO")
                    ->distinct()
                    ->get();
                $documentos_prestado = Documento::select("documentos.*")
                    ->join("prestamo_documentos", "prestamo_documentos.documento_id", "=", "documentos.id")
                    ->whereBetween("prestamo_documentos.fecha_registro", [$fecha_ini, $fecha_fin])
                    ->where("estado", "PRESTADO")
                    ->distinct()
                    ->get();
            }
        }

        $datos = [
            ["EN ARCHIVO", (int)count($documentos_archivo)],
            ["RESERVADO", (int)count($documentos_reservado)],
            ["PRESTADO", (int)count($documentos_prestado)],
        ];

        return response()->JSON([
            "datos" => $datos
        ]);
    }
}
