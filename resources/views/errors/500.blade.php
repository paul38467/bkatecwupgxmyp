@extends('layouts.errors_master')

@section('page_title', 'Error 500')

@section('content')
    @component('components.alert_with', ['color' => 'danger', 'header' => 'Error 500'])
        @slot('body')
            {{ $exception->getMessage() }}
        @endslot

        <p class="mb-0 text-center">{{ config('app.name') }} <a href="{{ url('/') }}">{{ url('/') }}</a></p>
    @endcomponent
@endsection
