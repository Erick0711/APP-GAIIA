<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Deuda;
use App\Models\Persona;
use App\Models\Cargo;


class Socio extends Model
{
    use HasFactory;

    protected $table = 'socio';
    protected $fillable = ['id_persona', 'id_cargo', 'fecha_ingreso_soc'];

    public function persona()
    {
        return $this->hasOne(Persona::class, 'id', 'id_persona');
    }

    public function cargo()
    {
        return $this->hasOne(Cargo::class, 'id', 'id_cargo');
    }
    
    public function deudas()
    {
        return $this->hasMany(Deuda::class, "id" ,'id_socio');
    }
}
