@extends('layouts.app') @section('content')
    <h1>Edit #{{$maintenanceRequest->id}}</h1>
    <form method="POST" action="{{route('requests.update', $maintenanceRequest)}}">@csrf @method('PUT')
        <div>
            <label>Title</label>
            <input name="title" value="{{old('title', $maintenanceRequest->title)}}">
            @error('title')<div class="field-error">{{$message}}</div>@enderror
        </div>

        <div>
            <label>Description</label>
            <textarea name="description">{{old('description', $maintenanceRequest->description)}}</textarea>
            @error('description')<div class="field-error">{{$message}}</div>@enderror
        </div>

        <div>
            <label>Customer</label>
            <select name="customer_id">@foreach($customers as $c)
                <option value="{{$c->id}}" @selected(old('customer_id', $maintenanceRequest->customer_id) == $c->id)>{{$c->name}}</option>@endforeach
            </select>
            @error('customer_id')<div class="field-error">{{$message}}</div>@enderror
        </div>

        <div>
            <label>Technician</label>
            <select name="technician_id">
                <option value="">-- Not assigned --</option>@foreach($technicians as $t)
                <option value="{{$t->id}}" @selected(old('technician_id', $maintenanceRequest->technician_id) == $t->id)>{{$t->name}}</option>@endforeach
            </select>
            @error('technician_id')<div class="field-error">{{$message}}</div>@enderror
        </div>

        <div>
            <label>Priority</label>
            <select name="priority">@foreach(['low', 'medium', 'high'] as $p)
                <option value="{{$p}}" @selected(old('priority', $maintenanceRequest->priority) === $p)>{{$p}}</option>@endforeach
            </select>
            @error('priority')<div class="field-error">{{$message}}</div>@enderror
        </div>

        <div>
            <label>Status</label>
            <select name="status">@foreach(['pending', 'in_progress', 'completed', 'cancelled'] as $s)
                <option value="{{$s}}" @selected(old('status', $maintenanceRequest->status) === $s)>{{$s}}</option>@endforeach
            </select>
            @error('status')<div class="field-error">{{$message}}</div>@enderror
        </div>

        <div>
            <label>Requested date</label>
            <input name="requested_at" type="date"
                value="{{old('requested_at', $maintenanceRequest->requested_at?->format('Y-m-d'))}}">
            @error('requested_at')<div class="field-error">{{$message}}</div>@enderror
        </div>

        <button>Update</button>
    </form>
    <a href="{{route('requests.show', $maintenanceRequest)}}">Cancel</a>
@endsection
