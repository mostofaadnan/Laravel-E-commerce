@extends('frontend.layout.master')
@section('content')
<div class="home_content">
    @include('frontend.home.slider')
    <section class="mt-20">
        <div class="container">
            <div class="ser-feature-block">
                <div class="row mlr_-20">
                    <div class="col-md-4 col-xs-6 plr-20 center-sm">
                        <div class="feature-box-main">
                            <div class="feature-box feature1">
                                <div class="ser-title">Free Shipping <br>& Return</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-6 plr-20 center-sm">
                        <div class="feature-box-main">
                            <div class="feature-box feature2">
                                <div class="ser-title">100% Money <br>Return</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-6 plr-20 center-sm">
                        <div class="feature-box-main">
                            <div class="feature-box feature3">
                                <div class="ser-title">24/7 Customer <br>Services</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Services Features Block End -->

    <!-- Electronics block Start -->
    @foreach($HomeProductCategories as $homecategory)
    <section class="pt-60">
        <div class="container">
            <!--    <div class="row d-none d-lg-block">
            <div class="col-xl-12">
                <div class="mb-20">
                    <a href="shop.html">
                        <img src="images/elec-top-img.jpg" alt="Shopholic">
                    </a>
                </div>
            </div>
        </div> -->
            <div class="row mlr_-20">
                <div class="col-lg-12 col-md-12 plr-20">
                    <div class="sidebar-title">
                        <a href="{{ route('product.categoryproduct', $homecategory->CategoryName->title) }}" style="color:aliceblue"><span>{{ $homecategory->CategoryName->title }}</span></a>
                    </div>
                    <div class="product-listing grid-type home-category">
                        <div class="inner-listing">
                            <div class="row mlr_-20">
                                @foreach( $homecategory->CategoryProduct as $product)
                                <div class="col-md-2 col-6 plr-20 mb-xs-20 mt-1">
                                    <div class="product-item">
                                        <!--  <div class="main-label sale-label"><span>Sale</span></div> -->
                                        <div class="product-item-inner">
                                            <div class="product-image">
                                                <a href="{{ route('product.productDetails', $product->name) }}">
                                                    <img src="{{asset('storage/app/public/product/image/profile/'.$product->image)}}" alt="Shopholic">
                                                </a>
                                                <div class="quick-view">
                                                    <a class="popup-with-product btn btn-color productview" href="#product_popup" title="quick-view" data-id="{{ $product->id }}"><i class="fa fa-eye"></i> Quick View</a>
                                                </div>
                                            </div>
                                            <div class="product-item-details">
                                                <div class="product-item-name">
                                                    <a href="{{ route('product.categoryproduct', $product->CategoryName->title) }}">{{ $product->CategoryName->title }}</a>
                                                </div>
                                                <div class="product-item-name">
                                                    <a href="{{ route('product.productDetails', $product->name) }}">{{ $product->name }}</a>
                                                </div>
                                                <div class="price-box">
                                                    @if($product->discount>0)
                                                    <del class="price old-price">{{ $product->discount }}</del>
                                                    <span class="price">AED {{ $product->mrp }}</span>
                                                    @else
                                                    <span class="price">AED {{ $product->mrp }}</span>
                                                    @endif
                                                </div>
                                               <!--  <div class="rating-summary-block">
                                                    <div class="rating-result" title="53%">
                                                        <span style="width:53%"></span>
                                                    </div>
                                                </div> -->
                                                <div class="product-des">
                                                    <p>Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. ipsum primis in faucibus orci luctus et ultrices.</p>
                                                </div>
                                                <!--    <div class="mb-30">
                                                <div class="bottom-detail cart-button responsive-btn">
                                                    <ul>
                                                        <li class="pro-cart-icon">
                                                            <a data-id="{{ $product->id}}" title="Add to Cart" class="btn btn-color add-to-cart"><span></span> Add to Cart</a>
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                            </div> -->
                                                <div class="product-detail-inner">
                                                    <div class="detail-inner-left align-center">
                                                        <ul>
                                                            <li class="pro-cart-icon">
                                                                <a class="add-to-cart" data-id="{{ $product->id}}" title="Add to Cart">
                                                                    <span></span>
                                                                </a>
                                                            </li>
                                                            <li class="pro-wishlist-icon">
                                                                <a href="{{ route('wishlist.addToWish',$product->id)}}" title="Wishlist">
                                                                    <span></span>
                                                                </a>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endforeach
</div>


@endsection