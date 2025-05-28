<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Configuracions extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'direccion', 
        'telefono', 
        'telefonoActivo', 
        'telPresidencia', 
        'telPresActivo',
        'telSecretaria',
        'telSecActivo',
        'telTesoreria',
        'telTesActivo',
    ];

    public function doctor() {
        return $this->belongsTo(User::class,"user_id");
    }
}
