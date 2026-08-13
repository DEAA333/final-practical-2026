<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login</title>
    <style>
        body {
            font-family: Arial;
            max-width: 380px;
            margin: 60px auto;
            padding: 0 20px
        }

        input {
            width: 100%;
            padding: 8px;
            margin: 6px 0;
            box-sizing: border-box
        }

        .errors {
            padding: 10px;
            background: #fde8e8;
            border: 1px solid #f5b5b5;
            margin-bottom: 15px
        }
    </style>
</head>

<body>
    <h1>Login</h1>

    @if($errors->any())
        <div class="errors">
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{$e}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{route('login.store')}}">@csrf
        <input name="email" type="email" placeholder="Email" value="{{old('email')}}">
        <input name="password" type="password" placeholder="Password">
        <button>Login</button>
    </form>
</body>

</html>
