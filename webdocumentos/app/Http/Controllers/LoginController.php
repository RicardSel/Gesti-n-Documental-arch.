<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $usuario = $request->usuario;
        $password = $request->password;
        $res = Auth::attempt(['usuario' => $usuario, 'password' => $password]);
        if ($res) {
            $user = Auth::user();
            if ($user->acceso == 1) {
                return response()->JSON([
                    'user' => Auth::user(),
                ], 200);
            }
            Auth::logout();
            return response()->JSON([
                "message" => "El acceso a este usuario fue restringido"
            ], 401);
        }

        return response()->JSON([], 401);
    }

    public function logout()
    {
        Auth::logout();
        return response()->JSON(['code' => 204], 204);
    }
}
