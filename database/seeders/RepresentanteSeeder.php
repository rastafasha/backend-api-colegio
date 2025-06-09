<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Representante;
use App\Models\Student;
use Faker\Factory as Faker;

class RepresentanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Create 10 representantes
        for ($i = 0; $i < 10; $i++) {
            $representante = Representante::create([
                'name' => $faker->firstName,
                'surname' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'), // default password
                'n_doc' => $faker->unique()->numerify('##########'),
                'mobile' => $faker->phoneNumber,
                'birth_date' => $faker->date(),
                'gender' => $faker->randomElement(['1', '2']),
                'address' => $faker->address,
                'avatar' => null,
                'status' => $faker->randomElement(['ACTIVE', 'INACTIVE']),
            ]);

            // Create up to 5 students for each representante
            $studentsCount = rand(1, 5);
            for ($j = 0; $j < $studentsCount; $j++) {
                Student::create([
                    'name' => $faker->firstName,
                    'surname' => $faker->lastName,
                    'n_doc' => $faker->unique()->numerify('##########'),
                    'matricula' => 1000,
                    'birth_date' => $faker->date(),
                    'gender' => $faker->randomElement(['1', '2']),
                    'avatar' => null,
                    'user_id' => 4,
                    'status' => $faker->randomElement(['ACTIVE', 'INACTIVE', 
                    'RETIRED','GRADUATED']),
                    'school_year' => $faker->randomElement(['1st', '2nd', '3rd', '4th', '5th']),
                    'parent_id' => $representante->id,
                    'section' => $faker->randomLetter,
                ]);
            }
        }
    }
}
