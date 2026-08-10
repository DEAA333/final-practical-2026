<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;

class MaintenanceRequestApiController extends Controller
{
    public function index(Request $request)
    {
        $query = MaintenanceRequest::with(['customer', 'technician']);

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        return response()->json(
            $query->latest()->paginate(10)
        );
    }

    public function show(MaintenanceRequest $maintenanceRequest)
    {
        return response()->json(
            $maintenanceRequest->load(['customer', 'technician', 'rating'])
        );
    }
}
