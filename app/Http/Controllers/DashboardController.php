<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Representante;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function config()
    {
        $parents = Representante::orderBy('id', 'desc')
            ->paginate(10);

        $parents_deuda = Representante::orderBy('id', 'desc')
            
            ->with(['payments' => function ($query) {
                $query->where('status_deuda', 'DEUDA')->select('id', 'parent_id', 'status_deuda');
            }])
            ->paginate(10);
        $parents_nodeuda = Representante::orderBy('id', 'desc')
            
            ->with(['payments' => function ($query) {
                // $query->where('status_deuda', 'PAID')->select('id', 'parent_id', 'status_deuda');
                $query->where('status', 'APPROVED')->select('id', 'parent_id', 'status_deuda');
            }])
            ->paginate(10);

        $students = Student::orderBy("id", "desc")
        ->paginate(10);
                    
        return response()->json([
            "total_parents" =>$parents->total(),
            "parents_nodeuda" =>$parents_nodeuda->total(),
            "total_parents_deuda" =>$parents_deuda->total(),
            // "parents_deuda" =>$parents_deuda,
            // "parents" => $parents,
            "total_students" =>$students->total(),
            // "students" => $students,
            // "students" => StudentCollection::make($students),
            
        ]); 
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
