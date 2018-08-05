@extends('layouts.master')

@section('page_title', 'Fetchaa - 檢視文章')

@section('content')
    <h5 class="pb-2">Fetch Alabout - 檢視文章</h5>
    @include('layouts.blocks.errors')

    <table class="table table-bordered my-link-visited">
        <thead class="table-success">
            <tr>
                <th class="col-md-2" scope="col">ID：{{ $thread->id }}</th>
                <th class="col-md-2" scope="col">{{ $thread->thread_type }}</th>
                <th class="col-md-2" scope="col">
                    [<a href="{{ redirect_url($thread->tid, 'fetchaa') }}" rel="noreferrer" target="_blank">{{ $thread->tid }}</a>]
                </th>
                <th class="col-md-2" scope="col">{{ $thread->fetch_date }}</th>
                <th class="col-md-2" scope="col">{{ $thread->regdate }}</th>
                <th class="col-md-2" scope="col">
                    <i class="fa fa-file-image-o text-danger"></i> {{ count($threadImages) }}
                    <i class="fa fa-link text-danger ml-3"></i> {{ count($thread->urls) }}
                </th>
            </tr>
        </thead>

        <tbody>
            <tr class="bg-light">
                <!-- start left column -->
                <td scope="row" colspan="4">
                    <!-- start 顯示 thread 的 images -->
                    @if (count($threadImages))
                        <div class="pre-scrollable" style="max-height: 500px">
                            @foreach ($threadImages as $threadImage)
                                <img src="{{ $threadImage }}" class="img-fluid" alt="Responsive image">
                                <p><small class="text-danger">[{{ $loop->iteration }}] {{ $threadImage }}</small></p>
                            @endforeach
                        </div>
                    @endif
                    <!-- end 顯示 thread 的 images -->

                    <!-- start 顯示 thread 的 urls -->
                    @foreach ($thread->urls as $url)
                        [{{ $loop->iteration }}] <a href="{{ redirect_url($url['url']) }}" rel="noreferrer" target="_blank">{{ $url['name'] }}</a><br>
                    @endforeach
                    <!-- end 顯示 thread 的 urls -->
                </td>
                <!-- end left column -->

                <!-- start right column -->
                <td colspan="2">
                    <div class="d-flex flex-column">
                        <!-- start 基本資料 form -->
                        <form method="POST" action="{{ route('fetchaa.update', $thread->id) }}">
                            @method('PATCH')
                            @csrf

                            <div class="form-group">
                                <label for="fetchaaTitle">
                                    文章標題 <small class="text-muted">(不要按 enter 斷行)</small>
                                    @if ($thread->is_merge)
                                        <span class="text-danger">*曾經合併*</span>
                                    @endif
                                </label>
                                <button type="button" class="btn btn-dark btn-sm pull-right" onclick="copyToClipboard('fetchaaTitle')">Copy</button>
                                <textarea class="form-control mt-1" id="fetchaaTitle" name="title" rows="2" spellcheck="false">{{ old('title', $thread->title) ?? '' }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="fetchaaArtist">藝人 <small class="text-muted">(不要按 enter 斷行)</small></label>
                                <button type="button" class="btn btn-dark btn-sm pull-right" onclick="copyToClipboard('fetchaaArtist')">Copy</button>
                                <textarea class="form-control mt-1" id="fetchaaArtist" name="artist" rows="2" spellcheck="false">{{ old('artist', $thread->artist) ?? '' }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="fetchaaAvIcode">AV Icode</label>
                                <input type="text" class="form-control" id="fetchaaAvIcode" name="av_icode" value="{{ old('av_icode', $thread->av_icode) ?? '' }}">
                            </div>

                            <div class="custom-control custom-checkbox">
                                <input type="hidden" name="is_focus" value="0">
                                <input type="checkbox" class="custom-control-input" id="fetchaaIsFocus" name="is_focus" value="1"{{ old('is_focus', $thread->is_focus) ? ' checked' : '' }}>
                                <label class="custom-control-label" for="fetchaaIsFocus">關注</label>
                                <button type="submit" class="btn btn-primary pull-right disable-on-click">更新</button>
                            </div>
                        </form>
                        <!-- end 基本資料 form -->
                    </div><!-- ./d-flex -->

                    <div class="d-flex justify-content-end mt-2">
                        <!-- start 合併 form -->
                        @if ($dupeAvIcodeThreadsCount > 1)
                            <div class="pl-2">
                                <form method="POST" action="{{ route('fetchaa.merge', $thread->id) }}">
                                    @csrf

                                    <button type="submit" class="btn {{ ($dupeAvIcodeThreadsCount > 5) ? 'btn-dark' : 'btn-success' }} disable-on-click">
                                        合併 {{ $dupeAvIcodeThreadsCount }} 筆重複的記錄
                                    </button>
                                </form>
                            </div>
                        @endif
                        <!-- end 合併 form -->

                        <!-- start 刪除 form -->
                        <div class="pl-2">
                            <form method="POST" action="{{ route('fetchaa.destroy', $thread->id) }}">
                                @method('DELETE')
                                @csrf

                                <button type="submit" class="btn btn-danger disable-on-click" accesskey="a"><u>(A)</u> 刪除</button>
                            </form>
                        </div>
                        <!-- end 刪除 form -->
                    </div><!-- ./d-flex -->
                </td>
                <!-- end right column -->
            </tr>
        </tbody>
    </table>

    <div class="card bg-light mb-3">
        <h5 class="card-header">乾淨原始碼</h5>
        <div class="card-body">
            <pre>{{ strip_tags($thread->clear_code) }}</pre>
        </div>
    </div>
@endsection

@push('master_script_src')
    <script src="{{ asset('my_asset/copy_to_clipboard.js') }}"></script>
@endpush
