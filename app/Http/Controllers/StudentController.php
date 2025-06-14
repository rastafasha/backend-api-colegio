<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Representante;
use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Student\StudentResource;
use App\Http\Resources\Student\StudentCollection;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $students = Student::orderBy("id", "desc")
        ->paginate(10);
                    
        return response()->json([
            "total" =>$students->total(),
            "students" => $students,
            // "students" => StudentCollection::make($students),
            
        ]);          
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile($id)
    {
        
        $student = App\Models\Student::findOrFail($id);
    
        return response()->json($student);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $student_is_valid = Student::where("n_doc", $request->n_doc)->first();

        if($student_is_valid){
            return response()->json([
                "message"=>403,
                "message_text"=> 'el paciente ya existe'
            ]);
        }

        if($request->hasFile('imagen')){
            $path = Storage::putFile("students", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }

        if($request->birth_date){
            $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->birth_date );
            $request->request->add(["birth_date" => Carbon::parse($date_clean)->format('Y-m-d h:i:s')]);
        }

        $student = Student::create($request->all());

        // Generate initial debt for the newly registered student
        app(\App\Http\Controllers\Admin\AdminPaymentController::class)->generateInitialDebtForStudent($student->id);

        $request->request->add([
            "student_id" =>$student->id
        ]);
        
        
        return response()->json([
            "message"=>200,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::find($id);

        return response()->json([
            // "student" => StudentResource::make($student),
            "student" => $student,
        ]);

       
    }

    public function studentbyParent(Request $request, $parent_id)
    {
        $parent = Representante::findOrFail($parent_id);
        $students = Student::where("parent_id", $parent_id)->orderBy('created_at', 'DESC')
        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'parent' => $parent,
            "students" => $students,
            // "students" => StudentCollection::make($students),
        ], 200);
    }

    public function paymentbyStudent(Request $request, $student_id)
    {
        $student = Student::findOrFail($student_id);
        $payments = Payment::where("student_id", $student_id)->orderBy('created_at', 'DESC')
        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'student' => $student,
            "payments" => $payments,
            // "students" => StudentCollection::make($students),
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $student_is_valid = Student::where("id", "<>", $id)->where("n_doc", $request->n_doc)->first();

        // if($student_is_valid){
        //     return response()->json([
        //         "message"=>403,
        //         "message_text"=> 'el paciente ya existe'
        //     ]);
        // }
        
        $student = Student::findOrFail($id);
        if($request->hasFile('imagen')){
            if($student->avatar){
                Storage::delete($student->avatar);
            }
            $path = Storage::putFile("students", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }
        
        if($request->birth_date){
            $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->birth_date );
            $request->request->add(["birth_date" => Carbon::parse($date_clean)->format('Y-m-d h:i:s')]);
        }
        
        $student->update($request->all());

        return response()->json([
            "message"=>200,
            "student"=>$student
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        if($student->avatar){
            Storage::delete($student->avatar);
        }
        $student->delete();
        return response()->json([
            "message"=>200
        ]);
    }


    public function search(Request $request){
        return Student::search($request->buscar);
    }

    public function updateStatus(Request $request, $id)
    {
        $student = Student::findOrfail($id);
        $student->status = $request->status;
        $student->update();
        return $student;
    }

}
