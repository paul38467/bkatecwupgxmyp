@extends('layouts.master')

@section('page_title', 'Fetchaa - 匯入資料')

@section('content')
    <div class="container w-75 mt-3">
        @include('layouts.blocks.errors')

        @if (session('lastFetchDate'))
            <!-- start import result -->
            <div class="card bg-light">
                <h5 class="card-header">Fetchaa - 匯入成功</h5>
                <div class="card-body">
                    <h5 class="card-title">時間花了 {{ session('importTime') }}</h5>
                    @if (session('txtsCount') == session('dbSavedCount'))
                        <p class="card-text">
                            <i class="fa fa-check fa-fw fa-3x text-success"></i>
                            txt 檔案數目 {{ number_format(session('txtsCount')) }}，
                            和儲存的資料數目 {{ number_format(session('dbSavedCount')) }}，完全相同。
                            <a href="{{ route('fetchaa.unread') }}">按此進入未檢查的文章</a>
                        </p>
                    @else
                        <p class="card-text text-danger">
                            <i class="fa fa-close fa-fw fa-3x"></i>
                            txt 檔案數目 {{ number_format(session('txtsCount')) }}，
                            和儲存的資料數目 {{ number_format(session('dbSavedCount')) }}，不相同。
                        </p>
                    @endif
                </div>
            </div>

            <div class="card bg-light mt-3">
                <h5 class="card-header">Fetchaa - 最後新增的一筆記錄</h5>
                <div class="card-body">
                    <p class="card-text">id：{{ session('lastId') }}</p>
                    <p class="card-text">fetch_date：{{ session('lastFetchDate') }}</p>
                    <p class="card-text">tid：{{ session('lastTid') }}</p>
                </div>
            </div>
            <!-- end import result -->
        @else
            <!-- start import form -->
            <div class="card bg-light">
                <h5 class="card-header">Fetchaa - 匯入資料</h5>
                <div class="card-body">
                    <h5 class="card-title">有 {{ number_format($fetchaaImportTxtCount) }} 筆新資料</h5>
                    <p class="card-text text-danger">匯入資料前，請先關閉系統上的 {{ $cfg['fetchaa']['importDir'] }} 資料夾。</p>
                    <form method="POST" action="{{ route('fetchaa.store-import') }}">
                        @csrf

                        <button type="submit" class="btn btn-primary disable-on-click" {{ $fetchaaImportTxtCount ? "" : "disabled" }}>匯入資料</button>
                    </form>
                </div>
            </div>
            <!-- end import form -->
        @endif
    </div><!-- /.container -->
@endsection
