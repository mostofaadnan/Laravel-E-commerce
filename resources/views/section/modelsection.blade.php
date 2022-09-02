<style>
    .modal {
        color: #000;
    }
</style>
<!-- barcode model -->
<div class="modal modal-success fade" id="setting" tabindex="-1" role="dialog" aria-labelledby="settingTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="settingTitle">Labels Show Option</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <label id="message" style="color:red;"></label>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"> <input type="checkbox" class="mr-2" id="companyname" value="companyname" name="companyname" checked> <label for="companyname"> Company Name</label></li>
                            <li class="list-group-item"><input type="checkbox" class="mr-2" id="showcode" value="Code" name="showcode" checked> <label for="showcode"> Show Item Code</label></li>
                            <li class="list-group-item"> <input type="checkbox" class="mr-2" id="itemname" value="itemname" name="itemname" checked> <label for="itemname"> Item Name</label></li>
                            <li class="list-group-item"> <input type="checkbox" class="mr-2" id="price" value="price" name="price" checked> <label for="price"> Product Price</label></li>
                            <li class="list-group-item"><input type="checkbox" class="mr-2" id="othernotes" value="othernote" name="othernote"> <label for="othernote"> Other Notes</label></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="barcodesettingsubmit">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- end barcode Model -->

<div class="modal fade" id="vatsetting" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelviewtitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modeldetials">
            @include('modeldata.vatsettingdatalist')
            </div>
            <div class="modal-footer modelviewfooter">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="vatsubmit" class="btn btn-success" id="">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Item -->

<div class="modal fade" id="modelitemview" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header card-header-section">
                <h5 class="modal-title" id="modelviewtitle">Item Check</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:#fff">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('modeldata.item')
            </div>
            <div class="modal-footer modelviewfooter">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="itemdetails" class="btn btn-success" id="">Details</button>
            </div>
        </div>
    </div>
</div>

<!-- invoice print -->
<div class="modal fade modal-lg" id="invoiceprint" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelviewtitle">Invoice Check</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('modeldata.invview')
            </div>
            <div class="modal-footer modelviewfooter">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="modeldatasubmit" class="btn btn-success" id="">Print</button>
                <button type="button" id="modeldatasubmit" class="btn btn-danger" id="">PDF</button>
            </div>
        </div>
    </div>
</div>
<!-- Customer print -->
<div class="modal fade" id="customerinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelviewtitle">Customer Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('modeldata.customer')
            </div>
            <div class="modal-footer modelviewfooter">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="customerclear" onclick=CustomerClear() class="btn btn-info">Clear</button>
                <button type="button" id="modeldatasubmit" class="btn btn-success" id="">Profile</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="invmodelviewitems" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header card-header-section">
                <h5 class="modal-title" id="modelviewtitle">@lang('home.invoice') @lang('home.item')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:#fff">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('modeldata.invoiceitem')
            </div>
            <div class="modal-footer modelviewfooter">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('home.close')</button>
                <button type="button" id="invoiceitemupdate" class="btn btn-success" id="">@lang('home.submit')</button>
            </div>
        </div>
    </div>
</div>

