<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Moroso;
use App\Models\Representante;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class MorososSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing morosos data
        DB::table('morosos')->truncate();

        // Get some parents and students to create sample morosos
        $parents = Representante::take(5)->get();
        $students = Student::take(5)->get();

        $currentYear = date('Y');
        $currentMonth = date('m');

        foreach ($parents as $parent) {
            foreach ($students as $student) {
                // Only create moroso if student belongs to the parent
                if ($student->parent_id === $parent->id) {
                    Moroso::create([
                        'parent_id' => $parent->id,
                        'student_id' => $student->id,
                        'month' => $currentMonth,
                        'year' => $currentYear,
                        'amount_due' => 400,
                        'amount_paid' => 0,
                        'status' => 'unpaid',
                    ]);
                }
            }
        }
    }
}
