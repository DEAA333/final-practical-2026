@extends('layouts.app')

@section('content')
<h1>Request #{{ $maintenanceRequest->id }}</h1>

<div class="card">
<p><strong>Title:</strong> {{ $maintenanceRequest->title }}</p>
<p><strong>Description:</strong> {{ $maintenanceRequest->description }}</p>
<p><strong>Customer:</strong> {{ $maintenanceRequest->customer->name }}</p>
<p><strong>Phone:</strong> {{ $maintenanceRequest->customer->phone }}</p>
<p><strong>Technician:</strong> {{ $maintenanceRequest->technician?->name ?? 'Not assigned' }}</p>
<p><strong>Priority:</strong> {{ $maintenanceRequest->priority }}</p>
<p><strong>Status:</strong> {{ $maintenanceRequest->status }}</p>
<p><strong>Requested:</strong> {{ $maintenanceRequest->requested_at?->format('Y-m-d') }}</p>
</div>

@if($maintenanceRequest->rating)
<div class="card">
<h3>Rating</h3>
<p>{{ $maintenanceRequest->rating->rating }}/5</p>
<p>{{ $maintenanceRequest->rating->comment }}</p>
</div>
@elseif($maintenanceRequest->status === 'completed')
<div class="card">
<h3>Add rating</h3>
<form method="POST" action="{{ route('ratings.store',$maintenanceRequest) }}">
@csrf
<label>Customer ID</label>
<input name="customer_id">
<label>Rating</label>
<input type="number" min="1" max="5" name="rating">
<label>Comment</label>
<textarea name="comment"></textarea>
<button type="submit">Save rating</button>
</form>
</div>
@endif

<div class="actions">
<a href="{{ route('requests.edit',$maintenanceRequest) }}">Edit</a>
<form method="POST" action="{{ route('requests.destroy',$maintenanceRequest) }}">
@csrf
@method('DELETE')
<button type="submit">Delete</button>
</form>
</div>
@endsection
