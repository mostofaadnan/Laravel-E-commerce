<style>
    .image-container {
        position: relative;
    }

    .image {
        opacity: 1;
        display: block;
        width: 100%;
        height: auto;
        transition: .5s ease;
        backface-visibility: hidden;
    }

    .middle {
        transition: .5s ease;
        opacity: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        text-align: center;
    }

    .image-container:hover .image {
        opacity: 0.3;
    }

    .image-container:hover .middle {
        opacity: 1;
    }

    .my-custom-scrollbar {
        position: relative;
        height: 200px;
        overflow: auto;
    }

    .table-wrapper-scroll-y {
        display: block;
    }
</style>
<div class="row">
<div class="col-sm-10 form-single-input-section">
    <div class="card-body image-body">
        <div class="main-img-preview">
            <div class="d-flex justify-content-start">
                <div class="image-container">
                    <img src="#" id="imgProfile" style="width: 150px; height: 150px" class="img-thumbnail" />
                    <div class="middle">
                        <input type="button" class="btn btn-secondary" id="btnChangePicture" value="Change" />
                        <input type="file" style="display: none;" id="profilePicture" name="file" />
                    </div>
                </div>

            </div>


        </div>
    </div>
    <div class="card-footer">
        <div class="ml-auto" style="margin-left: auto;margin-right: auto;">
            <input type="button" class="btn btn-danger btn-lg d-none" id="btnDiscard" value="Discard Changes" />
        </div>
    </div>

</div>
</div>
