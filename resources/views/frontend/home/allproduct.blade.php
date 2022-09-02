@foreach($HomeProductCategories as $homecategory)
<style>
.product_area{
    background-color: #f9f9f9;
}
</style>
<section class="product_area mb-40">
    <div class="container">
        <div class="product_wrapper_inner">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h3 class="category_title">{{ $homecategory->CategoryName->title }}</h3>
                   
                    <div class="product_right_area">
                        <div class="product_carousel product_column6 col-xs-6 owl-carousel">
                            @foreach( $homecategory->CategoryProduct as $product)
                            <div class="product_items">
                                <div class="single_product">
                                    <div class="product_thumb">
                                        <a class="primary_img" href="{{ route('product.productDetails',$product) }}"><img src="{{asset('storage/app/public/product/image/profile/'.$product->image)}}" alt=""></a>
                                        <a class="secondary_img" href="{{ route('product.productDetails',$product) }}"><img src="{{asset('storage/app/public/product/image/profile/'.$product->image)}}" alt=""></a>
                                        @if($product->discount>0)
                                        <div class="label_product">
                                            <span class="label_sale">-{{ $product->parcentage }}%</span>
                                        </div>
                                        @endif

                                        <div class="action_links">
                                            <ul>
                                                <li class="wishlist"><a href="{{ route('wishlist.addToWish',$product)}}" title="Add to Wishlist"><i class="icon-heart"></i></a></li>
                                                <li class="compare"><a href="compare.html" title="compare"><i class="icon-repeat"></i></a></li>
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
                                    <div class="product_content">
                                        <p class="manufacture_product"><a href="{{ route('product.categoryproduct',$product->CategoryName) }}">{{ $product->CategoryName->title }}</a></p>
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





