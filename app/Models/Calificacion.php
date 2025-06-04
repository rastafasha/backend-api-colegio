<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = 'calificaciones';

    protected $fillable = [
        'student_id',
        'materia_id',
        'grade',
        'semestre',
        'anio_escolar',
    ];


    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public static function search($query = ''){
        if(!$query){
            return self::all();
        }
        return self::where('semestre', 'like', "%$query%")
         ->orWhere('anio_escolar', 'like', "%$query%")
         ->orWhere('materia_id', 'like', "%$query%")
         ->orWhere('student_id', 'like', "%$query%")
        ->get();
    }

}
