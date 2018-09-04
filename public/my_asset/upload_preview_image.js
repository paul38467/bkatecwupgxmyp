/*!
 *  upload_preview_image.js
 *
 *  require 3 <#id>
 *  id="upload_image_preview" eg. <img id="upload_image_preview" src="example.jpg"> will change example.jpg to upload img
 *  id="upload_image_name"    eg. <h6 id="upload_image_name"></h6> will display the upload img file name
 *  id="upload_image_input"   eg. <input type="file" id="upload_image_input"> will detect onclick action
 *
 *  HOW TO USE:
 *  1. link the .js before </body>
 *      <script src="/my_asset/upload_preview_image.js"></script>
 *
 *  2. call this function inside $(function() {}
 *      $("#upload_image_input").change(function() {
 *          uploadPreviewImage(this);
 *      });
 *
 */
function uploadPreviewImage(input) {
    //
    // show upload file name
    //
    var uploadFileName = input.files[0].name;
    var strLimit = 20;

    if (uploadFileName.length > strLimit) {
        var endOfFileName = uploadFileName.substr( (uploadFileName.lastIndexOf('.') -2) );
        var startOfFileName = uploadFileName.substr(0, (strLimit - endOfFileName.length - 3));
        uploadFileName = startOfFileName+"..."+endOfFileName;
    }

    // show upload file name
    $('#upload_image_name').html(uploadFileName);

    //
    // show upload image preview
    //
    var reader = new FileReader();
    reader.readAsDataURL(input.files[0]);

    reader.onload = function(e) {
        // show image preview
        $('#upload_image_preview').attr('src', e.target.result);
    };
}
