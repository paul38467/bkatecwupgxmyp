@extends('layouts.master')

@section('page_title', 'Fetchaa - ' . $threadTitle)

@section('content')
    <h5 class="pb-2">Fetch Alabout - {{ $threadTitle }}</h5>
    @include('layouts.blocks.errors')

    @if (blank($threads))
        沒有任何相關資料
    @else
        @include('components.pagination', ['pagination' => $threads])
        @include('components.pagination_text', ['pagination' => $threads])

        <table class="table table-hover table-bordered my-link-visited">
            <thead class="table-success">
                <tr>
                    <th class="col-md-1" scope="col">ID</th>
                    <th class="col-md-1" scope="col">分類</th>
                    <th class="col-md-1" scope="col">文章 ID</th>
                    <th class="col-md-1" scope="col">Icode</th>
                    <th class="col-md-6" scope="col">標題</th>
                    <th class="col-md-1 text-center" scope="col">合併</th>
                    <th class="col-md-1 text-center" scope="col">連結數</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($threads as $thread)
                <tr>
                    <th scope="row" nowrap>{{ $thread->id }}</th>
                    <td nowrap>{{ $cfg['fetchaa']['threadTypes'][$thread->thread_type]['label'] }}</td>
                    <td nowrap>
                        [<a href="{{ redirect_url($thread->tid, 'fetchaa') }}"  rel="noreferrer" target="_blank">{{ $thread->tid }}</a>]
                    </td>
                    <td nowrap>{{ str_limit($thread->av_icode, 20) }}</td>
                    <td>{{ $thread->title }}</td>
                    <td class="text-center">{{ $thread->is_merge ? '已合併' : '' }}</td>
                    <td class="text-center" nowrap>
                        <a href="{{ route('fetchaa.edit', $thread->id) }}" target="_blank">( {{ count($thread->urls) }} )</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @include('components.pagination', ['pagination' => $threads])
    @endif
@endsection
