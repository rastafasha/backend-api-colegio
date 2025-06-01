<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Student;
use App\Jobs\PaymentRegisterJob;
use App\Mail\NewPaymentRegisterMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Appointment\Appointment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | goblan variables
    |--------------------------------------------------------------------------
    */
    protected $fillable = [

        'referencia',
        'metodo',
        'bank_name',
        'bank_destino',
        'monto',
        'nombre',
        'email',
        'parent_id',
        'student_id',
        'avatar',
        'fecha',
        'status',
        'deuda',
        'monto_pendiente',
        'status_deuda'
    ];

    const APPROVED = 'APPROVED';
    const PENDING = 'PENDING';
    const REJECTED = 'REJECTED';

    /*
    |--------------------------------------------------------------------------
    | functions
    |--------------------------------------------------------------------------
    */

    //recibe todos los pagos al correo 
    // protected static function boot(){

    //     parent::boot();

    //     static::created(function($payment){

    //         // PaymentRegisterJob::dispatch(
    //         //     $user
    //         // )->onQueue("high");

    //     Mail::to('mercadocreativo@gmail.com')->send(new NewPaymentRegisterMail($payment));

    //     });


    // }

    public static function statusTypes()
    {
        return [
            self::APPROVED, self::PENDING, self::REJECTED
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function users()
    {
        return $this->belongsTo(User::class, 'id');
    }

    
    public function parents()
    {
        return $this->belongsTo(Representante::class, 'parent_id');
    }
    public function parent()
    {
        return $this->belongsTo(Representante::class, 'parent_id');
    }
    public function students()
    {
        return $this->hasMany(Student::class, 'student_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }


    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */


    public function scopefilterAdvancePayment($query,
    $metodo, 
    $search_referencia,
    $bank_name,
    $bank_destino,
    $nombre,
    $monto,
    $fecha,
           $deuda,
$status_deuda,
$status
    ){
        
        
        if($search_referencia){
            $query->where("referencia", $search_referencia);
        }
        if($metodo){
            $query->where("metodo", $metodo);
        }
        if($bank_name){
            $query->where("bank_name", $bank_name);
        }
        if($bank_destino){
            $query->where("bank_destino", $bank_destino);
        }
        
        if($nombre){
            $query->where("nombre", $nombre);
        }
        if($monto){
            $query->where("monto", $monto);
        }
        if($fecha){
            $query->where("fecha", $fecha);
        }
        if($deuda){
            $query->where("deuda", $deuda);
        }
        if($status_deuda){
            $query->where("status_deuda", $status_deuda);
        }
        if($status){
            $query->where("status", $status);
        }
        
        return $query;
    }

    public static function search($query = ''){
        if(!$query){
            return self::all();
        }
        return self::where('referencia', 'like', "%$query%")
        ->orWhere('metodo', 'like', "%$query%")
        ->orWhere('bank_name', 'like', "%$query%")
        ->orWhere('bank_destino', 'like', "%$query%")
        ->orWhere('nombre', 'like', "%$query%")
        ->orWhere('email', 'like', "%$query%")
        ->orWhere('monto', 'like', "%$query%")
        ->orWhere('fecha', 'like', "%$query%")
        ->orWhere('deuda', 'like', "%$query%")
        ->orWhere('status_deuda', 'like', "%$query%")
        ->orWhere('status', 'like', "%$query%")
        ->get();
    }
}
