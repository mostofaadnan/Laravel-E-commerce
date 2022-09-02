@extends('layouts.master')
@section('content')
<style>
    .opening {
        border: 1px #ccc solid;
    }
</style>
<div class="row">
    <div class="col-sm-6 form-single-input-section">
        <div class="card opening">
            <div class="card-header card-header-custom">

                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        @lang('home.opening') @lang('home.stock')
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="input-group  mb-1">

                            <input type="text" class="form-control" id="search" placeholder="@lang('home.search')" list="product" required>
                            <datalist id="product">
                            </datalist>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
               
                <div class="input-group  mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="">@lang('home.barcode')</span>
                    </div>
                    <input type="text" id="barcode" class="form-control" placeholder="@lang('home.barcode')" readonly>
                </div>
                <div class="input-group  mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="">@lang('home.item') @lang('home.name')</span>
                    </div>
                    <input type="text" id="name" class="form-control" placeholder="@lang('home.item')  @lang('home.name')" readonly>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">@lang('home.category')</label>
                    </div>
                    <input type="text" class="form-control" id="category" readonly>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">@lang('home.subcategory')</label>
                    </div>
                    <input type="text" class="form-control" id="subcategory" readonly>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">@lang('home.tp')</label>
                    </div>
                    <input type="text" class="form-control" id="tp" readonly>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01"> @lang('home.mrp') </label>
                    </div>
                    <input type="text" class="form-control" id="mrp" readonly>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">@lang('home.opening') @lang('home.stock')</label>
                    </div>
                    <input type="number" class="form-control" id="qty" placeholder="qty">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">@lang('home.unit')</label>
                    </div>
                    <input type="text" class="form-control" id="unit" placeholder="unit">
                </div>
                <hr>
                <div class="pull-right">
                    <button type="submit" id="submitdata" class="btn btn-lg btn-primary btn-block">@lang('home.submit')</button>
                </div>

            </div>
        </div>
    </div>
</div>


<script>
    var productid;
    var unit_id = 0;

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

    function getUrl() {
        var url = $(location).attr('href')
        productid = url.substring(url.lastIndexOf('/') + 1);
        ItemInformation(productid);
    }
    window.onload = ItemInformation("{{ $id }}");
    $("#search").on('input', function() {
        var val = this.value;
        if ($('#product option').filter(function() {
                return this.value.toUpperCase() === val.toUpperCase();
            }).length) {
            productid = $('#product').find('option[value="' + val + '"]').attr('id');
            ItemInformation(productid);
          //  changeUrl();
        }
    });
    function changeUrl() {
        var url = $(location).attr('href')
        var i = url.lastIndexOf('/');
        if (i != -1) {
            newurl = url.substr(0, i) + "/" + productid;
            history.pushState({}, null, newurl);
        }
    }
    function ItemInformation(id) {
        $.ajax({
            type: 'get',
            url: "{{ route('product.getDataById') }}",
            //data: data,
            data: {
                id: id,
            },
            datatype: 'JSON',
            success: function(data) {
                productid=data.id;
                LoadData(data);
                getOpening(productid);

            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    function LoadData(data) {
        unit_id = data.unit_id;
        $("#name").val(data.name);
        $("#barcode").val(data.barcode);
        $("#category").val(data.category_name['title']);
        $("#subcategory").val(data.subcategory_name['title']);
        $("#unit").val(data.unit_name['Shortcut']);
        $("#tp").val(data.tp);
        $("#mrp").val(data.mrp);

    }

    function getOpening(dataid) {
        $.ajax({
            type: 'get',
            url: "{{ url('Admin/Product/getopening')}}" + '/' + dataid,
            datatype: 'JSON',
            success: function(data) {
                console.log(data)
                $("#qty").val(data);

            },
            error: function(data) {
                console.log(data);
            }
        })
    }
    $("#qty").on('click', function() {
        $("#qty").val("");
    })

    //sumbit Data

    $(document).on('click', "#submitdata", function() {
        
        var qty = $("#qty").val();
        if (qty == "" || qty == 0) {
            swal("Opps! Faild", "Quantity Should be More Than Zero Or More Than Empty", "error");
        } else {
            $("#overlay").fadeIn();
            $.ajax({
                type: 'post',
                url: "{{ route('product.openingstore')}}",
                data: {
                    product_id: productid,
                    qty: qty,
                    unit_id: unit_id
                },
                success: function(data) {
                    $("#overlay").fadeOut();
                    swal("Success", "Opening Stock successfuly Insert", "Success");
                    getOpening(data)
                },
                error: function() {
                    $("#overlay").fadeOut();
                    swal("Opps! Faild", "Form Submited Faild", "error");
                }

            });
        }

    })
</script>

@endsection