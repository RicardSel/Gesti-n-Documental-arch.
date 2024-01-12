<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestamoDocumento extends Model
{
    use HasFactory;

    protected $fillable = [
        "documento_id",
        "funcionario_id",
        "tipo_documento",
        "cantidad_documentos",
        "fecha",
        "hora",
        "dependencia_id",
        "descripcion",
        "observacion",
        "fecha_registro",
        "estado"
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

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class, 'dependencia_id');
    }
}
