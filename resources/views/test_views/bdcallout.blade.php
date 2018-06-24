@extends('layouts.master')

@section('page_title', 'Test component bdcallout')

@section('content')
<div class="container">
    <h3>Test component bdcallout</h3>

    <!-- create and use blade alias component -->
    <p>create and use blade alias component:</p>
    @bdcallout(['color' => 'primary'])
        <h4>Primary Callout - use blade alias component</h4>
        <p>without icon</p>
    @endbdcallout

    @bdcallout(['color' => 'secondary', 'icon' => 'fa-exclamation-circle'])
        <h4>Secondary Callout - use blade alias component</h4>
        <p>with icon <code class="highlighter-rouge">fa-exclamation-circle</code></p>
    @endbdcallout

    <!-- Types Color -->
    <p>Types Color:</p>
    <div class="media bd-callout bd-callout-primary">
        <div class="media-body">
            <h4>Primary Callout</h4>
            <p>without icon</p>
        </div>
    </div>

    <div class="media bd-callout bd-callout-secondary">
        <i class="fa fa-exclamation-circle fa-3x fa-fw mr-3" aria-hidden="true"></i>
        <div class="media-body">
            <h4>Secondary Callout</h4>
            <p>with icon <code class="highlighter-rouge">fa-exclamation-circle</code></p>
        </div>
    </div>

    <div class="media bd-callout bd-callout-success">
        <i class="fa fa-check fa-3x fa-fw mr-3" aria-hidden="true"></i>
        <div class="media-body">
            <h4>Success Callout</h4>
            <p>with icon <code class="highlighter-rouge">fa-check</code></p>
        </div>
    </div>

    <div class="media bd-callout bd-callout-info">
        <i class="fa fa-info fa-3x fa-fw mr-3" aria-hidden="true"></i>
        <div class="media-body">
            <h4>Info Callout</h4>
            <p>with icon <code class="highlighter-rouge">fa-info</code></p>
        </div>
    </div>

    <div class="media bd-callout bd-callout-warning">
        <i class="fa fa-question fa-3x fa-fw mr-3" aria-hidden="true"></i>
        <div class="media-body">
            <h4>Error 404</h4>
            <p>with icon <code class="highlighter-rouge">fa-question</code></p>
            <p>More test.</p>
            <p>More test.</p>
        </div>
    </div>

    <div class="media bd-callout bd-callout-danger">
        <i class="fa fa-hand-paper-o fa-3x fa-fw mr-3" aria-hidden="true"></i>
        <div class="media-body">
            <h4>Error 500</h4>
            <p>with icon <code class="highlighter-rouge">fa-hand-paper-o</code></p>
            <p>More test.</p>
            <p>More test.</p>
        </div>
    </div>

    <!-- Colors -->
    <p>Colors:</p>
    <div class="media bd-callout bd-callout-blue">
        <i class="fa fa-question-circle-o fa-3x fa-fw mr-3" aria-hidden="true"></i>
        <div class="media-body">
            <h4>Blue Callout</h4>
            <p>with icon <code class="highlighter-rouge">fa-question-circle-o</code></p>
        </div>
    </div>

    <div class="media bd-callout bd-callout-indigo">
        <i class="fa fa-check fa-3x fa-fw mr-3" aria-hidden="true"></i>
        <div class="media-body">
            <h4>Indigo Callout</h4>
            <p>This is a indigo callout.</p>
        </div>
    </div>

    <div class="media bd-callout bd-callout-purple">
        <i class="fa fa-check fa-3x fa-fw mr-3" aria-hidden="true"></i>
        <div class="media-body">
            <h4>Purple Callout</h4>
            <p>This is a purple callout.</p>
        </div>
    </div>

    <div class="media bd-callout bd-callout-pink">
        <i class="fa fa-check fa-3x fa-fw mr-3" aria-hidden="true"></i>
        <div class="media-body">
            <h4>Pink Callout</h4>
            <p>This is a pink callout.</p>
        </div>
    </div>

    <div class="media bd-callout bd-callout-red">
        <i class="fa fa-check fa-3x fa-fw mr-3" aria-hidden="true"></i>
        <div class="media-body">
            <h4>Red Callout</h4>
            <p>This is a red callout.</p>
        </div>
    </div>

    <div class="media bd-callout bd-callout-orange">
        <i class="fa fa-check fa-3x fa-fw mr-3" aria-hidden="true"></i>
        <div class="media-body">
            <h4>Orange Callout</h4>
            <p>This is a orange callout.</p>
        </div>
    </div>

    <div class="media bd-callout bd-callout-yellow">
        <i class="fa fa-check fa-3x fa-fw mr-3" aria-hidden="true"></i>
        <div class="media-body">
            <h4>Yellow Callout</h4>
            <p>This is a yellow callout.</p>
        </div>
    </div>

    <div class="media bd-callout bd-callout-green">
        <i class="fa fa-check fa-3x fa-fw mr-3" aria-hidden="true"></i>
        <div class="media-body">
            <h4>Green Callout</h4>
            <p>This is a green callout.</p>
        </div>
    </div>

    <div class="media bd-callout bd-callout-teal">
        <i class="fa fa-check fa-3x fa-fw mr-3" aria-hidden="true"></i>
        <div class="media-body">
            <h4>Teal Callout</h4>
            <p>This is a teal callout.</p>
        </div>
    </div>

    <div class="media bd-callout bd-callout-cyan">
        <i class="fa fa-check fa-3x fa-fw mr-3" aria-hidden="true"></i>
        <div class="media-body">
            <h4>Cyan Callout</h4>
            <p>This is a cyan callout.</p>
        </div>
    </div>

    <div class="media bd-callout bd-callout-dark">
        <i class="fa fa-check fa-3x fa-fw mr-3" aria-hidden="true"></i>
        <div class="media-body">
            <h4>Dark Callout</h4>
            <p>This is a dark callout.</p>
        </div>
    </div>
</div><!-- /.container -->
@endsection
