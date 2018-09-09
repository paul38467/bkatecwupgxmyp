@extends('layouts.master')

@section('page_title', '管理藝人的標籤')

@section('content')
    <h5 class="pb-2">管理藝人的標籤</h5>
    @include('layouts.blocks.errors')

    @forelse($artist_tagcats as $artist_tagcat)
        <form method="POST" action="{{ route('artist-tag.store') }}">
            @csrf

            <div class="d-inline-flex">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ $artist_tagcat->tagcat_name }}</span>
                    </div>
                    <input type="text" name="tag_name" value="" class="form-control" placeholder="輸入標籤名稱" aria-label="輸入標籤名稱">
                    <div class="input-group-append">
                        <input type="hidden" name="tagcat_id" value="{{ $artist_tagcat->id }}">
                        <button class="btn btn-outline-secondary disable-on-click" type="submit">新增</button>
                    </div>
                </div>
            </div>
        </form>

        <table class="table table-hover table-bordered mb-5">
            <thead class="table-success">
                <tr>
                    <th class="col-md-1" scope="col">標籤 ID</th>
                    <th class="col-md-1" scope="col">標籤分類</th>
                    <th class="col-md-8" scope="col">標籤名稱</th>
                    <th class="col-md-1 text-center" scope="col">藝人數量</th>
                    <th class="col-md-1 text-center" scope="col">管理</th>
                </tr>
            </thead>
            <tbody>
                @forelse($artist_tagcat->artistTag as $artist_tag)
                    <tr>
                        <th scope="row">{{ $artist_tag->id }}</th>
                        <td>{{ $artist_tagcat->tagcat_name }}</td>
                        <td><i class="fa fa-tag fa-fw text-success"></i> {{ $artist_tag->tag_name }}</td>
                        <td class="text-right text-danger">{{ number_format($artist_tag->artist->count()) }}</td>
                        <td class="text-center">
                            <a class="btn btn-primary btn-sm" href="{{ route('artist-tag.edit', $artist_tag) }}">
                                <i class="fa fa-edit fa-lg"></i> 編輯
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">沒有任何標籤</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @empty
        沒有任何相關資料
    @endforelse
@endsection
