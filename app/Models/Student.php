<?php

namespace App\Models;

use App\Models\Payment;
use App\Models\Representante;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
     protected $fillable=[
        'name',
        'surname',
        'n_doc',
        'birth_date',
        'gender',
        'avatar',
        'school_year',
        'parent_id',
        'section',
        'matricula',
        'user_id',
    ];


    public function parent()
    {
        return $this->belongsTo(Representante::class, 'parent_id');
    }

    public function maestro()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function maestros()
    {
        return $this->hasMany(User::class, 'user_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public static function search($query = ''){
        if(!$query){
            return self::all();
        }
        return self::where('name', 'like', "%$query%")
         ->orWhere('surname', 'like', "%$query%")
         ->orWhere('n_doc', 'like', "%$query%")
         ->orWhere('school_year', 'like', "%$query%")
        ->orWhere('section', 'like', "%$query%")
        ->orWhere('matricula', 'like', "%$query%")
        ->orWhere('gender', 'like', "%$query%")
        ->get();
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }
}
