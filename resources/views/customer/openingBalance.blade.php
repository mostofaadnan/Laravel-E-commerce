@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-body">
        <div class="row">
            @include('customer.partials.openingForm')
        </div>
        <hr>
        <h4 align='center' style="border-bottom:1px #ccc solid;">Balance History</h4>
        <table class="table table-bordered" cellspacing="0" id="mytable" width="100%">
            <thead>
                <tr>
                    <th> @lang('home.sl')</th>
                    <th> @lang('home.date') </th>
                    <th> @lang('home.opening') @lang('home.balance') </th>
                    <th> @lang('home.order')</th>
                    <th> @lang('home.cash') @lang('home.invoice') </th>
                    <th> @lang('home.credit') @lang('home.invoice') </th>
                    <th> @lang('home.discount') </th>
                    <th> @lang('home.credit') @lang('home.payment') </th>
                    <th> @lang('home.payment') </th>
                    <th> @lang('home.return') </th>
                    <th> @lang('home.remark') </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th> @lang('home.sl')</th>
                    <th> @lang('home.date') </th>
                    <th> @lang('home.opening') @lang('home.balance') </th>
                    <th> @lang('home.order')</th>
                    <th> @lang('home.cash') @lang('home.invoice') </th>
                    <th> @lang('home.credit') @lang('home.invoice') </th>
                    <th> @lang('home.discount') </th>
                    <th> @lang('home.credit') @lang('home.payment') </th>
                    <th> @lang('home.payment') </th>
                    <th> @lang('home.return') </th>
                    <th> @lang('home.remark') </th>
                </tr>
            </tfoot>
        </table>
    </div>

</div>

<script>
    $(document).ready(function() {
        var opening = 0;

        function getUrl() {
            var url = $(location).attr('href')
            var customerid = url.substring(url.lastIndexOf('/') + 1);
            $("#customer_id").val(customerid);
            getOpening(customerid);
            DataTable(customerid);


        }
        window.onload = getUrl()

        function calc() {
            var cashinvoice = 0.00;
            var creditinvoice = 0.00
            var totaldiscount = 0.00;
            var payment = 0.00;

            cashinvoice = ($.trim($("#cashinvoice").val()) != "" && !isNaN($("#cashinvoice").val())) ? parseFloat($("#cashinvoice").val()) : 0.00;
            creditinvoice = ($.trim($("#creditinvoice").val()) != "" && !isNaN($("#creditinvoice").val())) ? parseFloat($("#creditinvoice").val()) : 0.00;
            totaldiscount = ($.trim($("#totaldiscount").val()) != "" && !isNaN($("#totaldiscount").val())) ? parseFloat($("#totaldiscount").val()) : 0.00;
            payment = ($.trim($("#payment").val()) != "" && !isNaN($("#payment").val())) ? parseFloat($("#payment").val()) : 0.00;
            var balancedue = 0.00;
            var consignment = 0.00;
            var netPayment = 0.00;
            var netconsignment = 0.00;
            consignment = parseFloat(cashinvoice + creditinvoice);
            netPayment = parseFloat(payment + cashinvoice);
            netconsignment = parseFloat(consignment - totaldiscount);
            balancedue = parseFloat(netconsignment - netPayment);
            $("#consignment").val(netconsignment);
            $("#netpayment").val(netPayment);
            $("#balancedue").val(balancedue);
        }
        $("#cashinvoice").keyup(function() {
            calc();
        });
        $("#creditinvoice").keyup(function() {
            calc();
        });
        $("#totaldiscount").keyup(function() {
            calc();
        });
        $("#payment").keyup(function() {
            calc();
        });
    });

    function getOpening(customerid) {
        $.ajax({
            type: 'get',
            data: {
                customerid: customerid
            },
            url: "{{url('Admin/Customer/getopening')}}",
            success: function(data) {
                $("#balanceid").val(data.id);
                LoadData(data);
            },
            error: function(data) {
                console.log(data);
            }
        });

    }

    function LoadData(data) {
        var balancedue = 0.00;
        var consignment = 0.00;
        var netPayments = 0.00;
        var netconsignment = 0.00;
        var cashinvoice = parseFloat(data.cashinvoice);
        var creditinvoice = parseFloat(data.creditinvoice);
        var totaldiscount = parseFloat(data.totaldiscount);
        var payment = parseFloat(data.payment);
        $("#cashinvoice").val(cashinvoice);
        $("#creditinvoice").val(creditinvoice);
        $("#totaldiscount").val(totaldiscount);
        $("#payment").val(payment);
        consignment = parseFloat(cashinvoice + creditinvoice).toFixed(2)
        netPayments = parseFloat(payment + cashinvoice).toFixed(2)
        netconsignment = parseFloat(consignment - totaldiscount).toFixed(2)
        balancedue = parseFloat(netconsignment - netPayments);
        $("#consignment").val(netconsignment);
        $("#netpayment").val(netPayments);
        $("#balancedue").val(balancedue);
    }


    //load Balance
    var tabledata;

    function DataTable(customerid) {
        var tabledata = $('#mytable').DataTable({

            responsive: true,
            paging: true,
            scrollY: 300,
            ordering: true,
            searching: true,
            colReorder: true,
            keys: true,
            processing: true,
            serverSide: true,
            footerCallback: function() {
                var sum = 0;
                var column = 0;
                this.api().columns('2,3,4,5,6,7,8', {
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
                    /*  if (!sum.includes('tk'))
                       sum += ' &euro;';*/
                    $(column.footer()).html(sum);

                });
            },

            dom: "<'row'<'col-sm-4'l><'col-sm-5 text-center'B><'col-sm-3'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",

            buttons: [{
                    text: '<i class="fa fa-refresh"></i>Refresh',
                    action: function() {
                        tabledata.ajax.reload();
                    },
                    className: 'btn btn-info',
                },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i>Excel',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    },
                    footer: true,
                },
                {
                    text: '<i class="fa fa-file-pdf-o"></i>PDF',
                    extend: 'pdfHtml5',
                    className: 'btn btn-light',
                    orientation: 'landscape', //portrait',
                    pageSize: 'A4',
                    title: 'Customer List(Cash)',
                    filename: 'Customer',
                    className: 'btn btn-danger',

                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    },
                    footer: true,
                    customize: function(doc) {

                        var tblBody = doc.content[1].table.body;
                        doc.content[1].layout = {
                            hLineWidth: function(i, node) {
                                return (i === 0 || i === node.table.body.length) ? 2 : 1;
                            },
                            vLineWidth: function(i, node) {
                                return (i === 0 || i === node.table.widths.length) ? 2 : 1;
                            },
                            hLineColor: function(i, node) {
                                return (i === 0 || i === node.table.body.length) ? 'black' : 'gray';
                            },
                            vLineColor: function(i, node) {
                                return (i === 0 || i === node.table.widths.length) ? 'black' : 'gray';
                            }
                        };
                        $('#gridID').find('tr').each(function(ix, row) {
                            var index = ix;
                            var rowElt = row;
                            $(row).find('td').each(function(ind, elt) {
                                tblBody[index][ind].border
                                if (tblBody[index][1].text == '' && tblBody[index][2].text == '') {
                                    delete tblBody[index][ind].style;
                                    tblBody[index][ind].fillColor = '#FFF9C4';
                                } else {
                                    if (tblBody[index][2].text == '') {
                                        delete tblBody[index][ind].style;
                                        tblBody[index][ind].fillColor = '#FFFDE7';
                                    }
                                }
                            });
                        });
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>Print',
                    className: 'btn btn-dark',
                    orientation: 'landscape',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    },
                    footer: true,
                },

            ],
            "ajax": {
                "data": {
                    customerid: customerid
                },
                "url": "{{ route('customer.balanceloadall') }}",
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
                },
                {
                    data: 'openingBalance',
                    name: 'openingBalance',
                    className: "text-right"
                },
                {
                    data: 'order',
                    name: 'order',
                    className: "text-right"
                },
                {
                    data: 'cashinvoice',
                    name: 'cashinvoice',
                    className: "text-right"
                },
                {
                    data: 'creditinvoice',
                    name: 'creditinvoice',
                    className: "text-right"
                },

                {
                    data: 'totaldiscount',
                    name: 'totaldiscount',
                    className: "text-right"

                },
                {
                    data: 'payment',
                    name: 'payment',
                    className: "text-right"
                },
                {
                    data: 'totalpayment',
                    name: 'totalpayment',
                    className: "text-right"
                },
                {
                    data: 'salereturn',
                    name: 'salereturn',
                    className: "text-right"
                },
                {
                    data: 'remark',
                    name: 'remark',
                    className: "text-right"
                },

            ],
        });
        /*   $('.dataTables_length').addClass('bs-select'); */
    }
</script>
@endsection