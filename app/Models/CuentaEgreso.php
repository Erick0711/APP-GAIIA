<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaEgreso extends Model
{
    use HasFactory;
    protected $table = "gasto";
    protected $fillable = ["id_articulo", "id_cuenta_bancaria","id_gestion", "id_tipopago", "monto_gasto","nro_recibo","nro_recibo_tesorera","observacion","fecha_gasto","id_usuario"];
}
