<?php

namespace Database\Seeders;

use App\Models\Calendariotareas;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
   public function run()
{
    // 1. Roles y Permisos (DEBE IR PRIMERO para poder asignarlos a los usuarios)
    $this->call(PermissionsDemoSeeder::class);

    // 2. Catálogos base independientes
    $this->call(TiposDePagoSeeder::class);
    $this->call(MateriasSeeder::class);
    $this->call(CategoriesSeeder::class);

    // 3. Usuarios y Perfiles (Dependen de los roles)
    $this->call(UserSeeder::class);
    $this->call(RepresentanteSeeder::class);

    // 4. Relaciones complejas entre entidades existentes
    $this->call(AssignMaestrosToStudentsSeeder::class);

    // 5. Entidades dependientes (Necesitan usuarios, materias o categorías ya creados)
    $this->call(PaymentsSeeder::class);
    $this->call(CalificacionesSeeder::class);
    $this->call(ExamenesSeeder::class);
    $this->call(BlogsSeeder::class);
    $this->call(CalendarioTareaSeeder::class);
}

}
