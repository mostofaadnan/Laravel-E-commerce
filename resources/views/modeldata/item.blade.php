<div class="input-group mb-1">
    <div class="input-group-prepend">
        <span class="input-group-text">@lang('home.search')</span>
    </div>
    <input type="text" class="form-control" id="modelitemsearch" placeholder="@lang('home.search') @lang('home.item')" list="modelproduct" required>
    <datalist id="modelproduct">
    </datalist>
</div>
<div class="row">
    <div class="input-group  col-sm-6 mb-1">
        <div class="input-group-prepend">
            <span class="input-group-text">@lang('home.item') @lang('home.id')</span>
        </div>
        <input type="text" class="form-control" id="choiceproductid" placeholder="Product Id" readonly>
    </div>
    <div class="input-group col-sm-6 mb-1">
        <div class="input-group-prepend">
            <span class="input-group-text" id="">@lang('home.label')</span>
        </div>
        <input type="text" name="barcode" id="choicebarcodes" class="form-control" placeholder="Barcode" readonly>
    </div>
</div>
<div class="input-group  mb-1">
    <div class="input-group-prepend">
        <span class="input-group-text" id="">@lang('home.name')</span>
    </div>
    <input type="text" name="name" id="choicename" class="form-control" placeholder="Name">
</div>
<div class="row">
    <div class="input-group  mb-1 col-sm-6">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.category')</label>
        </div>
        <input type="text" class="form-control" id="choicecategory" placeholder="Category" readonly>
    </div>
    <div class="input-group mb-1 col-sm-6">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.subcategory')</label>
        </div>
        <input type="text" class="form-control" id="choicesubcategory" placeholder="Subategory" readonly>
    </div>
</div>
<div class="input-group  mb-1">
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">@lang('home.brand')</label>
    </div>
    <input type="text" class="form-control" id="choicebrand" placeholder="Brand" readonly>
</div>
<div class="row">
    <div class="input-group mb-1 col-sm-6">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.stock')</label>
        </div>
        <input type="number" class="form-control" id="stock" value="0" placeholder="Stock" readonly>
    </div>
    <div class="input-group  mb-1 col-sm-6">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.unit')</label>
        </div>
        <input type="text" class="form-control" id="choiceunit" placeholder="Unit" readonly>
    </div>
</div>
<div class="input-group  mb-1">
    <div class="input-group date">
        <div class="input-group-prepend">
            <span class="input-group-text" id="">@lang('home.opening') @lang('home.date')</span>
        </div>
        <input type="text" id="choicedateinput" class="form-control">
    </div>
</div>
<div class="row">
    <div class="input-group mb-1 col-sm-6">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.tp')(@lang('home.trade') @lang('home.price'))</label>
        </div>
        <input type="number" class="form-control" id="choicetp" value="0" placeholder="@lang('home.tp')">
    </div>
    <div class="input-group mb-1 col-sm-6">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.mrp')(@lang('home.market') @lang('home.price'))</label>
        </div>
        <input type="number" class="form-control" id="choicemrp" value="0" placeholder="@lang('home.mrp')">
    </div>
</div>
<div class="row">
    <div class="input-group mb-1 col-sm-6">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.vat') @lang('home.type')</label>
        </div>
        <input type="text" class="form-control" id="choicedatavattype" placeholder="Vat Type" readonly>
    </div>
    <div class="input-group mb-1 col-sm-6">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.vat') @lang('home.value')</label>
        </div>
        <input type="number" class="form-control" id="choicevatvalue" value="0" placeholder="@lang('home.vat') @lang('home.value')">
    </div>
</div>
<div class="input-group mb-1">
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">@lang('home.remark')</label>
    </div>
    <textarea name="remark" class="form-control" id="choiceremark" cols="30" rows="2" placeholder="@lang('home.remark')">
              </textarea>
</div>
<div class="row">
    <div class="input-group mb-2 col-sm-6">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.status')</label>
        </div>
        <input type="text" class="form-control" id="choicestatus" placeholder="@lang('home.status')" readonly>
    </div>
</div>

<script>
    var productid = 0;
    $("#itemcheck").on('click', function() {
        console.log("clear")
        itemclear();
        //ItemShow();
    });

    function ItemShow() {
        $.ajax({
            type: 'get',
            url: "{{ route('product.itemdatalist') }}",
            datatype: 'JSON',
            success: function(data) {
                $('#modelproduct').html(data);
            },
            error: function(data) {}
        });
    }
    window.onload=ItemShow();

    $("#modelitemsearch").on('input', function() {
        var val = this.value;
        if ($('#modelproduct option').filter(function() {
                return this.value.toUpperCase() === val.toUpperCase();
            }).length) {
            var dataid = $('#modelproduct').find('option[value="' + val + '"]').attr('id');
            $.ajax({
                type: 'get',
                url: "{{ route('product.getDataById') }}",
                data: {
                    dataid: dataid,
                },
                datatype: 'JSON',
                success: function(data) {
                    if (data) {
                        productid = data.id;
                        $("#choiceproductid").val(data.id);
                        $("#choicebarcodes").val(data.barcode);
                        $("#choicename").val(data.name);
                        $("#choicecategory").val(data.category_name['title']);
                        $("#choicesubcategory").val(data.subcategory_name['title']);
                        $("#choicebrand").val(data.brand_name['title']);
                        $("#choiceunit").val(data.unit_name['Shortcut']);
                        $("#choicedateinput").val(data.openingDate);
                        $("#choicedatavattype").val(data.vat_name['name']);
                        $("#choicevatvalue").val(data.vat_name['value'])
                        $("#choicestock").val(data.qty)
                        $("#choicetp").val(data.tp);
                        $("#choicemrp").val(data.mrp);
                        $("#choiceremark").val(data.remark);
                        $("#choicestatus").val(data.status == 1 ? 'Active' : 'Inactive');
                    } else {
                        itemclear();
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });

        }
    });

    function itemclear() {
        productid = 0;
        $("#modelitemsearch").val("")
        $('#modelproduct').val("");
        $("#choiceproductid").val("");
        $("#choicebarcodes").val("");
        $("#choicename").val("");
        $("#choicecategory").val("");
        $("#choicesubcategory").val("");
        $("#choicebrand").val("");
        $("#choiceunit").val("");
        $("#choicedateinput").val("");
        $("#choicedatavattype").val("");
        $("#choicevatvalue").val("");
        $("#choicetp").val("");
        $("#choicedatamrp").val("");
        $("#choiceremark").val("");
        $("#choicestatus").val("");
        $("#choicestock").val("");
    }

    $(document).on('click', "#itemdetails", function() {
        if (productid > 0) {
            url = "{{ url('Admin/Product/show')}}" + '/' + productid,
                window.open(url, '_blank');
            $("#modelitemview").modal('toggle')
        }

    });
</script>