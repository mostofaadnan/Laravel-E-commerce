<div class="form-row">
    <div class="col-md-5 mb-1">
        <label for="validationDefault02">@lang('home.item')</label>
        <input type="text" class="form-control" id="search" placeholder="@lang('home.search')" list="product" autocomplete="off">
        <datalist id="product">
        </datalist>
    </div>
    <div class="col-md-2 mb-1">
        <label for="validationDefault01">@lang('home.price')</label>
        <input type="number" class="form-control" id="mrp" placeholder="@lang('home.price')">
    </div>
    <div class="col-md-2 mb-1">
        <label for="validationDefault01">@lang('home.quantity')</label>
        <input type="number" class="form-control" id="qty" placeholder="@lang('home.quantity')" required>
    </div>
    <div class="col-md-1 mb-1">
        <label for="validationDefault01">@lang('home.discount')</label>
        <input type="number" class="form-control" id="discount" placeholder="@lang('home.discount')" required value="0">
    </div>
    <div class="col-md-2 mt-4 button-section">
        <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-sm btn-info" id="addrows" name="button">@lang('home.add')</button>
            <button type="button" id="clear" class="btn btn-sm btn-success" name="button">@lang('home.reset')</button>
        </div>
    </div>
</div>