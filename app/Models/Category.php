<?php

namespace App\Models;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [

        'name'

    ];
     /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

      /*
    |--------------------------------------------------------------------------
    | search
    |--------------------------------------------------------------------------
    */
    public static function search($query = ''){
        if(!$query){
            return self::all();
        }
        return self::where('name', 'like', "%$query%")
        ->get();
    }
}
