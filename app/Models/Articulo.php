<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Deuda;

class Articulo extends Model
{
    use HasFactory;
    protected $table = "articulo_pago";
    protected $fillable = ['id_cuenta_contable','nombre_art','id_gestion','monto_art'];

    public function deuda(){
        return $this->belongsToMany(Deuda::class, "id", "id_deuda");
    }
    public function gestion()
    {
        return $this->belongsTo(Gestion::class, 'id_gestion');
    }
}
