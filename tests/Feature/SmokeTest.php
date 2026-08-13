<?php
namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class SmokeTest extends TestCase
{
    use RefreshDatabase;
    public function test_seed_works(): void
    {
        $this->seed();
        $this->assertDatabaseHas('users', ['email' => 'admin@example.com']);
        $this->assertDatabaseCount('customers', 8);
    }
    public function test_requests_require_login(): void
    {
        $this->get('/requests')->assertRedirect('/login');
    }
}
