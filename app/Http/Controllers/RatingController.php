<?php
namespace App\Http\Controllers;
use App\Models\MaintenanceRequest;
use App\Models\Rating;
use Illuminate\Http\Request;
class RatingController
{
    public function store(Request $r, MaintenanceRequest $m)
    {
        $v = $r->validate([
            'customer_id' => 'required|exists:customers,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000'
        ]);
        Rating::create(['maintenance_request_id' => $m->id, ...$v]);
        return back()->with('success', 'Rating saved.');
    }
}
