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

        $counts = $q->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('dashboard', [
            'total' => $counts->sum(),
            'pending' => $counts['pending'] ?? 0,
            'inProgress' => $counts['in_progress'] ?? 0,
            'completed' => $counts['completed'] ?? 0
        ]);
    }
}
