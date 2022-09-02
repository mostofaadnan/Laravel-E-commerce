@extends('frontend.layout.master')
@section('content')
<!--
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li>shop</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
-->

<div class="shop_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <!--sidebar widget start-->
                @include('frontend.product.rightSidebar')
                <!--sidebar widget end-->
            </div>
            <div class="col-lg-9 col-md-12">

                <!--
                    <div class="shop_banner">
                        <img src="assets/img/bg/banner11.jpg" alt="">
                    </div>
                      -->
                <div class="shop_title">
                    <h4>Search results: "{{ $data }}"</h4>
                </div>
                <div class="shop_toolbar_wrapper">
                    <div class="shop_toolbar_btn">

                        <button data-role="grid_3" type="button" class="active btn-grid-3" data-toggle="tooltip" title="3"></button>

                        <button data-role="grid_4" type="button" class=" btn-grid-4" data-toggle="tooltip" title="4"></button>

                        <button data-role="grid_list" type="button" class="btn-list" data-toggle="tooltip" title="List"></button>
                    </div>

                    <div class="page_amount">
                        <p>Showing {{($products->currentpage()-1)*$products->perpage()+1}} - {{$products->currentpage()*$products->perpage()}} of {{$products->total()}} result</p>

                    </div>
                </div>
                <!--shop toolbar end-->

                <div class="row shop_wrapper">

                    @foreach($products as $product)

                    <div class="col-lg-4 col-md-4 col-sm-6 col-12 ">
                        <div class="single_product">
                            <div class="product_thumb">

                                <a class="primary_img" href="{{ route('product.productDetails',$product) }}"><img src="{{asset('storage/app/public/product/image/profile/'.$product->image)}}" alt="{{ $product->name }}"></a>
                                <a class="secondary_img" href="{{ route('product.productDetails',$product) }}"><img src="{{asset('storage/app/public/product/image/profile/'.$product->image)}}" alt="{{ $product->name }}"></a>
                                @if($product->discount>0)
                                <div class="label_product">
                                    <span class="label_sale">-{{ $product->parcentage }}%</span>
                                </div>
                                @endif
                                <div class="action_links">
                                    <ul>
                                        <li class="wishlist"><a href="{{ route('wishlist.addToWish',$product)}}" title="Add to Wishlist"><i class="icon-heart"></i></a></li>
                                        <li class="quick_button"><a href="#" data-toggle="modal" data-target="#modal_box" title="quick view" class="productview" data-id="{{ $product->id }}"> <i class="icon-eye"></i></a></li>
                                    </ul>
                                </div>
                                <div class="add_to_cart">
                                    <?php
                                    $color = $product->ColorName;
                                    $size = $product->SizeName;
                                    ?>
                                    @if(count($color)==0 || count($size)==0)
                                    <a data-id="{{ $product->id}}" class="add-to-cart" title="add to cart">Add to cart</a>
                                    <input type="hidden" id="size" value="emp">
                                    <input type="hidden" id="color" value="emp">

                                    @else
                                    <a href="{{ route('product.productDetails',$product) }}" title="add to cart">Add to cart</a>
                                    @endif
                                </div>
                            </div>
                            <div class="product_content grid_content">
                                <p class="manufacture_product"><a href="{{ route('product.categoryproduct',$product->category_id) }}">{{ $product->CategoryName->title }}</a></p>
                                <h4><a href="{{ route('product.productDetails',$product) }}">{{ Str::limit($product->name,24) }}</a></h4>
                                <div class="price_box">

                                    @if($product->discount>0)
                                    <span class="old_price">TK {{ $product->mrp }}</span>
                                    <span class="current_price">TK {{ $product->discount }}</span>
                                    @else
                                    <span class="current_price">TK {{ $product->mrp }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="product_content list_content">
                                <div class="left_caption">
                                    <p class="manufacture_product"><a href="#">{{ $product->CategoryName->title }}</a></p>
                                    <h4><a href="{{ route('product.productDetails',$product) }}">{{ $product->name }}</a></h4>
                                    <div class="product_desc">
                                    </div>
                                </div>
                                <div class="right_caption">
                                    <div class="text_available">
                                        <?php
                                        $openigqty = $product->openingStock()->sum('qty');
                                        $invoice = $product->QuantityOutBySale()->sum('qty');
                                        $invoiceReturn = $product->QuantityOutBySaleReturn()->sum('qty');
                                        $totalinvoiceqty = $invoice - $invoiceReturn;
                                        $purchase = $product->QuantityOutByPurchase()->sum('qty');
                                        $PurchaseReturn = $product->QuantityOutByPurchaseReturn()->sum('qty');
                                        $totalPurchaseqty = $purchase - $PurchaseReturn;
                                        $stock = $openigqty + ($totalPurchaseqty - $totalinvoiceqty);
                                        ?>
                                        @if($stock>0)
                                        <p>availabe: <span>{{ $stock }} in stock</span></p>
                                        @else
                                        <p><span>Stock Not available</span></p>
                                        @endif
                                    </div>
                                    <div class="price_box">
                                        @if($product->discount>0)
                                        <span class="old_price">TK {{ $product->mrp }}</span>
                                        <span class="current_price">TK {{ $product->discount }}</span>
                                        @else
                                        <span class="current_price">TK {{ $product->mrp }}</span>
                                        @endif
                                    </div>
                                    <div class="cart_links_btn">
                                        <a data-id="{{ $product->id}}" class="add-to-cart" title="add to cart">add to cart</a>
                                    </div>
                                    <div class="action_list_links">
                                        <ul>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i class="icon-heart"></i></a></li>
                                            <li class="compare"><a href="compare.html" title="compare"><i class="icon-repeat"></i></a></li>
                                            <li class="quick_button"><a href="#" data-toggle="modal" data-target="#modal_box" title="quick view"> <i class="icon-eye"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>

                <div class="shop_toolbar t_bottom">
                    <div class="pagination">
                        <ul>
                            {{ $products->links() }}
                        </ul>
                    </div>
                </div>
                <!--shop toolbar end-->
                <!--shop wrapper end-->
            </div>

        </div>
    </div>
</div>


@endsection