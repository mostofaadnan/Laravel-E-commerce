@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header card-header-section">
        <div class="row">
            <div class="col-8 col-sm-4 col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">@lang('home.vat') @lang('home.number')</label>
                    </div>
                    <input type="text" class="form-control" id="paymentcode" list="paymentno" placeholder="@lang('home.search')">
                    <datalist id="paymentno">
                    </datalist>
                    </datalist>
                </div>
            </div>
            <div class="col-4 col-sm-8">

                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @lang('home.action')
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ route('vatcollection.vatpayment') }}" class="nav-link">@lang('home.payment') @lang('home.list')</a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('vatpayment.paymentcreate') }}" class="nav-link">@lang('home.new')</a>
                        <div class="dropdown-divider"></div>
                        <a id="deletedata" class="nav-link">@lang('home.delete')</a>
                        <div class="dropdown-divider"></div>
                        <a id="print" class="nav-link">@lang('home.print')</a>
                        <div class="dropdown-divider"></div>
                        <a id="pdfdata" class="nav-link"> @lang('home.pdf')</a>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="inv-title">
            <h4 class="no-margin" style="color:blue"><b>@lang('home.vat') @lang('home.payment')</b></h4>
        </div>
        <div class="row">
            <div class="col-sm-8 hidden-xs">
            </div>
            <div class="col-12 col-sm-4">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>@lang('home.payment') @lang('home.number')</th>
                        <td id="vatpaymentno"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.vat') @lang('home.number')</th>
                        <td id="vatno"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.date')</th>
                        <td id="date"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.payment') @lang('home.type')</th>
                        <td id="paymenttype"></td>
                    </tr>

                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped table-responsive-sm table-sm  data-table mt-2" width="100%">
                    <thead>
                        <th>@lang('home.description')</th>
                        <th>@lang('home.payment') @lang('home.description')</th>
                        <th>@lang('home.amount')</th>
                        <th>@lang('home.remark')</th>
                    </thead>
                    <tbody id="tablebody">
                        <tr>
                            <td>@lang('home.vat') @lang('home.payment')</td>
                            <td id="paymentdescription"></td>
                            <td id="amount" align="right"></td>
                            <td id="remark"></td>
                        </tr>
                        <tr>
                            <th id="inwordsht">@lang('home.inwords'):</th>
                            <td id="inwords" colspan="3"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var pid = 0;

    function paymentNo() {
        $.ajax({
            type: 'get',
            url: "{{ route('vatpayment.vatPaymentCodatalist') }}",
            datatype: 'JSON',
            success: function(data) {
                $("#paymentno").html(data);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    window.onload = paymentNo();
    $("#paymentcode").on('input', function() {
        var val = this.value;
        if ($('#paymentno option').filter(function() {
                return this.value.toUpperCase() === val.toUpperCase();
            }).length) {
            var paymentid = $('#paymentno').find('option[value="' + val + '"]').attr('id');
            $.ajax({
                type: "post",
                url: "{{ url('Admin/Vat-Collections/SetPaymentId')}}" + '/' + paymentid,
                datatype: ("json"),
                success: function(data) {
                    VatPaymentDetails();
                },
                error: function(data) {}

            });
        }
    });

    function VatPaymentDetails() {
        $.ajax({
            type: "get",
            url: "{{ url('Admin/Vat-Collections/getPaymentView')}}",
            datatype: ("json"),
            success: function(data) {
                pid = data.id;
                lodData(data);

            },
            error: function(data) {}
        });
    }
    window.onload = VatPaymentDetails();

    function lodData(data) {
        var paymenttye;
        if (data.payment_type == 1) {
            paymenttye = 'Cash'
        } else {
            paymenttye = 'Bank'
        }
        $("#vatpaymentno").html(data.vat_payment_no)
        $("#date").html(data.inputdate)
        $("#vatno").html(data.vat__collection['collection_no'])
        $("#paymenttype").html(paymenttye)
        $("#paymentdescription").html(data.paymentdescription)
        $("#amount").html(data.amount)
        $("#remark").html(data.remark)
    }
    $(document).on('click', '#pdfdata', function() {
        url = "{{ url('Admin/Vat-Collections/vatPaymentPdf')}}" + '/' + pid,
            window.open(url, '_blank');
    });
    $(document).on('click', '#print', function() {
        url = "{{ url('Admin/Vat-Collections/LoadPrintslip')}}" + '/' + pid,
            window.open(url, '_blank');
    });
    $(document).on('click', "#deletedata", function() {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this  data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var id = $(this).data("id");
                    $.ajax({
                        type: "post",
                        url: "{{ url('Admin/Vat-Collections/VatPaymentDelete')}}" + '/' + id,
                        success: function() {
                            url = "{{ route('vatcollection.vatpayment')}}"
                            window.location = url;
                        },
                        error: function(data) {
                            console.log(data)
                            swal("Opps! Faild", "Data Fail to Delete", "error");
                        }
                    });
                    swal("Ok! Your file has been deleted!", {
                        icon: "success",
                    });
                } else {
                    swal("Your file is safe!");
                }
            });

    });
</script>
@endsection