<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Calendariotareas;

class CalendarioTareaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample task calendar entries with 2 tasks, 2 exams, and 1 presentation in one month
        $tasks = [
            [
                'user_id' => 4,
                
                'title' => 'Tarea: Entrega de proyecto de matemáticas',
                'description' => 'Completar el proyecto sobre álgebra y entregarlo en formato PDF.',
                'fecha_entrega' => '2025-06-10',
            ],
            [
                'user_id' => 4,
                
                'title' => 'Tarea: Lectura de capítulo 5 de historia',
                'description' => 'Leer y resumir el capítulo 5 para discusión en clase.',
                'fecha_entrega' => '2025-06-20',
            ],
            [
                'user_id' => 4,
                
                'title' => 'Examen: Matemáticas',
                'description' => 'Examen final de matemáticas, temas álgebra y geometría.',
                'fecha_entrega' => '2025-06-15',
            ],
            [
                'user_id' => 4,
                
                'title' => 'Examen: Historia',
                'description' => 'Examen de historia sobre la revolución industrial.',
                'fecha_entrega' => '2025-06-25',
            ],
            [
                'user_id' => 4,
                
                'title' => 'Presentación: Proyecto de ciencias',
                'description' => 'Presentar el proyecto de ciencias en clase.',
                'fecha_entrega' => '2025-06-30',
            ],
        ];

        foreach ($tasks as $task) {
            Calendariotareas::create($task);
        }
    }
}
