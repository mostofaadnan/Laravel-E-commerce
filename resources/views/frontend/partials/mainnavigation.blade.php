<!-- <div class="header_bottom sticky-header">
    <div class="container">
        <div class="header_bottom_container3">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <div class="offcanvas_menu">
                        <div class="canvas_menu">
                            <a href="javascript:void(0)"><i class="icon-menu" id="canvas_open"></i><span class="pagename">{{ $pagetitle  }}</span></a>
                        </div>
                        <div class="mini_cart_wrapper text-right pull-right mt-2">
                            <i class="fa fa-2x fa-shopping-cart mobile-cart"></i>
                            <span class="cart_quantity" style="color:#fff">2</span>
                        </div>
                    </div>


                    <div class="categories_menu">
                        <div class="categories_title">
                            <h2 class="categori_toggle">@lang('home.all') @lang('home.category') </h2>
                        </div>
                        <div class="categories_menu_toggle">
                            <ul>
                                @foreach($categories as $category)
                                <li class="menu_item_children"><a href="{{ route('product.categoryproduct',$category) }}">{{ $category->title }}<i class="fa fa-angle-right"></i></a>
                                    @if(count($category->subcategory)>0)
                                    <ul class="categories_mega_menu">
                                        <li class="menu_item_children">
                                            <ul class="categorie_sub_menu">
                                                @foreach($category->subcategory as $subcat)
                                                <li><a href="{{ route('product.subcategoryproduct',$subcat) }}">{{ $subcat->title }}</a></li>
                                                @endforeach

                                            </ul>
                                        </li>

                                    </ul>
                                    @endif
                                </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="main_menu menu_three header_position">
                        <nav>
                            <ul>
                                <li><a class="active" href="{{route('home') }}">@lang('home.home')</a></li>
                                <li><a href="{{route('allproducts') }}">@lang('home.shop')</a></li>
                                <li><a href="{{ route('contacts') }}"> @lang('home.contact') @lang('home.us')</a></li>
                                <li><a href="{{ route('about') }}"> @lang('home.about') @lang('home.us')</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
 -->
<div class="header_bottom sticky-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="offcanvas_menu">
                    <div class="canvas_menu">
                        <a href="javascript:void(0)"><i class="icon-menu" id="canvas_open"></i><span class="pagename">{{ $pagetitle  }}</span></a>
                    </div>

                    <div class="mini_cart_wrapper text-right pull-right mt-3 mr-2">
                        <i class="fa fa-2x fa-shopping-cart mobile-cart"></i>
                        <span class="cart_quantity" style="color:#fff"></span>
                    </div>
                    @guest
                    @if (Route::has('login'))

                    @endif

                    @else
                    <div class="mini_cart_wrapper text-right pull-right mt-3 mr-4">
                        <i class="fa fa-2x fa-bell"></i>
                        <span class="" style="color:#fff">{{ auth()->user()->unreadNotifications->count()==0?'':auth()->user()->unreadNotifications->count() }}</span>
                    </div>
                   
                    @endguest
                    <div class="mini_cart_wrapper text-right pull-right mt-3 mr-4">
                        <a href="{{ route('accounts') }}"><i class="fa  fa-2x fa-user"></i></a>
                    </div>


                </div>
                <div class="main_menu menu_four header_position">
                    <nav>
                        <ul>
                            <li><a class="active" href="{{route('home') }}">@lang('home.home')</a></li>
                            <li><a href="{{route('allproducts') }}">@lang('home.product')</a></li>
                            <li><a href="blog.html">@lang('home.category')<i class="fa fa-angle-down"></i></a>
                                <ul class="sub_menu pages">
                                    @foreach($categories as $category)
                                    <li><a href="{{ route('product.categoryproduct',$category) }}">{{ $category->title }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="#">@lang('home.brand') <i class="fa fa-angle-down"></i></a>
                                <ul class="sub_menu pages">
                                    @foreach($brands as $brand)
                                    <li><a href="{{ route('product.brandproduct',$brand) }}">{{ $brand->title }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="{{ route('about') }}">about Us</a></li>
                            <li><a href="{{ route('contacts') }}"> Contact Us</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>