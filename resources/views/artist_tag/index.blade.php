@extends('layouts.master')

@section('page_title', '管理藝人的標籤')

@section('content')
    <h4 class="pb-2">管理藝人的標籤</h4>
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
                        <button class="btn btn-outline-secondary" type="submit" name="tagcat_id" value="{{ $artist_tagcat->id }}">新增</button>
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
                        {{-- 將來要在 number_format(填上使用這個標籤的藝人數量) --}}
                        <td class="text-right text-danger">{{ number_format('0') }}</td>
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
