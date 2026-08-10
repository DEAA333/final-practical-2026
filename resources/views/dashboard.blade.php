@extends('layouts.app')

@section('content')
<h1>Dashboard</h1>
<div class="row">
    <div class="card"><strong>Total</strong><h2>{{ $total }}</h2></div>
    <div class="card"><strong>Pending</strong><h2>{{ $pending }}</h2></div>
    <div class="card"><strong>In progress</strong><h2>{{ $inProgress }}</h2></div>
    <div class="card"><strong>Completed</strong><h2>{{ $completed }}</h2></div>
</div>
@endsection
