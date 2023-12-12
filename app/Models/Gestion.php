<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    use HasFactory;
    protected $table = "gestion";
    protected $fillable = ["numero_gest", "anio_gest"];

    public function deuda()
    {
        return $this->belongsToMany(Deuda::class, 'id_gestion');
    }

}
