@extends('layouts.app')

@section('content')
<h1>Edit Request #{{ $maintenanceRequest->id }}</h1>

<form method="POST" action="{{ route('requests.update',$maintenanceRequest) }}">
@csrf
@method('PUT')

<p><label>Title</label>
<input name="title" value="{{ old('title',$maintenanceRequest->title) }}"></p>

<p><label>Description</label>
<textarea name="description">{{ old('description',$maintenanceRequest->description) }}</textarea></p>

<div class="row">
<div>
<label>Customer</label>
<select name="customer_id">
@foreach($customers as $customer)
<option value="{{ $customer->id }}" @selected(old('customer_id',$maintenanceRequest->customer_id)==$customer->id)>
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
<option value="{{ $technician->id }}" @selected(old('technician_id',$maintenanceRequest->technician_id)==$technician->id)>
{{ $technician->name }}
</option>
@endforeach
</select>
</div>
</div>

<div class="row">
<div>
<label>Priority</label>
<select name="priority">
@foreach(['low','medium','high'] as $priority)
<option value="{{ $priority }}" @selected(old('priority',$maintenanceRequest->priority)===$priority)>
{{ ucfirst($priority) }}
</option>
@endforeach
</select>
</div>
<div>
<label>Status</label>
<select name="status">
@foreach(['pending','in_progress','completed','cancelled'] as $status)
<option value="{{ $status }}" @selected(old('status',$maintenanceRequest->status)===$status)>
{{ ucfirst(str_replace('_',' ',$status)) }}
</option>
@endforeach
</select>
</div>
</div>

<p><label>Requested date</label>
<input type="date" name="requested_at" value="{{ old('requested_at',$maintenanceRequest->requested_at?->format('Y-m-d')) }}"></p>

<button type="submit">Update</button>
</form>
@endsection
