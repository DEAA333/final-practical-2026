<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $query = MaintenanceRequest::query();

        if (auth()->user()->isTechnician()) {
            $query->where('technician_id', auth()->id());
        }

        return view('dashboard', [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'inProgress' => (clone $query)->where('status', 'in_progress')->count(),
            'completed' => (clone $query)->where('status', 'completed')->count(),
        ]);
    }
}
