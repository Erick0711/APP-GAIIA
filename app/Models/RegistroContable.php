<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroContable extends Model
{
    use HasFactory;
    protected $table = "registro_contable";
    protected $fillable = ['id_cuentabancaria', 'id_cuentacontable', 'id_gestion', 'nro_registro_contable'];
}
