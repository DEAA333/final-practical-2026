<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maintenance Exam</title>
    <style>
        body{font-family:Arial,sans-serif;max-width:1100px;margin:30px auto;padding:0 20px}
        nav{display:flex;gap:15px;margin-bottom:25px;align-items:center}
        table{width:100%;border-collapse:collapse}
        th,td{border:1px solid #ddd;padding:9px;text-align:left}
        input,select,textarea{padding:8px;width:100%;box-sizing:border-box}
        .row{display:grid;grid-template-columns:repeat(2,1fr);gap:15px}
        .card{border:1px solid #ddd;padding:20px;margin:10px 0}
        .success{padding:10px;background:#e4f6e8;margin-bottom:15px}
        .error{color:#a00}
        .actions{display:flex;gap:8px;align-items:center}
    </style>
</head>
<body>
<nav>
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <a href="{{ route('requests.index') }}">Requests</a>
    <a href="{{ route('requests.create') }}">New Request</a>
    @auth
        <span>{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button>Logout</button>
        </form>
    @endauth
</nav>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="error">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@yield('content')
</body>
</html>
