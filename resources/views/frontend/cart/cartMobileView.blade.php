@extends('frontend.layout.master')
@section('content')

<div class="mini_cart">
    <div class="cart_item">
        <div class="cart_img">
            <a href="#"><img src="assets/img/s-product/product.jpg" alt=""></a>
        </div>
        <div class="cart_info">
            <a href="#">Madden by Steve Madden Cale 6</a>

            <span class="quantity">Qty: 1</span>
            <span class="price_cart">$60.00</span>

        </div>
        <div class="cart_remove">
            <a href="#"><i class="ion-android-close"></i></a>
        </div>
    </div>
    <div class="cart_item">
        <div class="cart_img">
            <a href="#"><img src="assets/img/s-product/product2.jpg" alt=""></a>
        </div>
        <div class="cart_info">
            <a href="#">Calvin Klein Jeans Reflective Logo Full Zip </a>
            <span class="quantity">Qty: 1</span>
            <span class="price_cart">$69.00</span>
        </div>
        <div class="cart_remove">
            <a href="#"><i class="ion-android-close"></i></a>
        </div>
    </div>
    <div class="mini_cart_table">
        <div class="cart_total">
            <span>Sub total:</span>
            <span class="price">$138.00</span>
        </div>
        <div class="cart_total mt-10">
            <span>total:</span>
            <span class="price">$138.00</span>
        </div>
    </div>

    <div class="mini_cart_footer">
        <div class="cart_button">
            <a href="cart.html">View cart</a>
        </div>
        <div class="cart_button">
            <a href="checkout.html">Checkout</a>
        </div>

    </div>

</div>

@endsection