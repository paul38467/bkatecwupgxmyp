<!-- start upload_image -->
<img id="upload_image_preview" class="border border-dark rounded" src="{{ $image }}" width="{{ $image_width }}" height="{{ $image_height }}">
<h6 id="upload_image_name"></h6>
<label class="btn btn-secondary" for="upload_image_input">
    <input type="file" id="upload_image_input" name="{{ $file_input_name }}" accept="{{ $file_accept }}" style="display:none">
    {{ $button_label }}
</label>
<!-- end upload_image -->

@push('master_script_src')
    <script src="/my_asset/upload_preview_image.js"></script>
@endpush

@push('master_script')
    //
    // Upload Image Preview
    //
    $("#upload_image_input").change(function() {
        uploadPreviewImage(this);
    });

@endpush
