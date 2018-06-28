@extends('layouts.master')

@section('page_title', 'Test component alert_with')

@section('content')
<div class="container">
    <h3>Test component alert_with</h3>

    @component('components.alert_with', ['color' => 'info', 'header' => 'Error 404'])
        @slot('body')
            error string ...
        @endslot

        <p class="mb-0 text-center">{{ config('app.name') }} <a href="{{ url('/') }}">{{ url('/') }}</a></p>
    @endcomponent

    @component('components.alert_with', ['color' => 'warning', 'header' => 'Error 403', 'icon' => 'fa-hand-paper-o'])
        @slot('body')
            error string ...
        @endslot

        <p class="mb-0 text-center">{{ config('app.name') }} <a href="{{ url('/') }}">{{ url('/') }}</a></p>
    @endcomponent

    @component('components.alert_with', ['color' => 'danger', 'header' => 'Error 500', 'icon' => 'fa-exclamation-circle'])
        @slot('body')
            error string ...
        @endslot

        <p class="mb-0 text-center">{{ config('app.name') }} <a href="{{ url('/') }}">{{ url('/') }}</a></p>
    @endcomponent
</div><!-- /.container -->
@endsection
