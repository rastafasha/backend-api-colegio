<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sliders extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        "user_id",
        'title',
        'description',
        'is_activeText',
        'is_activeBot',
        'boton',
        'enlace',
        'target',
        'is_active',
        'avatar',
        'imagemovil',
    ];

    public function doctor() {
        return $this->belongsTo(User::class,"user_id");
    }
}
