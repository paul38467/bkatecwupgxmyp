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
    <link rel="stylesheet" href="/plugin/bootstrap-4.1.1-dist/css/bootstrap.min.css">

    <!-- Font Awesome 4.7.0 -->
    <link rel="stylesheet" href="/plugin/font-awesome-4.7.0/css/font-awesome.min.css">

    @stack('master_css')

    <!-- my_style.css -->
    <link rel="stylesheet" href="/my_asset/my_style.css">

    <title>{{ config('app.name') }} - @yield('page_title')</title>
    <link rel="shortcut icon" href="/favicon.ico">
</head>
<body>
    <!-- show bodyWrapper if JavaScript enabled -->
    <div id="bodyWrapper" style="display: none">
        <!-- start navbar -->
        @include('layouts.blocks.navbar')
        <!-- end navbar -->

        <main role="main" class="container-fluid">
            <div class="row">

                <!-- start content -->
                <div class="col-12 col-lg-10 my-content-pt">
                    @yield('content')
                </div><!-- /.col -->
                <!-- end content -->

                <!-- start sidebar -->
                <div class="col-6 col-lg-2 my-sidebar-pt">
                    <div class="sticky-top">
                        <h4>sticky-top div</h4>
                        @include('layouts.blocks.sidebar')
                    </div><!-- /.sticky-top -->
                </div><!-- /.col -->
                <!-- end sidebar -->

            </div><!-- /.row -->
        </main>

        <!-- start footer -->
        {{-- @include('layouts.blocks.footer') --}}
        <!-- end footer -->
    </div><!-- /#bodyWrapper -->

    <noscript><center>Please enable Javascript in your browser settings to view full site!</center></noscript>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <!-- jquery-3.3.1 -->
    <script src="/plugin/jquery-3.3.1/jquery-3.3.1.min.js"></script>

    <!-- bootstrap, bootstrap.bundle.min.js already included popper.min.js -->
    <script src="/plugin/bootstrap-4.1.1-dist/js/bootstrap.bundle.min.js"></script>

    @stack('master_script_src')

    <script type="text/javascript">
        // if JavaScript enabled, show #bodyWrapper
        $("#bodyWrapper").show();

        // submit button disable on click
        $(".disable-on-click").click(function() {
            $(this).prop('disabled', true);
        });

        // Laravel CSRF Token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {
            @stack('master_script')
        });
    </script>
</body>
</html>
