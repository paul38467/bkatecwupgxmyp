@extends('layouts.master')

@section('page_title', '藝人')

@section('content')
    <h5 class="pb-2">藝人</h5>
    @include('layouts.blocks.errors')

    @if (blank($artists))
        沒有任何相關資料
    @else
        @include('components.pagination', ['pagination' => $artists])
        @include('components.pagination_text', ['pagination' => $artists])

        @include ('artist.blocks.avatar_cards', ['artist' => $artists])

        @include('components.pagination', ['pagination' => $artists])
    @endif
@endsection
