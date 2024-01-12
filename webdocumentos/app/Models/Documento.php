<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        "codigo",
        "descripcion",
        "dependencia_id",
        "funcionario_id",
        "oficina_id",
        "estante_id",
        "nivel",
        "division",
        "estado",
        "fecha",
        "hora",
        "fecha_registro",
    ];


    protected $appends = ['fecha_registro_t', 'fecha_hora_t', 'ultimo_prestamo', 'ultima_reserva'];

    public function getUltimoPrestamoAttribute()
    {
        $prestamo = PrestamoDocumento::where("documento_id", $this->id)->orderBy("id", "desc")->where("estado", 1)->get()->first();
        return $prestamo;
    }

    public function getUltimaReservaAttribute()
    {
        $reserva = ReservaDocumento::where("documento_id", $this->id)->orderBy("id", "desc")->where("estado", 1)->get()->first();
        return $reserva;
    }

    public function getFechaHoraTAttribute()
    {
        return date("d/m/Y H:i", strtotime($this->fecha . ' ' . $this->hora));
    }

    public function getFechaRegistroTAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha_registro));
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class, 'dependencia_id');
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'funcionario_id');
    }

    public function oficina()
    {
        return $this->belongsTo(Oficina::class, 'oficina_id');
    }

    public function estante()
    {
        return $this->belongsTo(Estante::class, 'estante_id');
    }

    public function adjuntar_documentos()
    {
        return $this->hasMany(AdjuntarDocumento::class, 'documento_id');
    }
}
