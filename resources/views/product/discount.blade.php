@extends('layouts.master')
@section('content')
<div class="col-lg-12">
    <div class="card card-design">
        <div class="card-header card-header-section">

            <div class="pull-left">
                @lang('home.item') @lang('home.price')/@lang('home.discount') @lang('home.update')
            </div>
            <div class="pull-right"><button class="btn btn-light" id="loadall">@lang("home.all") @lang("home.item")</button></div>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="col-md-4 mb-1">
                    <label for="validationDefault02">@lang('home.item')</label>
                    <input type="text" class="form-control" id="search" placeholder="Search" list="product" required>
                    <datalist id="product">
                    </datalist>
                </div>
                <div class="col-md-2 mb-1">
                    <label for="validationDefault02">@lang('home.category')</label>
                    <input type="text" class="form-control" id="search" placeholder="Search" list="product" required>
                    <datalist id="product">
                    </datalist>
                </div>
                <div class="col-md-2 mb-1">
                    <label for="validationDefault01">@lang('home.mrp')</label>
                    <input type="number" class="form-control" id="mrp" placeholder="@lang('home.mrp')">
                </div>
                <div class="col-md-2 mb-1">
                    <label for="validationDefault01">@lang('home.discount') @lang('home.price')</label>
                    <input type="number" class="form-control" id="discount" placeholder="Discount" required value="0">
                </div>
                <div class="col-md-2 mt-4 button-section">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-sm btn-info" id="addrows" name="button">@lang('home.add')</button>
                        <button type="button" id="clear" class="btn btn-sm btn-success" name="button">@lang('home.reset')</button>
                    </div>
                </div>
            </div>
            <div class="my-custom-scrollbar my-custom-scrollbar-primary scrollbar-morpheus-den">
                <table class="table table-bordered data-table" id="producttable" style="width:100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10%"> #@lang('home.sl') </th>
                            <th> @lang('home.description')</th>
                            <th width="10%"> @lang('home.category')</th>
                            <th width="10%"> @lang('home.mrp')</th>
                            <th width="10%"> @lang('home.discount') @lang('home.price')</th>
                            <th width="10%"> @lang('home.vat')
                            <th width="10%"> @lang('home.action')</th>
                        </tr>
                    </thead>
                    <tbody id="datatablebody">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer  card-header-section">
            <div class="pull-right">
                <button type="button" id="submittData" class="btn btn-lg btn-submit btn-rounded btn-danger" name="button">@lang('home.save')</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var itemids = 0;
            var sl = 1;

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
            $("#search").on('input', function() {
                var val = this.value;
                if ($('#product option').filter(function() {
                        return this.value.toUpperCase() === val.toUpperCase();
                    }).length) {
                    itemids = $('#product').find('option[value="' + val + '"]').attr('data-barcode');
                    var mrp = $('#product').find('option[value="' + val + '"]').attr('data-mrp');
                    var discount = $('#product').find('option[value="' + val + '"]').attr('data-discount');
                    if (mrp) {
                        $("#tp").val(tp)
                        $("#mrp").val(mrp)
                        $("#discount").val(discount)
                    } else {
                        $("#mrp").val("")
                    }

                }
            });


            $("#addrows").on('click', function(e) {
                var rowCount = $('.data-table tr').length;
                if (rowCount == 1) {
                    addRowData();
                } else {
                    CheckEntry();
                }

            });

            function CheckEntry() {
                var isvalid = true;
                $("#producttable tr").each(function() {
                    var row = $(this);
                    var tableitemcode = row.find("TD").eq(1).html();
                    if (itemids == tableitemcode) {
                        isvalid = false;
                        var findrow = $(this);
                        AutoQuantityUpdate(findrow)
                    }
                });
                if (isvalid == true) {
                    addRowData();
                }
            }

            function addRowData() {
                var search = $("#search").val();
                var itemcode = $('#product').find('option[value="' + search + '"]').attr('id');
                var barcode = $('#product').find('option[value="' + search + '"]').attr('data-barcode');
                var productname = $('#product').find('option[value="' + search + '"]').attr('data-name');
                var qty = $("#qty").val();
                var mrp = $("#mrp").val();
                var tp = $("#tp").val();
                var discount = $("#discount").val();
                $(".data-table tbody").append("<tr data-itemcode='" + itemcode + "' >" +
                    "<td>" + sl + "</td>" +
                    "<td >" + productname + "</td>" +
                    "<td align='right'>" + mrp + "</td>" +
                    "<td contenteditable='true' align='right'>" + discount + "</td>" +
                    "<td  align='center'>" +
                    "<button class='btn btn-danger btn-delete'>X</button>" +
                    "</td>" +
                    "</tr>");
                sl++;
                clear();
            }
            $("body").on("click", ".btn-delete", function() {
                swal({
                        title: "Are you sure?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $(this).parents("tr").remove();
                        } else {
                            //swal("Your imaginary file is safe!");
                        }
                    });
            });

            function AutoQuantityUpdate(row) {
                var tp = $("#tp").val();
                var mrp = $("#mrp").val();
                var discount = $("#discount").val();
                row.find("td:eq(3)").text(tp);
                row.find("td:eq(4)").text(mrp);
                row.find("td:eq(5)").text(discount);
                clear();
            }

            function clear() {
                $("#search").val("");
                $("#mrp").val("");
                $("#tp").val("");
                $("#discount").val("");
                $('#search').focus();
                itemids = 0;
            }
            $(document).on('click', "#clear", function() {
                clear();
            })

            function ProductDetails() {
                $.ajax({
                    type: "get",
                    url: "{{ url('Admin/Product/productgetlist')}}",
                    datatype: ("json"),
                    success: function(data) {
                        loadTableDetails(data);
                    },
                    error: function(data) {

                    }

                });
            }

            function loadTableDetails(data) {
                $("#datatablebody").empty();
                data.forEach(function(value) {
                    console.log(value);
                    $(".data-table tbody").append("<tr data-itemcode='" + value.id + "' >" +
                        "<td align='center'>" + sl + "</td>" +
                        "<td>" + value.name + "</td>" +
                        "<td>" + value.category_name['title'] + "</td>" +
                        "<td align='right'  contenteditable='true'>" + value.mrp + "</td>" +
                        "<td align='right' contenteditable='true' ><b style='color:red;'>" + value.discount + "</b></td>" +
                        "<td align='right' contenteditable='true' ><b style='color:green;'>" + value.vatvalue + "</b></td>" +
                        "<td align='center'>" +
                        "<button class='btn btn-danger btn-delete'>X</button>" +
                        "</td>" +
                        "</tr>");
                    sl++;
                })
            }

            $(document).on('click', "#loadall", function() {
                ProductDetails();
            });

            //inset Data
            function DataInsert() {
                $("#overlay").fadeIn();
                var itemtables = new Array();
                $("#producttable TBODY TR").each(function() {
                    var row = $(this);
                    var item = {};
                    item.code = row.data('itemcode');
                    /*  item.tp = row.find("TD").eq(3).text(); */
                    item.mrp = row.find("TD").eq(3).text();
                    item.discountprice = row.find("TD").eq(4).text();
                    item.vat = row.find("TD").eq(5).text();
                    itemtables.push(item);
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('product.updateDiscount') }}",
                    data: {
                        itemtables: itemtables,
                    },
                    datatype: ("json"),
                    success: function(data) {
                        $("#overlay").fadeOut();
                        swal("Discount Update Successfully", "Form Submited", "success");
                        $("#datatablebody").empty();
                    },
                    error: function(data) {
                        $("#overlay").fadeOut();
                        console.log(data);
                    }
                });
            }
            $("#submittData").click(function() {

                if ($("#datatablebody").is(':empty')) {
                    swal("Ops!Item Table is Empty", "input Data", "error");
                } else {
                    DataInsert();
                }
            });
        });
    </script>

    @endsection