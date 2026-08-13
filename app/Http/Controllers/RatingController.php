<?php
namespace App\Http\Controllers;
use App\Models\MaintenanceRequest;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class RatingController
{
    public function store(Request $r, MaintenanceRequest $maintenanceRequest)
    {
        if ($maintenanceRequest->status !== 'completed') {
            return back()->withInput()->withErrors(['rating' => 'Only completed requests can be rated.']);
        }

        if ($maintenanceRequest->rating()->exists()) {
            return back()->withInput()->withErrors(['rating' => 'This request already has a rating.']);
        }

        $v = $r->validate([
            'customer_id' => ['required', 'integer', Rule::in([$maintenanceRequest->customer_id])],
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000'
        ], [
            'customer_id.in' => 'Only the customer who owns this request can rate it.'
        ]);

        Rating::create(['maintenance_request_id' => $maintenanceRequest->id, ...$v]);
        return back()->with('success', 'Rating saved.');
    }
}
