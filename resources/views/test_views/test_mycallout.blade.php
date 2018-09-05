@extends('layouts.master')

@section('page_title', 'Test component bdcallout')

@section('content')
<div class="container">
    <h3>Test mycallout</h3>

    <div class="w-25">
        <div class="my-callout my-callout-primary text-center">
            <h5>來源日期</h5>
            3年前
            <p><small class="text-muted">2018-01-02 10:32:33</small></p>
        </div>
        <div class="my-callout my-callout-success text-center">
            <h5>出生日期</h5>
            3年前
            <p><small class="text-muted">2018-01-02 10:32:33</small></p>
        </div>
        <div class="my-callout my-callout-secondary text-center">
            <h5>死亡日期</h5>
                -----
        </div>
    </div>
</div><!-- /.container -->
@endsection

@push('master_css')
    <!-- bootstrap-my-callout.css -->
    <link rel="stylesheet" href="/my_asset/bootstrap-my-callout.css">

@endpush
