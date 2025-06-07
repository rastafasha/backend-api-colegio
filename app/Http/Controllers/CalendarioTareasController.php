<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Calendariotareas;

class CalendarioTareasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
    {
        $calificaciones = Calendariotareas::all();
        return response()->json($calificaciones);
    }

    public function showmaestro($id)
    {
        //traemos todas las calificaciones del estudiante con las materias
        $user = User::findOrFail($id);
        $calendariotareas = Calendariotareas::where('user_id', '=', $id)
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            "message"=>200,
            "user"=>$user,
            "calendariotareas" =>$calendariotareas
        ]);
    }

    public function show($id)
    {
        $calendariotarea = Calendariotareas::findOrFail($id);

        return response()->json([
            "calendariotarea" => $calendariotarea,
            
        ]);
    }

    public function activos($id)
    {
        $user = User::findOrFail($id);
        $calendariotareas = Calendariotareas::where('status','ACTIVE')
        ->where('user_id', '=', $id)
        ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'code' => 200,
                'status' => 'Listar calendariotareas destacados',
                "calendariotareas" => $calendariotareas,
            ], 200);
    }


    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required',
            'description' => 'required',
        ]);

        if($request->fecha_entrega){
            $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->fecha_entrega );
            $request->request->add(["fecha_entrega" => Carbon::parse($date_clean)->format('Y-m-d h:i:s')]);
        }

        $calendariotarea = Calendariotareas::create($request->all());
        return response()->json($calendariotarea, 201);
    }

    public function update(Request $request, $id)
    {
        $calendariotarea = Calendariotareas::find($id);
        if (!$calendariotarea) {
            return response()->json(['message' => 'calendariotarea not found'], 404);
        }

        $request->validate([
            'student_id' => 'sometimes|required|exists:students,id',
            'materia_id' => 'sometimes|required|exists:materias,id',
            'grade' => 'sometimes|required|numeric|min:0|max:100',
        ]);

        $calendariotarea->update($request->all());
        return response()->json($calendariotarea);
    }

    public function destroy($id)
    {
        $calendariotarea = Calendariotareas::find($id);
        if (!$calendariotarea) {
            return response()->json(['message' => 'calendariotarea not found'], 404);
        }

        $calendariotarea->delete();
        return response()->json(['message' => 'calendariotarea deleted']);
    }


    public function search(Request $request){
        return Calendariotareas::search($request->buscar);
    }
}
