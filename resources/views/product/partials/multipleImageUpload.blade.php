<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
<style>
    .preview-images-zone {
        width: 100%;
        border: 1px solid #ddd;
        min-height: 180px;
        /* display: flex; */
        padding: 5px 5px 0px 5px;
        position: relative;
        overflow: auto;
    }

    .preview-images-zone>.preview-image:first-child {
        height: 185px;
        width: 185px;
        position: relative;
        margin-right: 5px;
    }

    .preview-images-zone>.preview-image {
        height: 90px;
        width: 90px;
        position: relative;
        margin-right: 5px;
        float: left;
        margin-bottom: 5px;
    }

    .preview-images-zone>.preview-image>.image-zone {
        width: 100%;
        height: 100%;
    }

    .preview-images-zone>.preview-image>.image-zone>img {
        width: 100%;
        height: 100%;
    }

    .preview-images-zone>.preview-image>.tools-edit-image {
        position: absolute;
        z-index: 100;
        color: #fff;
        bottom: 0;
        width: 100%;
        text-align: center;
        margin-bottom: 10px;
        display: none;
    }

    .preview-images-zone>.preview-image>.image-cancel {
        font-size: 18px;
        position: absolute;
        top: 0;
        right: 0;
        font-weight: bold;
        margin-right: 10px;
        cursor: pointer;
        display: none;
        z-index: 100;
    }

    .preview-image:hover>.image-zone {
        cursor: move;
        opacity: .5;
    }

    .preview-image:hover>.tools-edit-image,
    .preview-image:hover>.image-cancel {
        display: block;
    }

    .ui-sortable-helper {
        width: 90px !important;
        height: 90px !important;
    }
</style>
<div class="container">

    <fieldset class="form-group">
        <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-success btn-lg"><a href="javascript:void(0)" onclick="$('#pro-image').click()" style="color:#fff">Select Image</a></button>
            <input type="file" id="pro-image" name="pro-image" style="display: none;" class="form-control" multiple>
            <!--   <button class="btn btn-info btn-lg" id="multiimageupload" style="background-color:#791059;">Upload</button>
            <button class="btn btn-danger btn-lg" id="deleteMultiple" style="display: none;">Delete & Clear</button>
            -->
        </div>
    </fieldset>
    <div class="preview-images-zone" id="imag-zon">
    </div>

</div>