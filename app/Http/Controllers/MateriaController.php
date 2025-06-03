<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::all();
        return response()->json($materias);
    }

    public function show($id)
    {
        $materia = Materia::find($id);
        if (!$materia) {
            return response()->json(['message' => 'Materia not found'], 404);
        }
        return response()->json($materia);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $materia = Materia::create($request->all());
        return response()->json($materia, 201);
    }

    public function update(Request $request, $id)
    {
        $materia = Materia::find($id);
        if (!$materia) {
            return response()->json(['message' => 'Materia not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $materia->update($request->all());
        return response()->json($materia);
    }

    public function destroy($id)
    {
        $materia = Materia::find($id);
        if (!$materia) {
            return response()->json(['message' => 'Materia not found'], 404);
        }

        $materia->delete();
        return response()->json(['message' => 'Materia deleted']);
    }
}
