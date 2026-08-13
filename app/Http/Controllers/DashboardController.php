<?php
namespace App\Http\Controllers;
use App\Models\MaintenanceRequest;
class DashboardController
{
    public function index()
    {
        $q = MaintenanceRequest::query();
        if (auth()->user()->isTechnician())
            $q->where('technician_id', auth()->id());
        return view('dashboard', [
            'total' => (clone $q)->count(),
            'pending' => (clone $q)->where('status', 'pending')->count(),
            'inProgress' => (clone $q)->where('status', 'in_progress')->count(),
            'completed' => (clone $q)->where('status', 'completed')->count()
        ]);
    }
}
