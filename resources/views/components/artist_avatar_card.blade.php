<!-- start artist_avatar_card -->
<div class="card text-center{{ $artist->is_fav ? ' my-fav' : '' }}">
    <a href="{{ route('artist.show', $artist) }}">
        <img class="card-img-top" src="{{ $artist->avatar_url }}" alt="Card image cap">
    </a>
    @if ($artist->age)
        <div class="my-card-age-badge">
            <h5>
                <span class="badge {{ is_null($artist->death_date) ? 'badge-danger' : 'badge-secondary' }}">
                    {{ $artist->age }} 歲
                </span>
            </h5>
        </div>
    @endif

    <div class="card-body my-card-body my-card-bar-color-1">
        <p class="card-text">{{ $artist->en_name }}</p>
        <p class="card-text">{{ $artist->screen_name ?: '-- 不明 --' }}</p>
        @for ($i = 1; $i <= $artist->grade; $i++)
            <i class="fa fa-star fa-lg my-grade-stars"></i>
        @endfor
    </div>
</div>
<!-- end artist_avatar_card -->
