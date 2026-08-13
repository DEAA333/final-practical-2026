<?php
namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\MaintenanceRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MaintenanceRequestController
{
    private function rules(bool $withStatus): array
    {
        $rules = [
            'customer_id' => 'required|exists:customers,id',
            'technician_id' => ['nullable', Rule::exists('users', 'id')->where('role', 'technician')],
            'title' => 'required|string|min:5|max:100',
            'description' => 'required|string|min:10|max:2000',
            'priority' => 'required|in:low,medium,high',
            'requested_at' => 'required|date'
        ];

        if ($withStatus) {
            $rules['status'] = 'required|in:pending,in_progress,completed,cancelled';
        }

        return $rules;
    }

    private function attributes(): array
    {
        return [
            'customer_id' => 'customer',
            'technician_id' => 'technician',
            'requested_at' => 'requested date'
        ];
    }

    public function index(Request $r)
    {
        $query = MaintenanceRequest::with(['customer', 'technician']);

        if ($r->filled('search')) {
            $search = $r->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhereHas('customer', function($c) use ($search) {
                      $c->where('name', 'like', "%$search%");
                  });
            });
        }

        if ($r->filled('status')) {
            $query->where('status', $r->status);
        }

        if ($r->filled('priority')) {
            $query->where('priority', $r->priority);
        }

        if ($r->filled('technician_id')) {
            $query->where('technician_id', $r->technician_id);
        }

        $requests = $query->latest()->orderByDesc('id')->paginate(5)->withQueryString();

        $technicians = User::where('role', 'technician')->orderBy('name')->get();

        return view('requests.index', compact('requests', 'technicians'));
    }

    public function create()
    {
        return view('requests.create', ['customers' => Customer::orderBy('name')->get(), 'technicians' => User::where('role', 'technician')->orderBy('name')->get()]);
    }

    public function store(Request $r)
    {
        $v = $r->validate($this->rules(withStatus: false), [], $this->attributes());
        $v['status'] = 'pending';

        MaintenanceRequest::create($v);
        return redirect()->route('requests.index')->with('success', 'Request created.');
    }

    public function show(MaintenanceRequest $maintenanceRequest)
    {
        $maintenanceRequest->load(['customer', 'technician', 'rating']);
        return view('requests.show', ['m' => $maintenanceRequest]);
    }

    public function edit(MaintenanceRequest $maintenanceRequest)
    {
        return view('requests.edit', ['maintenanceRequest' => $maintenanceRequest, 'customers' => Customer::orderBy('name')->get(), 'technicians' => User::where('role', 'technician')->orderBy('name')->get()]);
    }

    public function update(Request $r, MaintenanceRequest $maintenanceRequest)
    {
        $v = $r->validate($this->rules(withStatus: true), [], $this->attributes());
        $maintenanceRequest->update($v);
        return redirect()->route('requests.show', $maintenanceRequest)->with('success', 'Request updated.');
    }

    public function destroy(MaintenanceRequest $maintenanceRequest)
    {
        $maintenanceRequest->delete();
        return redirect()->route('requests.index')->with('success', 'Request deleted.');
    }
}