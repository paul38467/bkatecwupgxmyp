@extends('layouts.master')

@section('page_title', '編輯地區')

@section('content')
    <h4 class="pb-2">地區管理</h4>
    <div class="container w-50 mb-3">
        <div class="card">
            <h5 class="card-header text-center">編輯地區</h5>
            <div class="card-body">
                @include('layouts.blocks.errors')

                <div class="d-flex justify-content-center">
                    <form class="form-inline" method="POST" action="{{ route('region.update', $region) }}">
                        @method('PATCH')
                        @csrf

                        <div class="form-group">
                            <label for="region_name">地區 ID: {{ $region->id }}</label>
                            <input type="text" id="region_name" name="region_name" value="{{ old('region_name', $region->region_name) }}" class="form-control ml-2" placeholder="輸入地區名稱" aria-label="輸入地區名稱">
                        </div>
                        <button type="submit" class="btn btn-success ml-2">儲存</button>
                    </form>
                </div>
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div><!-- /.container -->

    <div class="container w-50">
        <div class="card">
            <h5 class="card-header text-center">刪除地區</h5>
            <div class="card-body text-center">
                @if ($region->category_data_total)
                    <div class="row text-left mb-3">
                        <div class="col-2">藝人：</div>
                        <div class="col">{{ $region->artist_count }} 筆資料</div>
                        <div class="w-100"></div>
                        <div class="col-2">AV：</div>
                        <div class="col">{{ $region->av_count }} 筆資料</div>
                        <div class="w-100"></div>
                        <div class="col-2">電影：</div>
                        <div class="col">{{ $region->movie_count }} 筆資料</div>
                    </div>
                @endif

                {{-- 防止刪除有資料的地區 --}}
                @if (session('delete_not_allowed'))
                    @component('components.alert', ['color' => 'danger'])
                        {{ session('delete_not_allowed') }}
                    @endcomponent
                @endif

                <form method="POST" action="{{ route('region.destroy', $region) }}">
                    @method('DELETE')
                    @csrf

                    <button type="submit" class="btn btn-danger"{{ ($region->category_data_total) ? ' disabled' : '' }}>刪除</button>
                </form>
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div><!-- /.container -->
@endsection
