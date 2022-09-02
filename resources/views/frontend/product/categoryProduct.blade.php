@extends('frontend.layout.master')
@section('content')
<div class="banner inner-banner1">
    <div class="container">
        <section class="banner-detail center-xs">
            <h1 class="banner-title">{{ $category->title }}</h1>
            <div class="bread-crumb right-side float-none-xs">
                <ul>
                    <li><a href="index.html"><i class="fa fa-home"></i>Home</a>/</li>
                    <li><span>Category</span></li>
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
            <div class="col-12">
                <div class="shorting shorting-style-2 mb-20">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="view">
                                <div class="list-types grid active">
                                    <a>
                                        <div class="grid-icon list-types-icon"></div>
                                    </a>
                                </div>
                                <div class="list-types list">
                                    <a>
                                        <div class="list-icon list-types-icon"></div>
                                    </a>
                                </div>
                            </div>
                            <div class="short-by"> <span>Sort By :</span>
                                <div class="select-item select-dropdown">
                                    <fieldset>
                                        <select name="speed" id="sort-price" class="option-drop">
                                            <option value="" selected="selected">Name (A to Z)</option>
                                            <option value="">Name(Z - A)</option>
                                            <option value="">price(low&gt;high)</option>
                                            <option value="">price(high &gt; low)</option>
                                            <option value="">rating(highest)</option>
                                            <option value="">rating(lowest)</option>
                                        </select>
                                    </fieldset>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-6">
                            <div class="show-item float-left-sm"> <span>Show :</span>
                                <div class="select-item select-dropdown">
                                    <fieldset>
                                        <select name="speed" id="show-item" class="option-drop">
                                            <option value="" selected="selected">
                                                <p>{{($products->currentpage()-1)*$products->perpage()+1}} - {{$products->currentpage()*$products->perpage()}} of {{$products->total()}} result</p>
                                            </option>
                                            <option value="">12</option>
                                            <option value="">6</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <span>Per Page</span>
                                <div class="compare float-right-sm"> <a href="#" class="btn btn-color">Compare (0)</a> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-listing grid-type">
                    <div class="inner-listing">
                        <div class="row mlr_-20">
                            @foreach($products as $product)
                            <div class="col-md-2 col-6 plr-20 item-width mb-20">
                                <div class="product-item">
                                    <div class="product-item-inner">
                                        <div class="product-image">
                                            <!--  <div class="main-label sale-label"><span>Sale</span></div>
                        <div class="main-label new-label"><span>New</span></div> -->
                                            <a href="{{ route('product.productDetails', $product->name) }}">
                                                <img src="{{asset('storage/app/public/product/image/profile/'.$product->image)}}" alt="Shopholic">
                                            </a>
                                            <div class="quick-view">
                                                <a class="popup-with-product btn btn-color productview" href="#product_popup" title="quick-view"><i class="fa fa-eye"></i>Quick View</a>
                                            </div>
                                        </div>
                                        <div class="product-item-details">
                                            <div class="product-item-name">
                                                <a href="{{ route('product.productDetails', $product->name) }}">{{ $product->name }}</a>
                                            </div>
                                            <div class="price-box">
                                                @if($product->discount>0)
                                                <span class="price old-price">TK {{ $product->mrp }}</span>
                                                <span class="price">AED {{ $product->discount }}</span>
                                                @else
                                                <span class="price">AED {{ $product->mrp }}</span>
                                                @endif

                                            </div>
                                        <!--     <div class="rating-summary-block">
                                                <div class="rating-result" title="53%">
                                                    <span style="width:53%"></span>
                                                </div>
                                            </div> -->
                                            <div class="product-des">
                                                <p>
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
                                                </p>
                                            </div>
                                            <div class="product-detail-inner">
                                                <div class="detail-inner-left align-center">
                                                    <ul>
                                                        <li class="pro-cart-icon">
                                                            <a class="add-to-cart" data-id="{{ $product->id}}" title="Add to Cart">
                                                                <span></span>
                                                            </a>
                                                        </li>
                                                        <li class="pro-wishlist-icon">
                                                            <a href="{{ route('wishlist.addToWish',$product)}}" title="Wishlist">
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
                        <div class="row">
                            <div class="col-12">
                                <div class="pagination-bar">
                                    {{ $products->links() }}
                                    <!--  <ul>
                                        <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                                        <li class="active"><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                                    </ul> -->
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

