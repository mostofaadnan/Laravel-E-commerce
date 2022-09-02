@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header card-header-section">
        <div class="form-row">
            <div class="col-md-2 col-xs-4 mb-1">
                <label for="validationDefault01">@lang('home.date')</label>
                @include('section.inputdatesection')
            </div>
            <div class="col-md-4 mb-1">
                <label for="validationDefault02">@lang('home.delever') By</label>
                <input type="text" class="form-control" id="search" placeholder="@lang('home.employee')" list="employee" autocomplete="off">
                <datalist id="employee">
                </datalist>
            </div>
            <div class="col-md-2 col-xs-4 mb-1">
                <label for="validationDefault01">@lang('home.shipment') @lang('home.expenses')</label>
                <input type="text" class="form-control" placeholder="Shipment" id="shipment" value="0" required>
            </div>
            <div class="col-md-4 col-xs-4 mb-1">
                <label for="validationDefault01">@lang('home.remark')</label>
                <input type="text" class="form-control" placeholder="Remark" id="remark" value="0" required>
            </div>
            <input type="hidden" id="employee_id" value="">
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

            <div class="col-sm-8">
            </div>
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
                <button type="submit" id="deliverorder" class="btn btn-success btn-lg">@lang('home.submit')</button>
            </div>
        </div>
    </div>
</div>


@include('order.partials.invviewscript')
<script>
    $(document).ready(function() {
        function EmployeeDatalist() {
            $.ajax({
                type: 'get',
                url: "{{ route('employees.employedatalist') }}",
                datatype: 'JSON',
                success: function(data) {
                    $('#employee').html(data);
                },
                error: function(data) {}
            });
        }

        window.onload = EmployeeDatalist();

        $("#search").on('input', function() {
            var val = this.value;
            if ($('#employee option').filter(function() {
                    return this.value.toUpperCase() === val.toUpperCase();
                }).length) {
                var empid = $('#employee').find('option[value="' + val + '"]').attr('id');
                $("#employee_id").val(empid)
            }
        });
    });
</script>
@endsection