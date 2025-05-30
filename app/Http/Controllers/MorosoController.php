<?php

namespace App\Http\Controllers;

use App\Models\Moroso;
use Illuminate\Http\Request;

class MorosoController extends Controller
{
    /**
     * Get debtors (parent_id and student_id) for the current month and year with unpaid status.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDebtorsForCurrentMonth()
    {
        $currentMonth = date('m');
        $currentYear = date('Y');

        return Moroso::where('month', $currentMonth)
            ->where('year', $currentYear)
            ->where('status', 'unpaid')
            ->get(['parent_id', 'student_id']);
    }

    /**
     * Display a listing of debtors (parent_id and student_id) for the current month.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $debtors = $this->getDebtorsForCurrentMonth();

        return response()->json([
            'debtors' => $debtors,
        ]);
    }
}
