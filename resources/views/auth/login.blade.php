<!doctype html>
<html>

<body>
    <h1>Login</h1>
    <form method="POST" action="{{route('login.store')}}">@csrf<input name="email" type="email"
            placeholder="Email"><input name="password" type="password" placeholder="Password"><button>Login</button>
    </form>
</body>

</html>