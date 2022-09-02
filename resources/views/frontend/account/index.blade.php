@extends('frontend.layout.master')
@section('content')

<div class="banner inner-banner1">
    <div class="container">
        <section class="banner-detail center-xs">
            <h1 class="banner-title">Account</h1>
            <div class="bread-crumb right-side float-none-xs">
                <ul>
                    <li><a href="index.html"><i class="fa fa-home"></i>Home</a>/</li>
                    <li><span>Account</span></li>
                </ul>
            </div>
        </section>
    </div>
</div>
<div class="home_content">
    <section class="checkout-section ptb-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="account-sidebar account-tab mb-sm-30">
                        <div class="tab-title-bg">
                            <div class="heading-part">
                                <div class="sub-title"><span></span> My Account</div>
                            </div>
                        </div>
                        <div class="account-tab-inner">
                            <ul class="account-tab-stap">
                                <li id="step1" class="active"> <a href="javascript:void(0)">My Dashboard<i class="fa fa-angle-right"></i> </a> </li>
                                <li id="step2"> <a href="javascript:void(0)">Account Details<i class="fa fa-angle-right"></i> </a> </li>
                                <li id="step5"> <a href="javascript:void(0)">Notification<i class="fa fa-angle-right"></i> </a> </li>
                                <li id="step3"> <a href="javascript:void(0)">My Order List<i class="fa fa-angle-right"></i> </a> </li>
                                <li id="step4"> <a href="javascript:void(0)">Change Password<i class="fa fa-angle-right"></i> </a> </li>
                                <li>
                                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div id="data-step1" class="account-content" data-temp="tabdata">
                        <div class="row">
                            <div class="col-12">
                                <div class="heading-part heading-bg mb-30">
                                    <h2 class="heading m-0">Account Dashboard</h2>
                                </div>
                            </div>
                        </div>
                        <div class="mb-30">
                            <div class="row">
                                <div class="col-12">
                                    <div class="heading-part">
                                        <h3 class="sub-heading">Hello, {{ Auth::user()->name}}</h3>
                                    </div>
                                    <!-- <p>Lorem ipsum dolor sit amet, consec adipiscing elit. Donec eros tellus, nec consec elit. Donec eros tellus laoreet sit amet. <a class="account-link" id="subscribelink" href="#">Click Here</a></p> -->
                                </div>
                            </div>
                        </div>
                        <div class="m-0">
                            <div class="row">
                                <div class="col-12 mb-20">
                                    <div class="heading-part">
                                        <h3 class="sub-heading">Account Information</h3>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    <div class="cart-total-table address-box commun-table">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Shipping Address</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <ul>
                                                                <li class="inner-heading"> <b>{{ Auth::user()->name}}</b> </li>
                                                                <li>
                                                                    <p>@if(!is_null($customer)){{ $customer->shipping_address }}@endif</p>
                                                                </li>
                                                                <li>
                                                                    <p>@if(!is_null($customer)){{ $customer->shipping_state }}@endif,@if(!is_null($customer)){{ $customer->shipping_city }}@endif, @if(!is_null($customer)){{ $customer->shipping_postalcode }}@endif.</p>
                                                                </li>
                                                                <li>
                                                                    <p>@if(!is_null($customer)){{ $customer->shipping_country }}@endif</p>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="cart-total-table address-box commun-table">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Billing Address</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <ul>
                                                                <li class="inner-heading"> <b>@if(!is_null($customer)){{ $customer->billing_name }}@endif</b> </li>
                                                                <li>
                                                                    <p>@if(!is_null($customer)){{ $customer->shipping_address }}@endif</p>
                                                                </li>
                                                                <li>
                                                                    <p>@if(!is_null($customer)){{ $customer->shipping_state }}@endif,@if(!is_null($customer)){{ $customer->shipping_city }}@endif, @if(!is_null($customer)){{ $customer->shipping_postalcode }}@endif.</p>
                                                                </li>
                                                                <li>
                                                                    <p>@if(!is_null($customer)){{ $customer->shipping_country }}@endif</p>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="data-step2" class="account-content" data-temp="tabdata" style="display:none">
                        <div class="row">
                            <div class="col-12">
                                <div class="heading-part heading-bg mb-30">
                                    <h2 class="heading m-0">Account Details</h2>
                                </div>
                            </div>
                        </div>
                        <div class="m-0">
                            <form class="main-form full">
                                <div class="mb-20">
                                    <div class="row">
                                        <div class="col-12 mb-20">
                                            <div class="heading-part">
                                                <h3 class="sub-heading">Shipping Address</h3>
                                            </div>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-box">
                                                <input type="text" required placeholder="Full Name" value="{{ Auth::user()->name}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-box">
                                                <input type="email" required placeholder="Email Address" value="{{ Auth::user()->email }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-box">
                                                <input type="text" required placeholder="Company" value="@if(!is_null($customer)){{ $customer->company }}@endif">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-box">
                                                <input type="text" required placeholder="Contact Number" value="@if(!is_null($customer)){{ $customer->mobile_no }}@endif">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-box">
                                                <input type="text" required placeholder="Shipping Address" value="@if(!is_null($customer)){{ $customer->shipping_address }}@endif ">
                                                <span>Please provide the number and street.</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-box select-dropdown">
                                                <fieldset>
                                                    <select name="shippingCountryId" class="option-drop" id="shippingcountryid">
                                                        @foreach($countrys as $country)
                                                        <option value="{{ $country->name }}" @if(!is_null($customer)){{ $country->id==$customer->country_id ? 'selected': '' }}@endif>{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-box select-dropdown">
                                                <fieldset>
                                                    <select name="shippingstateId" class="option-drop" id="state">
                                                        @if(!is_null($customer))
                                                        @foreach($states as $state)
                                                        <option value="{{ $state->name }}" {{ $state->name==$customer->state ? 'selected': '' }}>{{ $state->name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-box">
                                                <input type="text" required placeholder="Select City" value="@if(!is_null($customer)){{ $customer->city }}@endif">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-box">
                                                <input type="text" required placeholder="Postcode/zip" value="@if(!is_null($customer)){{ $customer->shipping_postalcode }}@endif">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-20">
                                        <div class="heading-part">
                                            <h3 class="sub-heading">Billing Address</h3>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-box">
                                            <input type="text" required placeholder="Full Name" value="@if(!is_null($customer)){{ $customer->billing_name }}@endif">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-box">
                                            <input type="text" required placeholder="Contact Number" value="@if(!is_null($customer)){{ $customer->billing_phone }}@endif">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-box">
                                            <input type="text" required placeholder="Billing Address" value=" @if(!is_null($customer)){{ $customer->billing_address }}@endif">
                                            <span>Please provide the number and street.</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-box select-dropdown">
                                            <fieldset>
                                                <select name="billingcountryId" class="option-drop" id="billingcountryid">
                                                    <option selected="" value="">Select Country</option>
                                                    @foreach($countrys as $country)
                                                    <option value="{{ $country->name }}" @if(!is_null($customer)){{ $country->name==$customer->country ? 'selected': '' }}@endif>{{ $country->name }}</option>
                                                    @endforeach

                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-box select-dropdown">
                                            <fieldset>
                                                <select name="billingstateId" class="option-drop" id="billingstateid">
                                                    @if(!is_null($customer))
                                                    @foreach($states as $state)
                                                    <option value="{{ $state->name }}" {{ $state->name==$customer->state ? 'selected': '' }}>{{ $state->name }}</option>
                                                    @endforeach
                                                    @endif

                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-box">
                                            <input type="text" required placeholder="Select City" value="@if(!is_null($customer)){{ $customer->billing_state }}@endif">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-box">
                                            <input type="text" required placeholder="Postcode/zip" value="@if(!is_null($customer)){{ $customer->billing_postalcode }}@endif">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-color right-side submitaddress">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div id="data-step5" class="account-content" data-temp="tabdata" style="display:none">
                        <div class="row">
                            <div class="col-12">
                                <div class="heading-part heading-bg mb-30">
                                    <h2 class="heading m-0">Notification</h2>
                                </div>
                            </div>
                        </div>
                        <div class="m-0">
                            <ul>
                                @foreach($notifications as $notify)
                                @if($notify->read_at==null)
                                <li class="notification-box bg-gray notification-item" data-id="{{ $notify->id }}">
                                    @else
                                <li class="notification-box notification-item" data-id="{{ $notify->id }}">
                                    @endif
                                    <div class="row">
                                        <div class="col-lg-8 col-sm-8 col-8">
                                            <strong class="text-info">{{ $notify->data['type'] }}</strong>
                                            <div>
                                                {{ $notify->data['message'] }}
                                            </div>

                                        </div>
                                        <div class="col-lg-4 col-sm-4 col-4">
                                            <small class="text-warning">{{ $notify->data['inputdate'] }}</small><br>
                                            <small class="text-info">{{ $notify->data['invoice_no'] }}</small>
                                            <strong class="text-danger">{{ $notify->data['total'] }}</strong>
                                        </div>
                                    </div>
                                </li>

                                @endforeach
                            </ul>
                            @if($notifications->count()>9)
                            <div class="shop_toolbar t_bottom">
                                <div class="pagination">
                                    <ul>
                                        {{ $notifications->links() }}
                                    </ul>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>


                    <div id="data-step3" class="account-content" data-temp="tabdata" style="display:none">
                        <div id="form-print" class="admission-form-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="heading-part heading-bg mb-30">
                                        <h2 class="heading m-0">My Orders</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-xs-30">
                                    <div class="cart-item-table commun-table">
                                        <div class="table-responsive">
                                            @if(!is_null($orders))
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Order</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>Total</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @foreach($orders as $key=>$order)
                                                        <tr>
                                                            <td><strong>{{ $key+1 }}</strong>.#{{ $order->invoice_no }}</td>

                                                            <td>{{ $order->inputdate }}</td>
                                                            <td>
                                                                <?php
                                                                $status = "";
                                                                switch ($order->status) {

                                                                    case 0:
                                                                        $status = 'New Order';
                                                                        break;
                                                                    case 1:
                                                                        $status = 'Recieved';
                                                                        break;
                                                                    default:
                                                                        $status = 'Delivered';
                                                                        break;
                                                                }
                                                                ?>
                                                                <span class="success">{{ $status }}</span>
                                                            </td>
                                                            <td>AED {{ $order->nettotal }}</td>
                                                            <td><a href="{{ route( 'checkout.orderslip',$order->id ) }}" class="view">view</a></td>
                                                        </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                                @if($orders->count()>9)
                                                <div class="shop_toolbar t_bottom">
                                                    <div class="pagination">
                                                        <ul>
                                                            {{ $orders->links() }}
                                                        </ul>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="data-step4" class="account-content" data-temp="tabdata" style="display:none">
                        <div class="row">
                            <div class="col-12">
                                <div class="heading-part heading-bg mb-30">
                                    <h2 class="heading m-0">Change Password</h2>
                                </div>
                            </div>
                        </div>
                        <form method="POST" class="main-form full" action="{{ route('password.update') }}">
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-box">
                                        <label for="old-pass">Email Address</label>
                                        <input type="email" placeholder="Email Address" required id="email" value="{{ Auth::user()->email }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-box">
                                        <label for="login-pass">Password</label>
                                        <input type="password" placeholder="Enter your Password" name="password" required id="password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-box">
                                        <label for="re-enter-pass">Re-enter Password</label>
                                        <input type="password" placeholder="Re-enter your Password" name="password_confirmation" required id="password-confirm">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn-color" type="submit" name="submit">Change Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<script>
    $('#country').change(function() {
        var countryID = $(this).val();
        State(countryID);
    });

    function State(countryID) {
        if (countryID) {
            $.ajax({
                type: "GET",
                url: "{{url('State/getstate')}}?country_id=" + countryID,
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
    }
    $('#state').on('change', function() {
        var stateID = $(this).val();
        City(stateID);
    });

    function City(stateID) {
        if (stateID) {
            $.ajax({
                type: "GET",
                url: "{{url('City/getcity')}}?state_id=" + stateID,
                success: function(res) {
                    if (res) {
                        $("#city").empty();
                        $("#city").append('<option>Select</option>');
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

    }
    $("#submittData").click(function() {
        var customername = $("#customer_name").val();
        var address = $("#customer_address").val();
        var address_one = $("#customer_address_one").val();
        var country = $("#country").val();
        var state = $("#state").val();
        var city = $("#city").val();
        var mobile = $("#phone").val();
        if (customername == "" || address == "" || country == "" || state == "" || mobile == "") {
            swal("Ops! Fail To submit", "Data field Required", "error");
        } else {
            $("#overlay").fadeIn();
            $.ajax({
                type: "POST",
                url: "{{ route('account.addressUpdate') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    customername: customername,
                    address: address,
                    address_one: address_one,
                    country_id: country,
                    state_id: state,
                    city_id: city,
                    mobile_no: mobile,
                },
                datatype: ("json"),
                success: function(data) {
                    $("#overlay").fadeOut();
                    swal("Data Update successfully", "", "success");
                },

                error: function(data) {
                    $("#overlay").fadeOut();
                    swal("Ops! Fail To submit", "Data Submit", "error");
                    console.log(data);
                }
            });
        }

    });
</script>
@endsection