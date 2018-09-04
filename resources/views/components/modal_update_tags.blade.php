<div class="modal fade" id="{{ $div_id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $div_id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ $form_action }}">
                @method('PATCH')
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $div_id }}Label">{{ $title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body table-primary">
                    {{ $slot }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-success">儲存</button>
                </div>
            </form>
        </div>
    </div>
</div>
