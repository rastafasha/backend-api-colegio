<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moroso extends Model
{
    use HasFactory;

    protected $table = 'morosos';

    protected $fillable = [
        'parent_id',
        'student_id',
        'month',
        'year',
        'amount_due',
        'amount_paid',
        'status',
    ];

    /**
     * Get the parent (representante) associated with the moroso record.
     */
    public function parent()
    {
        return $this->belongsTo(Representante::class, 'parent_id');
    }

    /**
     * Get the student associated with the moroso record.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Get debtors (parent_id and student_id) for the current month and year with unpaid status.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getDebtorsForCurrentMonth()
    {
        $currentMonth = date('m');
        $currentYear = date('Y');

        return self::where('month', $currentMonth)
            ->where('year', $currentYear)
            ->where('status', 'unpaid')
            ->get(['parent_id', 'student_id']);
    }
}
