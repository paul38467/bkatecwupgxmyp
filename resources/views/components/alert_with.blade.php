<div class="alert alert-{{ $color }}" role="alert">
    <div class="media">
        @isset($icon)
            <i class="fa {{ $icon }} fa-3x fa-fw mr-3" aria-hidden="true"></i>
        @endisset
        <div class="media-body">
            <h4 class="alert-heading">{{ $header }}</h4>
            {{ $body }}
        </div>
    </div>
    <hr>
    {{ $slot }}
</div>
