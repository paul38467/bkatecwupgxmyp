@extends('layouts.master')

@section('page_title', '藝人 - 個人檔案')

@section('content')
    @include('layouts.blocks.errors')

    <!-- start Modal - artist delete -->
    @component('components.modal_confirm_delete')
        @slot('div_id', 'modalArtistDelete')
        @slot('form_action', route('artist.destroy', $artist))
        @slot('title', '確認刪除 #' . $artist->id)
    @endcomponent
    <!-- end Modal - artist delete -->

    <!-- start Modal - artist tags -->
    @component('components.modal_update_tags')
        @slot('div_id', 'modalArtistTagsUpdate')
        @slot('form_action', route('artist.update-tags', $artist))
        @slot('title', '藝人標籤')

        <!-- start list all artistTagcats and artistTag -->
        @foreach ($artistTagcats as $tagCat)
            <div class="media mb-3">
                <label class="col-form-label">{{ $tagCat->tagcat_name }}：</label>
                <div class="media-body">
                    <div class="btn-group-toggle my-button-checkbox" data-toggle="buttons">
                        @foreach ($tagCat->artistTag as $tag)
                            @if ($artist->artistTag->contains($tag->id))
                                <label class="btn btn-light mb-2 active">
                                    <input type="checkbox" name="artist_tags[]" value="{{ $tag->id }}" checked autocomplete="off"> {{ $tag->tag_name }}
                                </label>
                            @else
                                <label class="btn btn-light mb-2">
                                    <input type="checkbox" name="artist_tags[]" value="{{ $tag->id }}" autocomplete="off"> {{ $tag->tag_name }}
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div><!-- ./media-body -->
            </div><!-- ./media -->
        @endforeach
        <!-- end list all artistTagcats and artistTag -->
    @endcomponent
    <!-- end Modal - artist tags -->

    <div class="card bg-light">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#">個人檔案</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">AV</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">電影</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Fetchaa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">歷史</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">搜尋</a>
                </li>

                <li class="nav-item ml-auto">
                    <div class="my-card-nav-pull-right">
                        <a href="{{ route('artist.edit', $artist) }}">
                            <i class="fa fa-edit fa-lg align-bottom mr-2 text-secondary"></i>
                        </a>
                        <a href="#" data-toggle="modal" data-target="#modalArtistTagsUpdate">
                            <i class="fa fa-tag fa-lg mr-2 text-secondary" ></i>
                        </a>
                        <a href="#" data-toggle="modal" data-target="#modalArtistDelete">
                            <i class="fa fa-trash fa-lg text-secondary" ></i>
                        </a>
                    </div>
                </li>
            </ul>
        </div><!-- ./card-header -->


        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <!-- start left column -->
                    @include('components.artist_avatar_card', ['artist' => $artist])
                    <!-- end left column -->
                </div>
                <div class="col-md-10">
                    <!-- start right column -->
                    <div class="d-flex justify-content-between">
                        <div>
                            <!-- start id, en_name, screen_name -->
                            <h4>
                                <span class="text-danger">#{{ $artist->id }}</span>
                                 :: {{ $artist->en_name }}{{ $artist->screen_name ? '，' . $artist->screen_name : '' }}
                            </h4>
                            <!-- end id, en_name, screen_name -->
                        </div>
                        <div>
                            <!-- start is_fav, need_focus, cat -->
                            <span class="h5">
                                @if ($artist->is_fav)
                                    <i class="fa fa-heart fa-fw text-danger mr-1"></i>
                                @endif

                                @if ($artist->need_focus == 1)
                                    <i class="fa fa-eye-slash fa-fw text-danger mr-1"></i>
                                @elseif ($artist->need_focus == 2)
                                    <i class="fa fa-eye fa-fw text-danger mr-1"></i>
                                @endif
                            </span>
                            <span class="h4">?級</span>
                            <!-- end is_fav, need_focus, cat -->
                        </div>
                    </div>
                    <hr class="my-hr">
                    <!-- start details block -->
                    <div class="d-flex justify-content-between">
                        <div>
                            {{ $artist->region->region_name }}，{{ $artist->gender ? '女' : '男' }}性，舊 ID：{{ $artist->old_id }}
                        </div>
                        <div>
                            來源日期：{{ $artist->found_at }} ({{ $artist->found_at_age }})
                        </div>
                    </div>
                    <div class="d-flex">
                        Wiki：
                        @if ($artist->wiki)
                            <a href="{{ redirect_url($artist->wiki) }}" rel="noreferrer" target="_blank">{{ $artist->wiki }}</a>
                        @endif
                    </div>
                    <hr>
                    <!-- start artistAka -->
                    <div class="media">
                        {{ $artist->artistAka->count() }} 個別名：
                        <div class="media-body text-success">
                            {{ $artist->artistAka->implode('aka_name', ' ， ') }}
                        </div>
                    </div>
                    <!-- end artistAka -->
                    <hr>
                    <!-- start artistTag -->
                    <div class="media">
                        {{ $artist->artistTag->count() }} 個標籤：
                        <div class="media-body">
                            @foreach ($artist->artistTag as $tag)
                                <a href="#" class="badge my-badge badge-warning">{{ $tag->tag_name }}</a>
                            @endforeach
                        </div>
                    </div>
                    <!-- end artistTag -->
                    <hr>
                    <div class="row">
                        <div class="col">
                            出生日期：{{ $artist->birth_date ? $artist->birth_date . ' (' . $artist->birth_age . ')' : '' }}
                        </div>
                        <div class="col">
                            建立日期：{{ $artist->created_at }} ({{ $artist->created_at_age }})
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            死亡日期：{{ $artist->death_date ? $artist->death_date . ' (' . $artist->death_age . ')' : '' }}
                        </div>
                        <div class="col">
                            修改日期：{{ $artist->created_at == $artist->updated_at ? '' : $artist->updated_at . ' (' . $artist->updated_at_age . ')' }}
                        </div>
                    </div>
                    <hr>
                    <div class="media">
                        藝人簡介：
                        <div class="media-body">
                            {!! show_textarea($artist->description) !!}
                        </div>
                    </div>
                    <!-- end details block -->
                    <!-- end right column -->
                </div>
            </div><!-- ./row -->
        </div><!-- ./card-body -->
    </div><!-- ./card -->
@endsection
