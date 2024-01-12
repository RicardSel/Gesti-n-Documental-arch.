<?php

namespace App\Http\Controllers;

use App\Models\Estante;
use App\Models\HistorialAccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstanteController extends Controller
{
    public $validacion = [
        'nombre' => 'required|min:2',
        'nivel' => 'required|numeric|min:1',
        'division' => 'required|numeric|min:1',
    ];

    public $mensajes = [
        'nombre.required' => 'Este campo es obligatorio',
        'nombre.min' => 'Debes ingresar al menos 4 carácteres',
        'nivel.required' => 'Este campo es obligatorio',
        'nivel.numeric' => 'Debes ingresar un valor númerico',
        'nivel.min' => 'Debes ingresar un valor mayor o igual a :min',
        'division.required' => 'Este campo es obligatorio',
        'division.numeric' => 'Debes ingresar un valor númerico',
        'division.min' => 'Debes ingresar un valor mayor o igual a :min',
    ];

    public function index(Request $request)
    {
        $estantes = Estante::orderBy("id", "desc")->get();
        return response()->JSON(['estantes' => $estantes, 'total' => count($estantes)], 200);
    }

    public function nivel_division(Estante $estante)
    {
        $niveles = $estante->nivel;
        $divisiones = $estante->division;

        $list_niveles = [];
        $list_divisiones = [];
        for ($i = 1; $i <= $niveles; $i++) {
            $list_niveles[] = $i;
        }
        for ($i = 1; $i <= $divisiones; $i++) {
            $list_divisiones[] = $i;
        }

        return response()->JSON([
            "niveles" => $list_niveles,
            "divisiones" => $list_divisiones,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        $request['fecha_registro'] = date('Y-m-d');
        DB::beginTransaction();
        try {
            // crear el Estante
            $nuevo_estante = Estante::create(array_map('mb_strtoupper', $request->all()));

            $datos_original = HistorialAccion::getDetalleRegistro($nuevo_estante, "estantes");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->estante . ' REGISTRO UN ESTANTE',
                'datos_original' => $datos_original,
                'modulo' => 'ESTANTES',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'estante' => $nuevo_estante,
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

    public function update(Request $request, Estante $estante)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($estante, "estantes");
            $estante->update(array_map('mb_strtoupper', $request->all()));
            $datos_nuevo = HistorialAccion::getDetalleRegistro($estante, "estantes");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->estante . ' MODIFICÓ UN ESTANTE',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'ESTANTES',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'estante' => $estante,
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

    public function show(Estante $estante)
    {
        return response()->JSON([
            'sw' => true,
            'estante' => $estante
        ], 200);
    }
    public function destroy(Estante $estante)
    {
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($estante, "estantes");
            $estante->delete();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->estante . ' ELIMINÓ UN ESTANTE',
                'datos_original' => $datos_original,
                'modulo' => 'ESTANTES',
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
