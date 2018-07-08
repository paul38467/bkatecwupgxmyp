@extends('layouts.master')

@section('page_title', '編輯地區')

@section('content')
    <h4 class="pb-2">地區管理</h4>
    @component('components.edit_delete_view')
        @slot('header_edit', '編輯地區')
        @slot('header_delete', '刪除地區')
        @slot('data_total', $region->category_data_total)
        @slot('url_back', route('region.index'))
        @slot('action_update', route('region.update', $region))
        @slot('action_delete', route('region.destroy', $region))

        <label for="region_name">地區 ID: {{ $region->id }}</label>
        <input type="text" id="region_name" name="region_name" value="{{ old('region_name', $region->region_name) }}" class="form-control ml-2" placeholder="輸入地區名稱" aria-label="輸入地區名稱">
    @endcomponent
@endsection
