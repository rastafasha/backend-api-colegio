<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Materia;
use App\Models\Examen;
use Illuminate\Support\Str;

class ExamenesSeeder extends Seeder
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
                if ($student->maestro) {
                    for ($i = 1; $i <= 3; $i++) {
                        Examen::create([
                            'student_id' => $student->id,
                            'user_id' => $student->maestro->id,
                            'materia_id' => $materia->id,
                            'title' => 'Examen ' . $i . ' de ' . $materia->name,
                            'exam_date' => now(),
                            'puntaje' => rand(1, 20),
                            'valor_examen' => rand(5, 30),
                        ]);
                    }
                }
            }
        }
    }
}
