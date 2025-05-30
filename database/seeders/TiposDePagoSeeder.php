<?php

namespace Database\Seeders;

use App\Models\Tiposdepago;
use Illuminate\Database\Seeder;

class TiposDePagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposDePago = [
            [
                'id' => 1,
                'tipo' => 'Transferencia Bolívares',
                'ciorif' => null,
                'telefono' => null,
                'bankAccount' => '01051223345678904',
                'bankName' => 'mercantil',
                'bankAccountType' => 'Corriente',
                'email' => null,
                'user' => 'das',
                'status' => 'ACTIVE',
                'created_at' => '2023-10-10 05:32:48',
                'updated_at' => '2023-10-10 06:04:50'
            ],
            [
                'id' => 2,
                'tipo' => 'Transferencia Dólares',
                'ciorif' => null,
                'telefono' => null,
                'bankAccount' => 'ZEL0101010143543',
                'bankName' => 'BOFA',
                'bankAccountType' => null,
                'email' => 'ddsa',
                'user' => null,
                'status' => 'ACTIVE',
                'created_at' => '2024-01-10 02:07:20',
                'updated_at' => '2024-01-10 02:07:43'
            ],
            [
                'id' => 3,
                'tipo' => 'Pago Móvil',
                'ciorif' => '123456',
                'telefono' => '234567',
                'bankAccount' => '253453',
                'bankName' => 'Mercantil Pago M',
                'bankAccountType' => null,
                'email' => null,
                'user' => null,
                'status' => 'ACTIVE',
                'created_at' => '2024-01-16 03:17:12',
                'updated_at' => '2024-01-16 03:17:16'
            ],
            [
                'id' => 4,
                'tipo' => 'Pago Móvil',
                'ciorif' => '1223338',
                'telefono' => '234566777',
                'bankAccount' => null,
                'bankName' => 'Provincial',
                'bankAccountType' => null,
                'email' => null,
                'user' => null,
                'status' => 'ACTIVE',
                'created_at' => '2024-05-17 05:16:25',
                'updated_at' => '2024-05-17 05:16:29'
            ]
        ];

        foreach ($tiposDePago as $tipoDePago) {
            Tiposdepago::updateOrCreate(
                ['id' => $tipoDePago['id']],
                $tipoDePago
            );
        }
    }
}
