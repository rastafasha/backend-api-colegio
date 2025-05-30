<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Payment;
use App\Helpers\Uploader;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Representante;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Appointment\Payment\PaymentResource;
use App\Http\Resources\Appointment\Payment\PaymentCollection;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnrollmentNotificationMail;
use Carbon\Carbon;

class AdminPaymentController extends Controller
{
    // /**
    //  * Create a new AuthController instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('jwt.verify');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $metodo = $request->metodo;
        $search_referencia = $request->search_referencia;
        $bank_name = $request->bank_name;
        $nombre = $request->nombre;
        $monto = $request->monto;
        $fecha = $request->fecha;


        $payments = Payment::filterAdvancePayment($search_referencia)->orderBy("id", "desc")
                            ->paginate(100);
                    
        return response()->json([
            "total"=>$payments->total(),
            "payments" => $payments ,
            // "payments" => PaymentCollection::make($payments) ,
            
        ]);  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paymentStore(Request $request)
    {
        // Sanitize 'monto' to remove commas and convert to float
        if ($request->has('monto')) {
            $monto = str_replace(',', '', $request->input('monto'));
            $request->merge(['monto' => (float)$monto]);
        }

        if($request->hasFile('imagen')){
            $path = Storage::putFile("payments", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }

        $payment = Payment::create($request->all());

        // Check if payment amount equals student's matricula amount
        $student = $payment->student;
        if ($student && $payment->monto == $student->matricula) {
            $payment->status_deuda = 'PAID';
            $payment->save();
        }

        return response()->json([
            "message"=>200,
            "payment"=>$payment,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function paymentShow(Payment $payment)
    {
       

        if (!$payment) {
            return response()->json([
                'message' => 'Pago not found.'
            ], 404);
        }
        


        return response()->json([
            'code' => 200,
            'status' => 'success',
            // "payment" => PaymentResource::make($payment),
            "payment" => $payment,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function paymentUpdate(Payment $request,  $id)
    {
        try {
            DB::beginTransaction();

            $request = $request->all();
            $payment = Payment::find($id);
            $payment->update($request->all());


            DB::commit();
            return response()->json([
                'code' => 200,
                'status' => 'Update payment success',
                'payment' => $payment,
            ], 200);
        } catch (\Throwable $exception) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error no update'  . $exception,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function paymentDestroy(Payment $payment)
    {
        $this->authorize('paymentDestroy', Payment::class);

        try {
            DB::beginTransaction();

            if ($payment->image) {
                Uploader::removeFile("public/payments", $payment->image);
            }

            $payment->delete();

            DB::commit();
            return response()->json([
                'code' => 200,
                'status' => 'Pago delete',
            ], 200);
        } catch (\Throwable $exception) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Borrado fallido. Conflicto',
            ], 409);
        }
    }

    protected function paymentInput(string $file = null): array
    {
        return [
            "referencia" => request("referencia"),
            "metodo" => request("metodo"),
            "bank_name" => request("bank_name"),
            "monto" => request("monto"),
            "validacion" => request("validacion"),
            "currency_id" => request("currency_id"),
            "nombre" => request("nombre"),
            "email" => request("email"),
            "user_id" => request("user_id"),
            "plan_id" => request("plan_id"),
            "status" => request("status"),
            "image" => $file,
        ];
    }

    protected function paymentInputUpdate(string $file = null): array
    {
        return [
            "validacion" => request("validacion"),
            "status" => request("status"),
        ];
    }

    public function recientes()
    {
        $payments = Payment::orderBy('created_at', 'DESC')
        ->paginate(10);
        // ->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'payments' => $payments
        ], 200);
    }


     public function deleteFotoPayment($id)
     {
         $payment = Payment::findOrFail($id);
         \Storage::delete('payments/' . $payment->image);
         $payment->image = '';
         $payment->save();
         return response()->json([
             'data' => $payment,
             'msg' => [
                 'summary' => 'Archivo eliminado',
                 'detail' => '',
                 'code' => ''
             ]
         ]);
     }

     public function search(Request $request){
        return Payment::search($request->buscar);
    }




    public function updateStatus(Request $request, $id)
    {
        $payment = Payment::findOrfail($id);
        $payment->status = $request->status;

        if ($request->status === 'REJECTED') {
            $payment->status_deuda = 'DEUDA';
        }
        if ($request->status === 'APPROVED') {
            $payment->status_deuda = 'PAID';
        }

        $payment->update();
        return $payment;
    }


    public function pagosbyUser(Request $request, $parent_id)
    {
        
        $payments = Payment::where("parent_id", $parent_id)
        ->orderBy('created_at', 'DESC')
        ->with('student')
        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            // "payments" => PaymentCollection::make($payments),
            "payments" => $payments,
        ], 200);
    }

    public function pagosPendientes()
    {
        
        $payments = Payment::where('status', 'PENDING')->orderBy("id", "desc")
                            ->paginate(10);
        return response()->json([
            "total"=>$payments->total(),
            "payments"=> PaymentCollection::make($payments)
        ]);

    }

    public function pagosPendientesbyParent(Request $request, $parent_id)
    {
        $payments = Payment::where("parent_id", $parent_id)
            ->where(function ($query) {
                $query->where('status_deuda', '!=', 'PAID')
                      ->orWhere('status', 'PENDING');
            })
            ->whereHas('student', function ($query) {
                $query->whereColumn('payments.monto', '<', 'matricula');
            })
            ->orderBy("id", "desc")
            ->with('student')
            ->paginate(10);

        return response()->json([
            "total" => $payments->total(),
            "payments" => $payments,
        ]);
    }
    

    /**
     * Send enrollment notification emails to representatives at the end and beginning of the month.
     */
    public function sendEnrollmentNotificationEmails()
    {
        $now = Carbon::now();
        $day = $now->day;

        // Only proceed if today is between 28-31 or 1-3 of the month
        if (($day >= 28 && $day <= 31) || ($day >= 1 && $day <= 3)) {
            // Find students with pending enrollment payments or relevant criteria
            $students = \App\Models\Student::whereHas('payments', function ($query) {
                $query->where('status_deuda', '!=', 'PAID');
            })->get();

            foreach ($students as $student) {
                $parent = $student->parent;
                if ($parent && $parent->email) {
                    Mail::to($parent->email)->send(new EnrollmentNotificationMail($student));
                }
            }

            return response()->json([
                'message' => 'Enrollment notification emails sent successfully.',
                'date' => $now->toDateString(),
            ]);
        } else {
            return response()->json([
                'message' => 'Today is not within the notification period.',
                'date' => $now->toDateString(),
            ]);
        }
    }

    /**
     * Check if the representative (parent) and student have debt and the amount.
     *
     * @param int $parent_id
     * @param int $student_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkDebtStatusByParent($parent_id)
    {
        // Sum unpaid payments for the representative (parent)
        $parentDebt = Payment::where('parent_id', $parent_id)
            ->where(function ($query) {
                $query->where('status_deuda', '!=', 'PAID')
                      ->orWhere('status', 'PENDING');
            })
            ->sum('monto');

        // Get students with debt and their debt details
        $studentsWithDebt = Payment::select('student_id', DB::raw('SUM(monto) as total_debt'), DB::raw('MIN(created_at) as earliest_debt_date'))
            ->where('parent_id', $parent_id)
            ->where(function ($query) {
                $query->where('status_deuda', '!=', 'PAID')
                      ->orWhere('status', 'PENDING');
            })
            ->groupBy('student_id')
            ->with('student:id,name,matricula') // assuming student has 'name' attribute
            ->get();

        $studentsDebtDetails = $studentsWithDebt->map(function ($item) {
            return [
                'student_id' => $item->student_id,
                'student_name' => $item->student ? $item->student->name : null,
                'matricula' => $item->student ? $item->student->matricula : null,
                'debt_amount' => $item->total_debt,
                'earliest_debt_date' => $item->earliest_debt_date,
            ];
        });

        return response()->json([
            'parent_id' => $parent_id,
            'parent_has_debt' => $parentDebt > 0,
            'parent_debt_amount' => $parentDebt,
            'students_with_debt' => $studentsDebtDetails,
        ]);
    }
    public function checkDebtStatus($parent_id, $student_id)
    {
        // Sum unpaid payments for the representative (parent)
        $parentDebt = Payment::where('parent_id', $parent_id)
            ->where(function ($query) {
                $query->where('status_deuda', '!=', 'PAID')
                      ->orWhere('status', 'PENDING');
            })
            ->sum('monto');

        // Sum unpaid payments for the student
        $studentDebt = Payment::where('student_id', $student_id)
            ->where(function ($query) {
                $query->where('status_deuda', '!=', 'PAID')
                      ->orWhere('status', 'PENDING');
            })
            ->sum('monto');

        return response()->json([
            'parent_id' => $parent_id,
            'student_id' => $student_id,
            'parent_has_debt' => $parentDebt > 0,
            'parent_debt_amount' => $parentDebt,
            'student_has_debt' => $studentDebt > 0,
            'student_debt_amount' => $studentDebt,
        ]);
    }

    /**
     * View the debt of each student for a given parent (representative).
     *
     * @param int $parent_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function viewDebtByParent($parent_id)
    {
        // Get students of the parent with their total debt amount
        $studentsWithDebt = Payment::select('student_id', DB::raw('SUM(monto) as total_debt'))
            ->where('parent_id', $parent_id)
            ->where(function ($query) {
                $query->where('status_deuda', '!=', 'PAID')
                ->where('status',  'REJECTED')
                      ->orWhere('status', 'PENDING');
            })
            ->groupBy('student_id')
            ->with('student:id,name,matricula') // assuming student has 'name' attribute
            ->get();

        $studentsDebtDetails = $studentsWithDebt->map(function ($item) {
            return [
                'student_id' => $item->student_id,
                'student_name' => $item->student ? $item->student->name : null,
                'matricula' => $item->student ? $item->student->matricula : null,
                'debt_amount' => $item->total_debt,
            ];
        });

        return response()->json([
            'parent_id' => $parent_id,
            'students_with_debt' => $studentsDebtDetails,
        ]);
    }

    /**
     * Pay the debt for a student under a parent.
     * Creates a payment and updates status_deuda to PAID if amount equals debt.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $parent_id
     * @param int $student_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function payDebtForStudent(Request $request, $parent_id, $student_id)
    {
        $monto = $request->input('monto');
        if (!is_numeric($monto) || $monto <= 0) {
            return response()->json(['error' => 'Invalid payment amount'], 400);
        }

         if($request->hasFile('imagen')){
            $path = Storage::putFile("payments", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }


        // Calculate current debt for the student under the parent
        $currentDebt = Payment::where('parent_id', $parent_id)
            ->where('student_id', $student_id)
            ->where(function ($query) {
                $query->where('status_deuda', '!=', 'PAID')
                      ->orWhere('status', 'PENDING');
            })
            ->sum('monto');

        if ($monto > $currentDebt) {
            return response()->json(['error' => 'Payment amount exceeds current debt'], 400);
        }

        // Create new payment record
        $payment = new Payment();
        $payment->parent_id = $parent_id;
        $payment->student_id = $student_id;
        $payment->monto = $monto;
        $payment->status_deuda = ($monto == $currentDebt) ? 'PAID' : 'PENDING';
        // $payment->status = 'PAID'; // Assuming payment status is PAID when payment is made
        $payment->metodo = $request->metodo;
        $payment->referencia = $request->referencia;
        $payment->bank_name = $request->bank_name;
        $payment->bank_destino = $request->bank_destino;
        $payment->nombre = $request->nombre;
        $payment->email = $request->email;
        $payment->status = $request->status;
        $payment->avatar = $request->avatar;
        $payment->save();

        // Update existing unpaid debts by applying the payment amount
        $remainingAmount = $monto;
        $unpaidDebts = Payment::where('parent_id', $parent_id)
            ->where('student_id', $student_id)
            ->where(function ($query) {
                $query->where('status_deuda', '!=', 'PAID')
                      ->orWhere('status', 'PENDING');
            })
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($unpaidDebts as $debt) {
            if ($remainingAmount <= 0) {
                break;
            }

            if ($debt->monto <= $remainingAmount) {
                // Mark this debt as paid
                $debt->status_deuda = 'PAID';
                $debt->status = 'APPROVED';
                $remainingAmount -= $debt->monto;
            } else {
                // Partial payment: reduce the debt amount
                $debt->monto -= $remainingAmount;
                $remainingAmount = 0;
            }
            $debt->save();
        }

        return response()->json([
            'message' => 'Payment recorded successfully and debt updated',
            'payment' => $payment,
        ]);
    }
}
