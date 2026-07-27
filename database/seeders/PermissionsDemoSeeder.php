<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run(): void
    {

    // ¡PASO NUEVO!: Forzar el vaciado de las tablas limpiando dependencias en Postgres
    if (config('database.default') === 'pgsql') {
        // Desactiva temporalmente las restricciones de claves foráneas
        DB::statement('TRUNCATE TABLE roles, permissions, model_has_roles, model_has_permissions, role_has_permissions RESTART IDENTITY CASCADE;');
    } else {
        // Alternativa tradicional por si ejecutas en local con MySQL
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        Role::truncate();
        Permission::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }


        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['guard_name' => 'api', 'name' => 'patient_dashboard']);
        Permission::create(['guard_name' => 'api', 'name' => 'admin_dashboard']);
        Permission::create(['guard_name' => 'api', 'name' => 'doctor_dashboard']);
        Permission::create(['guard_name' => 'api', 'name' => 'register_rol']);
        Permission::create(['guard_name' => 'api', 'name' => 'list_rol']);
        Permission::create(['guard_name' => 'api', 'name' => 'edit_rol']);
        Permission::create(['guard_name' => 'api', 'name' => 'delete_rol']);

        Permission::create(['guard_name' => 'api', 'name' => 'settings']);


        // create roles and assign existing permissions
        // $role1 = Role::create(['guard_name' => 'api','name' => 'writer']);
        // $role1->givePermissionTo('edit articles');
        // $role1->givePermissionTo('delete articles');

        // $role2 = Role::create(['guard_name' => 'api','name' => 'admin']);
        // $role2->givePermissionTo('publish articles');
        // $role2->givePermissionTo('unpublish articles');

        // $role3 = Role::create(['guard_name' => 'api','name' => 'SUPERADMIN']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create roles (CORREGIDO: arreglos asociativos explícitos)
        $role4 = Role::create(['guard_name' => 'parent-api', 'name' => 'GUEST']);
        $role5 = Role::create(['guard_name' => 'api', 'name' => 'MAESTRO']);

        // SINCRONIZACIÓN DE SECUENCIAS PARA POSTGRESQL (SUPABASE)
// Esto evita el error de "duplicate key value violates unique constraint" en futuros inserts
        if (config('database.default') === 'pgsql') {
            DB::statement("SELECT setval(pg_get_serial_sequence('permissions', 'id'), coalesce(max(id), 0) + 1, false) FROM permissions;");
            DB::statement("SELECT setval(pg_get_serial_sequence('roles', 'id'), coalesce(max(id), 0) + 1, false) FROM roles;");
        }

        // create demo users
        // $user = \App\Models\User::factory()->create([
        //     'name' => 'Example User',
        //     'email' => 'test@example.com',
        //     'password' => bcrypt('12345678')
        // ]);
        // $user->assignRole($role1);

        // $user = \App\Models\User::factory()->create([
        //     'name' => 'Example Admin User',
        //     'email' => 'admin@example.com',
        //     'password' => bcrypt('12345678')
        // ]);
        // $user->assignRole($role2);

        // $user = \App\Models\User::factory()->create(
        //     [
        //         // "rolename" => User::GUEST,
        //         "name" => "invitado",
        //         'surname' => 'Johnson',
        //         "email" => "invitado@invitado.com",
        //         'gender' => 1,
        //         "password" => bcrypt("password"),
        //         'roles' => [
        //             [
        //                 "id"=> 9,
        //                 "name"=> "GUEST",
        //                 "guard_name"=> "api-parent",
        //                 "created_at"=> "2025-02-16T06:49:18.000000Z",
        //                 "updated_at"=> "2025-02-16T06:49:18.000000Z",
        //             ],
        //             'pivot' => [
        //                 [
        //                     "model_id"=> 8,
        //                     "role_id"=> 9,   
        //                     "model_type"=> "App\\Models\\User"
        //                 ]
        //             ],
        //         ],
        //         "email_verified_at" => now(),
        //         "created_at" => now(),
        //     ]
        // );


        // $user->assignRole($role4);
    }
}