<!-- start pagination_text -->
<div class="d-flex">
    <h5>
        總數 {{ number_format($pagination->total()) }} 筆，
        正在列出第 {{ number_format($pagination->firstItem()) }} - {{ number_format($pagination->lastItem()) }} 筆的 {{ $pagination->count() }} 項資料
    </h5>
</div>
<!-- end pagination_text -->
