<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Laravel CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('plugin/bootstrap-4.1.1-dist/css/bootstrap.min.css') }}">

    <!-- Font Awesome 4.7.0 -->
    <link rel="stylesheet" href="{{ asset('plugin/font-awesome-4.7.0/css/font-awesome.min.css') }}">

    <title>{{ config('app.name') }} - @yield('page_title')</title>
    <link rel="shortcut icon" href="/favicon.ico">
</head>
<body>
    <!-- show bodyWrapper if JavaScript enabled -->
    <div id="bodyWrapper" style="display: none">
        @include('layouts.blocks.navbar')
        <hr>

        @yield('content')
        <hr>

        @include('layouts.blocks.sidebar')
        <hr>

        @include('layouts.blocks.footer')
        <hr>
    </div><!-- /#bodyWrapper -->

    <noscript><center>Please enable Javascript in your browser settings to view full site!</center></noscript>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <!-- jquery-3.3.1 -->
    <script src="{{ asset('plugin/jquery-3.3.1/jquery-3.3.1.min.js') }}"></script>

    <!-- bootstrap, bootstrap.bundle.min.js already included popper.min.js -->
    <script src="{{ asset('plugin/bootstrap-4.1.1-dist/js/bootstrap.bundle.min.js') }}"></script>

    <script type="text/javascript">
        // if JavaScript enabled, show #bodyWrapper
        $("#bodyWrapper").show();

        // Laravel CSRF Token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</body>
</html>
