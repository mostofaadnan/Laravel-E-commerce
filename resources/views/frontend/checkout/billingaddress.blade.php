@extends('frontend.layout.master')
@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<div class="banner inner-banner1">
    <div class="container">
        <section class="banner-detail center-xs">
            <h1 class="banner-title">Checkout</h1>
            <div class="bread-crumb right-side float-none-xs">
                <ul>
                    <li><a href="index.html"><i class="fa fa-home"></i>Home</a>/</li>
                    <li><a href="cart.html">Cart</a>/</li>
                    <li><span>Checkout</span></li>
                </ul>
            </div>
        </section>
    </div>
</div>
<!-- Bread Crumb END -->

<!-- CONTAIN START -->
<section class="checkout-section ptb-10">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="checkout-step mb-10 billing_address">
                    @include('frontend.checkout.checkoutstep')

                </div>
                <div class="checkout-content billing_address">
                    <div class="row">
                        <div class="col-12">
                            <div class="heading-part align-center">
                                <h2 class="heading">Please fill up your Shipping details</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-xl-6 col-lg-8 col-md-8">
                            <div class="main-form full">
                                <div class="row mb-20">
                                    <div class="col-12 mb-20">
                                        <div class="heading-part">
                                            <h3 class="sub-heading">Shipping Address</h3>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-box">
                                            <input type="text" id="customer_name" value="@if(!is_null($customer)){{ $customer->name }}@else{{ Auth::user()->name }}@endif">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-box">

                                            <input type="text" id="customer_email" value="{{ Auth::user()->email }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-box">
                                            <input type="text" id="customer_company" required placeholder="Company">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-box">
                                            <input id="customer_phone" name="phone" type="tel" placeholder="Contact Number" value="{{ Auth::user()->phone }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-box">
                                            <input placeholder="Shipping Address" id="customer_address" type="text" value="@if(!is_null($customer)){{ $customer->address }}@endif" required placeholder="Shipping Address">

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-box select-dropdown">
                                            <fieldset>
                                                <select name="shippingCountryId" class="option-drop" id="country">
                                                    <option>Select Country</option>
                                                    @foreach($countrys as $country)
                                                   <!--  <option value="{{ $country->id }}" @if(!is_null($customer)){{ $country->id==$customer->country_id ? 'selected': '' }}@endif>{{ $country->name }}</option> -->
                                                     <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-box select-dropdown">
                                            <fieldset>
                                                <select name="shippingstateId" class="option-drop" id="state">
                                                  <!--   @if(!is_null($customer))
                                                    @foreach($states as $state)
                                                    <option value="{{ $state->id }}" @if(!is_null($customer)){{ $state->id==$customer->state_id ? 'selected': '' }}@endif>{{ $state->name }}</option>
                                                    @endforeach
                                                    @else -->
                                                    <option value="0">Select State</option>
                                                   <!--  @endif -->
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-box">
                                            <input type="text" id="city" required placeholder="Select City">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-box">
                                            <input type="text" required id="customer_postalcode" placeholder="Postcode/zip">
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
                                            <input type="text" required placeholder="Full Name" id="billing_name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-box">
                                            <input type="text" required placeholder="Contact Number" id="billing_phone">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-box">
                                            <input type="text" required placeholder="Billing Address" id="billing_address">
                                            <span>Please provide the number and street.</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-box select-dropdown">
                                            <fieldset>
                                                <select name="billingcountryId" class="option-drop" id="billing_country">
                                                    <option selected="" value="">Select Country</option>
                                                    @foreach($countrys as $country)
                                                    <option value="{{ $country->id }}" @if(!is_null($customer)){{ $country->id==$customer->country_id ? 'selected': '' }}@endif>{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-box select-dropdown">
                                            <fieldset>
                                                <select name="shippingstateId" class="option-drop" id="billing_state">
                                                   <!--  @if(!is_null($customer))
                                                    @foreach($states as $state)
                                                    <option value="{{ $state->id }}" @if(!is_null($customer)){{ $state->id==$customer->state_id ? 'selected': '' }}@endif>{{ $state->name }}</option>
                                                    @endforeach
                                                    @else -->
                                                    <option value="0">Select State</option>
                                                    <!-- @endif -->
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-box">
                                            <input type="text" required placeholder="Select City" id="billing_city">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-box">
                                            <input type="text" id="billing_postalcode" required placeholder="Postcode/zip" >
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-color right-side submitaddress">Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).on('click', ".submitaddress", function() {
        //shipping
        var shipping_name = $("#customer_name").val();
        var shipping_email = $("#customer_email").val();
        var shipping_phone = $("#customer_phone").val();
        var shipping_company = $("#customer_company").val();
        var shipping_address = $("#customer_address").val();
        var shipping_state = $("#state option:selected").text();
        var state_id=$("#state").val();
        var shipping_city = $("#city").val();
        var shipping_country = $("#country option:selected").text();
        var customer_postalcode=$("#customer_postalcode").val();
        //billing
        var billing_name = $("#billing_name").val();
        var billing_email = $("#billing_email").val();
        var billing_phone = $("#billing_phone").val();
        var billing_company = $("#billing_company").val();
        var billing_address = $("#billing_address").val();
        var billing_state = $("#billing_state").val();
        var billing_city = $("#billing_city").val();
        var billing_country = $("#billing_country option:selected").text();
        var billing_postalcode=$("#billing_postalcode").val();
   
        $.ajax({
            type: "get",
            url: "{{ route('checkout.storeAddress') }}",
            data: {
                state_id:state_id,
                shipping_name: shipping_name,
                shipping_email: shipping_email,
                shipping_phone: shipping_phone,
                shipping_company: shipping_company,
                shipping_address: shipping_address,
                shipping_state: shipping_state,
                shipping_city: shipping_city,
                shipping_postalcode: customer_postalcode,
                shipping_country: shipping_country,

                billing_name: billing_name,
                billing_phone: billing_phone,
                billing_address: billing_address,
                billing_state: billing_state,
                billing_city: billing_city,
                billing_postalcode: billing_postalcode,
                billing_country: billing_country,

            },
            datatype: 'json',
            success: function(data) {
                url = "{{ route('checkout.overview')}}",
                    window.location = url;
            },
            error: function(data) {
                swal("Opps! Faild", "Form Submited Faild", "error");
                console.log(data)
            }
        });
    });
    $( document ).ready(function() {
    /*  $(document).on('change', "#country", function() { */
    $('#country').change(function() {
        console.log("asa")
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
      
        }
    }
    $('#billing_country').change(function() {
        var countryID = $(this).val();
        billing_State(countryID);
    });

    function billing_State(countryID) {
        if (countryID) {
            $.ajax({
                type: "GET",
                url: "{{url('State/getstate')}}?country_id=" + countryID,
                success: function(res) {
                    if (res) {
                        $("#billing_state").empty();
                        $("#billing_state").append('<option>Select</option>');
                        $.each(res, function(key, value) {
                            $("#billing_state").append('<option value="' + key + '">' + value + '</option>');
                        });

                    } else {
                        $("#billing_state").empty();
                    }
                }
            });
        } else {
            $("#billing_state").empty();
        }
    }
});
</script>
@endsection