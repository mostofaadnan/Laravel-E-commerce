@extends('layouts.master')
@section('content')

<div class="card">
    <style .input-group-text{width:auto;}></style>
    <div class="card-header card-header-section">
        <div class="pull-left">
            @lang('home.bank') @lang('home.desctiption')
        </div>
        <div class="pull-right">
            <label id="balance"></label>
            <!--  <div class="input-group">
                <div class="input-group-prepend" style="background-color: transparent !important;">
                    <span class="input-group-text">Prasent Balance</span>
                </div>
                <input type="text" class="form-control sum-section" id="balance" placeholder="nettotal" value="0" readonly>
            </div> -->

        </div>
    </div>
    <div class="card-body">
        <div class="row ">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-9">
                @include('section.dateBetween')
                <!-- https://w3alert.com/laravel-tutorial/laravel-datatables-custom-search-filter-example-tutorial -->
            </div>

            <div class="divider"></div>
        </div>
        <table id="mytable" class="table table-bordered" style="width:100%" cellspacing="0">
            <thead>
                <tr>
                    <th> #@lang('home.sl') </th>
                    <th> @lang('home.id') </th>
                    <th> @lang('home.amount') </th>
                    <th> @lang('home.currency') </th>
                    <th> @lang('home.description')</th>
                    <th> @lang('home.exchange_rate') </th>
                    <th> @lang('home.fee')</th>
                    <th> @lang('home.net')</th>
                    <th> @lang('home.source')</th>
                    <th> @lang('home.type')</th>

                </tr>
            </thead>
            <tbody>
<!-- 
                @foreach($historys['data'] as $key =>$history)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $history['id']  }}</td>
                    <td>{{ $history['amount']  }}</td>
                    <td>{{ $history['currency']  }}</td>
                    <td>{{ $history['description']  }}</td>
                    <td>{{ $history['exchange_rate']  }}</td>
                    <td>{{ $history['fee']  }}</td>
                    <td>{{ $history['source']  }}</td>
                    <td>{{ $history['type']  }}</td>
                </tr>
                @endforeach -->

            </tbody>
            <tfoot>
                <tr>
                    <th> #@lang('home.sl') </th>
                    <th> @lang('home.id') </th>
                    <th> @lang('home.amount') </th>
                    <th> @lang('home.currency') </th>
                    <th> @lang('home.description')</th>
                    <th> @lang('home.exchange_rate') </th>
                    <th> @lang('home.fee')</th>
                    <th> @lang('home.net')</th>
                    <th> @lang('home.source')</th>
                    <th> @lang('home.type')</th>
                </tr>
            </tfoot>
        </table>

    </div>


</div>
<script>
    var table;

    function DataTable() {
        var fromdate = $("#min").val();
        var todate = $("#max").val();
        table = $('#mytable').DataTable({
            responsive: true,
            paging: true,
            scrollY: 400,
            ordering: true,
            searching: true,
            colReorder: true,
            keys: true,
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            iDisplayLength: 100,
            processing: true,
            serverSide: true,
            /*    footerCallback: function() {
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
                
                   $(column.footer()).html(sum);

                 });
               }, */
            //dom: 'lBfrtip',
            dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [{

                    text: '<i class="fa fa-refresh"></i>@lang("home.refresh")',
                    action: function() {
                        $("#min").val("");
                        $("#max").val("");
                        /* table.destroy();
                        DataTable(); */
                        table.ajax.reload();
                    },
                    className: 'btn btn-info',
                },
                {
                    extend: 'copy',
                    className: 'btn btn-secondary',
                    text: '<i class="fa fa-files-o"></i>@lang("home.export")',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'csv',
                    text: '<i class="fa fa-file-text-o"></i>@lang("home.csv")',
                    className: 'btn btn-info',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i>@lang("home.excel")',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                    footer: true,
                },
                {
                    text: '<i class="fa fa-file-pdf-o"></i>@lang("home.pdf")',
                    extend: 'pdf',
                    className: 'btn btn-light',
                    orientation: 'portrait', //portrait',
                    pageSize: 'A4',
                    title: 'Purchase Order List',
                    filename: 'purchaseorder',
                    className: 'btn btn-danger',

                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
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
                    text: '<i class="fa fa-print"></i>@lang("home.print")',
                    className: 'btn btn-dark',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                    footer: true,
                },

            ],
            "ajax": {
                "url": "{{ route('cards.StripeLoad') }}",
                /* "data": {
                  fromdate: fromdate,
                  todate: todate
                }, */
                "type": "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: "text-center"
                },
                {
                    data: 'id',
                    name: 'id',
                  
                },
                {
                    data: 'amount',
                    name: 'amount',
                    className: "text-right"


                },
                {
                    data: 'currency',
                    name: 'currency',
                    className: "text-center"
                },

                {
                    data: 'description',
                    name: 'description',
                  
                },
                {
                    data: 'exchange_rate',
                    name: 'exchange_rate',
                    className: "text-right"
                 
                },
                {
                    data: 'fee',
                    name: 'fee',
                    className: "text-right"
                },
                {
                    data: 'net',
                    name: 'net',
                    className: "text-right"

                },
                {
                    data: 'source',
                    name: 'source',

                },
                {
                    data: 'type',
                    name: 'type',

                }
            ],
        });
        $('.dataTables_length').addClass('bs-select');
    }
    window.onload=DataTable();
</script>
@endsection