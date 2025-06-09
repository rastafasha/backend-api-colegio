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

        $representantes = Representante::with('students')
        ->where('status', 'ACTIVE')
        ->get();

        foreach ($representantes as $representante) {
            foreach ($representante->students as $student) {
                $monto = $faker->randomFloat(2, 100, 1000);
                $deuda = $monto * 0.5; // example calculation
                $monto_pendiente = $monto - $deuda;
                $status_deuda = null;
                if ($monto < 400) {
                    $status_deuda = 'DEUDA';
                }

                Payment::create([
                    'referencia' => $faker->unique()->bothify('REF-#####'),
                    'metodo' => $faker->randomElement(['Transferencia Dólares', 'Transferencia Bolívares', 'Pago Móvil']),
                    'bank_name' => $faker->randomElement(['Bank of America', 'Chase', 'Wells Fargo', 'Citibank']),
                    'bank_destino' => $faker->randomElement(['Bank of America', 'Chase', 'Wells Fargo', 'Citibank']),
                    'monto' => $monto,
                    'deuda' => $deuda,
                    'monto_pendiente' => $monto_pendiente,
                    'status_deuda' => $status_deuda,
                    'nombre' => $representante->name . ' ' . $representante->surname,
                    'email' => $representante->email,
                    'avatar' => null,
                    'fecha' => Carbon::now(),
                    'status' => $faker->randomElement([Payment::APPROVED, Payment::PENDING, Payment::REJECTED]),
                    'student_id' => $student->id,
                    'parent_id' => $representante->id,
                ]);
            }
        }
    }
}
