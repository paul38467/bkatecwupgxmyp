<div class="media bd-callout bd-callout-{{ $color }}">
    @isset($icon)
        <i class="fa {{ $icon }} fa-3x fa-fw mr-3" aria-hidden="true"></i>
    @endisset
    <div class="media-body">
        {{ $slot }}
    </div>
</div>
