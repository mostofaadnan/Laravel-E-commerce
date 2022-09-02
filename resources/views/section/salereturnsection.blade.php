<div class="form-row">
    <div class="col-md-2 col-xs-4">
        <label for="validationDefault01">@lang('home.return') @lang('home.no')</label>
        <input type="text" class="form-control" id="returncode" placeholder="@lang('home.return') @lang('home.code')" readonly>
    </div>
    <div class="col-md-2 col-xs-4">
        <label for="validationDefault01">@lang('home.invoice') @lang('home.no')</label>
        <input type="text" class="form-control" id="invoicecode" list="invoicenumber" placeholder="@lang('home.invoice') @lang('home.no')">
        <datalist id="invoicenumber">
        </datalist>
    </div>
    <div class="col-md-1 col-xs-4">
        <label for="validationDefault01">@lang('home.type')</label>
        <select id="type" class="form-control">
            <option value="1">Cash</option>
            <option value="2">Credit</option>
        </select>
    </div>
    <div class="col-md-2 col-xs-4">
        <label for="validationDefault01">@lang('home.date')</label>
        @include('section.inputdatesection')
    </div>
    <div class="col-md-4 col-xs-4">
        @include('section.customersection')
    </div>
    <div class="col-md-1 col-xs-4">
        <label for="validationDefault01">@lang('home.reference')</label>
        <input type="text" class="form-control" placeholder="@lang('home.reference')" id="refno" required>
    </div>
</div>