<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title> @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{asset('theme/font/iconsmind/style.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/font/simple-line-icons/css/simple-line-icons.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/css/vendor/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/css/vendor/bootstrap-float-label.min.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/css/all.min.css')}}" />

    <link rel="icon" type="image/png" href="{{asset('images/loopfy.png')}}">
    <link rel="apple-touch-icon" href="{{asset('images/loopfy.png')}}">
</head>



<body class="background show-spinner">
    <main>
        @yield('content')

    </main>
    <script src="{{asset('theme/js/vendor/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('theme/js/vendor/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('theme/js/vendor/bootstrap-notify.min.js')}}"></script>
    <script src="{{asset('theme/js/dore.script.js')}}"></script>
    @yield("js")
    <script src="{{asset('theme/js/scripts.js')}}"></script>
    

</body>

</html>