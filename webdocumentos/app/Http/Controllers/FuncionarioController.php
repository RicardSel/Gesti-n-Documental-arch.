<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\HistorialAccion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FuncionarioController extends Controller
{
    public $validacion = [
        'nombre' => 'required|min:4',
        'paterno' => 'required|min:4',
        'ci' => 'required|numeric|digits_between:4, 20|unique:users,ci',
        'ci_exp' => 'required',
        'gestion_ingreso' => 'required',
        'tipo_ingreso' => 'required',
        'fecha_baja' => 'required',
        'fecha_item' => 'required',
        'acceso' => 'required',
    ];

    public $mensajes = [
        'codigo.required' => 'Este campo es obligatorio',
        'codigo.unique' => 'El código que ingreso ya fue asignado a otro funcionario',
        'nombre.required' => 'Este campo es obligatorio',
        'nombre.min' => 'Debes ingresar al menos 4 carácteres',
        'paterno.required' => 'Este campo es obligatorio',
        'paterno.min' => 'Debes ingresar al menos 4 carácteres',
        'ci.required' => 'Este campo es obligatorio',
        'ci.numeric' => 'Debes ingresar un valor númerico',
        'ci.unique' => 'Este número de C.I. ya fue registrado',
        'ci_exp.required' => 'Este campo es obligatorio',
        'dir.required' => 'Este campo es obligatorio',
        'dir.min' => 'Debes ingresar al menos 4 carácteres',
        'fono.required' => 'Este campo es obligatorio',
        'fono.min' => 'Debes ingresar al menos 4 carácteres',
        'cel.required' => 'Este campo es obligatorio',
        'cel.min' => 'Debes ingresar al menos 4 carácteres',
        'gestion_ingreso.required' => 'Este campo es obligatorio',
        'tipo_ingreso.required' => 'Este campo es obligatorio',
        'fecha_baja.required' => 'Este campo es obligatorio',
        'fecha_item.required' => 'Este campo es obligatorio',
    ];

    public function index(Request $request)
    {
        $funcionarios = Funcionario::with("user")->get();
        return response()->JSON(['funcionarios' => $funcionarios, 'total' => count($funcionarios)], 200);
    }

    public function getLastFuncionario()
    {
        return response()->JSON([
            "funcionario" => Funcionario::orderBy("id", "desc")->get()->first()
        ]);
    }

    public function store(Request $request)
    {
        $this->validacion['codigo'] = 'required|min:2|unique:funcionarios,codigo';
        $this->validacion['ci'] = 'required|min:4|numeric|unique:users,ci';
        $request->validate($this->validacion, $this->mensajes);

        $cont = 0;
        do {
            $nombre_usuario = User::getNombreUsuario($request->nombre, $request->paterno);
            if ($cont > 0) {
                $nombre_usuario = $nombre_usuario . $cont;
            }
            $request['usuario'] = $nombre_usuario;
            $cont++;
        } while (User::where('usuario', $nombre_usuario)->get()->first());

        DB::beginTransaction();
        try {
            // crear el Usuario
            $nuevo_usuario = User::create([
                "usuario" => $nombre_usuario,
                "nombre" => mb_strtoupper($request->nombre),
                "paterno" => mb_strtoupper($request->paterno),
                "materno" => mb_strtoupper($request->materno),
                "ci" => mb_strtoupper($request->ci),
                "ci_exp" => mb_strtoupper($request->ci_exp),
                "fono" => mb_strtoupper($request->fono),
                "tipo" => "FUNCIONARIO",
                "password" => Hash::make($request->ci),
                "acceso" => $request->acceso,
                "fecha_registro" => date("Y-m-d"),
            ]);

            // crear el funcionario
            $nuevo_funcionario = $nuevo_usuario->funcionario()->create([
                "codigo" => mb_strtoupper($request->codigo),
                "gestion_ingreso" => mb_strtoupper($request->gestion_ingreso),
                "tipo_ingreso" => mb_strtoupper($request->tipo_ingreso),
                "fecha_baja" => $request->fecha_baja,
                "fecha_item" => $request->fecha_item,
                "descripcion" => mb_strtoupper($request->descripcion),
                "observaciones" => mb_strtoupper($request->observaciones),
                "fecha_registro" => date("Y-m-d"),
            ]);

            $datos_original = HistorialAccion::getDetalleRegistro($nuevo_funcionario, "funcionarios");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->funcionario . ' REGISTRO UN FUNCIONARIO',
                'datos_original' => $datos_original,
                'modulo' => 'FUNCIONARIOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'funcionario' => $nuevo_funcionario,
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

    public function update(Request $request, Funcionario $funcionario)
    {
        $this->validacion['codigo'] = 'required|min:2|unique:funcionarios,codigo,' . $funcionario->id;
        $this->validacion['ci'] = 'required|min:4|numeric|unique:users,ci,' . $funcionario->user->id;

        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {

            $usuario = $funcionario->user;
            // actualizar el Usuario
            $usuario->update([
                "nombre" => mb_strtoupper($request->nombre),
                "paterno" => mb_strtoupper($request->paterno),
                "materno" => mb_strtoupper($request->materno),
                "ci" => mb_strtoupper($request->ci),
                "ci_exp" => mb_strtoupper($request->ci_exp),
                "fono" => mb_strtoupper($request->fono),
                "acceso" => $request->acceso,
            ]);

            $datos_original = HistorialAccion::getDetalleRegistro($funcionario, "funcionarios");

            // actualizar el funcionario
            $funcionario->update([
                "codigo" => mb_strtoupper($request->codigo),
                "gestion_ingreso" => mb_strtoupper($request->gestion_ingreso),
                "tipo_ingreso" => mb_strtoupper($request->tipo_ingreso),
                "fecha_baja" => $request->fecha_baja,
                "fecha_item" => $request->fecha_item,
                "descripcion" => mb_strtoupper($request->descripcion),
                "observaciones" => mb_strtoupper($request->observaciones),
            ]);

            $datos_nuevo = HistorialAccion::getDetalleRegistro($funcionario, "funcionarios");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->funcionario . ' MODIFICÓ UN FUNCIONARIO',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'FUNCIONARIOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'funcionario' => $funcionario,
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

    public function show(Funcionario $funcionario)
    {
        return response()->JSON([
            'sw' => true,
            'funcionario' => $funcionario
        ], 200);
    }
    public function destroy(Funcionario $funcionario)
    {
        DB::beginTransaction();
        try {
            // VALIDAR DEPENDECIAS

            // FIN VALIDAR DEPENDENCIAS

            $usuario = $funcionario->user;
            $datos_original = HistorialAccion::getDetalleRegistro($funcionario, "funcionarios");
            $funcionario->delete();
            // eliminar usuario
            $usuario->delete();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->funcionario . ' ELIMINÓ UN FUNCIONARIO',
                'datos_original' => $datos_original,
                'modulo' => 'FUNCIONARIOS',
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
