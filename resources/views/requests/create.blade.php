@extends('layouts.app') @section('content')
    <h1>Create</h1>
    <form method="POST" action="{{route('requests.store')}}">@csrf
        <div>
            <label>Customer</label>
            <select name="customer_id">
                <option value="">-- Select customer --</option>@foreach($customers as $c)
                <option value="{{$c->id}}" @selected(old('customer_id') == $c->id)>{{$c->name}}</option>@endforeach
            </select>
            @error('customer_id')<div class="field-error">{{$message}}</div>@enderror
        </div>

        <div>
            <label>Technician (optional)</label>
            <select name="technician_id">
                <option value="">-- Not assigned --</option>@foreach($technicians as $t)
                <option value="{{$t->id}}" @selected(old('technician_id') == $t->id)>{{$t->name}}</option>@endforeach
            </select>
            @error('technician_id')<div class="field-error">{{$message}}</div>@enderror
        </div>

        <div>
            <label>Title</label>
            <input name="title" placeholder="Title" value="{{old('title')}}">
            @error('title')<div class="field-error">{{$message}}</div>@enderror
        </div>

        <div>
            <label>Description</label>
            <textarea name="description" placeholder="Description">{{old('description')}}</textarea>
            @error('description')<div class="field-error">{{$message}}</div>@enderror
        </div>

        <div>
            <label>Priority</label>
            <select name="priority">@foreach(['low', 'medium', 'high'] as $p)
                <option value="{{$p}}" @selected(old('priority', 'medium') === $p)>{{$p}}</option>@endforeach
            </select>
            @error('priority')<div class="field-error">{{$message}}</div>@enderror
        </div>

        <div>
            <label>Requested date</label>
            <input name="requested_at" type="date" value="{{old('requested_at', now()->format('Y-m-d'))}}">
            @error('requested_at')<div class="field-error">{{$message}}</div>@enderror
        </div>

        <button>Save</button>
    </form>
@endsection
