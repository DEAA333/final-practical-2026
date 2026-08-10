@extends('layouts.app')

@section('content')
<h1>Create Maintenance Request</h1>

<form method="POST" action="{{ route('requests.store') }}">
@csrf

<div class="row">
<div>
<label>Customer</label>
<select name="customer_id">
<option value="">Select customer</option>
@foreach($customers as $customer)
<option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>
{{ $customer->name }}
</option>
@endforeach
</select>
</div>

<div>
<label>Technician</label>
<select name="technician_id">
<option value="">Not assigned</option>
@foreach($technicians as $technician)
<option value="{{ $technician->id }}" @selected(old('technician_id') == $technician->id)>
{{ $technician->name }}
</option>
@endforeach
</select>
</div>
</div>

<p><label>Title</label><input name="title" value="{{ old('title') }}"></p>
<p><label>Description</label><textarea name="description">{{ old('description') }}</textarea></p>

<div class="row">
<div>
<label>Priority</label>
<select name="priority">
@foreach(['low','medium','high'] as $priority)
<option value="{{ $priority }}" @selected(old('priority','medium') === $priority)>
{{ ucfirst($priority) }}
</option>
@endforeach
</select>
</div>
<div>
<label>Requested date</label>
<input type="date" name="requested_at" value="{{ old('requested_at',now()->format('Y-m-d')) }}">
</div>
</div>

<br><button type="submit">Save</button>
</form>
@endsection
