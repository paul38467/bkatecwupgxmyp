<!-- start grade_bar_rating -->
<div class="form-group my-bar-rating">
    <select id="{{ $select_id }}" name="{{ $select_name }}" class="form-control">
        @for ($i = 1; $i <= 5; $i++)
            <option value="{{ $i }}"{{ $compare_value == $i ? ' selected' : '' }}>{{ $i }}</option>
        @endfor
    </select>
</div>
<!-- end grade_bar_rating -->

@push('master_css')
    <link rel="stylesheet" href="/plugin/jquery-bar-rating-master/dist/themes/fontawesome-stars.css">
@endpush

@push('master_script_src')
    <script src="/plugin/jquery-bar-rating-master/dist/jquery.barrating.min.js"></script>
@endpush

@push('master_script')
    //
    // jquery-bar-rating 評分
    //
    $('#{{ $select_id }}').barrating({
        theme: 'fontawesome-stars'
    });

@endpush
