@extends('layouts.master')

@section('page_title', '藝人 - 新增')

@section('content')
    @include('layouts.blocks.errors')

    @if (blank($regions))
        缺少了地區資料，請先新增一個地區, 才能新增藝人。
    @else
        @include('artist.blocks.form_profile', ['doAction' => 'create'])
    @endif
@endsection
