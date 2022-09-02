@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-sm-8 form-single-input-section">
        <div class="card card-design">
            <div class="card-header card-header-section">
                <div class="row mb-3 mt-2">
                    <div class="col-sm-6">
                        @lang('home.sale') @lang('home.config')
                    </div>

                </div>
            </div>
            <div class="card-body form-div">

                <ul class="nav nav-tabs mb-2" id="myTab" role="tablist">
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link active" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="true">@lang('home.general')</a>
                    </li>
                    <!--  <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" id="card-tab" data-toggle="tab" href="#card" role="tab" aria-controls="card" aria-selected="false">@lang('home.card')</a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" id="paypal-tab" data-toggle="tab" href="#paypal" role="tab" aria-controls="paypal" aria-selected="false">@lang('home.paypal')</a>
                    </li> -->
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="container">
                            <h5 style="color:midnightblue">@lang('home.general') @lang('home.setup')</h5>
                            <hr>
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label for="inputGroupSelect01">@lang('home.default') @lang('home.customer')</label>
                                </div>
                                <div class="col-sm-6">
                                    <select class="form-control" id="defaultcuatomer">
                                        @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label for="inputGroupSelect01">@lang('home.automatic') @lang('home.item') @lang('home.store')</label>
                                </div>
                                <div class="col-sm-6">
                                    <select class="form-control" id="storeautometic">
                                        <option value="1" selected>@lang('home.yes')</option>
                                        <option value="2">@lang('home.no')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label for="inputGroupSelect01">@lang('home.vat') @lang('home.applicable')</label>
                                </div>
                                <div class="col-sm-6">
                                    <select class="form-control" id="vatapllicable">
                                        <option value="1" selected>@lang('home.yes')</option>
                                        <option value="2">@lang('home.no')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label for="inputGroupSelect01">@lang('home.print')(@lang('home.cash') @lang('home.invoice'))</label>
                                </div>
                                <div class="col-sm-6">
                                    <select class="form-control" id="print">
                                        <option value="1" selected>Thermal</option>
                                        <option value="2">Normal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label for="inputGroupSelect01">@lang('home.print')(@lang('home.credit') @lang('home.invoice'))</label>
                                </div>
                                <div class="col-sm-6">
                                    <select class="form-control" id="print_credit">
                                        <option value="1" selected>Thermal</option>
                                        <option value="2">Normal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label for="inputGroupSelect01">@lang('home.message')</label>
                                </div>
                                <div class="col-sm-8">
                                    <textarea id="footermsg" cols="35" rows="2" class="form-control" placeholder="@lang('home.message')"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--     <div class="tab-pane fade" id="card" role="tabpanel" aria-labelledby="card-tab">
                        <h5 style="color:midnightblue">@lang('home.card') @lang('home.setup')</h5>
                        <hr>
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <label for="inputGroupSelect01">@lang('home.stripe') @lang('home.key')</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="cardkey" placeholder="Stripe Key">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <label for="inputGroupSelect01">@lang('home.stripe') @lang('home.secret')</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" id="cardsecret" placeholder="Stripe Secrete">
                            </div>
                        </div>
                    </div> -->
                    <!--   <div class="tab-pane fade" id="paypal" role="tabpanel" aria-labelledby="card-tab">
                        <h5 style="color:midnightblue">@lang('home.paypal') @lang('home.setup')</h5>
                        <hr>
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <label for="inputGroupSelect01">@lang('home.username')</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="paypalusername" placeholder="Paypal User Name">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <label for="inputGroupSelect01">@lang('home.password')</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" id="paypalpassword" placeholder="Paypal Password">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <label for="inputGroupSelect01">@lang('home.paypal') @lang('home.secret')</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="" id="paypalsecret" placeholder="Paypal Secret">
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="card-footer  card-footer-section">
                <div class="pull-right">
                    <button type="submit" id="datainsert" class="btn btn-danger"> @lang('home.save') @lang('home.change')</button>
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
            url: "{{ route('saleconfig.view') }}",
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
        $("#defaultcuatomer option[value='" + data.customer_id + "']").attr('selected', 'selected');
        $("#storeautometic option[value='" + data.autometic_store + "']").attr('selected', 'selected');
        $("#vatapllicable option[value='" + data.vat_applicable + "']").attr('selected', 'selected');
        $("#print option[value='" + data.print + "']").attr('selected', 'selected');
        $("#print_credit option[value='" + data.print_credit + "']").attr('selected', 'selected');
        $("#footermsg").val(data.footermsg);
        /* $("#cashinv").val(data.cash_invoice);
        $("#creditinv").val(data.credit_invoice);
        $("#cardkey").val(data.card_key);
        $("#cardsecret").val(data.card_secret);
        $("#paypalusername").val(data.paypal_username);
        $("#paypalpassword").val(data.paypal_password);
        $("#paypalsecret").val(data.paypal_secret) */
    }

    $("#datainsert").on('click', function() {
        $("#overlay").fadeIn();
        var customerid = $("#defaultcuatomer").val();
        var autometic_store = $("#storeautometic").val();
        var vat_applicable = $("#vatapllicable").val();
        var print = $("#print").val();
        var print_credit = $("#print_credit").val();
        var footermsg=$("#footermsg").val();
     
      /*   var cash_invoice = $("#cashinv").val();
        var credit_invoice = $("#creditinv").val();
        var card_key = $("#cardkey").val();
        var card_secret = $("#cardsecret").val();
        var paypal_username = $("#paypal_username").val();
        var paypal_password = $("#paypalpassword").val();
        var paypal_secret = $("#paypalsecret").val(); */
        $.ajax({
            type: 'post',
            url: "{{ route('saleconfig.update') }}",
            datatype: 'JSON',
            data: {
                customer_id: customerid,
                autometic_store: autometic_store,
                vat_applicable: vat_applicable,
                print: print,
                footermsg:footermsg,
                print_credit:print_credit

               /*  cash_invoice: cash_invoice,
                credit_invoice: credit_invoice,
                card_key: card_key,
                card_secret: card_secret,
                paypal_username: paypal_username,
                paypal_password: paypal_password,
                paypal_secret: paypal_secret, */
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