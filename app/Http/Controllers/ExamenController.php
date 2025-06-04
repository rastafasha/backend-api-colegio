<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use App\Models\Student;
use Illuminate\Http\Request;

class ExamenController extends Controller
{
    public function index()
    {
        $examenes = Examen::with(['student', 'user', 'materia'])->get();
        return response()->json($examenes);
    }

    public function show($id)
    {
        $examen = Examen::find($id);
        if (!$examen) {
            return response()->json(['message' => 'examen not found'], 404);
        }
        return response()->json([
             'examen' => $examen,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'user_id' => 'required|exists:users,id',
            'materia_id' => 'required|exists:materias,id',
            'title' => 'required|string|max:255',
            'exam_date' => 'nullable|date',
            'puntaje' => 'nullable|numeric',
            'puntaje_letra' => 'nullable|string|max:10',
        ]);

        $examen = Examen::create($request->all());
        return response()->json($examen, 201);
    }

    public function update(Request $request, $id)
    {
        $examen = Examen::find($id);
        if (!$examen) {
            return response()->json(['message' => 'Examen not found'], 404);
        }

        $request->validate([
            'student_id' => 'sometimes|required|exists:students,id',
            'user_id' => 'sometimes|required|exists:users,id',
            'materia_id' => 'sometimes|required|exists:materias,id',
            'title' => 'sometimes|required|string|max:255',
            'exam_date' => 'nullable|date',
            'puntaje' => 'nullable|numeric',
            'puntaje_letra' => 'nullable|string|max:10',
        ]);

        // $examen->update($request->all());
        // return response()->json($examen);

         $examen->update($request->all());
        
        // error_log($examen);

        return response()->json([
            "message"=>200,
            "examen"=>$examen,
        ]);
    }

    public function destroy($id)
    {
        $examen = Examen::find($id);
        if (!$examen) {
            return response()->json(['message' => 'Examen not found'], 404);
        }

        $examen->delete();
        return response()->json(['message' => 'Examen deleted']);
    }

    public function showstudent($id)
    {
        //traemos todas las examenes del estudiante con las materias
        $student = Student::findOrFail($id);
        $examenes = Examen::where('student_id', '=', $id)
        ->with('materia')
        ->with('maestro')
        ->get();

        return response()->json([
            "message"=>200,
            "student"=>$student,
            "examenes" =>$examenes
        ]);
    }

    public function search(Request $request){
        return Examen::search($request->buscar);
    }

}
