
<div class="row">
    <div class="input-group  col-sm-6 mb-1">
        <div class="input-group-prepend">
            <span class="input-group-text">@lang('home.item') @lang('home.id')</span>
        </div>
        <input type="text" class="form-control" id="productid" placeholder="Product Id" readonly>
    </div>
    <div class="input-group col-sm-6 mb-1">
        <div class="input-group-prepend">
            <span class="input-group-text" id="">@lang('home.label')</span>
        </div>
        <input type="text" name="barcode" id="barcodes" class="form-control" placeholder="Barcode" readonly>
    </div>
</div>
<div class="input-group  mb-1">
    <div class="input-group-prepend">
        <span class="input-group-text" id="">@lang('home.name')</span>
    </div>
    <input type="text" name="name" id="name" class="form-control" placeholder="Name">
</div>
<div class="row">
    <div class="input-group  mb-1 col-sm-6">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.category')</label>
        </div>
        <input type="text" class="form-control" id="category" placeholder="Category" readonly>
    </div>
    <div class="input-group mb-1 col-sm-6">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.subcategory')</label>
        </div>
        <input type="text" class="form-control" id="subcategory" placeholder="Subategory" readonly>
    </div>
</div>
<div class="input-group  mb-1">
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">@lang('home.brand')</label>
    </div>
    <input type="text" class="form-control" id="brand" placeholder="Brand" readonly>
</div>
<div class="row">
    <div class="input-group mb-1 col-sm-6">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.stock')</label>
        </div>
        <input type="number" class="form-control" id="stock" value="0" placeholder="Stock" readonly>
    </div>
    <div class="input-group  mb-1 col-sm-6">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.unit')</label>
        </div>
        <input type="text" class="form-control" id="unit" placeholder="Unit" readonly>
    </div>
</div>
<div class="input-group  mb-1">
    <div class="input-group date">
        <div class="input-group-prepend">
            <span class="input-group-text" id="">@lang('home.opening') @lang('home.date')</span>
        </div>
        <input type="text" id="idateinput" class="form-control">
    </div>
</div>
<div class="row">
    <div class="input-group mb-1 col-sm-6">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.tp')(@lang('home.trade') @lang('home.price'))</label>
        </div>
        <input type="number" class="form-control" id="tp" value="0" placeholder="@lang('home.tp')">
    </div>
    <div class="input-group mb-1 col-sm-6">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.mrp')(@lang('home.market') @lang('home.price'))</label>
        </div>
        <input type="number" class="form-control" id="datamrp" value="0" placeholder="@lang('home.mrp')">
    </div>
</div>
<div class="row">
    <div class="input-group mb-1 col-sm-6">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.vat') @lang('home.type')</label>
        </div>
        <input type="text" class="form-control" id="datavattype" placeholder="Vat Type" readonly>
    </div>
    <div class="input-group mb-1 col-sm-6">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.vat') @lang('home.value')</label>
        </div>
        <input type="number" class="form-control" id="vatvalue" value="0" placeholder="@lang('home.vat') @lang('home.value')">
    </div>
</div>
<div class="input-group mb-1">
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">@lang('home.remark')</label>
    </div>
    <textarea name="remark" class="form-control" id="iremark" cols="30" rows="2" placeholder="@lang('home.remark')">
              </textarea>
</div>
<div class="row">
    <div class="input-group mb-2 col-sm-6">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.status')</label>
        </div>
        <input type="text" class="form-control" id="status" placeholder="@lang('home.status')" readonly>
    </div>
</div>