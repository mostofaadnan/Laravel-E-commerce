@extends('frontend.layout.master')
@section('content')


<!-- Bread Crumb STRAT -->
<div class="banner inner-banner1">
    <div class="container">
        <section class="banner-detail center-xs">
            <h1 class="banner-title">{{ $product->name }}</h1>
            <div class="bread-crumb right-side float-none-xs">
                <ul>
                    <li><a href="index.html"><i class="fa fa-home"></i>Home</a>/</li>
                    <li><span>{{ $product->CategoryName->title }}</span></li>/ <li><span>{{ $product->name }}</span></li>
                </ul>
            </div>
        </section>
    </div>
</div>
<!-- Bread Crumb END -->

<!-- CONTAINER START -->
<section class="pt-10">
    <div class="container">
        <div class="product-detail-view">
            <div class="">
                <div class="">
                    <div class="row m-0">
                        <div id="sidebar" class="col-md-5 mb-xs-30 p-0 pr-10 static-sidebar">
                            <div class="sidebar__inner">
                                <div class="fotorama" data-nav="thumbs" data-allowfullscreen="native">
                                    @foreach($product->MuliImage as $slider)
                                    <a href="#"><img src="{{asset('storage/app/public/product/image/multiple/'.$slider->image)}}" alt="Shopholic"></a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div id="content" class="col-md-7 p-0 pl-10">
                            <div class="product-detail-main">
                                <div class="product-item-details mb-60">
                                    <h1 class="product-item-name">{{ $product->name }}</h1>
                                    <div class="rating-summary-block">
                                        <div title="53%" class="rating-result"> <span style="width:53%"></span> </div>
                                    </div>
                                    <div class="price-box">
                                        @if($product->discount>0)
                                        <span class="price">AED {{ $product->mrp }}</span>
                                        <del class="price old-price">AED {{ $product->mrp }}</del>
                                        @else
                                        <span class="price">AED {{ $product->mrp }}</span>
                                        @endif
                                    </div>
                                    <div class="product-info-stock-sku">
                                        <div>
                                            <label>Availability: </label>
                                            <span class="info-deta">In stock</span>
                                        </div>
                                        <div>
                                            <label>SKU: </label>
                                            <span class="info-deta">20MVC-18</span>
                                        </div>
                                    </div>
                                    <hr class="mb-20">
                                    <p>short Descrtiption</p>
                                    <hr class="mb-20">
                                    <div class="mb-20">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-12">
                                                        <span>Qty:</span>
                                                    </div>
                                                    <div class="col-lg-9 col-md-12">
                                                        <div class="custom-qty">
                                                            <button type="button" class="reduced items" onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) result.value--;return false;"> <i class="fa fa-minus"></i> </button>
                                                            <input type="text" name="qty" id="qty" value="1" title="Qty" class="input-text qty">
                                                            <button type="button" class="increase items" onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;"> <i class="fa fa-plus"></i> </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="mb-20">
                                    <div class="mb-20">
                                        <div class="bottom-detail cart-button responsive-btn">
                                            <ul>
                                                <li class="pro-cart-icon">
                                                    <a data-id="{{ $product->id}}" title="Add to Cart" class="btn btn-color add-to-cart"><span></span> Add to Cart</a>
                                                </li>
                                                <li class="pro-wishlist-icon"><a href="wishlist.html" title="Wishlist"><span></span> Wishlist</a></li>
                                                <li class="pro-compare-icon"><a href="compare.html" title="Compare"><span></span> Compare</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="share-link">
                                        <label>Share This : </label>
                                        <div class="social-link">
                                            <ul class="social-icon">
                                                <li><a class="facebook" title="Facebook" href="#"><i class="fa fa-facebook"> </i></a></li>
                                                <li><a class="twitter" title="Twitter" href="#"><i class="fa fa-twitter"> </i></a></li>
                                                <li><a class="linkedin" title="Linkedin" href="#"><i class="fa fa-linkedin"> </i></a></li>
                                                <li><a class="rss" title="RSS" href="#"><i class="fa fa-rss"> </i></a></li>
                                                <li><a class="pinterest" title="Pinterest" href="#"><i class="fa fa-pinterest"> </i></a></li>
                                            </ul>
                                        </div>
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


<section class="ptb-10">
    <div class="container">
        <div class="product-detail-tab">
            <div class="row">
                <div class="col-lg-12">
                    <div id="tabs">
                        <ul class="nav nav-tabs">
                            <li><a class="tab-Description selected" title="Description">Description</a></li>
                            <li><a class="tab-Reviews" title="Reviews">Reviews</a></li>
                        </ul>
                    </div>
                    <div id="items">
                        <div class="tab_content">
                            <ul>
                                <li>
                                    <div class="items-Description selected">
                                        <div class="Description">
                                            <?php
                                            $filename = 'ProductConfig-' . $product->id . '.txt';
                                            $files = storage_path("app/public/product/description/$filename");
                                            if (file_exists($files)) {
                                                $file = fopen(storage_path("app/public/product/description/$filename"), "r") or exit("Unable to open file!");
                                                while (!feof($file)) {
                                                    echo fgets($file);
                                                }

                                                fclose($file);
                                            }

                                            ?>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    @include('frontend.product.productReview')
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('frontend.product.relatedproduct')
@endsection