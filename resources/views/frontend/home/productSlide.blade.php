<section class="product_area mb-60">
    <div class="container">
        <!--      <div class="row">
            <div class="col-12">
                <div class="product_header">
                    <div class="section_title">
                        <h2></h2>
                    </div>
                    <div class="product_tab_button">
                        <ul class=" nav" role="tablist">
                            @foreach($productSliders as $count => $productslide)
                            <li>
                                <a @if($count==0) class="active" @endif data-toggle="tab" href="#pharma-{{ $productslide->id }}" role="tab" aria-controls="pharma-{{ $productslide->id }}" aria-selected="true">{{ $productslide->name }}</a>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="tab-content">
            @foreach($productSliders as $count => $productslidetype)
            <div @if($count==0) class="tab-pane fade show active" @else class="tab-pane fade" @endif id="#pharma-{{ $productslidetype->id }}" role="tabpanel">
                <div class="product_carousel product_column6 owl-carousel">
                    @foreach($productslidetype->SliderProduct as $slide)
                    <?php
                    if ($slide->productName == null) {
                    } else {

                    ?>
                        <div class="single_product">
                            <div class="product_thumb">
                                <a class="primary_img" href="{{ route('product.productDetails',$slide->productName) }}"><img src="{{asset('storage/app/public/product/image/profile/'.$slide->productName->image)}}" alt=""></a>
                                <a class="secondary_img" href="{{ route('product.productDetails',$slide->productName) }}"><img src="{{asset('storage/app/public/product/image/profile/'.$slide->productName->image)}}" alt=""></a>

                                @if($slide->productName->discount>0)
                                <div class="label_product">
                                    <span class="label_sale">-{{ $slide->productName->parcentage }}%</span>
                                </div>
                                @endif
                                <div class="action_links">
                                    <ul>
                                        <li class="wishlist"><a href="{{ route('wishlist.addToWish',$slide->productName->id)}}" title="Add to Wishlist"><i class="icon-heart"></i></a></li>
                                        <li class="compare"><a href="compare.html" title="compare"><i class="icon-repeat"></i></a></li>
                                        <li class="quick_button"><a href="#" data-toggle="modal" data-target="#modal_box" title="quick view" class="productview" data-id="{{ $slide->productName->id }}"> <i class="icon-eye"></i></a></li>

                                    </ul>
                                </div>
                                <div class="add_to_cart">
                                    <?php
                                    $color = $slide->productName->ColorName;
                                    $size = $slide->productName->SizeName;
                                    ?>
                                    @if(count($color)==0 || count($size)==0)
                                    <a data-id="{{ $slide->productName->id }}" class="add-to-cart" title="add to cart">Add to cart</a>
                                    <input type="hidden" id="size" value="emp">
                                    <input type="hidden" id="color" value="emp">
                                    @else
                                    <a href="{{ route('product.productDetails',$slide->productName) }}" title="add to cart">Add to cart</a>
                                    @endif
                                </div>
                            </div>
                            <div class="product_content">
                                <p class="manufacture_product"><a href="{{ route('product.categoryproduct',$slide->productName->CategoryName) }}">{{ $slide->productName->CategoryName->title }}</a></p>
                                <h4><a href="{{ route('product.productDetails',$slide->productName) }}">{{ $slide->productName->name }}</a></h4>
                                <div class="price_box">

                                    @if($slide->productName->discount>0)
                                    <span class="old_price">TK {{ $slide->productName->mrp }}</span>
                                    <span class="current_price">TK {{ $slide->productName->discount }}</span>
                                    @else
                                    <span class="current_price">TK {{ $slide->productName->mrp }}</span>
                                    @endif


                                </div>
                            </div>
                        </div>
                    <?php }  ?>
                    @endforeach

                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>