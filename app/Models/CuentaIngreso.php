<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaIngreso extends Model
{
    use HasFactory;
    protected $table = "gasto";
    protected $fillable = ["id_articulo", "id_gestion", "id_tipopago", "monto_gasto", "observacion","fecha_gasto","id_usuario"];
}
