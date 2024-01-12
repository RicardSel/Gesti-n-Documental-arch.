<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\HistorialAccion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DocumentoController extends Controller
{
    public $validacion = [
        'descripcion' => 'required|min:2',
        'dependencia_id' => 'required',
        'funcionario_id' => 'required',
        'oficina_id' => 'required',
        'estante_id' => 'required',
        'nivel' => 'required',
        'division' => 'required',
        'fecha' => 'required',
        'hora' => 'required',
    ];

    public $mensajes = [
        'descripcion.required' => 'Este campo es obligatorio',
        'descripcion.min' => 'Debes ingresar al menos 4 carácteres',
        'dependencia_id.required' => 'Este campo es obligatorio',
        'funcionario_id.required' => 'Este campo es obligatorio',
        'oficina_id.required' => 'Este campo es obligatorio',
        'estante_id.required' => 'Este campo es obligatorio',
        'nivel.required' => 'Este campo es obligatorio',
        'division.required' => 'Este campo es obligatorio',
        'fecha.required' => 'Este campo es obligatorio',
        'hora.required' => 'Este campo es obligatorio',
    ];

    public function index(Request $request)
    {
        $documentos = Documento::with(["adjuntar_documentos", "dependencia", "funcionario", "oficina", "estante"])->orderBy("id", "desc")->get();
        return response()->JSON(['documentos' => $documentos, 'total' => count($documentos)], 200);
    }

    public function prestado()
    {
        $documentos = Documento::with(["adjuntar_documentos", "dependencia", "funcionario", "oficina", "estante"])
            ->where("estado", "PRESTADO")
            ->orderBy("id", "desc")->get();
        return response()->JSON(['documentos' => $documentos, 'total' => count($documentos)], 200);
    }

    public function archivo()
    {
        $documentos = Documento::with(["adjuntar_documentos", "dependencia", "funcionario", "oficina", "estante"])
            ->where("estado", "EN ARCHIVO")
            ->orderBy("id", "desc")->get();
        return response()->JSON(['documentos' => $documentos, 'total' => count($documentos)], 200);
    }

    public function archivo_reservado()
    {
        $documentos = Documento::with(["adjuntar_documentos", "dependencia", "funcionario", "oficina", "estante"])
            ->whereIn("estado", ["EN ARCHIVO", "RESERVADO"])
            ->orderBy("id", "desc")->get();
        return response()->JSON(['documentos' => $documentos, 'total' => count($documentos)], 200);
    }

    public function adjuntar_documentos(Documento $documento)
    {
        return response()->JSON([
            "adjuntar_documentos" => $documento->adjuntar_documentos,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        $request['fecha_registro'] = date('Y-m-d');
        DB::beginTransaction();
        try {
            // crear el Documento
            $request["codigo"] = "DOC-" . time();
            $request["estado"] = "EN ARCHIVO"; //EN ARCHIVO/RESERVADO/PRESTADO
            $nuevo_documento = Documento::create(array_map('mb_strtoupper', $request->all()));
            $nuevo_documento->codigo = "DOC-" . $nuevo_documento->id;
            $nuevo_documento->save();

            $datos_original = HistorialAccion::getDetalleRegistro($nuevo_documento, "documentos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->documento . ' REGISTRO UN DOCUMENTO',
                'datos_original' => $datos_original,
                'modulo' => 'DOCUMENTOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'documento' => $nuevo_documento,
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

    public function update(Request $request, Documento $documento)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($documento, "documentos");
            $documento->update(array_map('mb_strtoupper', $request->all()));
            $datos_nuevo = HistorialAccion::getDetalleRegistro($documento, "documentos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->documento . ' MODIFICÓ UN DOCUMENTO',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'DOCUMENTOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'documento' => $documento,
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

    public function show(Documento $documento)
    {
        return response()->JSON([
            'sw' => true,
            'documento' => $documento
        ], 200);
    }
    public function destroy(Documento $documento)
    {
        DB::beginTransaction();
        try {
            $documento->adjuntar_documentos()->delete();
            $datos_original = HistorialAccion::getDetalleRegistro($documento, "documentos");
            $documento->delete();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->documento . ' ELIMINÓ UN DOCUMENTO',
                'datos_original' => $datos_original,
                'modulo' => 'DOCUMENTOS',
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
