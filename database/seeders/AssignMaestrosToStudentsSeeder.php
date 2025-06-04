<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\User;

class AssignMaestrosToStudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all maestros users
        $maestros = User::role('maestro')->get();

        if ($maestros->isEmpty()) {
            $this->command->info('No maestros found to assign.');
            return;
        }

        $maestroCount = $maestros->count();
        $students = Student::all();

        foreach ($students as $index => $student) {
            // Assign maestros in round-robin fashion
            $maestro = $maestros[$index % $maestroCount];
            $student->maestro()->associate($maestro);
            $student->save();
        }

        $this->command->info('Maestros assigned to students successfully.');
    }
}
