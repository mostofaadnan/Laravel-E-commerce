<div class="offcanvas_menu">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="offcanvas_menu_wrapper">
                    <div class="canvas_close">
                        <a href="javascript:void(0)"><i class="icon-x"></i></a>
                    </div>

                    <div class="mobile-logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('assets/frontend/img/logo/mobilelogo.png') }}" alt="">Deys Pharma</a>
                    </div>

                    <div class="top_left mt-3">
                        <ul>
                            @guest
                            @if (Route::has('login'))
                            <li class="top_links">
                                <a href="{{ route('login') }}">@lang('home.login')/@lang('home.register')</a>
                            </li>
                            @endif
                            @else
                            <li>
                                <strong>{{ Auth::user()->name }}</strong>
                            </li>
                            @endguest
                        </ul>
                        <hr>
                    </div>
                    <div id="menu" class="text-left ">
                        <ul class="offcanvas_main_menu">
                            <li class="menu-item-has-children"><a class="active" href="{{route('home') }}">@lang('home.home')</a></li>
                            <li class="menu-item-has-children">
                                <a href="#">@lang('home.category')</a>
                                <ul class="sub-menu">
                                @foreach($categories as $category)  
                                <li><a href="{{ route('product.categoryproduct',$category) }}">{{ $category->title }}</a></li>
                                @endforeach
                                </ul>

                            </li>

                            <li class="menu-item-has-children"><a href="{{route('allproducts') }}">@lang('home.shop')</a></li>
                            <li class="menu-item-has-children"><a href="{{ route('contacts') }}"> @lang('home.contact') @lang('home.us')</a></li>
                            <li class="menu-item-has-children"><a href="{{ route('carts') }}">@lang('home.shopping') @lang('home.cart')</a></li>
                            <li class="menu-item-has-children"><a href="{{ route('checkouts') }}">@lang('home.checkout') </a></li>
                            <li class="menu-item-has-children"><a href="{{ route('wishlists') }}">Wishlist({{ Session::has('wish')?Session::get('wish')->totalQty:0 }})</a></li>
                        
                            @guest
                            @if (Route::has('login'))

                            @endif

                            @else
                            <li class="menu-item-has-children"><a href="{{ route('accounts') }}">@lang('home.my') @lang('home.account') </a></li>
                            @if(auth()->user()->Notifications->count()>0)
                            <li class="menu-item-has-children"><a href="{{ route('notifications') }}">Notification <span class="badge badge-pill badge-danger">{{ auth()->user()->unreadNotifications->count()==0?'':auth()->user()->unreadNotifications->count() }}</a></li>
                            <li class="menu-item-has-children"><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    @lang('home.logout')
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                            @endif
                            @endguest

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>