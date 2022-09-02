<div class="card">
    <div class="card-header">
        Select Mulltiple Photo

    </div>
    <div class="card-body">

        <div class="my-custom-scrollbar  scrollbar-morpheus-den">

            <script>
                $(document).ready(function() {


                    if (window.File && window.FileList && window.FileReader) {


                        $("#files").on("change", function(e) {
                            var files = e.target.files,
                                filesLength = files.length;

                            var caption = $("#captiontext").val();
                            for (var i = 0; i < filesLength; i++) {
                                var f = files[i]
                                var fileReader = new FileReader();
                                fileReader.onload = (function(e) {
                                    var file = e.target;
                                    $("<div class='thumbnail pip'>" +
                                        "<img class='img-thumbnail'  src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                                        "<div class='mt-1 mb-2'><div class='caption'><input type='text' name='captionname' class='form-control col-sm-8 caption-text' value='" + caption + "'>" +
                                        "<buttton id='remove' class='btn btn-danger remove'>Remove</button></div></div>" +
                                        "</div>").insertAfter("#files");
                                    $("#remove").on("click", function(e) {

                                        $(this).parent(".pip").remove();
                                    });
                                });
                                fileReader.readAsDataURL(f);
                            }
                            $("#captiontext").val("");
                        });
                    } else {
                        alert("Your browser doesn't support to File API")
                    }


                });
            </script>
            <div class="picup">
                <input type="file" id="files" class="form-control-file" name="requirimg[]" value="+" multiple readonly />
            </div>

        </div>

    </div>

    <div class="card-footer">

        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Recipient's username" aria-label="image type" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" >Button</button>
            </div>
            <script>
                function ClickUpload() {
                    $("#files").trigger('click');
                }
            </script>


        </div>











    </div>

</div>

