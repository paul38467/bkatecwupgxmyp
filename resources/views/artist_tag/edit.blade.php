@extends('layouts.master')

@section('page_title', '編輯藝人的標籤')

@section('content')
    <h5 class="pb-2">編輯藝人的標籤</h5>
    @component('components.edit_delete_view')
        @slot('header_edit', '編輯標籤')
        @slot('header_delete', '刪除標籤')
        @slot('data_total', $artist_tag->artist->count())
        @slot('url_back', route('artist-tag.index'))
        @slot('action_update', route('artist-tag.update', $artist_tag))
        @slot('action_delete', route('artist-tag.destroy', $artist_tag))

        <label for="artistTagTagName">標籤 ID: {{ $artist_tag->id }}</label>
        <input type="hidden" name="tagcat_id" value="{{ $artist_tag->tagcat_id }}">
        <input type="text" id="artistTagTagName" name="tag_name" value="{{ old('tag_name', $artist_tag->tag_name) }}" class="form-control ml-2" placeholder="輸入標籤名稱" aria-label="輸入標籤名稱">
    @endcomponent
@endsection
