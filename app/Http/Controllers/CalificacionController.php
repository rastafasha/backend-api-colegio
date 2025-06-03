<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Student;
use Illuminate\Http\Request;
use PDF; // Assuming barryvdh/laravel-dompdf is installed

class CalificacionController extends Controller
{
    public function index()
    {
        $calificaciones = Calificacion::all();
        return response()->json($calificaciones);
    }

    public function showstudent($id)
    {
        //traemos todas las calificaciones del estudiante con las materias
        $student = Student::findOrFail($id);
        $calificacions = Calificacion::where('student_id', '=', $id)
        ->with('materia')
        ->get();

        return response()->json([
            "message"=>200,
            "student"=>$student,
            "calificaciones" =>$calificacions
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'materia_id' => 'required|exists:materias,id',
            'grade' => 'required|numeric|min:0|max:100',
        ]);

        $calificacion = Calificacion::create($request->all());
        return response()->json($calificacion, 201);
    }

    public function update(Request $request, $id)
    {
        $calificacion = Calificacion::find($id);
        if (!$calificacion) {
            return response()->json(['message' => 'Calificacion not found'], 404);
        }

        $request->validate([
            'student_id' => 'sometimes|required|exists:students,id',
            'materia_id' => 'sometimes|required|exists:materias,id',
            'grade' => 'sometimes|required|numeric|min:0|max:100',
        ]);

        $calificacion->update($request->all());
        return response()->json($calificacion);
    }

    public function destroy($id)
    {
        $calificacion = Calificacion::find($id);
        if (!$calificacion) {
            return response()->json(['message' => 'Calificacion not found'], 404);
        }

        $calificacion->delete();
        return response()->json(['message' => 'Calificacion deleted']);
    }

    public function generatePdf($studentId)
    {
        $student = Student::with('calificaciones.materia')->find($studentId);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $data = [
            'student' => $student,
            'calificaciones' => $student->calificaciones,
        ];

        $pdf = PDF::loadView('pdf.calificaciones', $data);
        return $pdf->download('calificaciones_' . $student->id . '.pdf');
    }
}
