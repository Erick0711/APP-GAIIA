<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $table = 'persona';
    protected $fillable = ['nombre_pers', 'apellido_pers', 'ci_pers', 'complemento_pers', 'correo_pers', 'fecha_nac_pers' ,'telefono_pers', 'telefono2_pers'];

    public function socio()
    {
        return $this->belongsTo(Socio::class, 'id_persona');
    }
}
