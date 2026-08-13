<?php

namespace Tests\Feature;

use App\Models\MaintenanceRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class EagerLoadingTest extends TestCase
{
    use RefreshDatabase;

    private function queriesFor(callable $callback): int
    {
        DB::enableQueryLog();
        DB::flushQueryLog();

        $callback();

        return count(DB::getQueryLog());
    }

    public function test_lazy_loading_grows_with_row_count(): void
    {
        $this->seed();

        $five = $this->queriesFor(function () {
            foreach (MaintenanceRequest::take(5)->get() as $request) {
                $request->customer?->name;
                $request->technician?->name;
            }
        });

        $twelve = $this->queriesFor(function () {
            foreach (MaintenanceRequest::take(12)->get() as $request) {
                $request->customer?->name;
                $request->technician?->name;
            }
        });

        $this->assertGreaterThan($five, $twelve);
    }

    public function test_eager_loading_stays_constant(): void
    {
        $this->seed();

        $five = $this->queriesFor(function () {
            foreach (MaintenanceRequest::with(['customer', 'technician'])->take(5)->get() as $request) {
                $request->customer?->name;
                $request->technician?->name;
            }
        });

        $twelve = $this->queriesFor(function () {
            foreach (MaintenanceRequest::with(['customer', 'technician'])->take(12)->get() as $request) {
                $request->customer?->name;
                $request->technician?->name;
            }
        });

        $this->assertSame(3, $five);
        $this->assertSame($five, $twelve);
    }

    public function test_requests_index_has_no_n_plus_one(): void
    {
        $this->seed();
        $admin = User::where('email', 'admin@example.com')->first();

        $count = $this->queriesFor(function () use ($admin) {
            $this->actingAs($admin)->get('/requests')->assertOk();
        });

        $this->assertLessThanOrEqual(6, $count);
    }

    public function test_dashboard_uses_a_single_grouped_query(): void
    {
        $this->seed();
        $admin = User::where('email', 'admin@example.com')->first();

        $count = $this->queriesFor(function () use ($admin) {
            $this->actingAs($admin)->get('/dashboard')->assertOk();
        });

        $this->assertSame(1, $count);
    }
}
