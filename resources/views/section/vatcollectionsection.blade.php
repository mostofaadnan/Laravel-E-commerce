<style>
    .ui-datepicker-calendar {
        display: none;
    }

    .ui-widget {
        font-size: .7em;
    }
</style>
<div class="form-row">
    <div class="col-md-2 mb-1">
        <label for="validationDefault01">@lang('home.collection') @lang('home.no')</label>
        <input type="text" class="form-control" id="colloctionno" placeholder="Collection Number" readonly>
    </div>

    <div class="col-md-2 mb-1">
        <label for="validationDefault01">@lang('home.from')</label>
        <div class="input-group date" data-provide="datepicker" id="datetimepicker2">
            <input type="text" name="openingdate" id="inputdate" class="form-control" data-date="">
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-1">
        <label for="validationDefault01" id="typeview">@lang('home.to')</label>
        <div class="input-group date" data-provide="datepicker" id="datetimepicker2">
            <input type="text" name="openingdate" id="inputdateto" class="form-control" data-date="">
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
        </div>
    </div>
    <div class="col-md-1 mb-1">
        <label for="validationDefault01" id="typeview">@lang('home.action')</label><br>
        <button type="button" class="btn btn-sm btn-info btn-lg" id="vatcollect" name="button">@lang('home.submit')</button>
    </div>
    <div class="col-md-5 mb-1">
        <label for="validationDefault01">@lang('home.remark')</label>
        <input type="text" class="form-control" placeholder="@lang('home.remark')" id="remark">
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

        $('#inputdate').datepicker('setDate', today);
        $('#inputdateto').datepicker('setDate', today);
    });
</script>