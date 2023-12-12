<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaContable extends Model
{
    use HasFactory;
    protected $table = "cuenta_contable";
    protected  $fillable = ["id_cuenta_contable", "nombre_cuenta"];
}
