@extends('frontend.layout.master')
@section('content')

<!-- <link rel="stylesheet" href="{{asset('assets/css/tel/intlTelInput.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/tel/demo.css')}}"> -->

<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li>Checkout</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@if(Session::has('cart'))
<div class="Checkout_section mt-32">
    <div class="container">
        <div class="checkout_form">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <h3>Billing Details</h3>
                    @include('frontend.checkout.billinigaddress')
                </div>
                <div class="col-lg-6 col-md-6">
                    <h3>Your order</h3>
                    @include('frontend.checkout.orderTable')

                    <div class="payment_method">
                        <div class="panel-default">
                            <input id="cash" name="check_method" type="radio" data-toggle="collapse" data-target="#cashpayment" aria-controls="cashpayment" />
                            <label>Cash Payment</label>

                            <div id="cashpayment" class="collapse one" data-parent="#accordion">
                                <div class="card-body1">
                                    <p>You Should Pay with cash after recieved Products</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel-default">
                            <input id="sslpayment" name="check_method" type="radio" data-toggle="collapse" data-target="#sslpaymetcheck" aria-controls="sslpaymetcheck" />
                            <label>Secured Online Payment</label>
                            <div id="sslpaymetcheck" class="collapse two" data-parent="#accordion1">
                                <div class="card-body1">
                                    <p>Pay securely by Credit or Debit card or internet banking through SSLCommerz Secure Servers.</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel-defaul">
                            <p>Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="{{ route('privacy') }}" style="color:#87CEFA;">privacy policy.</a></p>
                        </div>
                        <div class="panel-defaul mt-2">
                            <input type="checkbox" name="" id="agree_check"><b>I have read and agree to the website <a href="{{route('term')}}" style="color:#00BFFF;">terms and conditions<badge style="color:red;">*</badge></a></b>
                        </div>
                        <div class="order_button mt-2">
                            <!--             <form method="POST" class="needs-validation" novalidate>
                                @csrf
                                <button class="btn btn-primary btn-lg btn-block button" id="sslczPayBtn" token="if you have any token validation" postdata="your javascript arrays or objects which requires in backend" order="If you already have the transaction generated for current order" endpoint="{{ url('/pay-via-ajax') }}"> Proceed to Payment
                                </button>
                            </form> -->
                            <div id="cashpaymentbtn">
                                <button class="btn btn-primary btn-lg btn-block button" id="submitdata"> Proceed to Payment
                                </button>
                            </div>
                            <div id="sslbutton" style="display:none;">
                                <button class="btn btn-primary btn-lg btn-block button" class="submitbutton" id="sslczPayBtn" token="if you have any token validation" postdata="your javascript arrays or objects which requires in backend" order="If you already have the transaction generated for current order" endpoint="{{ url('/pay-via-ajax') }}"> Proceed to Payment
                                </button>
                            </div>
                            <!--   <button class="button" id="submittData"> Proceed to Payment
                            </button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="Checkout_section mt-32">
    <div class="container">
        <h4 align="center">Your Cart is</h4>
        <div class="cart_button">
            <a href="{{ route('allproducts') }}">Shoping</a>
        </div>
    </div>
</div>
@endif
<script>
    (function(window, document) {
        var loader;
        /* if ($("#agree_check").prop("checked") == true) { */
        /*   $("#sslczPayBtn").on("click", function() { */
        function DataInsert() {

            $("#overlay").fadeIn();
            var customername = $("#customer_name").val();
            var address = $("#customer_address").val();
            var address_one = $("#customer_address_one").val();
            var country = $("#country").val();
            var state = $("#state").val();
            var city = $("#city").val();
            var mobile = $("#phone").val();
            var amount = $("#amount").html();
            var discount = 0.00;
            var vat = 0.00;
            var shipment = $("#shiping").html();
            var nettotal = $("#nettotal").html();

            var itemtables = new Array();

            $("#table tr").each(function() {
                var row = $(this);
                var item = {};
                item.code = row.data('itemcode');
                item.name = row.data('name');
                item.qty = row.data('qty');
                item.unitprice = row.data('unitprice');
                item.color = row.data("color");
                item.size = row.data("size");
                item.amount = row.data('amount');
                /*  item.discount = row.find("TD").eq(6).html(); */
                item.discount = 0.00;
                item.vat = 0.00;
                //    var nettotal = row.data('amount');
                item.nettotal = row.data('amount');
                if (item.nettotal > 0) {
                    itemtables.push(item);
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('checkout.storecash') }}",
                //data: JSON.stringify(itemtables),
                data: {

                    itemtables: itemtables,
                    name: customername,
                    address: address,
                    address_one: address_one,
                    country_id: country,
                    state_id: state,
                    city_id: city,
                    phone: mobile,
                    amount: amount,
                    discount: discount,
                    vat: vat,
                    shipment: shipment,
                    nettotal: nettotal,

                },
                datatype: ("json"),
                success: function(data) {
                    $("#overlay").fadeOut();
                    console.log(data);

                    if (data > 0) {
                        swal("Your Order Successfuly Place", "", "success");
                        url = "{{ url('CheckOut/orderslip')}}" + '/' + data,
                            window.location = url;
                    } else {
                        swal("Ops! Something Wrong", "Data Submit Fail", "error");
                    }

                },

                error: function(data) {
                    $("#overlay").fadeOut();
                    swal("Ops! Fail To submit", "Data Submit", "error");
                    console.log(data);
                }
            });
        }
        $(document).ready(function() {
            //set initial state.

            $('#cash').change(function() {
                if ($(this).is(":checked")) {
                    $("#sslbutton").hide();
                    $("#cashpaymentbtn").show();
                }


            });
            $('#sslpayment').change(function() {
                if ($(this).is(":checked")) {
                    $("#sslbutton").show();
                    $("#cashpaymentbtn").hide();
                }


            });
        });

        /*   $("#submittData").click(function() {
              if ($("#agree_check").prop('checked') == true) {
                  if ($("#cash").prop('checked') == true) {
                      $("#submittData").attr("endpoint", "");
                      DataInsert();
                  } else if ($("#sslpayment").prop('checked') == true) {
                      var link = "{{ url('/pay-via-ajax') }}"
                      $("#submittData").attr("endpoint", link);
                      CardPayment()
                  } else {

                  }

              } else {
                  swal("Ops! Fail To submit", "Please Accept Term & Condition", "error");
              }

          }); */

        $("#submitdata").click(function() {
            if ($("#agree_check").prop('checked') == true) {
                address = $("#customer_address").val();
                phone = $("#phone").val();
                var country = $("#country").val();
                var state = $("#state").val();
                var city = $("#city").val();
                if (address == "" || phone == "" || country == "0" || state == "0" || city == "0") {
                    swal("Ops! Fail To submit", "Please Fillup Billing Address", "error");
                } else {
                    DataInsert();
                }

            } else {
                swal("Ops! Fail To submit", "Please Accept Term & Condition", "error");
            }

        });
        $("#sslczPayBtn").click(function() {
            if ($("#agree_check").prop('checked') == true) {
                address = $("#customer_address").val();
                phone = $("#phone").val();
                var country = $("#country").val();
                var state = $("#state").val();
                var city = $("#city").val();
                if (address == "" || phone == "" || country == "0" || state == "0" || city == "0") {
                    swal("Ops! Fail To submit", "Please Fillup Billing Address", "error");
                } else {
                    CardPayment();
                }
            }
        });

        /*   (function(window, document) { */

        /*   })(window, document); */

        /*    function load() {
               var script = document.createElement("script"),
                   tag = document.getElementsByTagName("script")[0];
               script.src = "{{ asset('assets/frontend/js/embed.min.js') }}?" + Math.random().toString(36).substring(7);
               tag.parentNode.insertBefore(script, tag);
           }
        */

        loader = function() {
            var script = document.createElement("script"),
                tag = document.getElementsByTagName("script")[0];
            script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
            tag.parentNode.insertBefore(script, tag);
        };
        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);


        function CardPayment() {
            // window.addEventListener ? window.addEventListener("load",loader, false) : window.attachEvent("onload", loader);
            var obj = {};
            var itemtables = new Array();
            $("#table tr").each(function() {
                var row = $(this);
                var item = {};
                item.code = row.data('itemcode');
                item.name = row.data('name');
                item.qty = row.data('qty');
                item.unitprice = row.data('unitprice');
                item.color = row.data("color");
                item.size = row.data("size");
                item.amount = row.data('amount');
                /*  item.discount = row.find("TD").eq(6).html(); */
                item.discount = 0.00;
                item.vat = 0.00;
                //    var nettotal = row.data('amount');
                item.nettotal = row.data('amount');
                if (item.nettotal > 0) {
                    itemtables.push(item);
                }
            });
            obj.itemtables = itemtables;
            obj.cus_name = $("#customer_name").val();
            obj.cus_phone = $("#phone").val();
            obj.cus_addr1 = $("#customer_address").val();
            obj.cus_addr2 = $("#customer_address_one").val();
            obj.cus_city = $("#city option:selected").text();
            obj.cityid = $("#city").val();
            obj.cus_state = $("#state option:selected").text();
            obj.stateid = $("#state").val();
            obj.cus_country = $("#country option:selected").text();
            obj.countryid = $("#country").val();
            obj.amount = $("#amount").html();
            obj.discount = 0.00;
            obj.vat = 0.00;
            obj.shipment = $("#shiping").html();
            obj.total_amount = $("#nettotal").html();
            $('#sslczPayBtn').prop('postdata', obj);
        }
    })(window, document);
</script>

@endsection