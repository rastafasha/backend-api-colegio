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
    ];


    public function parent()
    {
        return $this->belongsTo(Representante::class, 'parent_id');
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
        
        ->get();
    }
}
