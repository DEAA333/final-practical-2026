<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        // INTENTIONAL EXAM ISSUE: business rules are incomplete.
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        Rating::create([
            'maintenance_request_id' => $maintenanceRequest->id,
            ...$validated,
        ]);

        return back()->with('success', 'Rating saved.');
    }
}
