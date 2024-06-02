<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  


     
     
    <a href="">users</a><br>
    <a href="{{route('logout.user')}}">logout</a><br>
    <a href="{{route('user.edit',auth()->user()->id)}}">edit</a><br>
 
</body>
</html>