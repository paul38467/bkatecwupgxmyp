@extends('layouts.master')

@section('page_title', 'Test component alert')

@section('content')
<div class="container">
    <h3>Test component alert</h3>

    @component('components.alert', ['color' => 'primary'])
        primary alert
    @endcomponent

    @component('components.alert', ['color' => 'secondary'])
        secondary alert
    @endcomponent

    @component('components.alert', ['color' => 'success'])
        success alert
    @endcomponent

    @component('components.alert', ['color' => 'danger'])
        danger alert
    @endcomponent

    @component('components.alert', ['color' => 'warning'])
        warning alert
    @endcomponent

    @component('components.alert', ['color' => 'info'])
        info alert
    @endcomponent

    @component('components.alert', ['color' => 'light'])
        light alert
    @endcomponent

    @component('components.alert', ['color' => 'dark'])
        dark alert
    @endcomponent
</div><!-- /.container -->
@endsection
