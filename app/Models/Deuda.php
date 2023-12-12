<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deuda extends Model
{
    use HasFactory;
    protected $table = "deuda";
    protected $fillable = ["id_socio", "id_gestion", "id_articulo"];
    
    public function socio()
    {
        return $this->belongsTo(Socio::class, 'id_socio');
    }

    public function articulo(){
        return $this->hasOne(Articulo::class, "id", "id_articulo");
    }
    
    public function gestion(){
        return $this->hasOne(Gestion::class, "id", "id_gestion");
    }

}
