<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Login</title></head>
<body>
<h1>Login</h1>
@if($errors->any())
<ul>
@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
</ul>
@endif
<form method="POST" action="{{ route('login.store') }}">
    @csrf
    <label>Email</label>
    <input type="email" name="email" value="{{ old('email') }}">
    <label>Password</label>
    <input type="password" name="password">
    <label><input type="checkbox" name="remember"> Remember me</label>
    <button type="submit">Login</button>
</form>
</body>
</html>
