<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevolucionDocumento extends Model
{
    use HasFactory;

    protected $fillable = [
        "documento_id",
        "funcionario_id",
        "cantidad_documentos",
        "fecha",
        "hora",
        "descripcion",
        "observacion",
        "fecha_registro",
    ];

    protected $appends = ['fecha_registro_t', 'fecha_hora_t'];

    public function getFechaHoraTAttribute()
    {
        return date("d/m/Y H:i", strtotime($this->fecha . ' ' . $this->hora));
    }

    public function getFechaRegistroTAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha_registro));
    }

    public function documento()
    {
        return $this->belongsTo(Documento::class, 'documento_id');
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'funcionario_id');
    }
}
