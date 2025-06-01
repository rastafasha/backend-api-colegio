<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Student;

class StudentControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_registers_a_student_successfully()
    {
        $parent = \App\Models\Representante::factory()->create();

        $data = [
            'n_doc' => '123456789',
            'name' => 'Test Student',
            'birth_date' => '2000-01-01 00:00:00',
            'parent_id' => $parent->id,
            'matricula' => 1000,
        ];

        $response = $this->postJson(route('student.store'), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('students', [
            'n_doc' => '123456789',
            'name' => 'Test Student',
        ]);
    }

    /** @test */
    public function it_fails_to_register_duplicate_student()
    {
        $parent = \App\Models\Representante::factory()->create();

        $student = \App\Models\Student::factory()->create([
            'n_doc' => '123456789',
            'parent_id' => $parent->id,
        ]);

        $data = [
            'n_doc' => '123456789',
            'name' => 'Duplicate Student',
            'birth_date' => '2000-01-01 00:00:00',
            'parent_id' => $parent->id,
            'matricula' => 1000,
        ];

        $response = $this->postJson(route('student.store'), $data);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 403,
            'message_text' => 'el paciente ya existe',
        ]);
    }
}
