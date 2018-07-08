@extends('layouts.master')

@section('page_title', '地區管理')

@section('content')
    <h4 class="pb-2">地區管理</h4>
    @include('layouts.blocks.errors')
    <form method="POST" action="{{ route('region.store') }}">
        @csrf

        <div class="d-inline-flex">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">新增地區</span>
                </div>
                <input type="text" id="region_name" name="region_name" value="{{ old('region_name') }}" class="form-control" placeholder="輸入地區名稱" aria-label="輸入地區名稱">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">新增</button>
                </div>
            </div>
        </div>
    </form>

    @if (count($regions))
        <table class="table table-hover table-bordered">
            <thead class="table-success">
                <tr>
                    <th class="col-md-1" scope="col">地區 ID</th>
                    <th class="col-md-6" scope="col">地區名稱</th>
                    <th class="col-md-1 text-center" scope="col">藝人數量</th>
                    <th class="col-md-1 text-center" scope="col">AV 數量</th>
                    <th class="col-md-1 text-center" scope="col">電影數量</th>
                    <th class="col-md-1 text-center" scope="col">總數量</th>
                    <th class="col-md-1 text-center" scope="col">管理</th>
                </tr>
            </thead>
            <tbody>
                @foreach($regions as $region)
                    <tr>
                        <th scope="row">{{ $region->id }}</th>
                        <td><i class="fa fa-flag fa-fw text-success"></i> {{ $region->region_name }}</td>
                        <td class="text-right">{{ number_format($region->artist_count) }}</td>
                        <td class="text-right">{{ number_format($region->av_count) }}</td>
                        <td class="text-right">{{ number_format($region->movie_count) }}</td>
                        <td class="text-right text-danger">{{ number_format($region->category_data_total) }}</td>
                        <td class="text-center">
                            <a class="btn btn-primary btn-sm" href="{{ route('region.edit', $region) }}">
                                <i class="fa fa-edit fa-lg"></i> 編輯
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        沒有任何相關資料
    @endif
@endsection
