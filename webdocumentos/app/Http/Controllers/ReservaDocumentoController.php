<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\HistorialAccion;
use App\Models\ReservaDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservaDocumentoController extends Controller
{
    public $validacion = [
        'documento_id' => 'required',
        'funcionario_id' => 'required',
        'descripcion' => 'required',
        'observacion' => 'required',
        'fecha' => 'required',
        'hora' => 'required',
    ];

    public $mensajes = [
        'documento_id.required' => 'Este campo es obligatorio',
        'funcionario_id.required' => 'Este campo es obligatorio',
        'descripcion.required' => 'Este campo es obligatorio',
        'observacion.required' => 'Este campo es obligatorio',
        'fecha.required' => 'Este campo es obligatorio',
        'hora.required' => 'Este campo es obligatorio',
    ];

    public function index(Request $request)
    {
        $reserva_documentos = [];
        if (Auth::user()->tipo == 'FUNCIONARIO') {
            $reserva_documentos = ReservaDocumento::with(["documento", "funcionario"])
                ->where("funcionario_id", Auth::user()->funcionario->id)
                ->where("estado", 1)
                ->orderBy("id", "desc")->get();
        } else {
            $reserva_documentos = ReservaDocumento::with(["documento", "funcionario"])->orderBy("id", "desc")->get();
        }
        return response()->JSON(['reserva_documentos' => $reserva_documentos, 'total' => count($reserva_documentos)], 200);
    }

    public function adjuntar_reserva_documentos(ReservaDocumento $reserva_documento)
    {
        return response()->JSON([
            "adjuntar_reserva_documentos" => $reserva_documento->adjuntar_reserva_documentos,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        $request['fecha_registro'] = date('Y-m-d');
        DB::beginTransaction();
        try {
            // crear el ReservaDocumento
            $nueva_reserva_documento = ReservaDocumento::create(array_map('mb_strtoupper', $request->all()));
            $nueva_reserva_documento->documento->estado = 'RESERVADO';
            $nueva_reserva_documento->documento->save();
            $datos_original = HistorialAccion::getDetalleRegistro($nueva_reserva_documento, "reserva_documentos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->reserva_documento . ' REGISTRO UNA RESERVA DE DOCUMENTO',
                'datos_original' => $datos_original,
                'modulo' => 'RESERVA DE DOCUMENTOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'reserva_documento' => $nueva_reserva_documento,
                'msj' => 'El registro se realizó de forma correcta',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, ReservaDocumento $reserva_documento)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $documento_id_anterior = $reserva_documento->documento_id;
            $datos_original = HistorialAccion::getDetalleRegistro($reserva_documento, "reserva_documentos");
            $reserva_documento->update(array_map('mb_strtoupper', $request->all()));

            if ($documento_id_anterior != $request->documento_id) {
                $documento_anterior = Documento::find($documento_id_anterior);
                $documento_anterior->estado = 'EN ARCHIVO';
                $documento_anterior->save();
                $reserva_documento->documento->estado = 'RESERVADO';
                $reserva_documento->documento->save();
            }


            $datos_nuevo = HistorialAccion::getDetalleRegistro($reserva_documento, "reserva_documentos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->reserva_documento . ' MODIFICÓ UNA RESERVA DE DOCUMENTO',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'RESERVA DE DOCUMENTOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'reserva_documento' => $reserva_documento,
                'msj' => 'El registro se actualizó de forma correcta'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(ReservaDocumento $reserva_documento)
    {
        return response()->JSON([
            'sw' => true,
            'reserva_documento' => $reserva_documento->load(["documento"]),
        ], 200);
    }
    public function destroy(ReservaDocumento $reserva_documento)
    {
        DB::beginTransaction();
        try {
            $reserva_documento->documento->estado = 'EN ARCHIVO';
            $reserva_documento->documento->save();
            $datos_original = HistorialAccion::getDetalleRegistro($reserva_documento, "reserva_documentos");
            $reserva_documento->delete();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->reserva_documento . ' ELIMINÓ UNA RESERVA DE DOCUMENTO',
                'datos_original' => $datos_original,
                'modulo' => 'RESERVA DE DOCUMENTOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'msj' => 'El registro se eliminó correctamente'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
