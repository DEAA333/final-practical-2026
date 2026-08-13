@extends('layouts.app') @section('content')
    <h1>Requests</h1>
    <form method="GET" class="row">
        <div><input name="search" value="{{request('search')}}" placeholder="Search title/customer"></div>
        <div><select name="status">
                <option value="">All statuses</option>@foreach(['pending', 'in_progress', 'completed', 'cancelled'] as $s)
                <option value="{{$s}}" @selected(request('status') === $s)>{{$s}}</option>@endforeach
            </select></div>
        <div><select name="priority">
                <option value="">All priorities</option>@foreach(['low', 'medium', 'high'] as $p)
                <option value="{{$p}}" @selected(request('priority') === $p)>{{$p}}</option>@endforeach
            </select></div>
        <div><select name="technician_id">
                <option value="">All technicians</option>@foreach($technicians as $t)
                <option value="{{$t->id}}" @selected((string) request('technician_id') === (string) $t->id)>{{$t->name}}</option>@endforeach
            </select></div>
        <div><button>Filter</button> <a href="{{route('requests.index')}}">Reset</a></div>
    </form>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Customer</th>
            <th>Technician</th>
            <th>Priority</th>
            <th>Status</th>
            <th></th>
        </tr>@forelse($requests as $r)
            <tr>
                <td>{{$r->id}}</td>
                <td>{{$r->title}}</td>
                <td>{{$r->customer?->name}}</td>
                <td>{{$r->technician?->name}}</td>
                <td>{{$r->priority}}</td>
                <td>{{$r->status}}</td>
                <td>@can('view', $r)<a href="{{route('requests.show', $r)}}">View</a>@endcan
                    @can('update', $r)<a href="{{route('requests.edit', $r)}}">Edit</a>@endcan</td>
        </tr>@empty<tr>
            <td colspan="7">No results</td>
        </tr>@endforelse
</table>{{$requests->links()}}@endsection