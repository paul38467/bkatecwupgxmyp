@extends('layouts.errors_master')

@section('page_title', 'Error 403')

@section('content')
    @component('components.alert_with', ['color' => 'warning', 'header' => 'Error 403'])
        @slot('body')
            {{ $exception->getMessage() }}
        @endslot

        <p class="mb-0 text-center">{{ config('app.name') }} <a href="{{ url('/') }}">{{ url('/') }}</a></p>
    @endcomponent
@endsection
