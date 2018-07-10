<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>

            <!-- navbar dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>

            <!-- navbar dropdown - navbarTestViews -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarTestViews" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Test Views</a>
                <div class="dropdown-menu" aria-labelledby="navbarTestViews">
                    <a class="dropdown-item" href="{{ asset('/test-views/test-layouts') }}">test-layouts</a>
                    <a class="dropdown-item" href="{{ asset('/test-views/test-bdcallout') }}">test-bdcallout</a>
                    <a class="dropdown-item" href="{{ asset('/test-views/test-alert') }}">test-alert</a>
                    <a class="dropdown-item" href="{{ asset('/test-views/test-alert-with') }}">test-alert-with</a>
                </div>
            </li>

            <!-- navbar dropdown - navbarManagement -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarManagement" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">管理</a>
                <div class="dropdown-menu" aria-labelledby="navbarManagement">
                    <a class="dropdown-item" href="{{ route('region.index') }}">地區管理</a>
                    <a class="dropdown-item" href="{{ route('artist-tagcat.index') }}">管理藝人的標籤分類</a>
                </div>
            </li>

        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div><!-- /#navbarSupportedContent -->
</nav>
