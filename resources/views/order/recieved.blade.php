@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header card-header-section">
        <div class="row">
            <div class="col-8 col-sm-6 col-md-6">
                Order Recieved
            </div>
            <div class="col-4 col-sm-6">

                <div class="input-group date" data-provide="datepicker" id="datetimepicker2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="">@lang('home.delivery') @lang('home.date')</span>
                    </div>
                    <input type="text" name="openingdate" id="startDate" class="form-control" data-date="" placeholder="@lang('home.opening') @lang('home.date')">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>


            </div>

        </div>
    </div>
    <div class="card-body">
        @include('partials.ErrorMessage')
        <div class="inv-title">
            <h4><b>@lang('home.new') @lang('home.order')</b></h4>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <h4>Shipment Address</h4>
                <h5 id="customername"></h5>
                <address>
                    <i class="" id="customeraddress"></i>
                    <i class="" id="customercountry"></i>
                    <i id="mobile" class="fa fa-mobile " aria-hidden="true"></i><br>
                    <i id="email" class="fa fa-envelope-o" aria-hidden="true"></i><br>
                    <i id="website" class="fa fa-address-book-o" aria-hidden="true"></i>
                </address>
            </div>
            <div class="col-sm-4 hidden-xs"></div>
            <div class="col-12 col-sm-4">
                <table class="table table-bordered table-striped">

                    <tr>
                        <th>@lang('home.order') @lang('home.no')</th>
                        <td id="invoiceno"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.date')</th>
                        <td id="invoicedate"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.delivary') @lang('home.date')</th>
                        <td id="delvarydate"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.payment') @lang('home.type')</th>
                        <td id="paymenttype"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.status')</th>
                        <td id="status"></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 mt-10">
                <table class="table table-bordered table-responsive-sm table-sm  data-table">
                    <thead>
                        <th align="center" width='5%'>#@lang("home.sl")</th>
                        <th>@lang("home.description")</th>
                        <th width='5%'>@lang("home.quantity")</th>
                        <th width='5%'>@lang("home.unit")</th>
                        <th width='10%'>@lang("home.unit") @lang("home.price")</th>
                        <th width='10%'>@lang("home.total")</th>
                    </thead>
                    <tbody id="tablebody">
                    </tbody>
                </table>
            </div>
            <div class="col-sm-8 "></div>
            <div class="col-sm-4">
                <table class="table table-bordered table-striped mt-2">
                    <tr>
                        <th>@lang("home.subtotal")</th>
                        <td id="subtotal" align="right"></td>
                    </tr>
                    <!--
                    <tr>
                        <th>@lang("home.discount")</th>
                        <td id="discount" align="right"></td>
                    </tr>

                    -->
                    <tr>
                        <th>@lang("home.sales") @lang("home.tax")</th>
                        <td id="vat" align="right"></td>
                    </tr>
                    <tr>
                        <th>@lang("home.shipment")</th>
                        <td id="shipment" align="right"></td>
                    </tr>
                    <tr>
                        <th>@lang("home.nettotal")</th>
                        <td id="nettotal" align="right"></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
    <div class="card-footer card-footer-section">
        <div class="pull-right">
            <div class="btn-group button-grp" role="group" aria-label="Basic example">
                <button type="submit" id="recievedOrder" class="btn btn-success btn-lg">@lang('home.submit')</button>
            </div>
        </div>
    </div>
</div>


@include('order.partials.invviewscript')
<script>
    $(function() {
        var myDate = $("#startDate").attr('data-date');
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        var currentmonth = new Date(date.getFullYear(), date.getMonth());
        $('#startDate').datepicker({
            dateFormat: 'yyyy/mm/dd',
            todayHighlight: true,
            startDate: today,
            endDate: end,
            autoclose: true
        });
        $('#startDate').datepicker('setDate', myDate);
        $('#startDate').datepicker('setDate', today);
    });
    $("#datepicker").datepicker({
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months"
    });
</script>
@endsection