<style>
    .icon {
        cursor: pointer;
        margin-top: 5px;
    }

    .icon span {
        background: #f00;
        padding: 7px;
        border-radius: 50%;
        color: #fff;
        vertical-align: top;
        margin-left: -25px
    }

    .icon img {
        display: inline-block;
        width: 26px;
        margin-top: 4px
    }

    .icon:hover {
        opacity: .7
    }

    .logo {
        flex: 1;
        margin-left: 50px;
        color: #eee;
        font-size: 20px;
        font-family: monospace
    }

    .notifications {
        width: 300px;
        height: 0px;
        opacity: 0;
        position: absolute;
        right: 20px;

        background-color: #fff;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        z-index: 9999;
        overflow: hidden;
        margin-top: 22px;
    }

    .notifications h2 {
        font-size: 14px;
        padding: 10px;
        border-bottom: 1px solid #eee;
        color: #999
    }

    .notifications h2 span {
        color: #f00
    }

    .notifications-item {
        display: flex;
        border-bottom: 1px solid #eee;
        padding: 6px 9px;
        margin-bottom: 0px;
        cursor: pointer
    }

    .notifications-item:hover {
        background-color: #eee
    }

    .notifications-item img {
        display: block;
        width: 50px;
        height: 50px;
        margin-right: 9px;
        border-radius: 50%;
        margin-top: 2px
    }

    .notifications-item .text h6 {
        color: #777;

        margin-top: 3px
    }

    .notifications-item .text p {
        color: #000;
        font-size: 12px
    }
</style>
<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
            <a id="menu_toggle" style="color:#fff;"><i class="fa fa-bars"></i></a>
        </div>
        <nav class="nav navbar-nav">
            <ul class="navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile text-white" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                        <img src="{{asset('storage/app/public/user/'.Auth::user()->image)}}">
                    </a>
                    <div class="dropdown-menu dropdown-usermenu" aria-labelledby="navbarDropdown">
                        <div class="notifications-item"> <img src="{{asset('storage/app/public/user/'.Auth::user()->image)}}" alt="img">
                            <div class="text">
                                <h5>{{ Auth::user()->name }}</h5>
                                <p>{{ Auth::user()->email }}</p>

                            </div>
                        </div>

                        <a class="dropdown-item" href="{{ route('user.profile') }}"> <i class="fa fa-cog"></i>@lang('home.account')</a>

                        <a class="dropdown-item" href="{{ route('reset.password') }}"><i class="fa fa-key"></i> @lang('home.password') @lang('home.change')</a>


                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
             document.getElementById('logout-form').submit();"> <i class="fa fa-sign-out"></i> @lang('home.logout')
                        </a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </div>
                </li>


                <li class="nav-item" style="padding-left: 15px;">
                    <?php
                    $proreviewnotification = auth()->user()->Notifications
                        ->where('type', 'App\Notifications\ProductReviewNotification')
                        ->all();

                    $proreviewnotificationunread = auth()->user()->unreadNotifications
                        ->where('type', 'App\Notifications\ProductReviewNotification')
                        ->all();
                    ?>
                    <i class="fa fa-bell fa-x icon" id="bell"></i><span class="badge badge-pill badge-danger">{{ count($proreviewnotificationunread) }}</span>
                    <div class="notifications" id="box">
                        <h2>Notifications - <span>{{ count($proreviewnotificationunread) }}</span></h2>
                        @foreach($proreviewnotification as $notify)
                        @if($notify->read_at==null)
                        <div class="notifications-item product_review bg-gray" data-id="{{ $notify->id }}">
                            @else
                            <div class="notifications-item product_review" data-id="{{ $notify->id }}">
                                @endif
                                <div class="text">
                                    <h5 style="color:red;">Product Review</h5>
                                    <p>{{ $notify->data['message'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                </li>
                <li class="nav-item" style="padding-left: 15px;">
                    <?php
                    $proreviewnotification = auth()->user()->Notifications
                        ->where('type', 'App\Notifications\MessageNotification')
                        ->all();

                    $proreviewnotificationunread = auth()->user()->unreadNotifications
                        ->where('type', 'App\Notifications\MessageNotification')
                        ->all();
                    ?>
                    <i class="fa fa-envelope fa-x icon" id="message"></i><span class="badge badge-pill badge-danger">{{ count($proreviewnotificationunread)  }}</span>
                    <div class="notifications" id="box-message">
                        <h2>Notifications - <span>{{ count($proreviewnotificationunread) }}</span></h2>
                        @foreach($proreviewnotification as $notify)
                        @if($notify->read_at==null)
                        <div class="notifications-item message bg-gray" data-id="{{ $notify->id }}">
                            @else
                            <div class="notifications-item message" data-id="{{ $notify->id }}">
                                @endif
                                <div class="text">
                                    <h5 style="color:red;">Contact</h5>
                                    <p>{{ $notify->data['message'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                </li>
                <li class="nav-item" id="delivery" style="padding-left: 15px;">
                    <i class="fa fa-truck icon"></i><span class="badge badge-pill badge-danger countDelivery"></span>
                    <div class="notifications" id="delivery-item">
                        <h2>Total Delivery(Waiting) - <span class="countDelivery"></span></h2>
                        <div class="deliveries my-custom-scrollbar"></div>
                    </div>
                </li>
                <li class="nav-item" id="cart" style="padding-left: 15px;">
                    <i class="fa fa-shopping-cart icon"></i><span class="badge badge-pill badge-danger countOrder"></span>
                    <div class="notifications" id="cart-item">
                        <h2>Total New Order - <span class="countOrder"></span></h2>
                        <div class="carts my-custom-scrollbar"></div>
                    </div>
                </li>

                <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Language<span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ url('locale/en')}}">English</a></li>
                        <div class="dropdown-divider"></div>
                        <li><a class="dropdown-item" href="{{ url('locale/bn')}}">Bangla</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
<script>
    $(document).ready(function() {
        var down = false;
        var down1 = false;
        var down2 = false;

        $('#bell').click(function(e) {
            var color = $(this).text();
            if (down) {
                $('#box').css('height', '0px');
                $('#box').css('opacity', '0');
                down = false;
            } else {

                $('#box').css('height', 'auto');
                $('#box').css('opacity', '1');
                down = true;


            }

        });


        $('#cart').click(function(e) {
            var color = $(this).text();
            if (down1) {
                $('#cart-item').css('height', '0px');
                $('#cart-item').css('opacity', '0');
                down1 = false;
            } else {
                $('#cart-item').css('height', 'auto');
                $('#cart-item').css('opacity', '1');
                down1 = true;
            }

        });
        $('#delivery').click(function(e) {
            var color = $(this).text();
            if (down2) {
                $('#delivery-item').css('height', '0px');
                $('#delivery-item').css('opacity', '0');
                down2 = false;
            } else {
                $('#delivery-item').css('height', 'auto');
                $('#delivery-item').css('opacity', '1');
                down2 = true;
            }

        });
        $('#message').click(function(e) {
            var color = $(this).text();
            if (down) {
                $('#box-message').css('height', '0px');
                $('#box-message').css('opacity', '0');
                down = false;
            } else {

                $('#box-message').css('height', 'auto');
                $('#box-message').css('opacity', '1');
                down = true;


            }

        });

        function LoadNotification() {
            $.ajax({
                type: 'get',
                url: "{{ route('order.loadnotification') }}",
                datatype: 'json',
                success: function(data) {
                    //console.log(data);

                    loadData(data);
                },
                error: function() {


                }

            });
        }

        function loadData(data) {
            $('.countOrder').html(data.length)
            $(".carts").html('');
            data.forEach(function(value) {
                var html = '<div class="notifications-item newOrder " data-id="' + value.id + '">' +
                    '<div class="text">' +
                    '<div><h5 style="color:red;" class="pull-left">New Order</h5><p class="pull-right">' + value.inputdate + '</p></div>' +
                    '<h6  class="pull-left">' + value.customer_name['name'] + ' Make New Order</h6>' +
                    '<div><p class="pull-left" style="color:tomato; margin-right:5px; margin-bottom:5px"><b>Invoice No:#' + value.invoice_no + '</b></p></div>' +
                    '<p class="pull-left" style="color:tomato"><b>Amount:' + value.nettotal + '</b></p>' +
                    '</div>' +
                    '</div>'
                $(".carts").append(html);
            });
        }

        function LoadDeliveryNotification() {
            $.ajax({
                type: 'get',
                url: "{{ route('order.deliverloadnotification') }}",
                datatype: 'json',
                success: function(data) {
                   
                    loadDataorder(data);
                },
                error: function() {}

            });
        }


        function loadDataorder(data) {
            $('.countDelivery').html(data.length)
            $(".deliveries").html('');
            data.forEach(function(value) {
                var html = '<div class="notifications-item deliveryOrder" data-id="' + value.id + '">' +
                    '<div class="text">' +
                    '<h5 style="color:red;" class="pull-left">Delivery Waiting</h5><p class="pull-right">' + value.inputdate + '</p>' +
                    '<h6  class="pull-left">' + value.customer_name['name'] + ' Recieved Order.Waiting for delivery</h6>' +
                     '<div>'+
                    '<p class="pull-left" style="color:tomato;margin-right:5px;margin-bottom:5px"><b>Invoice No:#' + value.invoice_no + '</b></p><br>' +
                    '<p class="pull-left" style="color:tomato"><b>Amount:' + value.nettotal + '</b></p><br>' +
                    '</div><div>'+
                    '<p class="pull-left"><b>Delivery Date:' + value.	delivery_date + '</b></p>' +
                    '</div></div>' +
                    '</div>'
                $(".deliveries").append(html);
            });
        }
        $(document).on('click', ".newOrder", function() {
            var id = $(this).data("id")
            url = "{{ url('Admin/Order/show')}}" + '/' + id,
                window.location = url;

        });
        $(document).on('click', ".deliveryOrder", function() {
            var id = $(this).data("id")
            url = "{{ url('Admin/Order/OrderDelivery')}}" + '/' + id,
                window.location = url;

        });
        $(document).on('click', ".product_review", function() {
            var id = $(this).data("id")
            url = "{{ url('Admin/Notifications/markAsRead')}}" + '/' + id,
                window.location = url;
        });

        $(document).on('click', ".message", function() {
            var id = $(this).data("id")
            url = "{{ url('Admin/Notifications/markAsReadmessage')}}" + '/' + id,
                window.location = url;
        });
        window.onload = LoadNotification();
        window.onload = LoadDeliveryNotification();
        setInterval(function() {
            LoadNotification()
        }, 10000);
    });
</script>