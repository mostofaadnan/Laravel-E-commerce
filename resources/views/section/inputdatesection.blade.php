<div class="input-group date" data-provide="datepicker" id="datetimepicker">
    <input type="text" name="inputdate" id="dateinput" class="form-control inv-section">
    <div class="input-group-addon">
        <span class="glyphicon glyphicon-th"></span>
    </div>
</div>
<script>
    $(function() {
        var myDate = $("#dateinput").attr('data-date');
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        var currentmonth = new Date(date.getFullYear(), date.getMonth());
        $('#dateinput').datepicker({
            dateFormat: 'yyyy/mm/dd',
            todayHighlight: true,
            startDate: today,
            endDate: end,
            autoclose: true
        });
        $('#dateinput').datepicker('setDate', myDate);
        $('#dateinput').datepicker('setDate', today);
    });
</script>