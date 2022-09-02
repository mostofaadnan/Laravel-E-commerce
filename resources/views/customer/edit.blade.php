@extends('layouts.master')
@section('content')

<div class="col-lg-12">
    <div class="card">
        <div class="card-header card-header-section">
            <div class="pull-left">
                @lang('home.customer') @lang('home.information')
            </div>
        </div>
        <div class="card-body">
            @include('partials.ErrorMessage')
            <form action="{{ route('customer.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="cusid" value="{{ $customer->id }}">
                <div class="row">
                    <div class="col-sm-6 form-left-portion">
                        <div class="input-group  mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="">@lang('home.customer') @lang('home.id')</span>
                            </div>
                            <input type="text" class="form-control" id="exampleInputEmail2" placeholder="Spplier Id" disabled value="{{$customer->customerid }}">

                        </div>
                        <div class="input-group  mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="">@lang('home.name')</span>
                            </div>
                            <input type="text" name="name" class="form-control" placeholder="@lang('home.customer')  @lang('home.name') " value="{{$customer->name}}">

                        </div>


                        <div class="input-group  mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">@lang('home.country') </label>
                            </div>
                            <select class="custom-select form-control" name="country_id" id="country">
                                <option selected>@lang('home.select') </option>
                                @foreach($countrys as $country)
                                <option value="{{ $country->id }}" {{ $country->id==$customer->country_id ? 'selected': '' }}>{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">@lang('home.state') </label>
                            </div>

                            <select class="custom-select form-control" name="state_id" id="state">
                                <option value="{{$customer->state_id}}">{{$customer->StateName ? $customer->StateName->name:''}}</option>
                            </select>
                        </div>

                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">@lang('home.city') </label>
                            </div>
                            <select class="custom-select form-control" name="city_id" id="city">
                                <option value="{{$customer->city_id}}">{{$customer->CityName ? $customer->CityName->name :''}}</option>
                            </select>
                        </div>
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">@lang('home.address') </label>
                            </div>
                            <textarea name="address" class="form-control" id="" cols="30" rows="6">{{$customer->address}}</textarea>
                        </div>

                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">@lang('home.status')</label>
                            </div>
                            <select name="status" class="form-control" id="">
                                <?php
                                if ($customer->status == 1) { ?>
                                    <option value="1">Active</option>

                                <?php } else {  ?>
                                    <option value="0">inactive</option>

                                <?php } ?>
                            </select>
                        </div>

                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">@lang('home.mobile') @lang('home.no') </label>
                            </div>
                            <input type="text" name="mobile_no" class="form-control" id="exampleInputPassword2" placeholder="@lang('home.mobile')  @lang('home.no')" value="{{ $customer->mobile_no}}">
                        </div>

                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">@lang('home.email')</label>
                            </div>
                            <input type="text" name="supemail" class="form-control" id="exampleInputPassword2" placeholder="@lang('home.email')" value="{{ $customer->email }}">
                        </div>



                    </div>
                    <div class="col-sm-6 form-right-portion">
                        <div class="form-group row">
                            @include('customer.partials.customerprofileedit')
                        </div>
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">@lang('home.opening') @lang('home.balance')</label>
                            </div>
                            <input id="ticketNum" type="text" class="form-control number-box text-right  red" name="openingbalance" placeholder="@lang('home.opening') @lang('home.balance')" value="{{ $openingbalance }}" readonly>
                        </div>
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">@lang('home.cash') @lang('home.invoice')</label>
                            </div>
                            <input type="text" class="form-control number-box text-right red" name="consignment" id="exampleInputPassword2" placeholder="@lang('home.cash') @lang('home.invoice')" readonly value="{{ $cashinvoice }}" readonly>
                        </div>

                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">@lang('home.credit') @lang('home.invoice')</label>
                            </div>
                            <input type="text" class="form-control number-box text-right red" name="payment" id="exampleInputPassword2" placeholder="@lang('home.credit') @lang('home.invoice')" value="{{ $creditinvoice }}" readonly>
                        </div>
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01"> @lang('home.consignment')</label>
                            </div>
                            <input type="text" class="form-control number-box text-right red" name="payment" id="exampleInputPassword2" placeholder="@lang('home.total') @lang('home.consignment')" value="{{ $consignment }}" readonly>
                        </div>
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">@lang('home.total') @lang('home.discount')</label>
                            </div>
                            <input type="text" class="form-control number-box text-right red" name="discount" id="exampleInputPassword2" placeholder="@lang('home.total') @lang('home.discount')" value="{{ $discount }}" readonly>
                        </div>
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01"> @lang('home.payment')</label>
                            </div>
                            <input type="text" class="form-control number-box text-right red" name="payment" id="exampleInputPassword2" placeholder="@lang('home.total') @lang('home.payment')" value="{{ $netpayment }}" readonly>
                        </div>
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">@lang('home.balancedue')</label>
                            </div>
                            <input type="text" class="form-control number-box text-right red" name="balancedue" id="exampleInputPassword2" placeholder="@lang('home.balancedue')" value="{{ $balancedue }}" readonly>
                        </div>
                    </div>
                </div>
        </div>
        <div class="card-footer">
            <div class="pull-right">
                <button type="submit" class="btn btn-lg btn-primary btn-block">@lang('home.submit')</button>
            </div>
            <div class="pull-right">
                <button class="btn btn-lg btn-secondary btn-block">@lang('home.reset')</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#country').change(function() {
        var countryID = $(this).val();
        if (countryID) {
            $.ajax({
                type: "GET",
                url: "{{url('Admin/Supplier/get-state-list')}}?country_id=" + countryID,
                success: function(res) {
                    if (res) {
                        $("#state").empty();
                        $("#state").append('<option>Select</option>');
                        $.each(res, function(key, value) {
                            $("#state").append('<option value="' + key + '">' + value + '</option>');
                        });

                    } else {
                        $("#state").empty();
                    }
                }
            });
        } else {
            $("#state").empty();
            $("#city").empty();
        }
    });
    $('#state').on('change', function() {
        var stateID = $(this).val();
        if (stateID) {
            $.ajax({
                type: "GET",
                url: "{{url('Admin/Supplier/get-city-list')}}?state_id=" + stateID,
                success: function(res) {
                    if (res) {
                        $("#city").empty();
                        $.each(res, function(key, value) {
                            $("#city").append('<option value="' + key + '">' + value + '</option>');
                        });

                    } else {
                        $("#city").empty();
                    }
                }
            });
        } else {
            $("#city").empty();
        }

    });
    $(function() {
        var myDate = $("#startDate").attr('data-date');
        var date = new Date();
        //  var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
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
        // $('#startDate').datepicker('setDate', today);
    });
</script>
@endsection