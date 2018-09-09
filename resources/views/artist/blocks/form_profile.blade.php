@if ($doAction == 'create')
    <form method="POST" action="{{ route('artist.store') }}" enctype="multipart/form-data">
        @csrf
@else
    <form method="POST" action="{{ route('artist.update', $artist) }}" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
@endif

<div class="card bg-light">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    {{ $doAction == 'create' ? '新增藝人' : '編輯個人檔案 #' . $artist->id }}
                </a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-2 text-center">
                <!-- start left column -->
                @component('components.upload_image')
                    @slot('image', $artist->avatar_url ?? Storage::disk('artist')->url($cfg['artist']['defaultAvatar']))
                    @slot('image_width', 170) {{-- max 180 --}}
                    @slot('image_height', 170)
                    @slot('file_input_name', 'avatar_image')
                    @slot('file_accept', '.jpg') {{-- 'image/*' --}}
                    @slot('button_label', '上傳頭像')
                @endcomponent
                <!-- end left column -->
            </div>
            <div class="col-md-2">
                <!-- start middle column -->
                <!-- start artist artist_aka_names -->
                <textarea class="form-control my-textarea-pre" id="artistArtistAka" name="aka_names" rows="16" placeholder="一行一個別名" spellcheck="false">{{ old('aka_names', (isset($artist->artistAka) ? $artist->artistAka->implode('aka_name', "\r\n") : '') ?? '') }}</textarea>
                <!-- end artist artist_aka_names -->
                <!-- end middle column -->
            </div>
            <div class="col-md-8">
                <!-- start right column -->
                <div class="row">
                    <div class="col-md-5">
                        <!-- start artist en_name -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="artistEnNameLabel">英文名稱</span>
                            </div>
                            <input type="text" class="form-control" id="artistEnName" name="en_name" value="{{ old('en_name', $artist->en_name ?? '') }}" aria-describedby="artistEnNameLabel">
                        </div>
                        <!-- end artist en_name -->
                    </div>
                    <div class="col-md-3">
                        <!-- start artist region_id -->
                        <label class="sr-only" for="artistRegionId">地區</label>
                        <select class="custom-select" id="artistRegionId" name="region_id">
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}"{{ old('region_id', $artist->region_id ?? '-1') == $region->id ? ' selected' : '' }}>{{ $region->region_name }}</option>
                            @endforeach
                        </select>
                        <!-- end artist region_id -->
                    </div>
                    <div class="col">
                        <!-- start artist birth_date -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="artistBirthDateLabel">出生日期</span>
                            </div>
                            <input type="text" class="form-control" id="artistBirthDate" name="birth_date" value="{{ old('birth_date', $artist->birth_date ?? '') }}" placeholder="yyyy-mm-dd" aria-describedby="artistBirthDateLabel">
                        </div>
                        <!-- end artist birth_date -->
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-5">
                        <!-- start artist screen_name -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="artistScreenNameLabel">顯示名稱</span>
                            </div>
                            <input type="text" class="form-control" id="artistScreenName" name="screen_name" value="{{ old('screen_name', $artist->screen_name ?? '') }}" aria-describedby="artistScreenNameLabel">
                        </div>
                        <!-- end artist screen_name -->
                    </div>
                    <div class="col-md-3">
                        <!-- start artist force_cat -->
                        <label class="sr-only" for="artistForceCat">強制級別</label>
                        <select class="custom-select" id="artistForceCat" name="force_cat">
                            @foreach ($cfg['artist']['forceCatArray'] as $key => $value)
                                <option value="{{ $key }}"{{ old('force_cat', $artist->force_cat ?? '-1') == $key ? ' selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        <!-- end artist force_cat -->
                    </div>
                    <div class="col">
                        <!-- start artist death_date -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="artistDeathDateLabel">死亡日期</span>
                            </div>
                            <input type="text" class="form-control" id="artistDeathDate" name="death_date" value="{{ old('death_date', $artist->death_date ?? '') }}" placeholder="yyyy-mm-dd" aria-describedby="artistDeathDateLabel">
                        </div>
                        <!-- end artist death_date -->
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-5">
                        <!-- start artist old_id -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="artistOldIdLabel">舊的編號</span>
                            </div>
                            <input type="text" class="form-control" id="artistOldId" name="old_id" value="{{ old('old_id', $artist->old_id ?? '') }}" aria-describedby="artistOldIdLabel">
                        </div>
                        <!-- end artist old_id -->
                    </div>
                    <div class="col-md-3">
                        <!-- start artist need_focus -->
                        <label class="sr-only" for="artistNeedFocus">設定關注</label>
                        <select class="custom-select" id="artistNeedFocus" name="need_focus">
                            @foreach ($cfg['artist']['needFocusArray'] as $key => $value)
                                <option value="{{ $key }}"{{ old('need_focus', $artist->need_focus ?? '-1') == $key ? ' selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        <!-- end artist need_focus -->
                    </div>
                    <div class="col">
                        <!-- start artist found_at -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="artistFoundAtLabel">來源日期</span>
                            </div>
                            <input type="text" class="form-control" id="artistFoundAt" name="found_at" value="{{ old('found_at', $artist->found_at ?? '') }}" placeholder="yyyy-mm-dd" aria-describedby="artistFoundAtLabel">
                        </div>
                        <!-- end artist found_at -->
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-5">
                        <!-- start artist grade -->
                        @component('components.grade_bar_rating')
                            @slot('select_id', 'artistGrade')
                            @slot('select_name', 'grade')
                            @slot('compare_value', old('grade', $artist->grade ?? '-1'))
                        @endcomponent
                        <!-- end artist grade -->
                    </div>
                    <div class="col-md-3">
                        <!-- start artist gender -->
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="artistGenderMale" name="gender" value="0"{{ old('gender', $artist->gender ?? '-1') == '0' ? ' checked' : '' }}>
                            <label class="custom-control-label" for="artistGenderMale">男</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="artistGenderFemale" name="gender" value="1"{{ old('gender', $artist->gender ?? '1') == '1' ? ' checked' : '' }}>
                            <label class="custom-control-label" for="artistGenderFemale">女</label>
                        </div>
                        <!-- end artist gender -->
                    </div>
                    <div class="col">
                        <!-- start artist is_fav -->
                        <div class="custom-control custom-checkbox">
                            <input type="hidden" name="is_fav" value="0">
                            <input type="checkbox" class="custom-control-input" id="artistIsFav" name="is_fav" value="1"{{ old('is_fav', $artist->is_fav ?? '0') ? ' checked' : '' }}>
                            <label class="custom-control-label" for="artistIsFav">我的最愛</label>
                        </div>
                        <!-- end artist is_fav -->
                    </div>
                </div>


                <div class="row">
                    <div class="col">
                        <!-- start artist wiki -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="artistWikiLabel">Wiki URL</span>
                            </div>
                            <input type="text" class="form-control" id="artistWiki" name="wiki" value="{{ old('wiki', $artist->wiki ?? '') }}" aria-describedby="artistWikiLabel">
                        </div>
                        <!-- end artist wiki -->
                    </div>
                </div>


                <div class="row">
                    <div class="col">
                        <!-- start artist description -->
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">藝人簡介</span>
                            </div>
                            <textarea class="form-control" id="artistDescription" name="description" rows="4" spellcheck="false" aria-label="藝人簡介">{{ old('description', $artist->description ?? '') }}</textarea>
                        </div>
                        <!-- end artist description -->
                    </div>
                </div>

                <div class="text-center">
                    @if ($doAction == 'create')
                        <button type="submit" class="btn btn-success ml-2 disable-on-click">新增</button>
                    @else
                        <button type="submit" class="btn btn-success ml-2 disable-on-click">儲存</button>
                        <a class="btn btn-primary ml-2" href="{{ route('artist.show', $artist) }}" role="button">返回</a>
                    @endif
                </div>
                <!-- end right column -->
            </div>
        </div><!-- ./row -->
    </div><!-- ./card-body -->
</div><!-- ./card -->
</form>
