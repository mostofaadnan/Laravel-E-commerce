<div class="header_middle">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-6">
            <div class="mobile-logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('assets/frontend/img/logo/mobilelogo.png') }}" alt="">Deys Pharma</a>
                    </div>
            </div>
            <div class="col-lg-6">
                <div class="search-container search_three">
                    <form action="{{ route('product.prosearch') }}" method="get">
                        <div class="search_box">
                            <input type="text" list="productsearch" name="search" id="itemsearch" autocomplete="off" placeholder="@lang('home.search')">
                            <datalist id="productsearch">
                            </datalist>
                            <button type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="header_cart_wishlist">
                    <div class="header_wishlist_btn">
                        <a href="{{ route('wishlists') }}"><i class="icon-heart"></i></a>
                        <span class="wishlist_quantity">{{ Session::has('wish')?Session::get('wish')->totalQty:0 }}</span>
                    </div>
                    <div class="mini_cart_wrapper text-right">
                        <a href="javascript:void(0)"><span class="icon-shopping-cart">k {{ Session::has('cart')?Session::get('cart')->totalPrice:'' }}</span></a>
                        <span class="cart_quantity">{{ Session::has('cart')?Session::get('cart')->totalQty:'0' }}</span>
                        <!--mini cart-->
                        @include('frontend.cart.minicart')
                        <!--mini cart end-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>