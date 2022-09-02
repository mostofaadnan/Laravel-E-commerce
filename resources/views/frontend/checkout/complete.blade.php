@extends('frontend.layout.master')
@section('content')
<!-- Bread Crumb STRAT -->
<div class="banner inner-banner1">
    <div class="container">
        <section class="banner-detail center-xs">
            <h1 class="banner-title">Order Complete</h1>
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
                        <li> <a href="checkout.html">
                                <div class="step">
                                    <div class="line"></div>
                                    <div class="circle">1</div>
                                </div>
                                <span>Shipping</span>
                            </a> </li>
                        <li> <a href="order-overview.html">
                                <div class="step">
                                    <div class="line"></div>
                                    <div class="circle">2</div>
                                </div>
                                <span>Order Overview</span>
                            </a> </li>
                        <li> <a href="payment.html">
                                <div class="step">
                                    <div class="line"></div>
                                    <div class="circle">3</div>
                                </div>
                                <span>Payment</span>
                            </a> </li>
                        <li class="active"> <a href="order-complete.html">
                                <div class="step">
                                    <div class="line"></div>
                                    <div class="circle">4</div>
                                </div>
                                <span>Order Complete</span>
                            </a> </li>
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
                                <h2 class="heading">Order Complete</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mb-sm-30">
                            <div id="form-print" class="admission-form-wrapper">
                                <div class="cart-item-table complete-order-table commun-table mb-30">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Product Detail</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->InvDetails as $product)
                                                <tr>
                                                    <td>
                                                        <a href="product-page.html">
                                                            <div class="product-image">
                                                                <img alt="Shopholic" src="{{asset('storage/app/public/product/image/profile/'.$product->productName->image)}}">
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <div class="product-title">
                                                            <a href="product-page.html">{{ $product->productName->name }}</a>
                                                            <div class="product-info-stock-sku m-0">
                                                                <div>
                                                                    <label>Price: </label>
                                                                    <div class="price-box">
                                                                        <span class="info-deta price">AED {{ $product->mrp }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="product-info-stock-sku m-0">
                                                                <div>
                                                                    <label>Quantity: </label>
                                                                    <span class="info-deta">{{ $product->qty }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="complete-order-detail commun-table mb-30">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td><b>Order Places :</b></td>
                                                    <td>{{ $order->inputdate }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Total :</b></td>
                                                    <td>
                                                        <div class="price-box"> <span class="price">{{ $order->nettotal }}</span> </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Payment :</b></td>
                                                    <td>{{ $order->payment_info }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Order No. :</b></td>
                                                    <td>#{{ $order->invoice_no }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="mb-30">
                                    <div class="heading-part">
                                        <h3 class="sub-heading">Order Confirmation</h3>
                                    </div>
                                    <hr>
                                    <p class="mt-20">Thank you for your order. We will confirm your order very soon. We will send it to you in due time after the order is confirmed.</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="print-btn">
                                        <a class="btn btn-color" href="{{ route('checkout.orderpdf',$order->id) }}" target="_blank">Print</a>
                                        <div class="right-side float-none-xs mt-sm-30">
                                            <a class="btn btn-black" href="{{ route('allproducts') }}">
                                                <span><i class="fa fa-angle-left"></i></span>Continue Shopping
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                                        <li class="inner-heading"> <b>{{ $order->CustomerName->name }}</b> </li>
                                                        <li>
                                                            <p>{{ $order->CustomerName->shipping_address }},</p>
                                                        </li>
                                                        <li>
                                                            <p>{{ $order->CustomerName->shipping_state }},{{ $order->CustomerName->shipping_city }}, {{ $order->CustomerName->shipping_postalcode }}.</p>
                                                        </li>
                                                        <li>
                                                            <p>{{ $order->CustomerName->shipping_country }}</p>
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
                                                        <li class="inner-heading"> <b>{{ $order->CustomerName->billing_name }}</b> </li>
                                                        <li>
                                                            <p>{{ $order->CustomerName->billing_address }},</p>
                                                        </li>
                                                        <li>
                                                            <p>{{ $order->CustomerName->billing_state }},{{ $order->CustomerName->billing_city }}, {{ $order->CustomerName->billing_postalcode }}.</p>
                                                        </li>
                                                        <li>
                                                            <p>{{ $order->CustomerName->billing_country }}</p>
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