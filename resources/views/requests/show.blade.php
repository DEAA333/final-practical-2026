@extends('layouts.app') @section('content')
    <h1>Request #{{$m->id}}</h1>
    <div class="card">
        <p><b>Title:</b> {{$m->title}}</p>
        <p><b>Description:</b> {{$m->description}}</p>
        <p><b>Customer:</b> {{$m->customer?->name}}</p>
        <p><b>Technician:</b> {{$m->technician?->name}}</p>
        <p><b>Priority:</b> {{$m->priority}}</p>
        <p><b>Status:</b> {{$m->status}}</p>
    </div>
    @can('update', $m)<a href="{{route('requests.edit', $m)}}">Edit</a>@endcan
    @can('delete', $m)
        <form method="POST" action="{{route('requests.destroy', $m)}}">@csrf @method('DELETE')<button>Delete</button></form>
    @endcan
    @if($m->rating)
        <div class="card">
            <h3>Rating</h3>
            <p><b>Score:</b> {{$m->rating->rating}} / 5</p>
            <p><b>Comment:</b> {{$m->rating->comment ?: '-'}}</p>
        </div>
    @elseif($m->status === 'completed')
        <div class="card">
            <h3>Rate this request</h3>
            <form method="POST" action="{{route('ratings.store', $m)}}">@csrf
                <label>Your customer ID</label>
                <input name="customer_id" placeholder="Customer ID" value="{{old('customer_id')}}">
                @error('customer_id')<div class="field-error">{{$message}}</div>@enderror

                <label>Score (1-5)</label>
                <input name="rating" type="number" min="1" max="5" value="{{old('rating')}}">
                @error('rating')<div class="field-error">{{$message}}</div>@enderror

                <label>Comment (optional)</label>
                <textarea name="comment">{{old('comment')}}</textarea>
                @error('comment')<div class="field-error">{{$message}}</div>@enderror

                <button>Rate</button>
            </form>
        </div>
    @else
        <p><i>Rating is available only after the request is completed.</i></p>
    @endif
@endsection