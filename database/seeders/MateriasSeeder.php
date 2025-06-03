<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materia;

class MateriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materias = [
            ['name' => 'Matemáticas', 'description' => 'Materia de matemáticas'],
            ['name' => 'Ciencias', 'description' => 'Materia de ciencias'],
            ['name' => 'Historia', 'description' => 'Materia de historia'],
            ['name' => 'Lengua', 'description' => 'Materia de lengua'],
            ['name' => 'Inglés', 'description' => 'Materia de inglés'],
        ];

        foreach ($materias as $materia) {
            Materia::create($materia);
        }
    }
}
