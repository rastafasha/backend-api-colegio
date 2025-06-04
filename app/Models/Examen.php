<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Examen extends Model
{
    use HasFactory;

    protected $table = 'examenes';

    protected $fillable = [
        'student_id',
        'user_id',
        'materia_id',
        'title',
        'exam_date',
        'puntaje',
        'puntaje_letra',
    ];

    protected static function booted()
    {
        static::created(function ($examen) {
            $examen->updateCalificacion();
        });

        static::updated(function ($examen) {
            $examen->updateCalificacion();
        });
    }

    public function updateCalificacion()
    {
        $totalPuntaje = self::where('student_id', $this->student_id)
            ->where('materia_id', $this->materia_id)
            ->sum('puntaje');

        $calificacion = \App\Models\Calificacion::firstOrNew([
            'student_id' => $this->student_id,
            'materia_id' => $this->materia_id,
        ]);

        $calificacion->grade = $totalPuntaje;
        $calificacion->save();
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function maestro()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public static function search($query = ''){
        if(!$query){
            return self::all();
        }
        return self::where('puntaje', 'like', "%$query%")
         ->orWhere('title', 'like', "%$query%")
         ->orWhere('exam_date', 'like', "%$query%")
         ->orWhere('materia_id', 'like', "%$query%")
         ->orWhere('student_id', 'like', "%$query%")
         ->orWhere('user_id', 'like', "%$query%")
        ->get();
    }
}
