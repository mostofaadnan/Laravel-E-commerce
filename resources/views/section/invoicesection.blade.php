<style>
    #shipment{
        color:red;
    }
</style>
<div class="form-row">
    <div class="col-md-2 col-xs-4 mb-1">
        <label for="validationDefault01">@lang('home.invoice') @lang('home.no')</label>
        <input type="text" class="form-control" id="invoicecode" placeholder="Purchase Code" readonly>
    </div>
    <div class="col-md-2 col-xs-4 mb-1">
        <label for="validationDefault01">@lang('home.date')</label>
        @include('section.inputdatesection')
    </div>
    <div class="col-md-4 mb-1">
        @include('section.customersection')
    </div>
    <div class="col-md-2 col-xs-4 mb-1">
        <label for="validationDefault01">@lang('home.reference')</label>
        <input type="text" class="form-control" placeholder="Ref. No" id="refno" required>
    </div>
    <div class="col-md-2 col-xs-4 mb-1">
        <label for="validationDefault01">@lang('home.shipment') @lang('home.expenses')</label>
        <input type="text" class="form-control" placeholder="Shipment" id="shipment" value="0" required>
    </div>
</div>