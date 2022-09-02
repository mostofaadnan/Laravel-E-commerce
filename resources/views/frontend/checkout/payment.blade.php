@extends('frontend.layout.master')
@section('content')
<div class="banner inner-banner1">
  <div class="container">
    <section class="banner-detail center-xs">
      <h1 class="banner-title">Payment</h1>
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
<section class="checkout-section ptb-60">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="checkout-step mb-40">
          <ul>
            <li>
              <a href="checkout.html">
                <div class="step">
                  <div class="line"></div>
                  <div class="circle">1</div>
                </div>
                <span>Shipping</span>
              </a>
            </li>
            <li>
              <a href="order-overview.html">
                <div class="step">
                  <div class="line"></div>
                  <div class="circle">2</div>
                </div>
                <span>Order Overview</span>
              </a>
            </li>
            <li class="active">
              <a href="payment.html">
                <div class="step">
                  <div class="line"></div>
                  <div class="circle">3</div>
                </div>
                <span>Payment</span>
              </a>
            </li>
            <li>
              <a href="order-complete.html">
                <div class="step">
                  <div class="line"></div>
                  <div class="circle">4</div>
                </div>
                <span>Order Complete</span>
              </a>
            </li>
            <li>
              <div class="step">
                <div class="line"></div>
              </div>
            </li>
          </ul>
          <hr>
        </div>
        <div class="checkout-content">
          <div class="row">
            <div class="col-12">
              <div class="heading-part align-center">
                <h2 class="heading">Select a payment method</h2>
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-8 ">
              <div class="payment-option-box mb-30">
                <div class="payment-option-box-inner gray-bg">
                  <div class="payment-top-box">
                    <div class="radio-box left-side"> <span>
                        <input type="radio" id="paypal" value="paypal" name="payment_type">
                      </span>
                      <label for="paypal">Secure Payment</label>
                    </div>
                    <div class="paypal-box">
                      <div class="inputbox mt-3"> <input type="text" name="name" class="form-control" required="required"> <span>Name on card</span> </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="inputbox mt-3 mr-2"> <input type="text" name="name" class="form-control" required="required"> <i class="fa fa-credit-card"></i> <span>Card Number</span> </div>
                        </div>
                        <div class="col-md-6">
                          <div class="d-flex flex-row">
                            <div class="inputbox mt-3 mr-2"> <input type="text" name="name" class="form-control" required="required"> <span>Expiry</span> </div>
                            <div class="inputbox mt-3 mr-2"> <input type="text" name="name" class="form-control" required="required"> <span>CVV</span> </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <p>If you Don't have CCAvenue Account, it doesn,t matter. You can also pay via CCAvenue with you credit card or bank debit card</p>
                  <p>Payment can be submitted in any currency.</p>
                </div>
              </div>
              <div class="payment-option-box mb-30">
                <div class="payment-option-box-inner gray-bg">
                  <div class="payment-top-box">
                    <div class="radio-box left-side"> <span>
                        <input type="radio" id="cash" value="cash" name="payment_type">
                      </span>
                      <label for="cash">Would you like to pay by Cash on Delivery?</label>
                    </div>
                  </div>
                  <p>Cash must be paid at the time of delivery</p>
                </div>
              </div>
              <div class="right-side float-none-xs"> <a class="btn btn-color" href="{{ route('checkout.placeorder') }}">Place Order<span><i class="fa fa-angle-right"></i></span></a> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>


</script>
@endsection