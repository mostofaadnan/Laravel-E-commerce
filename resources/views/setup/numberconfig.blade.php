@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-sm-8 form-single-input-section">
        <div class="card card-design">
            <div class="card-header card-header-section">
                <div class="row mb-3 mt-2">
                    <div class="col-sm-6">
                        @lang('home.number') @lang('home.format')
                    </div>

                </div>
            </div>
            <div class="card-body form-div">
                <ul class="nav nav-tabs mb-2" id="myTab" role="tablist">
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link active" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="true">@lang('home.general')</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="container">

                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label for="inputGroupSelect01">@lang('home.item') @lang('home.barcode')</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="product" placeholder="bracode">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label for="inputGroupSelect01">@lang('home.purchase')</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="purchase" placeholder="purchase">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label for="inputGroupSelect01">@lang('home.purchase') @lang('home.return')</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="purchasereturn" placeholder="purchase Return">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label for="inputGroupSelect01">@lang('home.grn')</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="grn" placeholder="grn">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label for="inputGroupSelect01">@lang('home.cash') @lang('home.invoice')</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="cashinvoice" placeholder="cashinvoice">
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label for="inputGroupSelect01">@lang('home.credit') @lang('home.invoice')</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="creditinvoice" placeholder="creditinvoice">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label for="inputGroupSelect01">@lang('home.sale') @lang('home.return')</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="salereturn" placeholder="Sale Return">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label for="inputGroupSelect01">@lang('home.supplier') @lang('home.payment')</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="supplierpayment" placeholder="Credit Invoice Strat Number">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label for="inputGroupSelect01">@lang('home.credit') @lang('home.invoice') @lang('home.start') @lang('home.number')</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="creditpayment" placeholder="creditpayment">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label for="inputGroupSelect01">@lang('home.expenses') @lang('home.number')</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="expneses" placeholder="expneses">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer  card-footer-section">
                <div class="pull-right">
                    
                    <button type="submit" id="datainsert" class="btn btn-danger btn-lg"> @lang('home.save') @lang('home.change')</button>

                </div>
                </form>

            </div>
        </div>

    </div>

</div>


<script>
    function RetriveData() {
        $.ajax({
            type: 'get',
            url: "{{ route('numberformat.view') }}",
            datatype: 'JSON',
            success: function(data) {

                loadData(data);
            },
            error: function(data) {
                console.log(data);
            }
        });

    }
    window.onload = RetriveData();

    function loadData(data) {

        $("#product").val(data.product);
        $("#purchase").val(data.purchase);
        $("#purchasereturn").val(data.purchasereturn);
        $("#grn").val(data.grn);
        $("#cashinvoice").val(data.cashinvoice);
        $("#creditinvoice").val(data.creditinvoice);
        $("#salereturn").val(data.salereturn);
        $("#supplierpayment").val(data.supplierpayment)
        $("#creditpayment").val(data.creditpayment)
        $("#expneses").val(data.expneses)
    }

    $("#datainsert").on('click', function() {
        $("#overlay").fadeIn();
        var branch = $("#branch").val();
        var product = $("#product").val();
        var purchase = $("#purchase").val();
        var purchasereturn = $("#purchasereturn").val();
        var grn = $("#grn").val();
        var cashinvoice = $("#cashinvoice").val();
        var creditinvoice = $("#creditinvoice").val();
        var salereturn = $("#salereturn").val();
        var supplierpayment = $("#supplierpayment").val();
        var creditpayment = $("#creditpayment").val();
        var expneses = $("#expneses").val();

        $.ajax({
            type: 'post',
            url: "{{ route('numberformat.update') }}",
            datatype: 'JSON',
            data: {
                branch: branch,
                product: product,
                purchase: purchase,
                grn: grn,
                cashinvoice: cashinvoice,
                creditinvoice: creditinvoice,
                supplierpayment: supplierpayment,
                creditpayment: creditpayment,
                expneses: expneses,
                purchasereturn:purchasereturn,
                salereturn:salereturn
            },
            success: function(data) {
                $("#overlay").fadeOut();
                swal("Successfuly data submit", "Data Submit", "success");
                RetriveData();
            },
            error: function(data) {
                $("#overlay").fadeOut();
                 swal("Ops! Fail To submit", "Data Submit", "error"); 
            }
        });

    });
</script>

@endsection