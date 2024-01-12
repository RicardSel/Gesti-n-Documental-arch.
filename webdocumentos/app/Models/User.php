<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "usuario", "nombre", "paterno", "materno", "ci", "ci_exp", "fecha_nac",
        "genero", "cargo", "fecha_ingreso", "taller", "dir", "fono",
        "tipo_personal", "p_discapacidad", "tipo", "foto", "validez_credencial",
        "password", "estado", "fecha_registro", "acceso"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    protected $appends = ['full_name', 'full_name_abre', 'full_ci', 'path_image', "fecha_registro_t"];

    public function getFechaRegistroTAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha_registro));
    }

    public static function getNombreUsuario($nom, $apep)
    {
        //determinando el nombre de usuario inicial del 1er_nombre+apep+tipoUser
        $nombre_user = substr(mb_strtoupper($nom), 0, 1); //inicial 1er_nombre
        $nombre_user .= mb_strtoupper($apep);

        return $nombre_user;
    }

    public function getFullNameAttribute()
    {
        return $this->nombre . ' ' . $this->paterno . ($this->materno != NULL && $this->materno != '' ? ' ' . $this->materno : '');
    }

    public function getFullNameAbreAttribute()
    {
        $nombre_completo = $this->nombre . ' ' . $this->paterno . ($this->materno != NULL && $this->materno != '' ? ' ' . $this->materno : '');

        $nombre = $this->nombre;
        $paterno = $this->paterno;
        $materno = ($this->materno != NULL && $this->materno != '' ? ' ' . $this->materno : '');
        $nombre_completo = $nombre . ' ' . $paterno . ($materno != '' ? ' ' . $materno : '');
        if (strlen($nombre_completo) > 25) {
            $array_nombre = explode(" ", $nombre);
            if (count($array_nombre) > 1) {
                $nombre = $array_nombre[0] . ' ' .  substr($array_nombre[1], 0, 1) . '.';
            }
        }
        $nombre_completo = $nombre . ' ' . $paterno . ($materno != '' ? ' ' . $materno : '');
        if (strlen($nombre_completo) > 26) {
            if (strlen($materno) > 1) {
                $materno = substr($this->materno, 0, 1) . '.';
            }
        }
        $nombre_completo = $nombre . ' ' . $paterno . ($materno != '' ? ' ' . $materno : '');
        return $nombre_completo;
    }

    public function getFullCiAttribute()
    {
        return $this->ci . ' ' . $this->ci_exp;
    }

    public function getPathImageAttribute()
    {
        if ($this->foto && trim($this->foto) != "") {
            return asset('imgs/users/' . $this->foto);
        }
        return asset('imgs/users/default.png');
    }

    public function funcionario()
    {
        return $this->hasOne(Funcionario::class, 'user_id');
    }
}
