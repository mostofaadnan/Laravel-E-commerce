@extends('layouts.master')
@section('content')
<style>
    .btn {
        border: 1px #fff solid;
    }
</style>
<div class="row">
    <div class="col-sm-7 form-single-input-section ">
        <div class="card card-design">
            <div class="card-header card-header-section">

                <div class="pull-left">
                    @lang('home.new') @lang('home.vat') @lang('home.payment')
                </div>


            </div>
            <div class="card-body form-div">
                <div class="mb-2"></div>
                <div class="container">

                    <style>
                        .paymentbox {
                            display: none;

                        }

                        #amount {
                            text-align: right;
                            font-style: bold;
                            color: #ff3547;
                            font-size: 16px;
                        }
                    </style>
                    <div class="row">
                        <div class="input-group  col-sm-6 mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@lang('home.payment') @lang('home.number')</span>
                            </div>
                            <input type="text" class="form-control" id="paymentno" placeholder="@lang('home.payment') @lang('home.number')" readonly>
                        </div>
                        <div class="input-group  col-sm-6 mb-1">
                            <div class="input-group date" data-provide="datepicker" id="datetimepicker2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">@lang('home.date')</span>
                                </div>
                                <input type="text" name="openingdate" id="inputdate" class="form-control" data-date="">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-group  mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">@lang('home.vat') @lang('home.number')</span>
                        </div>
                        <input type="text" class="form-control" id="vatnosearch" placeholder="@lang('home.vat') @lang('home.number')" list="vatno" required>
                        <datalist id="vatno">
                        </datalist>
                    </div>
                    <div class="row">
                        <div class="input-group mb-1 col-sm-6">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> @lang('home.payment') @lang('home.type')</span>
                            </div>
                            <select id="paymenttype" class="form-control">
                                <option value="1">Cash</option>
                                <option value="2">Bank</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="cashpanel">
                                <div class="input-group mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@lang('home.amount')</span>
                                    </div>
                                    <input type="number" class="form-control" id="vatamount" placeholder="@lang('home.amount')" readonly>
                                </div>
                            </div>
                            <div class="paymentbox" id="bankpanel">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@lang('home.bank')</span>
                                    </div>
                                    <input type="text" class="form-control" id="banknamesearch" placeholder="@lang('home.bank')" list="banknames" required>
                                    <datalist id="banknames">
                                    </datalist>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@lang('home.account') @lang('home.number')</span>
                                    </div>
                                    <input type="text" class="form-control sumsection-input-text" id="accno" placeholder="@lang('home.account') @lang('home.number')">
                                </div>
                                <div class="input-group">
                                    <textarea name="" id="bankdescrp" cols="35" rows="2" class="form-control sumsection-input-text" placeholder="@lang('home.bank') @lang('home.description')"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">@lang('home.remark')</span>
                        </div>
                        <textarea name="" class="form-control" id="remark" cols="5" rows="5" placeholder="@lang('home.remark')"></textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer  card-footer-section">
                <div class="pull-right">
                    <div class="btn-group button-grp" role="group" aria-label="Basic example">
                        <button type="submit" id="datasubmit" class="btn btn-success btn-lg">@lang('home.submit')</button>
                        <button id="reset" class="btn btn-light clear_field btn-lg">@lang('home.reset')</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var vatid = 0;
    var amount = 0;
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
        $('#inputdate').datepicker('setDate', myDate);
        $('#inputdate').datepicker('setDate', today);
    });

    function banknameDataList() {
        $.ajax({
            type: 'get',
            url: "{{ route('bankname.banknamedatalist') }}",
            datatype: 'JSON',
            success: function(data) {
                $('#banknames').html(data);
            },
            error: function(data) {}
        });
    }
    window.onload = banknameDataList();
    $('#paymenttype').change(function() {
        var type = $(this).val();
        console.log(type)
        if (type == 1) {

            $("#bankpanel").hide();

        } else {

            $("#bankpanel").show();

        }

    });

    function VatPaymentNo() {
        $.ajax({
            type: 'get',
            url: "{{ route('vatpayment.vatPaymentNo') }}",
            datatype: 'JSON',
            success: function(data) {
                $("#paymentno").val(data);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    window.onload = VatPaymentNo();

    function ViewVatNo() {
        $.ajax({
            type: 'get',
            url: "{{ route('vatpayment.vatcodedatalist') }}",
            datatype: 'JSON',
            success: function(data) {
                $('#vatno').html(data);
                console.log(data);
            },
            error: function(data) {
                console.log(data)
            }
        });
    }
    window.onload = ViewVatNo();
    $("#vatnosearch").on('input', function() {
        var val = this.value;
        if (val == "") {
            vatid = 0;
            amount = 0;
            $("#vatamount").val("");
        } else {
            if ($('#vatno option').filter(function() {
                    return this.value.toUpperCase() === val.toUpperCase();
                }).length) {
                vatid = $('#vatno').find('option[value="' + val + '"]').attr('id');
                amount = $('#vatno').find('option[value="' + val + '"]').attr('data-amount');
                $("#vatamount").val(amount);

            }
        }

    });

    function BalanceCheck() {
        $.ajax({
            type: "get",
            url: "{{ route('cashdrawer.balancechek') }}",
            data: {
                payment: amount
            },
            datatype: ("json"),
            success: function(data) {
                if (data == 1) {
                    var paymentdescription = "Cash Payment"
                    DataInsert(paymentdescription);
                } else {
                    swal("Ops! Insuffisiant Cash Balance", "Data Submit", "error");
                }
            }
        });

    }

    function ExecuteClear() {
        vatid = 0;
        amount = 0;
        $("#vatnosearch").val("");
        $("#vatamount").val("");
        $("#banknamesearch").val("");
        $("#accno").val("");
        $("#bankdescrp").val("");
        $("#bankpanel").hide();
        ViewVatNo();
        VatPaymentNo()
    }
    //inset Data
    function DataInsert(paymentdescription, bankname, accno, bankdescrip) {
        $("#overlay").fadeIn();
        var paymentno = $("#paymentno").val();
        var inputdate = $("#inputdate").val();
        var paymenttype = $("#paymenttype").val();
        var remark = $("#remark").val();
        $.ajax({
            type: "post",
            url: "{{ route('vatpayment.storepayment') }}",
            //data: JSON.stringify(itemtables),
            data: {
                paymentno: paymentno,
                inputdate: inputdate,
                vatid: vatid,
                amount: amount,
                paymenttype: paymenttype,
                remark: remark,
                paymentdescription: paymentdescription,
                bankname: bankname,
                accno: accno,
                bankdescrip: bankdescrip,

            },
            datatype: ("json"),
            success: function(data) {
                $("#overlay").fadeOut();
                Confirmation(data);
            },
            error: function(data) {
                $("#overlay").fadeOut();
                swal("Ops! Fail To submit", "Data Submit", "error");
                console.log(data)
            }
        });
    }
    $("#datasubmit").on('click', function() {
        var nbalancedue = $("#newbalancedue").val();

        if (amount == 0 || vatid == 0) {
            swal("Requirement Field", "Please Select Requirement fields to fillup", "error");
        } else {
            var type = $("#paymenttype").val();
            if (type == 1) {
                BalanceCheck();
            } else {
                var bankname = $("#banknamesearch").val();
                bankid = $('#banknames').find('option[value="' + bankname + '"]').attr('id');
                var accno = $("#accno").val();
                var bankdescrip = $("#bankdescrp").val();
                var paymentype = 2;
                var bankamount = $("#bankamount").val();
                var paymentdescription = "Bank:" + bankname + "\n" + "Acc No:" + accno;
                if (bankid == 0 || accno == "" || bankamount == 0 || bankamount == "") {
                    swal("Please Select Bank Requirment Fields", "Requirment Field Empty", "error");
                } else {
                    DataInsert(paymentdescription, bankname, accno, bankdescrip);
                }
            }

        }
    });

    function Confirmation(data) {
        swal("Successfully Data Save", "Data Submit", "success", {
                buttons: {
                    cancel: "Close",
                    Show: "Show",
                    catch: {
                        text: "Print",
                        value: "catch",
                    },
                    datapdf: {
                        text: "Pdf",
                        value: "datapdf",
                        background: "#endregion",
                    },
                    Cancel: false,
                },
            })
            .then((value) => {
                switch (value) {

                    case "Show":
                        url = "{{ url('Admin/Vat-Collections/paymentshow')}}" + '/' + data,
                            window.location = url;
                        break;
                    case "catch":
                        url = "{{ url('Admin/Vat-Collections/vatpLoadPrintslip')}}" + '/' + data,
                            window.open(url, '_blank');
                        break;
                    case "datapdf":
                        url = "{{ url('Admin/SupplierPayment/pdf')}}" + '/' + data,
                            window.open(url, '_blank');
                        break;

                    default:
                        //swal("Thank You For Your Choice");
                }
            });
        ExecuteClear();
    }
</script>
@endsection