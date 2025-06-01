<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Representante;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        return [
            'n_doc' => $this->faker->unique()->numerify('##########'),
            'name' => $this->faker->name,
            'birth_date' => $this->faker->dateTimeBetween('-30 years', '-10 years'),
            'parent_id' => Representante::factory(),
            'matricula' => $this->faker->numberBetween(500, 2000),
            'avatar' => null,
        ];
    }
}
