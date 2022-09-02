@extends('frontend.layout.master')
@section('content')
<div class="banner inner-banner1">
  <div class="container">
    <section class="banner-detail center-xs">
      <h1 class="banner-title">Order Overview</h1>
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
        <div class="checkout-step mb-40 billing_address">
          <ul>
            <li>
              <a href="{{ route('checkouts') }}">
                <div class="step">
                  <div class="line"></div>
                  <div class="circle">1</div>
                </div>
                <span>Shipping</span>
              </a>
            </li>
            <li class="active">
              <a href="order-overview.html">
                <div class="step">
                  <div class="line"></div>
                  <div class="circle">2</div>
                </div>
                <span>Order Overview</span>
              </a>
            </li>
            <li>
              <a href="{{ route('checkout.Payment') }}">
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
        </div>
        <div class="checkout-content billing_address">
          <div class="row">
            <div class="col-12">
              <div class="heading-part align-center">
                <h2 class="heading">Order Overview</h2>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8 mb-sm-30">
              <div class="cart-item-table commun-table mb-30">
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Product</th>
                        <th>Product Detail</th>
                        <th>Sub Total</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($products as $id=>$product)
                      <tr data-itemcode="{{ $product['item']['id'] }}" data-name="{{ $product['item']['name'] }}" data-qty="{{ $product['qty'] }}" data-unitprice="{{ $product['unitprice'] }}" data-amount="{{ $product['price'] }}">
                        <td><a href="product-page.html">
                            <div class="product-image"><img alt="Honour" src="{{asset('storage/app/public/product/image/profile/'.$product['item']['image'])}}"></div>
                          </a></td>
                        <td>
                          <div class="product-title"> <a href="product-page.html">{{ $product['item']['name'] }}</a>
                            <div class="product-info-stock-sku m-0">
                              <div>
                                <label>Price: </label>
                                <div class="price-box"> <span class="info-deta price">AED {{ $product['unitprice'] }}</span> </div>
                              </div>
                            </div>
                            <div class="product-info-stock-sku m-0">
                              <div>
                                <label>Quantity: </label>
                                <span class="info-deta">{{ $product['qty'] }}</span>
                              </div>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div data-id="100" class="total-price price-box"> <span class="price">AED {{ $product['price'] }}</span> </div>
                        </td>
                        <td><i class="fa fa-trash cart-remove-item" data-id="100" title="Remove Item From Cart"></i></td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="cart-total-table commun-table mb-30">
               
               <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th colspan="2">Cart Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Item(s) Subtotal</td>
                        <td>
                          <div class="price-box"> <span class="price">AED {{ $totalprice }}</span> </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Shipping</td>
                        <td>
                          <div class="price-box"> <span class="price">AED {{ $shipment }}</span> </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Vat</td>
                        <td>
                          <div class="price-box"> <span class="price">AED {{ $vat }}</span> </div>
                        </td>
                      </tr>
                      <tr>
                        <td><b>Amount Payable</b></td>
                        <td>
                          <div class="price-box"> <span class="price"><b>AED {{ $netotal }}</b></span> </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="right-side float-none-xs"> <a href="{{ route('checkout.Payment') }}" class="btn btn-color">Next</a> </div>
            </div>
            <div class="col-md-4">
              <div class="cart-total-table address-box commun-table mb-30">
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
                            <li class="inner-heading"> <b>{{ $address['shipping_name'] }}</b> </li>
                            <li>
                              <p>{{ $address['shipping_address'] }},</p>
                            </li>
                            <li>
                              <p>{{ $address['shipping_state'] }},{{ $address['shipping_city'] }}, {{ $address['shipping_postalcode'] }}.</p>
                            </li>
                            <li>
                              <p>{{ $address['shipping_country'] }}</p>
                            </li>
                          </ul>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
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
                            <li class="inner-heading"> <b>{{ $address['billing_name'] }}</b> </li>
                            <li>
                              <p>{{ $address['billing_address'] }},</p>
                            </li>
                            <li>
                              <p>{{ $address['billing_state'] }},{{ $address['billing_city'] }}, {{ $address['billing_postalcode'] }}.</p>
                            </li>
                            <li>
                              <p>{{ $address['billing_country'] }}</p>
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
    </div>
  </div>
</section>
@endsection