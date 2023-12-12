<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    protected $table = "pago";
    protected $fillable = ["id_socio" ,"id_gestion", "id_articulo", "id_cuenta_bancaria", "monto_pago","nro_recibo","nro_recibo_tesorera","id_tipopago", "observacion", "fecha_pago", "id_deuda" ,"id_usuario"];
    
    public function socio()
    {
        return $this->belongsTo(Socio::class, 'id_socio', 'id');
    }

    public function articulo(){
        return $this->belongsTo(Articulo::class, 'id_articulo', 'id');
    }
}
