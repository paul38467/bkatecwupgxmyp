{{-- start use 6 columns grid css --}}
@foreach ($artists->chunk(6) as $items)
    <div class="row pt-2 pb-2">
        @foreach ($items as $artist)
            <div class="col-md-2">
                @include('components.artist_avatar_card', ['artist' => $artist])
            </div>
        @endforeach
    </div>
@endforeach
{{-- end use 6 columns grid css --}}
