<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['guard_name' => 'api','name' => 'patient_dashboard']);
        Permission::create(['guard_name' => 'api','name' => 'admin_dashboard']);
        Permission::create(['guard_name' => 'api','name' => 'doctor_dashboard']);
        Permission::create(['guard_name' => 'api','name' => 'register_rol']);
        Permission::create(['guard_name' => 'api','name' => 'list_rol']);
        Permission::create(['guard_name' => 'api','name' => 'edit_rol']);
        Permission::create(['guard_name' => 'api','name' => 'delete_rol']);

        Permission::create(['guard_name' => 'api','name' => 'settings']);


        // create roles and assign existing permissions
        // $role1 = Role::create(['guard_name' => 'api','name' => 'writer']);
        // $role1->givePermissionTo('edit articles');
        // $role1->givePermissionTo('delete articles');

        // $role2 = Role::create(['guard_name' => 'api','name' => 'admin']);
        // $role2->givePermissionTo('publish articles');
        // $role2->givePermissionTo('unpublish articles');

        // $role3 = Role::create(['guard_name' => 'api','name' => 'SUPERADMIN']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        $role4 = Role::create(['guard_name' => 'parent-api', 'name' => 'GUEST']);

        $role5 = Role::create(['guard_name' => 'api', 'name' => 'MAESTRO']);

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