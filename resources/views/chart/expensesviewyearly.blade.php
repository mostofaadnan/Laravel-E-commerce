@extends('layouts.master')
@section('content')

<div class="card">

    <div class="card-header card-header-section">
        <div class="pull-left">
            @lang('home.expenses') @lang('home.chart')
        </div>

        <div class="pull-right">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <select class="form-control" id="viewchart">
                        <option value="1">Monthly</option>
                        <option value="2" selected>Yearly</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <select class="form-control charttype">
                        <option value="1">Bar</option>
                        <option value="2">Line</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <select class="form-control invoiceyear">
                        <?php
                        $currently_selected = date('Y');
                        for ($i = 2020; $i <= 2050; $i++) {
                            echo '<option value=' . $i . ' ' . ($i === $currently_selected ? ' selected="selected"' : '') . '>' . $i . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

        </div>
    </div>
    <div class="card-body">
        <div class="col-sm-12 col-md-12">
            {!! $ExpensesChart->container() !!}
        </div>
    </div>


</div>
{!! $ExpensesChart->script() !!}
<script>
    $("#viewchart").change(function() {
                var type = $(this).val();
                if (type == 1) {
                    url = "{{ route('chart.ExpensesMonthlyChartView')}}",
                        window.location = url;
                }
            });
            var expenses_api_url = {{ $ExpensesChart->id }}_api_url;
         $(".invoiceyear").change(function(){
        ChartFileter();
             });
               $(".charttype").change(function(){
        ChartFileter();
              });
              function ChartFileter(){
    var year = $(".invoiceyear").val();
    var type=$(".charttype").val();
    {{ $ExpensesChart->id }}_refresh(expenses_api_url + "?year="+year+"&type="+type);
}
</script>
@endsection