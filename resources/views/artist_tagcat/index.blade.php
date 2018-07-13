@extends('layouts.master')

@section('page_title', '管理藝人的標籤分類')

@section('content')
    <h4 class="pb-2">管理藝人的標籤分類</h4>
    @include('layouts.blocks.errors')
    <form method="POST" action="{{ route('artist-tagcat.store') }}">
        @csrf

        <div class="d-inline-flex">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">新增分類</span>
                </div>
                <input type="text" id="tagcat_name" name="tagcat_name" value="{{ old('tagcat_name') }}" class="form-control" placeholder="輸入分類名稱" aria-label="輸入分類名稱">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">新增</button>
                </div>
            </div>
        </div>
    </form>

    @if (count($artist_tagcats))
        <table class="table table-hover table-bordered">
            <thead class="table-success">
                <tr>
                    <th class="col-md-1" scope="col">分類 ID</th>
                    <th class="col-md-9" scope="col">分類名稱</th>
                    <th class="col-md-1 text-center" scope="col">標籤數量</th>
                    <th class="col-md-1 text-center" scope="col">管理</th>
                </tr>
            </thead>
            <tbody>
                @foreach($artist_tagcats as $artist_tagcat)
                    <tr>
                        <th scope="row">{{ $artist_tagcat->id }}</th>
                        <td><i class="fa fa-tags fa-fw text-success"></i> {{ $artist_tagcat->tagcat_name }}</td>
                        <td class="text-right text-danger">{{ number_format($artist_tagcat->artist_tag_count) }}</td>
                        <td class="text-center">
                            <a class="btn btn-primary btn-sm" href="{{ route('artist-tagcat.edit', $artist_tagcat) }}">
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
