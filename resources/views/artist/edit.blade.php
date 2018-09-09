@extends('layouts.master')

@section('page_title', '藝人 - 編輯個人檔案')

@section('content')
    @include('layouts.blocks.errors')
    @include('artist.blocks.form_profile', ['doAction' => 'edit'])
@endsection
