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
                ->select('materia_id')
                ->where('student_id', $student->id)
                ->groupBy('materia_id')
                ->get();

            foreach ($examenesGrouped as $examenGroup) {
                $examenes = DB::table('examenes')
                    ->where('student_id', $student->id)
                    ->where('materia_id', $examenGroup->materia_id)
                    ->get();

                $weightedGrade = 0;
                $totalWeight = 0;

                foreach ($examenes as $examen) {
                    $weightedGrade += ($examen->puntaje * $examen->valor_examen) / 100;
                    $totalWeight += $examen->valor_examen;
                }

                // Normalize if totalWeight is not 100%
                if ($totalWeight > 0) {
                    $weightedGrade = ($weightedGrade / $totalWeight) * 100;
                }

                Calificacion::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'materia_id' => $examenGroup->materia_id,
                    ],
                    [
                        'grade' => $weightedGrade,
                        'lapso' => 1, // Assuming lapso 1 for seeder, adjust as needed
                        'anio_escolar' => date('Y'),
                    ]
                );
            }
        }
    }
}
