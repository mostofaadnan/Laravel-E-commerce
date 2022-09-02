<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

Date Search:<div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
<i class="fa fa-calendar"></i>&nbsp;
    <span></span> <i class="fa fa-caret-down"></i>
</div>
<script type="text/javascript">
    /*$(function() {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

       cb(start, end);
      

       $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
   var start = picker.startDate.format('YYYY-MM-DD');
   var end = picker.endDate.format('YYYY-MM-DD');



  $.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
      var min = start;
      var max = end;
      var startDate = new Date(data[1]);
      if (min == null && max == null) {
        return true;
      }
      if (min == null && startDate <= max) {
        return true;
      }
      if (max == null && startDate >= min) {
        return true;
      }
      if (startDate <= max && startDate >= min) {
        return true;
      }
      return false;
    }
  );
  table.draw();


});

    });
    */
</script>
<!--
    
    <table  class="table table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>@lang('home.from')</th>
            <th>@lang('home.to')</th>
            <th>@lang('home.action')</th>
        </tr>
    <tbody>
        <td>
            <div class="input-group date" data-provide="datepicker" id="datepicker">
                <input type="text" name="min" id="min" class="form-control min">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>
        </td>
        <td>
            <div class="input-group date" data-provide="datepicker" id="datepicker">
                
                <input type="text" name="max" id="max" class="form-control max">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>

        </td>
        <td>
        <button type="button" class="btn btn-info" id="submitdate" name="button" style="width:100%;height:100%;">@lang('home.submit')</button>
        </td>
    </tbody>
    </thead>
</table>


<script>
    $(document).ready(function() {
        $('.input-daterange').datepicker({
            todayBtn: 'linked',
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });
</script>

-->