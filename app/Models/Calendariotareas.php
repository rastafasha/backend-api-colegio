<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendariotareas extends Model
{
    use HasFactory;
     protected $table = 'calendariotareas';

    protected $fillable = [
        'student_id',
        'user_id',
        'title',
        'description',
        'fecha_entrega',
        'status',
    ];


    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function maestro()
    {
        return $this->belongsTo(User::class);
    }

    public static function search($query = ''){
        if(!$query){
            return self::all();
        }
        return self::where('title', 'like', "%$query%")
        ->orWhere('description', 'like', "%$query%")
        ->orWhere('fecha_entrega', 'like', "%$query%")
        ->orWhere('status', 'like', "%$query%")
        ->orWhere('user_id', 'like', "%$query%")
        ->get();
    }
}
