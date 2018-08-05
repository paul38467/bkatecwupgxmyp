@extends('layouts.master')

@section('page_title', 'Fetchaa - 所有未檢查的文章')

@section('content')
    <h5 class="pb-2">Fetch Alabout - 所有未檢查的文章共有 {{ number_format($unreadTotalCount) }} 筆</h5>
    @include('layouts.blocks.errors')

    <!-- 分類的快速按鈕 -->
    <div class="text-center m-3">
        @foreach ($unreadTypes as $threadType => $threadTypeVal)
            <a class="btn btn-{{ $threadTypeVal['count'] ? 'primary' : 'outline-primary' }} mr-1" href="#{{ $threadType }}" role="button">{{ $threadTypeVal['label'] }} ({{ number_format($threadTypeVal['count']) }})</a>
        @endforeach
    </div>

    {{-- Loop 讀取每一個 unreadType --}}
    @foreach ($unreadTypes as $threadType => $threadTypeVal)
        <form method="POST" action="{{ route('fetchaa.markread') }}">
            @csrf

            <div class="d-flex justify-content-between">
                <div>
                    <a class="anchor" id="{{ $threadType }}"></a>
                    <h5>{{ $threadTypeVal['label'] }} ({{ number_format($threadTypeVal['count']) }}) 筆</h5>
                </div>
                <div>
                    <h5><a href="#">#TOP</a></h5>
                </div>
            </div>

            <table class="table table-hover table-bordered my-link-visited">
                <thead class="table-success">
                    <tr>
                        <th class="col-md-1" scope="col">#</th>
                        <th class="col-md-1" scope="col">分類</th>
                        <th class="col-md-1" scope="col">文章 ID</th>
                        <th class="col-md-1" scope="col">Icode</th>
                        <th class="col-md-7" scope="col">標題</th>
                        <th class="col-md-1 text-center" scope="col">連結數</th>
                    </tr>
                </thead>

                <tbody>
                    {{-- Loop 讀取一個 unreadType 的 datas --}}
                    @forelse ($threadTypeVal['datas'] as $thread)
                        <input type="hidden" name="id[]" value="{{ $thread['id'] }}">
                        <tr>
                            <th scope="row" nowrap>{{ $loop->iteration }}</th>
                            <td nowrap>{{ $threadTypeVal['label'] }}</td>
                            <td nowrap>
                                [<a href="{{ redirect_url($thread['tid'], 'fetchaa') }}"  rel="noreferrer" target="_blank">{{ $thread['tid'] }}</a>]
                            </td>
                            <td nowrap>{{ str_limit($thread['av_icode'], 20) }}</td>
                            <td>{{ $thread['title'] }}</td>
                            <td class="text-center" nowrap>
                                <a href="{{ route('fetchaa.edit', $thread['id']) }}" target="_blank">( {{ count($thread['urls']) }} )</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">沒有任何相關資料</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($threadTypeVal['count'])
                <div class="text-center mb-3">
                    <button type="submit" class="btn btn-primary disable-on-click">
                        將{{ $threadTypeVal['label'] }} ({{ number_format($threadTypeVal['count']) }}) 筆文章標記為已檢查
                    </button>
                </div>
            @endif
        </form>
    @endforeach
@endsection
