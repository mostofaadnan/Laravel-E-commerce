<div class="card-title mb-4 profile-view" id="supplierinfo">
    <div class="d-flex justify-content-start row">
        <div class="image-container mb-2 col-sm-2  col-mb-5">
            <img src="#" id="imgProfile" style="width: 150px; height: 150px" class="img-thumbnail" />
            <div class="middle">
                <input type="button" class="btn btn-secondary" id="btnChangePicture" value="Change" />
                <input type="file" style="display: none;" id="profilePicture" name="file" />
            </div>
        </div>
        <div class="userData mb-2 ml-2 col-sm-3 col-mb-5 detaisl-box" id="basicinfo">
        </div>
        <div class="col-sm-3 mb-2"></div>
        <div class="userData mb-2  ml-2 col-sm-3 col-mb-12" id="addressinfo">
            <h5>@lang('home.address') </h5>
            <hr>
            <address>
                <i class="" id="customeraddress"></i>
                <i class="" id="customercountry"></i>
                <i id="mobile" class="fa fa-mobile " aria-hidden="true"></i><br>
                <i id="telno" class="fa fa-phone" aria-hidden="true"></i><br>
                <i id="email" class="fa fa-envelope-o" aria-hidden="true"></i><br>
                <i id="website" class="fa fa-address-book-o" aria-hidden="true"></i>
            </address>
        </div>
    </div>
</div>