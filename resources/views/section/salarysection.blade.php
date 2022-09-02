<div class="form-row">
    <div class="col-md-2 mb-1">
        <label for="validationDefault01">@lang('home.salary') @lang('home.no')</label>
        <input type="text" class="form-control" id="paymentno" placeholder="Salary No" readonly>
    </div>
    <div class="col-md-3 mb-1">
        <label for="validationDefault01">@lang('home.date')</label>
        <div class="input-group date" data-provide="datepicker" id="datetimepicker2">
            <input type="text" name="openingdate" id="inputdate" class="form-control" data-date="">
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-1">
        <label for="validationDefault01">@lang('home.from')</label>
        <div class="input-group date" data-provide="datepicker" id="datetimepicker2">
            <input type="text" name="openingdate" id="fromdate" class="form-control" data-date="">
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-1">
        <label for="validationDefault01">@lang('home.to')</label>
        <div class="input-group date" data-provide="datepicker" id="datetimepicker2">
            <input type="text" name="openingdate" id="todate" class="form-control" data-date="">
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
        </div>
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