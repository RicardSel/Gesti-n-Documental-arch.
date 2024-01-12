<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjuntarDocumento extends Model
{
    use HasFactory;

    protected $fillable = [
        "documento_id",
        "archivo",
        "tipo",
        "ext",
    ];


    protected $appends = ["url"];

    public function getUrlAttribute()
    {
        return asset("files/" . $this->archivo);
    }

    public function documento()
    {
        return $this->belongsTo(Documento::class, 'documento_id');
    }
}
