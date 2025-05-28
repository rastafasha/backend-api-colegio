<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Representante;
use App\Models\Payment;
use Faker\Factory as Faker;
use Carbon\Carbon;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $representantes = Representante::with('students')->get();

        foreach ($representantes as $representante) {
            foreach ($representante->students as $student) {
                Payment::create([
                    'referencia' => $faker->unique()->bothify('REF-#####'),
                    'metodo' => $faker->randomElement(['Credit Card', 'Bank Transfer', 'Cash', 'Paypal']),
                    'bank_name' => $faker->randomElement(['Bank of America', 'Chase', 'Wells Fargo', 'Citibank']),
                    'monto' => $faker->randomFloat(2, 100, 1000),
                    'nombre' => $representante->name . ' ' . $representante->surname,
                    'email' => $representante->email,
                    'image' => null,
                    'fecha' => Carbon::now(),
                    'status' => $faker->randomElement([Payment::APPROVED, Payment::PENDING, Payment::REJECTED]),
                    'student_id' => $student->id,
                    'parent_id' => $representante->id,
                ]);
            }
        }
    }
}
