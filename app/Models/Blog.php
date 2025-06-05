<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        "user_id",
        'title',
        'description',
        'author',
        'is_active',
        'avatar',
        'slug',
        'favorite_id',
        'is_featured',
        'category_id',

    ];

    public function author() {
        return $this->belongsTo(User::class,"user_id");
    }

    

    public function category(){
        return $this->belongsTo(Category::class);
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
        return self::where('title', 'like', "%$query%")
        ->orWhere('description', 'like', "%$query%")
        ->get();
    }
}
