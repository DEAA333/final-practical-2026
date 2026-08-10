<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MaintenanceRequest;
use App\Models\User;
use Illuminate\Http\Request;

class MaintenanceRequestController extends Controller
{
    public function index(Request $request)
    {
        // INTENTIONAL EXAM ISSUE: filtering/search is incomplete.
        $requests = MaintenanceRequest::with(['customer', 'technician'])
            ->latest()
            ->paginate(5);

        return view('requests.index', compact('requests'));
    }

    public function create()
    {
        return view('requests.create', [
            'customers' => Customer::orderBy('name')->get(),
            'technicians' => User::where('role', 'technician')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        // INTENTIONAL EXAM ISSUE: validation is intentionally incomplete.
        $validated = $request->validate([
            'title' => ['required'],
        ]);

        MaintenanceRequest::create($validated);

        return redirect()->route('requests.index')
            ->with('success', 'Request created.');
    }

    public function show(MaintenanceRequest $maintenanceRequest)
    {
        $maintenanceRequest->load(['customer', 'technician', 'rating']);

        return view('requests.show', compact('maintenanceRequest'));
    }

    public function edit(MaintenanceRequest $maintenanceRequest)
    {
        return view('requests.edit', [
            'maintenanceRequest' => $maintenanceRequest,
            'customers' => Customer::orderBy('name')->get(),
            'technicians' => User::where('role', 'technician')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        $validated = $request->validate([
            'title' => ['required', 'min:5', 'max:100'],
            'description' => ['required', 'min:10'],
            'priority' => ['required', 'in:low,medium,high'],
            'status' => ['required', 'in:pending,in_progress,completed,cancelled'],
            'customer_id' => ['required', 'exists:customers,id'],
            'technician_id' => ['nullable', 'exists:users,id'],
            'requested_at' => ['required', 'date'],
        ]);

        $maintenanceRequest->update($validated);

        return redirect()->route('requests.show', $maintenanceRequest)
            ->with('success', 'Request updated.');
    }

    public function destroy(MaintenanceRequest $maintenanceRequest)
    {
        // INTENTIONAL EXAM ISSUE: authorization must be implemented.
        $maintenanceRequest->delete();

        return redirect()->route('requests.index')
            ->with('success', 'Request deleted.');
    }
}
