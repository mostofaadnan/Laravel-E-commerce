



@extends('frontend.layout.master')
@section('content')

<div class="banner inner-banner1">
    <div class="container">
        <section class="banner-detail center-xs">
            <h1 class="banner-title">Wishlist</h1>
            <div class="bread-crumb right-side float-none-xs">
                <ul>
                    <li><a href="index.html"><i class="fa fa-home"></i>Home</a>/</li>
                    <li><span>Wishlist</span></li>
                </ul>
            </div>
        </section>
    </div>
</div>
<!-- Bread Crumb END -->

<!-- CONTAIN START -->
<section class="ptb-60">
    <div class="container">
        <div class="row">
            <div class="col-12 ">
                <div class="cart-item-table commun-table">
                    <div class="table-responsive">
                        @if(Session::has('wish'))
                        <table class="table">
                            <thead>
                                @foreach($products as $id=>$product)
                                <tr>
                                    <th>Product</th>
                                    <th>Descriotion</th>
                                    <th>Price</th>
                                  <!--   <th>Quantity</th> -->
                                    <th>Stock Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <a href="{{ route('product.productDetails',$product['item']['id']) }}">
                                            <div class="product-image"><img alt="Stylexpo" src="{{asset('storage/app/public/product/image/profile/'.$product['item']['image'])}}"></div>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="product-title">
                                            <a href="{{ route('product.productDetails',$product['item']['id']) }}">{{ $product['item']['name'] }}</a>
                                        </div>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>
                                                <div class="base-price price-box"> <span class="price">AED {{ $product['item']['mrp'] }}</span> </div>
                                            </li>
                                        </ul>
                                    </td>
                                <!--     <td>
                                        <div class="input-box select-dropdown">
                                            <fieldset>
                                                <select data-id="100" class="quantity_cart option-drop" name="quantity_cart">
                                                    <option selected="" value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </td> -->
                                    <td>
                                        <div class="total-price price-box">
                                            <span class="price">In Stock</span>
                                        </div>
                                    </td>
                                    <td>
                                        <a class="add-to-cart" data-id="{{ $id }}">
                                            <i title="Shopping Cart" class="fa fa-shopping-cart" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('wishlist.remove',$id) }}"><i title="Remove Item From Cart" data-id="100" class="fa fa-trash cart-remove-item"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mt-30">
                    <a href="{{ route('allproducts') }}" class="btn btn-color">
                        <span><i class="fa fa-angle-left"></i></span>Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection