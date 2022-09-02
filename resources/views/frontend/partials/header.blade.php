<header class="navbar navbar-custom container-full-sm" id="header">
  <div class="header-top">
    <div class="container">
      <div class="row m-0">
        <div class="col-12 col-md-6 col-sm-5 p-0">
          <div class="top-link top-link-left select-dropdown d-none d-sm-block">
            <fieldset>
              <select name="speed" class="countr option-drop">
                <option selected="selected">English</option>
                <option>Frence</option>
                <option>German</option>
              </select>
              <select name="speed" class="currenc option-drop" id="currency">
                <option selected="selected" value="AED">AED</option>
                <option value="USD">USD</option>
                <option value="EUR">EURO</option>
                <option value="GBP">POUND</option>
              </select>
            </fieldset>
          </div>
        </div>
        <div class="col-12 col-md-6 col-sm-7 p-0">
          <div class="top-right-link right-side d-none d-sm-block">
            <ul>
              <li class="info-link wishlist-icon content">
                <a href="{{ route('wishlists') }}" title="Wishlist">
                  <span></span>
                  Wish List</a>
              </li>
              <li class="info-link icon-text">
                <a href="{{ route('carts') }}" title="Compare">
                  <span></span>
                  Cart</a>
              </li>

            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="header-middle">
    <div class="container">
      <div class="row mlr_-20">
        <div class="col-xl-3 col-lg-3 col-sm-12 plr-20">
          <div class="header-middle-left">
            <div class="navbar-header border-right float-none-sm">
              <a class="navbar-brand page-scroll" href="{{ route('home') }}">
                <img alt="Shopholic" src="{{asset('assets/frontend/images/logo.png')}}">
              </a>
            </div>
          </div>
        </div>
        <div class="col-xl-9 col-lg-9 col-sm-12 plr-20">
          <div class="row">
            <div class="col-6 col-lg-12 login-part">
              <div class="right-call-part">
                <ul>
                  <li class="call-us-icon d-none d-md-block">
                    <a href="#">
                      <span></span>
                      <div class="call-us-text">
                        <div class="header-right-text">Call Us Now</div>
                        <div class="header-price">{{ $company->mobile_no}}</div>
                      </div>
                    </a>
                  </li>
                  <li class="login-icon content">
                    <a class="content-link">
                      <!-- <span class="content-icon"></span> -->
                      <i class="content-icon fa fa-bell"></i>
                    </a>
                    <div class="content-dropdown">
                      <ul>
                      </ul>
                    </div>
                  </li>
                  <li class="login-icon content">
                    <a class="content-link">
                      <span class="content-icon"></span>
                    </a>
                    <div class="content-dropdown">
                      <ul>
                        @guest
                        @if (Route::has('login'))
                        <li class="login-icon"><a href="{{ route('login') }}" title="Login"><i class="fa fa-user"></i> Login</a></li>
                        <li class="register-icon"><a href="{{ route('register') }}" title="Register"><i class="fa fa-user-plus"></i> Register</a></li>
                        @endif
                        @else
                        <li>
                        <li class="login-icon"><a href="{{ route('accounts') }}">{{ Auth::user()->name }}</a></li>
                        <li class="login-icon">
                          <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                          </a>
                          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                          </form>
                        </li>
                  </li>
                  @endguest
                </ul>
              </div>
              </li>
              <li class="side-toggle">
                <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button"><i class="fa fa-bars"></i></button>
              </li>
              </ul>
            </div>
          </div>
          <div class="col-xl-12 col-md-12">
            <div class="nav_sec position-r right-side float-none-md">
              <div class="mobilemenu-title mobilemenu">
                <span>Menu</span>
                <i class="fa fa-bars pull-right"></i>
              </div>
              <div class="mobilemenu-content">
                <ul class="nav navbar-nav" id="menu-main">
                  <li>
                    <a href="{{ route('home') }}"><span>Home</span></a>
                  </li>
                  <li class="level dropdown ">
                    <span class="opener plus"></span>
                    <a href="{{ route('allproducts') }}"><span>Our Products</span></a>
                  </li>
                  <li>
                    <a href="{{ route('about') }}"><span>About Us</span></a>
                  </li>
                  <li>
                    <a href="{{ route('storeInformations') }}"><span>Store Information</span></a>
                  </li>

                  <li>
                    <a href="{{ route('contacts') }}"><span>Contact</span></a>
                  </li>

                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="header-bottom">
    <div class="container">
      <div class="header-line">
        <div class="row position-r mlr_-20">
          <div class="col-lg-3 plr-20 bottom-part position-initial">
            <div class="sidebar-menu-dropdown">
              <a class="btn-sidebar-menu-dropdown"> Categories <i class="fa fa-bars"></i></a>
              <div id="cat" class="cat-dropdown">
                <div class="sidebar-contant">
                  <div id="menu" class="navbar-collapse collapse">
                    <div class="top-right-link mobile d-block d-sm-none">
                      <ul>
                        <li class="info-link wishlist-icon content">
                          <a title="Wishlist" href="{{ route('wishlists') }}">
                            <span></span>
                            Wish List</a>
                        </li>
                        <li class="info-link icon-text">
                          <a href="{{ route('carts') }}" title="Cart">
                            <span></span>
                            Cart</a>
                        </li>

                      </ul>
                    </div>
                    <ul class="nav navbar-nav custom-scrollbar-css p-2">
                      @foreach($categories as $cat)
                      <li class="level "><a href="{{ route('product.categoryproduct', $cat) }}" class="page-scroll"><i class="fa fa-chevron-right"></i>{{ $cat->title }}</a>
                      </li>
                      @endforeach
                    </ul>
                    <div class="header-top mobile d-block d-sm-none">
                      <div class="">
                        <div class="row">
                          <div class="col-12">
                            <div class="top-link top-link-left select-dropdown">
                              <fieldset>
                                <select name="speed" class="countr option-drop">
                                  <option selected="selected">English</option>
                                  <option>Frence</option>
                                  <option>German</option>
                                </select>
                                <select name="speed" class="currenc option-drop">
                                  <option selected="selected">USD</option>
                                  <option>EURO</option>
                                  <option>POUND</option>
                                </select>
                              </fieldset>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-9 plr-20 bottom-part">
            <div class="header-right-part">
              <div class="category-main">
                <div class="category-dropdown select-dropdown">
                  <fieldset>
                    <input type="text" class="form-control" id="search" placeholder="@lang('home.search')" list="product" autocomplete="off">
                    <datalist id="product">
                    </datalist>
                  </fieldset>
                </div>
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
              <div class="cart-box-main">
                <a href="#">
                  <span class="cart-icon-main"> <small class="cart-notification cart_quantity"></small> </span>
                  <div class="my-cart">My cart<br>$99.00</div>
                </a>
                <div class="cart-dropdown header-link-dropdown">
                  <ul class="cart-list link-dropdown-list mincartAllItem">
                  </ul>
                  <p class="cart-sub-totle"> <span class="pull-left">Cart Subtotal</span> <span class="pull-right"><strong class="price-box subtotal"></strong></span> </p>
                  <div class="clearfix"></div>
                  <div class="mt-20"> <a href="{{ route('carts') }}" class="btn-color btn">Cart</a>
                    <a href="{{ route('checkouts') }}" class="btn-color btn right-side">Checkout</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('frontend.partials.popup')
</header>