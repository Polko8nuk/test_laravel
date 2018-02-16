<!DOCTYPE html>
<html>
    <head>
        <title>Тестирование</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="../../css/main.css">

        <script src="../../js/jquery-3.2.1.js"></script>
        <script src="../../js/main.js"></script>
        <script src="../../js/auth.js"></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    </head>
    <body>
        @yield('task')
    </body>
</html>