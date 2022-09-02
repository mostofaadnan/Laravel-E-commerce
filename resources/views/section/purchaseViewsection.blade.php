<div class="form-row">
    <div class="col-md-2 mb-1">
        <label for="validationDefault01">@lang('home.purchase') @lang('home.no')</label>
        <input type="text" class="form-control" id="purchasecode" list="purchaseno" placeholder="@lang('home.purchase') @lang('home.code')" autocomplete="off">
        <datalist id="purchaseno">

        </datalist>
    </div>
    <div class="col-md-2 mb-1">
        <label for="validationDefault01">@lang('home.date')</label>
        <div class="input-group date" data-provide="datepicker" id="datetimepicker2">
            <input type="text" name="openingdate" id="inputdate" class="form-control" data-date="">
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
        </div>

    </div>
    <div class="col-md-3 mb-1">
        <label for="validationDefault02">@lang('home.supplier')</label>
        <input type="text" class="form-control" id="suppliersearch" placeholder="@lang('home.supplier')" list="supplier" required>
        <datalist id="supplier">
        </datalist>
    </div>
    <div class="col-md-2 mb-1">
        <label for="validationDefault01">@lang('home.shipment') @lang('home.cost')</label>
        <input type="number" class="form-control" placeholder="@lang('home.shipment') @lang('home.cost')" id="shipment">
    </div>
    <div class="col-md-1 mb-1">
        <label for="validationDefault01">@lang('home.reference')</label>
        <input type="text" class="form-control" placeholder="@lang('home.reference')" id="refno">
    </div>
    <div class="col-md-2 mb-1">
        <label for="validationDefault01">@lang('home.comments')</label>
        <input type="text" class="form-control" placeholder="@lang('home.comments')" id="remark">
    </div>

</div>
<script>
    $(function() {
        var myDate = $("#inputdate").attr('data-date');
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        var currentmonth = new Date(date.getFullYear(), date.getMonth());
        $('#inputdate').datepicker({
            dateFormat: 'yyyy/mm/dd',
            todayHighlight: true,
            startDate: today,
            endDate: end,
            autoclose: true
        });
        $('#inputdate').datepicker('setDate', myDate);
        $('#inputdate').datepicker('setDate', today);
    });
</script>