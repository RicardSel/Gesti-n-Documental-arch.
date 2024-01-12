<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "codigo",
        "gestion_ingreso",
        "tipo_ingreso",
        "fecha_baja",
        "fecha_item",
        "descripcion",
        "observaciones",
        "fecha_registro",
    ];

    protected $appends = ['full_name', "full_ci", "path_image", "fecha_registro_t"];

    public function getFechaRegistroTAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha_registro));
    }
    
    public function getFullNameAttribute()
    {
        return $this->user->nombre . ' ' . $this->user->paterno . ($this->user->materno != NULL && $this->user->materno != '' ? ' ' . $this->user->materno : '');
    }

    public function getFullCiAttribute()
    {
        return $this->user->ci . ' ' . $this->user->ci_exp;
    }

    public function getPathImageAttribute()
    {
        if ($this->user->foto && trim($this->user->foto) != "") {
            return asset('imgs/users/' . $this->user->foto);
        }
        return asset('imgs/users/default.png');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
