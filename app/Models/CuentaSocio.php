<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaSocio extends Model
{
    use HasFactory;
    protected $table = "cuenta_socio";
    protected $fillable = ['id_socio', 'id_cuenta_bancaria', 'id_articulo', 'id_gestion', 'monto'];
}
