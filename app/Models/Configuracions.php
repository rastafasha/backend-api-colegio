<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Configuracions extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', //string
        'direccion', //text
        'email', //string
        'redessociales', //json
        'telefono', //string
        'telefonoActivo', //boolean
        'telPresidencia', //string
        'telPresActivo',//boolean
        'telSecretaria',//string
        'telSecActivo',//boolean
        'avatar',//string
    ];

   
}
