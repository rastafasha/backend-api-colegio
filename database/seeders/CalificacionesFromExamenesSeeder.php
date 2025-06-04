<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Calificacion;
use Illuminate\Support\Facades\DB;

class CalificacionesFromExamenesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = Student::all();

        foreach ($students as $student) {
            $examenesGrouped = DB::table('examenes')
                ->select('materia_id', DB::raw('AVG(puntaje) as avg_puntaje'), DB::raw('MAX(puntaje_letra) as max_puntaje_letra'))
                ->where('student_id', $student->id)
                ->groupBy('materia_id')
                ->get();

            foreach ($examenesGrouped as $examen) {
                Calificacion::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'materia_id' => $examen->materia_id,
                    ],
                    [
                        'grade' => $examen->avg_puntaje,
                        'puntaje_letra' => $examen->max_puntaje_letra,
                        'semestre' => null,
                        'anio_escolar' => null,
                    ]
                );
            }
        }
    }
}
