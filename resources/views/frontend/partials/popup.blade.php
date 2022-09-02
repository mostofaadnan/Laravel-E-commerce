<div class="popup-links">
    <div class="popup-links-inner">
        <ul>
            <li class="categories">
                <a class="popup-with-form" href="#categories_popup"><span class="icon"></span><span class="icon-text">Categories</span></a>
            </li>
            <li class="cart-icon">
                <a class="popup-with-form" href="#cart_popup"><span class="icon"></span><span class="icon-text">Cart</span></a>
            </li>
            @guest
            @if (Route::has('login'))
            <li class="account">
                <a class="popup-with-form" href="{{ route('login') }}"><span class="icon"></span><span class="icon-text">Login</span></a>
            </li>
            <li class="account">
                <a class="popup-with-form" href="{{ route('register') }}"><span class="icon"></span><span class="icon-text">Register</span></a>
            </li>
            @endif
            @else
            <li class="account">
                <a class="popup-with-form" href="#account_popup"><span class="icon"></span><span class="icon-text">Account</span></a>
            </li>
            @endguest
            <li class="search">
                <a class="popup-with-form" href="#search_popup"><span class="icon"></span><span class="icon-text">Search</span></a>
            </li>
            <li class="scroll scrollup">
                <a href="#"><span class="icon"></span><span class="icon-text">Scroll-top</span></a>
            </li>
        </ul>
    </div>
    <div id="popup_containt">
        <div id="categories_popup" class="white-popup-block mfp-hide popup-position">
            <div class="popup-title">
                <h2 class="main_title heading"><span>Categories</span></h2>
            </div>
            <div class="popup-detail">
                <ul class="cate-inner">
                    @foreach($categories as $cat)
                    <li class="level">
                        <a href="{{ route('product.categoryproduct', $cat) }}" class="page-scroll">{{ $cat->title }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div id="cart_popup" class="white-popup-block mfp-hide popup-position">
            <div class="popup-title">
                <h2 class="main_title heading"><span>Cart</span></h2>
            </div>
            <div class="popup-detail">
                <div class="cart-dropdown ">
                    <ul class="cart-list link-dropdown-list">
                        <li> <a class="close-cart"><i class="fa fa-times-circle"></i></a>
                            <div class="media"> <a class="pull-left"> <img alt="Shopholic" src="{{asset('assets/frontend/images/1.jpg')}}"></a>
                                <div class="media-body"> <span><a href="#">Black African Print Skirt</a></span>
                                    <p class="cart-price">$14.99</p>
                                    <div class="product-qty">
                                        <label>Qty:</label>
                                        <div class="custom-qty">
                                            <input type="text" name="qty" maxlength="8" value="1" title="Qty" class="input-text qty">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li> <a class="close-cart"><i class="fa fa-times-circle"></i></a>
                            <div class="media"> <a class="pull-left"> <img alt="Shopholic" src="{{asset('assets/frontend/images/2.jpg')}}"></a>
                                <div class="media-body"> <span><a href="#">Black African Print Skirt</a></span>
                                    <p class="cart-price">$14.99</p>
                                    <div class="product-qty">
                                        <label>Qty:</label>
                                        <div class="custom-qty">
                                            <input type="text" name="qty" maxlength="8" value="1" title="Qty" class="input-text qty">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <p class="cart-sub-totle"> <span class="pull-left">Cart Subtotal</span> <span class="pull-right"><strong class="price-box">$29.98</strong></span> </p>
                    <div class="clearfix"></div>
                    <div class="mt-20"> <a href="cart.html" class="btn-color btn">Cart</a> <a href="checkout.html" class="btn-color btn right-side">Checkout</a> </div>
                </div>
            </div>
        </div>
        @guest
        @if (Route::has('login'))


        @endif
        @else

        <div id="account_popup" class="white-popup-block mfp-hide popup-position">
            <div class="popup-title">
                <h2 class="main_title heading"><span>Account</span></h2>
            </div>
            <div class="popup-detail">
                <div class="row">
                    <div class="col-lg-4">
                        <a href="{{ route('accounts') }}">
                            <div class="account-inner mb-30">
                                <i class="fa fa-user"></i><br />
                                <span>Account</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4">
                        <a href="{{ route('allproducts') }}">
                            <div class="account-inner mb-30">
                                <i class="fa fa-shopping-bag"></i><br />
                                <span>Shopping</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <div class="account-inner">
                                <i class="fa fa-share-square-o"></i><br />
                                <span>log out</span>
                            </div>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endguest


        <div id="search_popup" class="white-popup-block mfp-hide popup-position">
            <div class="popup-title">
                <h2 class="main_title heading"><span>Search</span></h2>
            </div>
            <div class="popup-detail">
                <div class="main-search">
                    <div class="header_search_toggle desktop-view">
                        <form>
                            <div class="search-box">
                                <input class="input-text" type="text" placeholder="Search entire store here...">
                                <button class="search-btn"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>