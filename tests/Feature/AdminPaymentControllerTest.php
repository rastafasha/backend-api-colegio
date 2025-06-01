<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Representante;
use Carbon\Carbon;

class AdminPaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_monthly_debt_for_parents_only_on_first_day_of_month()
    {
        // Set date to a day other than first of the month
        Carbon::setTestNow(Carbon::create(2025, 5, 2));

        $response = $this->postJson(route('payment.generateMonthlyDebtForParents'));

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Today is not the first day of the month.',
        ]);
    }

    public function it_generates_monthly_debt_for_parents_on_first_day_of_month()
    {
        // Set date to first day of the month
        Carbon::setTestNow(Carbon::create(2025, 5, 1));

        // Create a student and parent
        $parent = Representante::factory()->create();
        $student = Student::factory()->create(['parent_id' => $parent->id, 'matricula' => 1000]);

        $response = $this->postJson(route('payment.generateMonthlyDebtForParents'));

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Monthly debts generated successfully.',
        ]);

        $this->assertDatabaseHas('payments', [
            'parent_id' => $parent->id,
            'student_id' => $student->id,
            'monto' => $student->matricula,
            'status_deuda' => 'DEUDA',
            'status' => 'PENDING',
        ]);
    }

    /** @test */
    public function it_processes_payment_and_updates_debt_status()
    {
        $parent = Representante::factory()->create();
        $student = Student::factory()->create(['parent_id' => $parent->id, 'matricula' => 1000]);

        // Create a debt payment
        $debtPayment = Payment::create([
            'parent_id' => $parent->id,
            'student_id' => $student->id,
            'monto' => 1000,
            'status_deuda' => 'DEUDA',
            'status' => 'PENDING',
            'metodo' => 'DEUDA',
            'referencia' => 'Test debt', // Added referencia to fix error
            'bank_name' => 'Test Bank', // Added bank_name to fix error
            'bank_destino' => 'Test Dest', // Added bank_destino to fix error
            'nombre' => $parent->name, // Added nombre to fix error
            'email' => $parent->email, // Added email to fix error
        ]);

        $data = [
            'monto' => 1000,
            'metodo' => 'Transferencia Dólares',
            'referencia' => 'Test payment',
            'bank_name' => 'Test Bank',
            'bank_destino' => 'Dest Bank',
            'nombre' => $parent->name,
            'email' => $parent->email,
            'status' => 'APPROVED',
        ];

        $response = $this->postJson(route('payment.payDebtForStudent', ['parent_id' => $parent->id, 'student_id' => $student->id]), $data);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Payment recorded successfully and debt updated',
        ]);

        $this->assertDatabaseHas('payments', [
            'parent_id' => $parent->id,
            'student_id' => $student->id,
            'status_deuda' => 'PAID',
            'status' => 'APPROVED',
        ]);
    }
}
