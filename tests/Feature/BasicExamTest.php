<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\MaintenanceRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BasicExamTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeded_data_can_be_created(): void
    {
        $this->seed();

        $this->assertDatabaseHas('users', [
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        $this->assertGreaterThanOrEqual(5, Customer::count());
        $this->assertGreaterThanOrEqual(10, MaintenanceRequest::count());
    }

    public function test_login_works(): void
    {
        $this->seed();

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
    }

    public function test_requests_index_requires_authentication(): void
    {
        $this->get('/requests')->assertRedirect('/login');
    }
}
