<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Calificacion;
use App\Models\Student;
use App\Models\Materia;

class CalificacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = Student::all();
        $materias = Materia::all();

        foreach ($students as $student) {
            foreach ($materias as $materia) {
                Calificacion::create([
                    'student_id' => $student->id,
                    'materia_id' => $materia->id,
                    'grade' => rand(60, 100), // Random grade between 60 and 100
                    'semestre' => rand(1, 3),
                    'anio_escolar' => $this->getAnioEscolar(),
                ]);
            }
        }
    }

    private function getAnioEscolar()
    {
        $month = date('m');
        $year = date('Y');
        if ($month >= 10) {
            return $year . '-' . ($year + 1);
        } else {
            return ($year - 1) . '-' . $year;
        }
    }
}
