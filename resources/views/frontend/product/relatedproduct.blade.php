<section class="ptb-10">
  <div class="container">
    <div class="product-listing grid-type related_product">
      <div class="row">
        <div class="col-12">
          <div class="heading-part line-bottom mb-30">
            <h2 class="main_title heading"><span>Related Products</span></h2>
          </div>
        </div>
      </div>
      <div class="pro_cat">
        <div class="row mlr_-20">
          <div class="owl-carousel pro-cat-slider">
            @foreach($RelatedProducts as $product)
            <div class="item plr-20">
              <div class="product-item">
                <!-- <div class="main-label sale-label"><span>Sale</span></div> -->
                <div class="product-item-inner">
                  <div class="product-image">
                    <a href="{{ route('product.productDetails', $product->name) }}">
                      <img src="{{asset('storage/app/public/product/image/profile/'.$product->image)}}" alt="Shopholic">
                    </a>
                  </div>
                  <div class="product-item-details">
                    <div class="product-item-name">
                      <a href="{{ route('product.productDetails', $product->name) }}">{{ $product->name }}</a>
                    </div>
                    <div class="price-box">
                      @if($product->discount>0)
                      <span class="price">AED {{ $product->mrp }}</span>
                      <del class="price old-price">AED {{ $product->mrp }}</del>
                      @else
                      <span class="price">AED {{ $product->mrp }}</span>
                      @endif
                    </div>
                  <!--   <div class="rating-summary-block">
                      <div class="rating-result" title="53%">
                        <span style="width:53%"></span>
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
                            <a href="{{ route('wishlist.addToWish',$product)}}" title="Wishlist">
                              <span></span>
                            </a>
                          </li>
                          
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="quick-view">
                  <a class="popup-with-product btn btn-color productview" href="#product_popup" title="quick-view">
                    <i class="fa fa-eye"></i> Quick View
                  </a>
                </div>
              </div>
            </div>
            @endforeach

          </div>
        </div>
      </div>
    </div>
  </div>
</section>