<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCarta extends Model
{
    protected $table = 'tipos_cartas';

    use HasFactory;
    protected $fillable = ['nombre', 'descripcion'];
}
