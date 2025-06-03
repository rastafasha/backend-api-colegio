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
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }
}
