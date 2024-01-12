<?php

namespace App\Http\Controllers;

use App\Models\DevolucionDocumento;
use App\Models\HistorialAccion;
use App\Models\PrestamoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DevolucionDocumentoController extends Controller
{
    public $validacion = [
        'documento_id' => 'required',
        'cantidad_documentos' => 'required|numeric|min:1',
        'descripcion' => 'required',
        'observacion' => 'required',
        'fecha' => 'required',
        'hora' => 'required',
    ];

    public $mensajes = [
        'documento_id.required' => 'Este campo es obligatorio',
        'descripcion.required' => 'Este campo es obligatorio',
        'observacion.required' => 'Este campo es obligatorio',
        'fecha.required' => 'Este campo es obligatorio',
        'hora.required' => 'Este campo es obligatorio',
        'cantidad_documentos.required' => 'Este campo es obligatorio',
        'cantidad_documentos.numeric' => 'Debes ingresar un valor númerico valido',
        'cantidad_documentos.min' => 'Debes ingresar un valor mayor o igual a :min',
    ];

    public function index(Request $request)
    {
        $devolucion_documentos = DevolucionDocumento::with(["documento", "funcionario"])->orderBy("id", "desc")->get();
        return response()->JSON(['devolucion_documentos' => $devolucion_documentos, 'total' => count($devolucion_documentos)], 200);
    }

    public function adjuntar_devolucion_documentos(DevolucionDocumento $devolucion_documento)
    {
        return response()->JSON([
            "adjuntar_devolucion_documentos" => $devolucion_documento->adjuntar_devolucion_documentos,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        $request['fecha_registro'] = date('Y-m-d');
        DB::beginTransaction();
        try {
            $prestamo_documento = PrestamoDocumento::where("documento_id", $request->documento_id)
                ->where("estado", 1)
                ->get()
                ->first();

            // crear el DevolucionDocumento
            $nueva_devolucion_documento = DevolucionDocumento::create(array_map('mb_strtoupper', $request->all()));
            $nueva_devolucion_documento->documento->estado = 'EN ARCHIVO';
            $nueva_devolucion_documento->documento->save();

            if ($prestamo_documento) {
                $prestamo_documento->estado = 0;
                $prestamo_documento->save();
            }

            $datos_original = HistorialAccion::getDetalleRegistro($nueva_devolucion_documento, "devolucion_documentos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->devolucion_documento . ' REGISTRO UNA DEVOLUCIÓN DE DOCUMENTO',
                'datos_original' => $datos_original,
                'modulo' => 'DEVOLUCIÓN DE DOCUMENTOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'devolucion_documento' => $nueva_devolucion_documento,
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

    public function update(Request $request, DevolucionDocumento $devolucion_documento)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $documento_id_anterior = $devolucion_documento->documento_id;
            $datos_original = HistorialAccion::getDetalleRegistro($devolucion_documento, "devolucion_documentos");
            $devolucion_documento->update(array_map('mb_strtoupper', $request->all()));

            if ($documento_id_anterior != $request->documento_id) {
                $documento_anterior = Documento::find($documento_id_anterior);
                $documento_anterior->estado = 'PRESTADO';
                $documento_anterior->save();
                $devolucion_documento->documento->estado = 'EN ARCHIVO';
                $devolucion_documento->documento->save();
            }


            $datos_nuevo = HistorialAccion::getDetalleRegistro($devolucion_documento, "devolucion_documentos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->devolucion_documento . ' MODIFICÓ UNA DEVOLUCIÓN DE DOCUMENTO',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'DEVOLUCIÓN DE DOCUMENTOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'devolucion_documento' => $devolucion_documento,
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

    public function show(DevolucionDocumento $devolucion_documento)
    {
        return response()->JSON([
            'sw' => true,
            'devolucion_documento' => $devolucion_documento->load(["documento", "funcionario"]),
        ], 200);
    }
    public function destroy(DevolucionDocumento $devolucion_documento)
    {
        DB::beginTransaction();
        try {
            $devolucion_documento->documento->estado = 'PRESTADO';
            $devolucion_documento->documento->save();
            $datos_original = HistorialAccion::getDetalleRegistro($devolucion_documento, "devolucion_documentos");
            $devolucion_documento->delete();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->devolucion_documento . ' ELIMINÓ UNA DEVOLUCIÓN DE DOCUMENTO',
                'datos_original' => $datos_original,
                'modulo' => 'DEVOLUCIÓN DE DOCUMENTOS',
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
