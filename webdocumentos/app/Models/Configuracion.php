<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_sistema', 'alias', 'razon_social', 'ciudad', 'dir',
        'fono', 'web', 'actividad', 'correo', 'correo_pedido', 'correo_pedido2', 'logo',
    ];

    protected $appends = ['path_image'];
    public function getPathImageAttribute()
    {
        return asset('imgs/' . $this->logo);
    }
}
