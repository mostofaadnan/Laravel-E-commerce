@extends('frontend.layout.master')
@section('content')
<div class="banner inner-banner1">
    <div class="container">
        <section class="banner-detail center-xs">
            <h1 class="banner-title">Order Overview</h1>
            <div class="bread-crumb right-side float-none-xs">
                <ul>
                    <li><a href="index.html"><i class="fa fa-home"></i>Home</a>/</li>
                    <li><a href="cart.html">Order</a>/</li>
                    <li><span>Order Slip</span></li>
                </ul>
            </div>
        </section>
    </div>
</div>

<div class="shopping_cart_area mt-10">
    <div class="container">
        <h4 align="center" class="mb-10" style="border:1px #ccc solid;padding:10px;margin:auto;margin-bottom:20px; background-color:#ccc;font-weight: 600;color:#000;">ORDER</h4>
        @if(Session::has('success'))
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <p>{{Session::get('success')}}</p>
        </div>
        @endif
        <div class="row">
            <div class="col-sm-4">
                <h3 class="billing-address">Billing address</h3>
                <hr>
                <h4 id="customername">{{ $order->CustomerName->name }}</h4>
                <address>
                    <i>Address one:{{ $order->CustomerName->shipping_address}}</i><br>
                    <i>City: {{ $order->CustomerName->shipping_city }}</i><br>
                    <i>State: {{ $order->CustomerName->shipping_state}}</i><br>
                    <i>{{ $order->CustomerName->shipping_country}}</i><br>
                    <i class="fa fa-mobile " aria-hidden="true"> {{ $order->CustomerName->mobile_no}}</i><br>
                    <i class="fa fa-envelope-o" aria-hidden="true"> {{ $order->CustomerName->email}}</i><br>

                </address>
            </div>
            <div class="col-sm-4 hidden-xs"></div>
            <div class="col-12 col-sm-4">
                <div class="cart-item-table commun-table mb-30">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>@lang('home.order') @lang('home.no')</th>
                                <td id="invoiceno">#{{ $order->invoice_no  }}</td>
                            </tr>
                            <tr>
                                <th>@lang('home.date')</th>
                                <td id="invoicedate">{{ $order->inputdate }}</td>
                            </tr>
                            <tr>
                                <th>@lang('home.payment') @lang('home.type')</th>
                                <td id="paymenttype">{{ $order->paymenttype }}</td>
                            </tr>
                            <tr>
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
                                <th>@lang('home.status')</th>
                                <td>{{ $status }}</td>
                            </tr>
                            <tr>
                                <th>Delivery Date</th>
                                <td>{{ $order->delivery_date }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table_desc">
                    <div class="cart-item-table commun-table mb-30">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product_name">Product</th>
                                        <th class="product_name">Specification</th>
                                        <th class="product-price">Price</th>
                                        <th class="product_quantity">Quantity</th>
                                        <th class="product_total">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->InvDetails as $product)
                                    <tr>


                                        <td class="product_name"><a href="#">{{ $product->productName->name }}</a></td>
                                        <td class="product_name">{{ $product->spacification }}</td>
                                        <td class="product-price">{{ $product->mrp }}</td>
                                        <td class="product_quantity">{{ $product->qty }}</td>
                                        <td class="product_total">TK {{ $product->amount }}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--coupon code area start-->
        <div class="coupon_area">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="coupon_code right">
                        <h3>Totals</h3>
                        <div class="coupon_inner">
                            <div class="cart_subtotal">
                                <p>Subtotal</p>
                                <p class="cart_amount">TK {{ $order->amount }}</p>
                            </div>
                            <div class="cart_subtotal ">
                                <p>Shipment Charge</p>
                                <p class="cart_amount">TK {{ $order->shipment }}</p>
                            </div>
                            <div class="cart_subtotal">
                                <p>Total</p>
                                <p class="cart_amount">TK {{ $order->nettotal }}</p>
                            </div>
                            <hr>
                            <div class="checkout_btn">
                                <a href="{{ route('checkout.orderpdf',$order->id) }}" target="_blank">Print</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection