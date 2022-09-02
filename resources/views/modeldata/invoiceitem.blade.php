<div class="row">
    <div class="input-group  col-sm-6 mb-1">
        <div class="input-group-prepend">
            <span class="input-group-text">@lang('home.item') @lang('home.id')</span>
        </div>
        <input type="text" class="form-control" id="invproductid" placeholder="Product Id" readonly>
    </div>
    <div class="input-group col-sm-6 mb-1">
        <div class="input-group-prepend">
            <span class="input-group-text" id="">@lang('home.barcode')</span>
        </div>
        <input type="text" name="barcode" id="invbarcode" class="form-control" placeholder="Barcode" readonly>
    </div>
</div>
<div class="input-group  mb-1">
    <div class="input-group-prepend">
        <span class="input-group-text" id="">@lang('home.name')</span>
    </div>
    <input type="text" name="name" id="invname" class="form-control" placeholder="Name">
</div>
<div class="row">
<div class="input-group mb-1 col-sm-6">
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">@lang('home.quantity')</label>
    </div>
    <input type="number" class="form-control" id="invqty" value="0" placeholder="Stock" readonly>
</div>
<div class="input-group  mb-1 col-sm-6">
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">@lang('home.unit')</label>
    </div>
    <input type="text" class="form-control" id="invunit" placeholder="Unit" readonly>
</div>
</div>
<div class="input-group mb-1">
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">@lang('home.mrp')</label>
    </div>
    <input type="number" class="form-control" id="invdatamrp" value="0" placeholder="@lang('home.mrp')" readonly>
</div>
<div class="input-group mb-1">
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">@lang('home.amount')</label>
    </div>
    <input type="number" class="form-control" id="invamount" value="0" placeholder="@lang('home.amont')" readonly>
</div>
<div class="input-group mb-1">
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">@lang('home.total') @lang('home.discount')</label>
    </div>
    <input type="number" class="form-control" id="invdiscount" value="0" placeholder="@lang('home.discount')" >
</div>
<div class="input-group mb-1 ">
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">@lang('home.total') @lang('home.vat')</label>
    </div>
    <input type="number" class="form-control" id="invvat" value="0" placeholder="@lang('home.vat')" readonly>
</div>
<div class="input-group mb-1">
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">@lang('home.nettotal')</label>
    </div>
    <input type="number" class="form-control" id="invnettotal" value="0" placeholder="@lang('home.nettotal')" readonly>
</div>