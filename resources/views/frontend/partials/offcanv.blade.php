<div class="offcanvas_menu">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="canvas_open">
                    <a href="javascript:void(0)"><i class="icon-menu"></i></a>
                </div>
                <div class="offcanvas_menu_wrapper">
                    <div class="canvas_close">
                        <a href="javascript:void(0)"><i class="icon-x"></i></a>
                    </div>
                    <div class="welcome_text">
                        <p>Welcome to our {{ $company->name }}</p>
                    </div>
                    <div class="top_right">
                        <ul>

                            <li><a href="{{ route('wishlists') }}"><i class="icon-heart"></i> @lang('home.wishlist') ({{ Session::has('wish')?Session::get('wish')->totalQty:0 }})</a></li>
                            <li class="top_links"><a href="#">@lang('home.settings')<i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                <ul class="dropdown_links">
                                    <li><a href="{{ route('checkouts') }}">@lang('home.checkout') </a></li>
                                    <li><a href="{{ route('carts') }}">@lang('home.shopping') @lang('home.cart')</a></li>
                                    <li><a href="wishlist.html">@lang('home.wishlist')</a></li>
                                </ul>
                            </li>

                            <li class="language"><a href="#"><img src="{{ asset('assets/frontend/img/logo/language.png') }}" alt="">English<i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                <ul class="dropdown_language">
                                    <li class="active"><a href="{{ url('locale/en')}}"><img src="{{ asset('assets/frontend/img/logo/language.png') }}" alt=""> English</a></li>
                                    <li><a href="{{ url('locale/bn')}}"><img src="{{ asset('assets/frontend/img/logo/language2.png') }}" alt=""> Bangla</a></li>
                                </ul>
                            </li>
                            @guest
                            @if (Route::has('login'))
                            <li class="top_links">
                                <a href="{{ route('login') }}">@lang('home.login')</a>
                            </li>
                            @endif

                            @if (Route::has('register'))
                            <li class="top_links">
                                <a href="{{ route('register') }}">@lang('home.register')</a>
                            </li>
                            @endif
                            @else
                            <li class="top_links"><a href="#"> {{ Auth::user()->name }}<i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                <ul class="dropdown_links">

                                    <li><a href="{{ route('accounts') }}">@lang('home.my') @lang('home.account') </a></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            @lang('home.logout')
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @if(auth()->user()->Notifications->count()>0)
                            <li class="top_links"><i class="fa fa-envelope fa-x icon"></i><span class="badge badge-pill badge-danger">{{ auth()->user()->unreadNotifications->count()==0?'':auth()->user()->unreadNotifications->count() }}</span>
                                <ul class="dropdown_links ojk">
                                    <li class="head text-light bg-dark">
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12 col-12">
                                                <span>Notifications {{ auth()->user()->unreadNotifications->count()==0?'':(auth()->user()->unreadNotifications->count())}}</span>
                                                @if(auth()->user()->unreadNotifications->count()>0)<a href="{{ route('notification.markasallread') }}" class="float-right text-light">Mark all as read</a>@endif
                                            </div>
                                    </li>
                                    <div class="my-custom-scrollbar">
                                        @foreach(auth()->user()->notifications as $notify)
                                        @if($notify->read_at==null)
                                        <li class="notification-box bg-gray notification-item" data-id="{{ $notify->id }}">
                                            @else
                                        <li class="notification-box notification-item" data-id="{{ $notify->id }}">
                                            @endif
                                            <div class="row">
                                                <div class="col-lg-8 col-sm-8 col-8">
                                                    <strong class="text-info">{{ $notify->data['type'] }}</strong>
                                                    <div>
                                                        {{ $notify->data['message'] }}
                                                    </div>

                                                </div>
                                                <div class="col-lg-4 col-sm-4 col-4">
                                                    <small class="text-warning">{{ $notify->data['inputdate'] }}</small><br>
                                                    <small class="text-info">{{ $notify->data['invoice_no'] }}</small>
                                                    <strong class="text-danger">{{ $notify->data['total'] }}</strong>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </div>
                                    <li class="footer bg-dark text-center">
                                        <a href="{{ route('accounts') }}" class="text-light">@lang('home.view') @lang('home.all')</a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                            @endguest
                        </ul>
                    </div>
                    <div class="search-container">
                        <form action="{{ route('product.prosearch') }}" method="get">
                            <div class="search_box">
                                <input type="text" list="productsearch" name="search" id="itemsearch" autocomplete="off" placeholder="@lang('home.search')">

                                <datalist id="productsearch">
                                </datalist>
                                <button type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="customer_support">
                        <div class="support_img_icon">
                            <img src="assets/img/icon/icon_phone.png" alt="">
                        </div>
                        <div class="customer_support_text">
                            <p>
                                <span>Customer Support</span>
                                <a href="tel:(08)12345789">{{ $company->mobile }}</a>
                            </p>
                        </div>
                    </div>
                    <div class="mini_cart_canvas">
                        <div class="mini_cart_wrapper">
                            <a href="javascript:void(0)"><span class="icon-shopping-cart"></span></a>
                            <span class="cart_quantity"></span>
                            <!--mini cart-->
                            <div class="mini_cart">
                                    <div class="cart_item">
                                        <div class="cart_img">
                                            <a href="#"><img src="assets/img/s-product/product.jpg" alt=""></a>
                                        </div>
                                        <div class="cart_info">
                                            <a href="#">Madden by Steve Madden Cale 6</a>

                                            <span class="quantity">Qty: 1</span>
                                            <span class="price_cart">$60.00</span>

                                        </div>
                                        <div class="cart_remove">
                                            <a href="#"><i class="ion-android-close"></i></a>
                                        </div>
                                    </div>
                                    <div class="cart_item">
                                        <div class="cart_img">
                                            <a href="#"><img src="assets/img/s-product/product2.jpg" alt=""></a>
                                        </div>
                                        <div class="cart_info">
                                            <a href="#">Calvin Klein Jeans Reflective Logo Full Zip </a>
                                            <span class="quantity">Qty: 1</span>
                                            <span class="price_cart">$69.00</span>
                                        </div>
                                        <div class="cart_remove">
                                            <a href="#"><i class="ion-android-close"></i></a>
                                        </div>
                                    </div>
                                    <div class="mini_cart_table">
                                        <div class="cart_total">
                                            <span>Sub total:</span>
                                            <span class="price">$138.00</span>
                                        </div>
                                        <div class="cart_total mt-10">
                                            <span>total:</span>
                                            <span class="price">$138.00</span>
                                        </div>
                                    </div>

                                    <div class="mini_cart_footer">
                                        <div class="cart_button">
                                            <a href="cart.html">View cart</a>
                                        </div>
                                        <div class="cart_button">
                                            <a href="checkout.html">Checkout</a>
                                        </div>

                                    </div>

                                </div>
                            <!--mini cart end-->
                        </div>
                    </div>
                    <div id="menu" class="text-left ">
                        <ul class="offcanvas_main_menu">
                            <li><a class="active" href="{{route('home') }}">@lang('home.home')</a></li>
                            <li><a href="{{route('allproducts') }}">@lang('home.shop')</a></li>
                            <li><a href="{{ route('contacts') }}"> @lang('home.contact') @lang('home.us')</a></li>
                        </ul>
                    </div>

                    <div class="offcanvas_footer">
                        <span><a href="#"><i class="fa fa-envelope-o"></i>{{ $company->companyemail }}</a></span>
                        <ul>
                            <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li class="pinterest"><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                            <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>