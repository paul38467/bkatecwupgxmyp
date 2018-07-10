@extends('layouts.master')

@section('page_title', '編輯藝人的標籤分類')

@section('content')
    <h4 class="pb-2">編輯藝人的標籤分類</h4>
    @component('components.edit_delete_view')
        @slot('header_edit', '編輯分類')
        @slot('header_delete', '刪除分類')
        @slot('data_total', $artist_tagcat->tag_total)
        @slot('url_back', route('artist-tagcat.index'))
        @slot('action_update', route('artist-tagcat.update', $artist_tagcat))
        @slot('action_delete', route('artist-tagcat.destroy', $artist_tagcat))

        <label for="tagcat_name">分類 ID: {{ $artist_tagcat->id }}</label>
        <input type="text" id="tagcat_name" name="tagcat_name" value="{{ old('tagcat_name', $artist_tagcat->tagcat_name) }}" class="form-control ml-2" placeholder="輸入分類名稱" aria-label="輸入分類名稱">
    @endcomponent
@endsection
