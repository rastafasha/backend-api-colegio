<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Materia extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }
}
