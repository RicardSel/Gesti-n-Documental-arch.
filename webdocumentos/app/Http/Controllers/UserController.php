<?php

namespace App\Http\Controllers;

use App\Models\Dependencia;
use App\Models\DevolucionDocumento;
use App\Models\Documento;
use App\Models\Estante;
use App\Models\HistorialAccion;
use App\Models\PrestamoDocumento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use PDF;

class UserController extends Controller
{
    public $validacion = [
        'nombre' => 'required|min:4',
        'paterno' => 'required|min:4',
        'ci' => 'required|numeric|digits_between:4, 20|unique:users,ci',
        'ci_exp' => 'required',
        'dir' => 'required',
        'fono' => 'required',
        'dir' => 'required',
        'tipo' => 'required',
        'acceso' => 'required',
    ];

    public $mensajes = [
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
        'tipo.required' => 'Este campo es obligatorio',
    ];

    public $permisos = [
        'ADMINISTRADOR' => [
            'usuarios.index',
            'usuarios.create',
            'usuarios.edit',
            'usuarios.destroy',

            'funcionarios.index',
            'funcionarios.create',
            'funcionarios.edit',
            'funcionarios.destroy',

            'dependencias.index',
            'dependencias.create',
            'dependencias.edit',
            'dependencias.destroy',

            'oficinas.index',
            'oficinas.create',
            'oficinas.edit',
            'oficinas.destroy',

            'estantes.index',
            'estantes.create',
            'estantes.edit',
            'estantes.destroy',

            'documentos.index',
            'documentos.create',
            'documentos.edit',
            'documentos.destroy',

            'reserva_documentos.index',
            'reserva_documentos.create',
            'reserva_documentos.edit',
            'reserva_documentos.destroy',

            'prestamo_documentos.index',
            'prestamo_documentos.create',
            'prestamo_documentos.edit',
            'prestamo_documentos.destroy',

            'devolucion_documentos.index',
            'devolucion_documentos.create',
            'devolucion_documentos.edit',
            'devolucion_documentos.destroy',

            'configuracion.index',
            'configuracion.edit',

            "reportes.usuarios",
            "reportes.documentos",
            "reportes.documentos_estados",
            "reportes.cantidad_documentos",
        ],
        "OPERADOR" => [
            'funcionarios.index',
            'funcionarios.create',
            'funcionarios.edit',
            'funcionarios.destroy',

            'dependencias.index',

            'oficinas.index',

            'estantes.index',

            'documentos.index',
            'documentos.create',
            'documentos.edit',
            'documentos.destroy',

            'reserva_documentos.index',
            'reserva_documentos.create',
            'reserva_documentos.edit',
            'reserva_documentos.destroy',

            'prestamo_documentos.index',
            'prestamo_documentos.create',
            'prestamo_documentos.edit',
            'prestamo_documentos.destroy',

            'devolucion_documentos.index',
            'devolucion_documentos.create',
            'devolucion_documentos.edit',
            'devolucion_documentos.destroy',

            "reportes.documentos",
            "reportes.documentos_estados",
            "reportes.cantidad_documentos",
        ],
        "FUNCIONARIO" => [
            'reserva_documentos.index',
            'prestamo_documentos.index',
        ],
    ];


    public function index(Request $request)
    {
        $usuarios = User::where('id', '!=', 1)->where("tipo", "!=", "FUNCIONARIO")->get();
        return response()->JSON(['usuarios' => $usuarios, 'total' => count($usuarios)], 200);
    }

    public function store(Request $request)
    {
        if ($request->hasFile('foto')) {
            $this->validacion['foto'] = 'image|mimes:jpeg,jpg,png|max:2048';
        }

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

        $request['password'] = 'NoNulo';
        $request['fecha_registro'] = date('Y-m-d');
        DB::beginTransaction();
        try {
            // crear el Usuario
            $nuevo_usuario = User::create(array_map('mb_strtoupper', $request->except('foto')));
            $nuevo_usuario->password = Hash::make($request->ci);
            $nuevo_usuario->save();
            $nuevo_usuario->foto = 'default.png';
            if ($request->hasFile('foto')) {
                $file = $request->foto;
                $nom_foto = time() . '_' . $nuevo_usuario->usuario . '.' . $file->getClientOriginalExtension();
                $nuevo_usuario->foto = $nom_foto;
                $file->move(public_path() . '/imgs/users/', $nom_foto);
            }
            $nuevo_usuario->save();

            $datos_original = HistorialAccion::getDetalleRegistro($nuevo_usuario, "users");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' REGISTRO UN USUARIO',
                'datos_original' => $datos_original,
                'modulo' => 'USUARIOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'usuario' => $nuevo_usuario,
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

    public function update(Request $request, User $usuario)
    {
        $this->validacion['ci'] = 'required|min:4|numeric|unique:users,ci,' . $usuario->id;
        if ($request->hasFile('foto')) {
            $this->validacion['foto'] = 'image|mimes:jpeg,jpg,png|max:2048';
        }

        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($usuario, "users");
            $usuario->update(array_map('mb_strtoupper', $request->except('foto')));

            if ($request->hasFile('foto')) {
                $antiguo = $usuario->foto;
                if ($antiguo != 'default.png') {
                    \File::delete(public_path() . '/imgs/users/' . $antiguo);
                }
                $file = $request->foto;
                $nom_foto = time() . '_' . $usuario->usuario . '.' . $file->getClientOriginalExtension();
                $usuario->foto = $nom_foto;
                $file->move(public_path() . '/imgs/users/', $nom_foto);
            }
            $usuario->save();

            $datos_nuevo = HistorialAccion::getDetalleRegistro($usuario, "users");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' MODIFICÓ UN USUARIO',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'USUARIOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'usuario' => $usuario,
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

    public function show(User $usuario)
    {
        return response()->JSON([
            'sw' => true,
            'usuario' => $usuario
        ], 200);
    }

    public function actualizaContrasenia(User $usuario, Request $request)
    {
        $request->validate([
            'password_actual' => ['required', function ($attribute, $value, $fail) use ($usuario, $request) {
                if (!\Hash::check($request->password_actual, $usuario->password)) {
                    return $fail(__('La contraseña no coincide con la actual.'));
                }
            }],
            'password' => 'required|confirmed|min:4',
            'password_confirmation' => 'required|min:4'
        ]);


        DB::beginTransaction();
        try {
            $usuario->password = Hash::make($request->password);
            $usuario->save();
            DB::commit();
            return response()->JSON([
                'sw' => true,
                'msj' => 'La contraseña se actualizó correctamente'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function actualizaFoto(User $usuario, Request $request)
    {
        DB::beginTransaction();
        try {

            if ($request->hasFile('foto')) {
                $antiguo = $usuario->foto;
                if ($antiguo != 'default.png') {
                    \File::delete(public_path() . '/imgs/users/' . $antiguo);
                }
                $file = $request->foto;
                $nom_foto = time() . '_' . $usuario->usuario . '.' . $file->getClientOriginalExtension();
                $usuario->foto = $nom_foto;
                $file->move(public_path() . '/imgs/users/', $nom_foto);
            }
            $usuario->save();
            DB::commit();
            return response()->JSON([
                'sw' => true,
                'usuario' => $usuario,
                'msj' => 'Foto actualizada con éxito'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(User $usuario)
    {
        DB::beginTransaction();
        try {
            $antiguo = $usuario->foto;
            if ($antiguo != 'default.png') {
                \File::delete(public_path() . '/imgs/users/' . $antiguo);
            }
            $datos_original = HistorialAccion::getDetalleRegistro($usuario, "users");
            $usuario->delete();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' ELIMINÓ UN USUARIO',
                'datos_original' => $datos_original,
                'modulo' => 'USUARIOS',
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

    public function getPermisos(User $usuario)
    {
        $tipo = $usuario->tipo;
        return response()->JSON($this->permisos[$tipo]);
    }

    public function getInfoBox()
    {
        $tipo = Auth::user()->tipo;
        $array_infos = [];
        if (in_array('prestamo_documentos.index', $this->permisos[$tipo])) {
            $prestamo_documentos = [];
            if ($tipo == 'FUNCIONARIO') {
                $prestamo_documentos = PrestamoDocumento::where("funcionario_id", Auth::user()->funcionario->id)->where("estado", 1)->get();
            } else {
                $prestamo_documentos = PrestamoDocumento::all();
            }

            $array_infos[] = [
                'label' => 'Préstamos',
                'cantidad' => count($prestamo_documentos),
                'color' => 'bg-success',
                'icon' => asset("imgs/icon_inscripcion.png"),
                // "url" => "prestamo_documentos.index",
                "url" => ""
            ];
        }
        if (in_array('devolucion_documentos.index', $this->permisos[$tipo])) {
            $devolucion_documentos = DevolucionDocumento::all();
            $array_infos[] = [
                'label' => 'Devoluciones',
                'cantidad' => count($devolucion_documentos),
                'color' => 'bg-success',
                'icon' => asset("imgs/checklist.png"),
                // "url" => "devolucion_documentos.index",
                "url" => ""
            ];
        }
        if (in_array('dependencias.index', $this->permisos[$tipo])) {
            $dependencias = Dependencia::all();
            $array_infos[] = [
                'label' => 'Dependencias',
                'cantidad' => count($dependencias),
                'color' => 'bg-success',
                'icon' => asset("imgs/icon_solicitud.png"),
                "url" => "dependencias.index"
            ];
        }
        if (in_array('estantes.index', $this->permisos[$tipo])) {
            $estantes = Estante::all();
            $array_infos[] = [
                'label' => 'Estantes',
                'cantidad' => count($estantes),
                'color' => 'bg-success',
                'icon' => asset("imgs/icon_recursos.png"),
                "url" => "estantes.index"
            ];
        }
        if (in_array('documentos.index', $this->permisos[$tipo])) {
            $documentos = Documento::all();
            $array_infos[] = [
                'label' => 'Documentos',
                'cantidad' => count($documentos),
                'color' => 'bg-success',
                'icon' => asset("imgs/documents.png"),
                "url" => "documentos.index"
            ];
        }

        if (in_array('usuarios.index', $this->permisos[$tipo])) {
            $array_infos[] = [
                'label' => 'Usuarios',
                'cantidad' => count(User::where('id', '!=', 1)->get()),
                'color' => 'bg-success',
                'icon' => asset("imgs/people.png"),
                "url" => "usuarios.index"
            ];
        }
        return response()->JSON($array_infos);
    }

    public function userActual()
    {
        return response()->JSON(Auth::user());
    }

    public function getUsuario(User $usuario)
    {
        return response()->JSON($usuario);
    }

    public function getUsuarioTipo(Request $request)
    {
        $tipo = $request->tipo;
        $usuarios = [];
        if ($tipo != "todos") {
            if (is_array($tipo)) {
                $usuarios = User::where("id", "!=", 1)->whereIn("tipo", $tipo)->get();
            } else {
                $usuarios = User::where("id", "!=", 1)->where("tipo", $tipo)->get();
            }
        } else {
            $usuarios = User::where("id", "!=", 1)->get();
        }
        return response()->JSON($usuarios);
    }

    public function updatePassword(User $usuario, Request $request)
    {
        $usuario->password = Hash::make($request->password);
        $usuario->save();

        return response()->JSON([
            "sw" => true,
            "message" => "Contraseña actualizada con éxito"
        ]);
    }
}
