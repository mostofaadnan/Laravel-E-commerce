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
        <h5 style="color:#fff;">@lang('home.stock') @lang("home.report")</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered" cellspacing="0" width="100%">
            <tr>
                <th>@lang('home.category')</th>
                <th>@lang('home.item')</th>
                <th>@lang('home.action')</th>
            </tr>
            <tr>
                <td>
                    <select class="form-control" id="category">
                        <option value="0" selected>@lang('home.all')</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control" id="productsearch" placeholder=" @lang('home.search')" list="product" required>
                    <datalist id="product">
                    </datalist>
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
                    <th> #@lang('home.sl') </th>
                    <th> @lang('home.barcode') </th>
                    <th> @lang('home.name') </th>
                    <th> @lang('home.category')</th>
                    <th> @lang('home.stock')</th>
                    <th> @lang('home.unit')</th>
                    <th> @lang('home.tp')</th>
                    <th> @lang('home.mrp')</th>
                    <th> @lang('home.stock') @lang('home.amount')</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr>
                    <th> #@lang('home.sl') </th>
                    <th> @lang('home.barcode') </th>
                    <th> @lang('home.name') </th>
                    <th> @lang('home.category')</th>
                    <th> @lang('home.stock')</th>
                    <th> @lang('home.unit')</th>
                    <th> @lang('home.tp')</th>
                    <th> @lang('home.mrp')</th>
                    <th> @lang('home.stock') @lang('home.amount')</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
    function ItemDatalist() {
        $.ajax({
            type: 'get',
            url: "{{ route('product.itemdatalist') }}",
            datatype: 'JSON',
            success: function(data) {
                $('#product').html(data);
            },
            error: function(data) {}
        });
    }
    window.onload = ItemDatalist();

    $('#category').change(function() {
        var categoryid = $(this).val();
        if (categoryid > 0) {
            $.ajax({
                type: "GET",
                data: {
                    categoryid: categoryid
                },
                url: "{{route('product.ItemDataListCategory')}}",
                success: function(data) {
                    $('#product').html("");
                    $("#productsearch").val("");
                    if (data) {
                        $('#product').html(data);
                    } else {
                        $('#product').html("");
                        $("#productsearch").val("");

                    }
                }
            });
        } else {
            ItemDatalist();
            $("#productsearch").val("");

        }
    });
    //query
    var table;
    var productid = 0;
    var categoryid = 0;
    window.onload = function Empty() {
        $('#mytable tbody').empty();
    }

    function DataTable() {
        categoryid = $('#category').val();
        var productname = $("#productsearch").val();
        if (productname == "") {
            productid = 0;
        } else {
            productid = $('#product').find('option[value="' + productname + '"]').attr('id');
        }

        console.log('category:' + categoryid + 'productid:' + productid);
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
                this.api().columns('8', {
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
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
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
                "url": "{{ route('report.stockReportQuery') }}",
                "data": {

                    categoryid: categoryid,
                    productid: productid

                },
                "type": "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: "text-center"
                },
                {
                    data: 'barcode',
                    name: 'barcode',
                    className: "text-center"
                },
                {
                    data: 'name',
                    name: 'name',

                },
                {
                    data: 'category',
                    name: 'category',
                },
                {
                    data: 'stock',
                    name: 'stock',
                    className: "text-right"
                },
                {
                    data: 'unit',
                    name: 'unit',
                    className: "text-right"
                },
                {
                    data: 'tp',
                    name: 'tp',
                    className: "text-right"
                },
                {
                    data: 'mrp',
                    name: 'mrp',
                    className: "text-right"
                },
                {
                    data: 'stockamount',
                    name: 'stockamount',
                    className: "text-right"
                },


            ],
        });

    }
    window.onload = DataTable();
    $("#submitdate").on('click', function() {

        table.destroy();
        DataTable();


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
            var product;
            var category;
            if (productid == 0) {
                product = "All"
            } else {
                product = $("#productsearch").val();
            }
            var category;
            if (categoryid == 0) {
                category = "All"
            } else {
                category = $('#category :selected').text();
            }

            $.ajax({
                type: "post",
                url: "{{ route('report.stockReportQueryPdf') }}",
                //data: JSON.stringify(itemtables),
                data: {
                    productid: productid,
                    categoryid: categoryid,
                    product: product,
                    category: category,
                    printconfirm: printconfirm

                },
                datatype: ("json"),
                success: function(data) {
                    url = "{{ url('Admin/Report/stockReportPdfView')}}",
                        window.open(url, '_blank');
                },
                error: function(data) {

                }
            });
        }



    }
</script>
@endsection