@extends('layouts.master')
@section('content')
<style>
 .date {
        margin-top: 10px!important;
    }
</style>
<div class="card">
    <style .input-group-text{width:auto;}></style>
    <div class="card-header card-header-section">
        <h5 style="color:#fff;">@lang("home.income")</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered" cellspacing="0" width="100%">
            <tr>

                <th>@lang('home.from')</th>
                <th>@lang('home.to')</th>
                <th>@lang('home.action')</th>
            </tr>
            <tr>
                <td>
                    <div class="input-group date" data-provide="datepicker" id="datetimepicker2">
                        <input type="text" name="openingdate" id="inputdate" class="form-control" data-date="">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="input-group date" data-provide="datepicker" id="datetimepicker2">
                        <input type="text" name="openingdate" id="inputdateto" class="form-control" data-date="">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </td>
                <td>
                <button type="button" class="btn btn-info" id="submitdate" name="button" style="width:100%;height:100%;">@lang('home.submit')</button>
                </td>
            </tr>

        </table>
        <hr>
        <table class="table table-bordered" id="mytable" style="width:100%" cellspacing="0">
            <thead>
                <tr>
                    <th> #@lang('home.sl') </th>
                    <th> @lang('home.date') </th>
                    <th> @lang('home.description') </th>
                    <th> @lang('home.number') </th>
                    <th> @lang('home.amount') </th>

                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr>
                    <th> #@lang('home.sl') </th>
                    <th> @lang('home.date') </th>
                    <th> @lang('home.description') </th>
                    <th> @lang('home.number') </th>
                    <th class="text-right" id="totalamout"> @lang('home.amount') </th>

                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
    var nettotal = 0;
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


    //query
    var table;

    window.onload = function Empty() {
        $('#mytable tbody').empty();
    }
    function DataTable() {
        var fromdate = $("#inputdate").val();
        var todate = $("#inputdateto").val();
        table = $('#mytable').DataTable({
            responsive: true,
            paging: true,
            scrollY: 400,
            ordering: false,
            searching: true,
            colReorder: false,
            keys: true,
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            iDisplayLength: 100,
            processing: true,
            serverSide: true,
            footerCallback: function() {
                var sum = 0;
                var column = 0;
                this.api().columns('4', {
                    page: 'current'
                }).every(function() {
                    column = this;
                    sum = column
                        .data()
                        .reduce(function(a, b) {
                            a = parseFloat(a, 10);
                            if (isNaN(a)) {
                                a = 0;
                            }
                            b = parseFloat(b, 10);
                            if (isNaN(b)) {
                                b = 0;
                            }
                            return (a + b).toFixed(2);
                        }, 0);

                    $(column.footer()).html('<b style="color:red">' + sum + '</b>');

                });
            },
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [{
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i>@lang("home.excel")',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                    footer: true,
                },
                {
                    text: '<i class="fa fa-file-pdf-o"></i>@lang("home.pdf")',
                    className: 'btn btn-danger',
                    attr: {
                        id: 'pdfconforms',
                    },

                },
                {

                    text: '<i class="fa fa-print"></i>@lang("home.print")',
                    className: 'btn btn-dark',
                    attr: {
                        id: 'printconfirms',
                    },
                },

            ],
            "ajax": {
                "url": "{{ route('report.incomeQuery') }}",
                "data": {
                    fromdate: fromdate,
                    todate: todate,
                },
                "type": "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: "text-center"
                },
                {
                    data: 'inputdate',
                    name: 'inputdate',
                    className: "text-center"

                },
                {
                    data: 'source',
                    name: 'source',

                },

                {
                    data: 'number',
                    name: 'number',


                },
                {
                    data: 'amount',
                    name: 'amount',
                    className: "text-right"

                },

            ],
        });

    }
    window.onload = DataTable();
    $("#submitdate").on('click', function() {
        if ($("#inputdateto").val() == "" || $("#inputdateto").val() == "") {
            swal("Opps! Faild", "Please Select Between Date", "error");
        } else {
            table.destroy();
            DataTable();
        }
    });
    //pdf
    $(document).on('click', '#pdfconforms', function() {
        var printconfirm = 1;
        pdf(printconfirm)
      
    });
    $(document).on('click', '#printconfirms', function() {
        var printconfirm = 2;
        pdf(printconfirm)
       
    });
    function pdf(printconfirm) {
        var tbody = $("#mytable tbody");
        if (tbody.children().length == 0) {

        } else {
            var fromdate = $("#inputdate").val();
            var todate = $("#inputdateto").val();
            $.ajax({
                type: "post",
                url: "{{ route('report.incomeQueryPdf') }}",
                //data: JSON.stringify(itemtables),
                data: {
                    
                   
                    todate: todate,
                    fromdate: fromdate,
                    printconfirm:printconfirm
                  
                },
                datatype: ("json"),
                success: function(data) {
                    url = "{{ url('Admin/Report/incomePdfView')}}",
                        window.open(url, '_blank');

                },
                error: function(data) {}
            });
        }
    }
</script>
@endsection