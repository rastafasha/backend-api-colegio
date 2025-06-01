<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Representante;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class PaymentProcessingEdgeCasesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_allows_partial_payment_and_updates_debt_correctly()
    {
        $parent = Representante::factory()->create();
        $student = Student::factory()->create(['parent_id' => $parent->id, 'matricula' => 2000]);

        // Create initial debt
        Payment::create([
            'parent_id' => $parent->id,
            'student_id' => $student->id,
            'monto' => 2000,
            'status_deuda' => 'DEUDA',
            'status' => 'PENDING',
            'referencia' => 'Initial debt',
            'metodo' => 'DEUDA',
            'bank_name' => '',
            'bank_destino' => '',
            'nombre' => $parent->name,
            'email' => $parent->email,
            'avatar' => null,
        ]);

        // Make a partial payment of 1000
        $response = $this->postJson(route('payment.payDebtForStudent', ['parent_id' => $parent->id, 'student_id' => $student->id]), [
            'monto' => 1000,
            'metodo' => 'Transferencia Dólares', // Changed to valid metodo with precio_dia
            'referencia' => 'Partial payment',
            'bank_name' => 'Bank A',
            'bank_destino' => 'Bank B',
            'nombre' => $parent->name,
            'email' => $parent->email,
            'status' => 'PENDING',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Payment recorded successfully and debt updated']);

        // Check that one debt remains with reduced monto
        $this->assertDatabaseHas('payments', [
            'parent_id' => $parent->id,
            'student_id' => $student->id,
            'monto' => 1000, // Remaining debt after partial payment
            'status_deuda' => 'PENDING',
        ]);
    }

    /** @test */
    public function it_rejects_payment_amount_exceeding_debt()
    {
        $parent = Representante::factory()->create();
        $student = Student::factory()->create(['parent_id' => $parent->id, 'matricula' => 1500]);

        // Create initial debt
        Payment::create([
            'parent_id' => $parent->id,
            'student_id' => $student->id,
            'monto' => 1500,
            'status_deuda' => 'DEUDA',
            'status' => 'PENDING',
            'referencia' => 'Initial debt',
            'metodo' => 'DEUDA',
            'bank_name' => '',
            'bank_destino' => '',
            'nombre' => $parent->name,
            'email' => $parent->email,
            'avatar' => null,
        ]);

        // Attempt to pay more than debt
        $response = $this->postJson(route('payment.payDebtForStudent', ['parent_id' => $parent->id, 'student_id' => $student->id]), [
            'monto' => 1600,
            'metodo' => 'Transferencia Dólares', // Changed to valid metodo with precio_dia
            'referencia' => 'Overpayment',
            'bank_name' => 'Bank A',
            'bank_destino' => 'Bank B',
            'nombre' => $parent->name,
            'email' => $parent->email,
            'status' => 'PENDING',
        ]);

        $response->assertStatus(400);
        $response->assertJson(['error' => 'Payment amount exceeds current debt']);
    }
}
