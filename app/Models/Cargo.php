<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Socio;

class Cargo extends Model
{
    use HasFactory;
    protected $table = 'cargo';
    protected $fillable = ['nombre_carg'];

    public function socio()
    {
        return $this->belongsTo(Socio::class, 'id_cargo');
    }
}
