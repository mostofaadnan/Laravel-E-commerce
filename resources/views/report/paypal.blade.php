@extends('layouts.master')
@section('content')
<style>
    .date {
        margin-top: 10px !important;
    }
</style>
<div class="card">
    <style .input-group-text{width:auto;}></style>
    <div class="card-header card-header-section">
        <h5 style="color:#fff;">@lang("home.paypal") @lang("home.payment")</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered" cellspacing="0" width="100%">
            <tr>
                <th>@lang('home.type')</th>
                <th>@lang('home.from')</th>
                <th>@lang('home.to')</th>
                <th>@lang('home.action')</th>
            </tr>
            <tr>
                <td>
                    <select class="form-control" id="type">
                        <option value="0">All</option>
                        <option value="1">Cash Invoice</option>
                        <option value="3">Credit Payment</option>
                    </select>
                </td>
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
        <table id="mytable" class="table table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="10%"> #@lang('home.sl') </th>
                    <th width="15%"> @lang('home.date') </th>
                    <th> @lang('home.description')</th>
                    <th> @lang('home.ref'). @lang('home.number')</th>
                    <th width="10%"> @lang('home.debit') </th>
                    <th width="10%"> @lang('home.credit')
                    <th width="10%"> @lang('home.balance')</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th width="10%"> #@lang('home.sl') </th>
                    <th width="15%"> @lang('home.date') </th>
                    <th> @lang('home.description')</th>
                    <th> @lang('home.ref'). @lang('home.number')</th>
                    <th width="10%" id="totaldebit"> @lang('home.debit') </th>
                    <th width="10%" id="totalcredit"> @lang('home.credit')
                    <th width="10%"> @lang('home.balance')</th>
                </tr>
            </tfoot>
        </table>
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


    //query
    var table;

    window.onload = function Empty() {
        $('#mytable tbody').empty();
    }

    function DataTable() {
        var type = $("#type").val();
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

            // deferLoading: [0, 100],
            footerCallback: function() {
                var sum = 0;
                var column = 0;
                this.api().columns('3,4', {
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
                    /* if (!sum.includes('€'))
                      sum += ' &euro;'; */
                    $(column.footer()).html(sum);


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
                        columns: [0, 1, 2, 3, 4, 5]
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
                "url": "{{ route('report.paypalQuery') }}",
                "data": {
                    type: type,
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
                    data: 'description',
                    name: 'description',

                },
                {
                    data: 'payerid',
                    name: 'payerid',
                    className: "text-center"
                },
                {
                    data: 'cashout',
                    name: 'cashout',
                    className: "text-right"
                },
                {
                    data: 'cashin',
                    name: 'cashin',
                    className: "text-right"
                },
                {
                    data: 'balance',
                    name: 'balance',
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
            var type = $('#type :selected').text();
            var fromdate = $("#inputdate").val();
            var todate = $("#inputdateto").val();
            var totaldebit = $("#totaldebit").text();
            var totalcredit = $("#totalcredit").text();
            var itemtables = new Array();
            $("#mytable TBODY TR").each(function() {
                var row = $(this);
                var item = {};
                item.date = row.find("TD").eq(1).html();
                item.description = row.find("TD").eq(2).html();
                item.ref = row.find("TD").eq(3).html();
                item.debit = row.find("TD").eq(4).html();
                item.credit = row.find("TD").eq(5).html();
                item.balance = row.find("TD").eq(6).html();
                itemtables.push(item);
            });
            /*   var args = {
                  itemtables: itemtables,  // make sure that the date is in Javascript date object and converted to ISO string for proper casting in c#
              }; */
            $.ajax({
                type: "post",
                url: "{{ route('report.paypalQueryPdf') }}",
                //data: JSON.stringify(itemtables),
                data: {
                    type: type,
                    itemtables: itemtables,
                    todate: todate,
                    fromdate: fromdate,
                    totaldebit: totaldebit,
                    totalcredit: totalcredit,
                    printconfirm:printconfirm
                },
                datatype: ("json"),
                success: function(data) {
                    url = "{{ url('Admin/Report/paypalPdfView')}}",
                        window.open(url, '_blank');

                },
                error: function(data) {}
            });
        }
    }
</script>
@endsection