<?php
namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\MaintenanceRequest;
use App\Models\User;
use Illuminate\Http\Request;

class MaintenanceRequestController
{
    public function index(Request $r)
    {
        $query = MaintenanceRequest::with(['customer', 'technician']);

        // البحث في العنوان أو اسم العميل
        if ($r->filled('search')) {
            $search = $r->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhereHas('customer', function($c) use ($search) {
                      $c->where('name', 'like', "%$search%");
                  });
            });
        }

        // فلتر الحالة
        if ($r->filled('status')) {
            $query->where('status', $r->status);
        }

        // فلتر الأولوية
        if ($r->filled('priority')) {
            $query->where('priority', $r->priority);
        }

        // فلتر الفني
        if ($r->filled('technician_id')) {
            $query->where('technician_id', $r->technician_id);
        }

        $requests = $query->latest()->paginate(5)->withQueryString();

        return view('requests.index', compact('requests'));
    }

    public function create()
    {
        return view('requests.create', ['customers' => Customer::orderBy('name')->get(), 'technicians' => User::where('role', 'technician')->orderBy('name')->get()]);
    }

    public function store(Request $r)
    {
        $v = $r->validate(['title' => 'required']);
        MaintenanceRequest::create($v);
        return redirect()->route('requests.index')->with('success', 'Request created.');
    }

    public function show(MaintenanceRequest $m)
    {
        $m->load(['customer', 'technician', 'rating']);
        return view('requests.show', compact('m'));
    }

    public function edit(MaintenanceRequest $m)
    {
        return view('requests.edit', ['maintenanceRequest' => $m, 'customers' => Customer::orderBy('name')->get(), 'technicians' => User::where('role', 'technician')->orderBy('name')->get()]);
    }

    public function update(Request $r, MaintenanceRequest $m)
    {
        $v = $r->validate([
            'title' => 'required|min:5|max:100',
            'description' => 'required|min:10',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'customer_id' => 'required|exists:customers,id',
            'technician_id' => 'nullable|exists:users,id',
            'requested_at' => 'required|date'
        ]);
        $m->update($v);
        return redirect()->route('requests.show', $m)->with('success', 'Request updated.');
    }

    public function destroy(MaintenanceRequest $m)
    {
        $m->delete();
        return redirect()->route('requests.index')->with('success', 'Request deleted.');
    }
}