<?php

namespace App\Http\Controllers;

use App\Models\HistorialAccion;
use App\Models\PrestamoDocumento;
use App\Models\ReservaDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrestamoDocumentoController extends Controller
{
    public $validacion = [
        'documento_id' => 'required',
        'funcionario_id' => 'required',
        'tipo_documento' => 'required',
        'cantidad_documentos' => 'required|numeric|min:1',
        'dependencia_id' => 'required',
        'descripcion' => 'required',
        'observacion' => 'required',
        'fecha' => 'required',
        'hora' => 'required',
    ];

    public $mensajes = [
        'documento_id.required' => 'Este campo es obligatorio',
        'funcionario_id.required' => 'Este campo es obligatorio',
        'dependencia_id.required' => 'Este campo es obligatorio',
        'descripcion.required' => 'Este campo es obligatorio',
        'observacion.required' => 'Este campo es obligatorio',
        'fecha.required' => 'Este campo es obligatorio',
        'hora.required' => 'Este campo es obligatorio',
        'tipo_documento.required' => 'Este campo es obligatorio',
        'cantidad_documentos.required' => 'Este campo es obligatorio',
        'cantidad_documentos.numeric' => 'Debes ingresar un valor númerico valido',
        'cantidad_documentos.min' => 'Debes ingresar un valor mayor o igual a :min',
    ];

    public function index(Request $request)
    {
        $prestamo_documentos = [];
        if (Auth::user()->tipo == 'FUNCIONARIO') {
            $prestamo_documentos = PrestamoDocumento::with(["documento", "funcionario", "dependencia"])
                ->where("funcionario_id", Auth::user()->funcionario->id)
                ->where("estado", 1)
                ->orderBy("id", "desc")
                ->get();
        } else {
            $prestamo_documentos = PrestamoDocumento::with(["documento", "funcionario", "dependencia"])->orderBy("id", "desc")->get();
        }

        return response()->JSON(['prestamo_documentos' => $prestamo_documentos, 'total' => count($prestamo_documentos)], 200);
    }

    public function funcionario_prestamo(Request $request)
    {
        $prestamo_documento = PrestamoDocumento::where("documento_id", $request->documento_id)
            ->orderBy("id", "desc")
            ->get()->first();

        return response()->JSON([
            "sw" => true,
            "funcionario" => $prestamo_documento->funcionario,
            "prestamo_documento" => $prestamo_documento->load(["documento", "funcionario", "dependencia"])
        ]);
    }

    public function adjuntar_prestamo_documentos(PrestamoDocumento $prestamo_documento)
    {
        return response()->JSON([
            "adjuntar_prestamo_documentos" => $prestamo_documento->adjuntar_prestamo_documentos,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        $request['fecha_registro'] = date('Y-m-d');
        DB::beginTransaction();
        try {
            // buscar la reserva si esta existe
            $existe_reserva = ReservaDocumento::where("documento_id", $request->documento_id)->where("estado", 1)->get()->first();

            // crear el PrestamoDocumento
            $nuevo_prestamo_documento = PrestamoDocumento::create(array_map('mb_strtoupper', $request->all()));
            $nuevo_prestamo_documento->documento->estado = 'PRESTADO';
            $nuevo_prestamo_documento->documento->save();
            if ($existe_reserva) {
                $existe_reserva->estado = 0;
                $existe_reserva->save();
            }

            $datos_original = HistorialAccion::getDetalleRegistro($nuevo_prestamo_documento, "prestamo_documentos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->prestamo_documento . ' REGISTRO UN PRESTAMO DE DOCUMENTO',
                'datos_original' => $datos_original,
                'modulo' => 'PRESTAMO DE DOCUMENTOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'prestamo_documento' => $nuevo_prestamo_documento,
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

    public function update(Request $request, PrestamoDocumento $prestamo_documento)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $documento_id_anterior = $prestamo_documento->documento_id;
            $datos_original = HistorialAccion::getDetalleRegistro($prestamo_documento, "prestamo_documentos");
            $prestamo_documento->update(array_map('mb_strtoupper', $request->all()));

            if ($documento_id_anterior != $request->documento_id) {
                $documento_anterior = Documento::find($documento_id_anterior);
                $documento_anterior->estado = 'RESERVADO';
                $documento_anterior->save();
                $prestamo_documento->documento->estado = 'PRESTADO';
                $prestamo_documento->documento->save();
            }


            $datos_nuevo = HistorialAccion::getDetalleRegistro($prestamo_documento, "prestamo_documentos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->prestamo_documento . ' MODIFICÓ UN PRESTAMO DE DOCUMENTO',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'PRESTAMO DE DOCUMENTOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'prestamo_documento' => $prestamo_documento,
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

    public function show(PrestamoDocumento $prestamo_documento)
    {
        return response()->JSON([
            'sw' => true,
            'prestamo_documento' => $prestamo_documento->load(["documento"]),
        ], 200);
    }
    public function destroy(PrestamoDocumento $prestamo_documento)
    {
        DB::beginTransaction();
        try {
            $prestamo_documento->documento->estado = 'RESERVADO';
            $prestamo_documento->documento->save();
            $datos_original = HistorialAccion::getDetalleRegistro($prestamo_documento, "prestamo_documentos");
            $prestamo_documento->delete();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->prestamo_documento . ' ELIMINÓ UN PRESTAMO DE DOCUMENTO',
                'datos_original' => $datos_original,
                'modulo' => 'PRESTAMO DE DOCUMENTOS',
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
