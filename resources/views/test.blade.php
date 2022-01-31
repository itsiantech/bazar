<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>




<script src="{{asset('js/main.js')}}"></script>
<script>
    Echo.channel('test')
        .listen('TestEvent', e => {
            console.log(e)
        })
</script>
</body>
</html>
