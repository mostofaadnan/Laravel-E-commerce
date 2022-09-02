<style>
    .image-body {
        margin: auto;
    }

    .img-upload {
        margin: auto;
        align-items: center;
    }
    .user-profile{
        box-shadow:none;
    }
</style>
<div class="card user-profile">
    <div class="card-body image-body">
        <div class="main-img-preview">
            <img class="thumbnail img-preview" src="{{asset('assets/images/avater/avater.jpg')}}" style="width:100px; height: 100px" name="image" class="img-thumbnail" title="Preview Logo">
        </div>
    </div>
    <div class="card-footer">
        <div class=" input-group">
            <input id="fakeUploadLogo" type="hidden" class="form-control fake-shadow" placeholder="Choose File" disabled="disabled">
            <div class="input-group-btn img-upload">
                <div class="fileUpload btn btn-danger ">
                    <span><i class="glyphicon glyphicon-upload"></i> Upload</span>
                    <input id="logo-id" name="user_image" type="file" class="attachment_upload">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var brand = document.getElementById('logo-id');
        brand.className = 'attachment_upload';
        brand.onchange = function() {
            document.getElementById('fakeUploadLogo').value = this.value.substring(12);
        };

        // Source: http://stackoverflow.com/a/4459419/6396981
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.img-preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#logo-id").change(function() {
            readURL(this);
        });
    });
</script>