<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('plugin/bootstrap-4.1.1-dist/css/bootstrap.min.css') }}">

    <!-- my_style.css -->
    <link rel="stylesheet" href="{{ asset('my_asset/my_style.css') }}">

    <title>{{ config('app.name') }} - @yield('page_title')</title>
    <link rel="shortcut icon" href="/favicon.ico">
</head>
<body>
    <div class="container mt-5">
        @yield('content')
    </div><!-- /.container -->
</body>
</html>
