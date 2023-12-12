<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cobranza extends Model
{
    use HasFactory;
    protected $table = 'cobranza';
    protected $fillable = ['id_socio', 'id_tipocobranza', 'id_articulo'];
}
