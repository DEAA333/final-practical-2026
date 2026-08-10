<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
class MaintenanceRequestApiController
{
    public function index(Request $r)
    {
        $q = MaintenanceRequest::with(['customer', 'technician']);
        if ($r->filled('status'))
            $q->where('status', $r->string('status'));
        return response()->json($q->latest()->paginate(10));
    }
    public function show(MaintenanceRequest $m)
    {
        return response()->json($m->load(['customer', 'technician', 'rating']));
    }
}
