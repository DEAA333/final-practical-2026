@extends('layouts.app')

@section('content')
<h1>Maintenance Requests</h1>

<form method="GET" action="{{ route('requests.index') }}" class="row">
    <div>
        <label>Search</label>
        <input name="search" value="{{ request('search') }}" placeholder="Title or customer">
    </div>
    <div>
        <label>Status</label>
        <select name="status">
            <option value="">All</option>
            @foreach(['pending','in_progress','completed','cancelled'] as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>
                    {{ ucfirst(str_replace('_',' ',$status)) }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label>Priority</label>
        <select name="priority">
            <option value="">All</option>
            @foreach(['low','medium','high'] as $priority)
                <option value="{{ $priority }}" @selected(request('priority') === $priority)>
                    {{ ucfirst($priority) }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label>&nbsp;</label>
        <button type="submit">Filter</button>
        <a href="{{ route('requests.index') }}">Reset</a>
    </div>
</form>

<br>

<table>
<thead>
<tr>
<th>ID</th><th>Title</th><th>Customer</th><th>Technician</th>
<th>Priority</th><th>Status</th><th>Actions</th>
</tr>
</thead>
<tbody>
@forelse($requests as $request)
<tr>
<td>{{ $request->id }}</td>
<td>{{ $request->title }}</td>
<td>{{ $request->customer->name }}</td>
<td>{{ $request->technician?->name ?? 'Not assigned' }}</td>
<td>{{ $request->priority }}</td>
<td>{{ $request->status }}</td>
<td class="actions">
<a href="{{ route('requests.show',$request) }}">View</a>
<a href="{{ route('requests.edit',$request) }}">Edit</a>
</td>
</tr>
@empty
<tr><td colspan="7">No requests found.</td></tr>
@endforelse
</tbody>
</table>

<br>
{{ $requests->links() }}
@endsection
