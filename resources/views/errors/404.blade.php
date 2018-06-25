@extends('layouts.errors_master')

@section('page_title', 'Error 404')

@section('content')
    @component('components.alert_with', ['color' => 'info', 'header' => 'Error 404'])
        @slot('body')
            {{ $exception->getMessage() }}
        @endslot

        <p class="mb-0 text-center">{{ config('app.name') }} <a href="{{ url('/') }}">{{ url('/') }}</a></p>
    @endcomponent
@endsection
