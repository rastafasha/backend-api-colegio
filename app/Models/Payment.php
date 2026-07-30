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

public function scopeFilterAdvancePayment($query, array $filters)
{
    // Limpieza de espacios vacíos y búsquedas condicionales rápidas
    if (!empty(trim($filters['search_referencia']))) {
        $query->where("referencia", "LIKE", "%" . trim($filters['search_referencia']) . "%");
    }
    if (!empty(trim($filters['metodo']))) {
        $query->where("metodo", trim($filters['metodo']));
    }
    if (!empty(trim($filters['bank_name']))) {
        $query->where("bank_name", trim($filters['bank_name']));
    }
    if (!empty(trim($filters['bank_destino']))) {
        $query->where("bank_destino", trim($filters['bank_destino']));
    }
    if (!empty(trim($filters['nombre']))) {
        $query->where("nombre", "LIKE", "%" . trim($filters['nombre']) . "%");
    }
    if (!empty($filters['monto'])) {
        $query->where("monto", $filters['monto']);
    }
    if (!empty($filters['fecha'])) {
        $query->whereDate("fecha", $filters['fecha']); // Corrección para ignorar la hora en búsquedas de fecha
    }
    if (!empty($filters['deuda'])) {
        $query->where("deuda", $filters['deuda']);
    }
    if (!empty(trim($filters['status_deuda']))) {
        $query->where("status_deuda", trim($filters['status_deuda']));
    }
    if (!empty(trim($filters['status']))) {
        $query->where("status", trim($filters['status']));
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
