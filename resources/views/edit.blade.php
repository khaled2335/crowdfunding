<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form action="{{route('user.update', $item->id)}}" method="post">
    @csrf
    @method('Put')
    <input type="text" name="phone" value="{{$item->phone}}">
    <button type="submit">submit</button>


    </form>
</body>
</html>