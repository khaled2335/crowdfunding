<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{route('login.login')}}" method="post">
    @csrf
<input className="col-12 " name="email" type="email" placeholder="Name" value="{{ old('email') }}" />
<input className="col-12 " id="password"  type="password" name="password" placeholder="password"value="{{ old('password') }}" />
<button type="submit">login</button>
</form>
</body>
</html>