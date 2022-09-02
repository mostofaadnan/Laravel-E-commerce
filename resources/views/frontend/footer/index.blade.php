<!-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> -->
<div class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-sm-12 center-sm mb-sm-20">
                    <div class="f-logo">
                        <a href="index.html" class="">
                            <img src="{{asset('assets/frontend/images/logo.png')}}" alt="Shopholic">
                        </a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-sm-12 center-sm mb-sm-20 align-center">

                </div>
                <div class="col-xl-3 col-lg-3 col-sm-12 center-sm">
                    <div class="footer_social right-side float-none-md">
                        <ul class="social-icon">
                            <li><a title="Facebook" class="facebook"><i class="fa fa-facebook"></i></a></li>
                            <li><a title="Twitter" class="twitter"><i class="fa fa-twitter"></i></a></li>
                            <li><a title="Linkedin" class="linkedin"><i class="fa fa-linkedin"> </i></a></li>
                            <li><a title="RSS" class="rss"><i class="fa fa-rss"> </i></a></li>
                            <li><a title="Pinterest" class="pinterest"><i class="fa fa-pinterest"> </i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="footer-inner">
            <div class="footer-middle">
                <div class="row">
                    <div class="col-lg-6 f-col">
                        <div class="footer-static-block"> <span class="opener plus"></span>
                            <h3 class="title">Information<span></span></h3>
                            <ul class="footer-block-contant address-footer">
                                <li class="item"> <i class="fa fa-home"></i>
                                    <p>{{ $company->address }}</p>
                                </li>
                                <li class="item"> <i class="fa fa-phone"> </i>
                                    <p>{{ $company->mobile_no }}</p>
                                </li>
                                <li class="item"> <i class="fa fa-envelope"> </i>
                                    <p> <a href="#">{{ $company->companyemail }}</a> </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 f-col">
                        <div class="footer-static-block"> <span class="opener plus"></span>
                            <h3 class="title">Important Link<span></span></h3>
                            <ul class="footer-block-contant link">
                                <li><a href="{{ route('about') }}"><i class="fa fa-stop"></i>About Us</a></li>
                                <li><a href="{{ route('contacts') }}"><i class="fa fa-stop"></i>Contact Us</a></li>
                                <li><a href="#"><i class="fa fa-stop"></i>FAQ</a></li>
                                <li><a href="{{ route('privacy') }}"><i class="fa fa-stop"></i>Privacy</a></li>
                                <li><a href="{{ route('term') }}"><i class="fa fa-stop"></i>Terms & Condition</a></li>
                            </ul>
                        </div>
                    </div>

                    <!--    <div class="col-lg-3 f-col">
                                <div class="footer-static-block"> <span class="opener plus"></span>
                                    <h3 class="title">Clothes & Fashion<span></span></h3>
                                    <ul class="footer-block-contant link">
                                        <li><a href="#"><i class="fa fa-stop"></i>Baby Clothes</a></li>
                                        <li><a href="#"><i class="fa fa-stop"></i>Boys & Girls</a></li>
                                        <li><a href="#"><i class="fa fa-stop"></i>Men Fashion</a></li>
                                        <li><a href="#"><i class="fa fa-stop"></i>Women Fashion</a></li>
                                        <li><a href="#"><i class="fa fa-stop"></i>Shoes & Sandle</a></li>
                                    </ul>
                                </div>
                            </div> -->
                </div>
            </div>
        </div>
    </div>
    <div class="copy-right-bg">
        <div class="container">
            <div class="col-12">
                <div class="copy-right ">©2021 All Rights Reserved. Design By REEHA PERFUMES</div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function() {
       
        $(document).on('click', ".add-to-cart", function() {
            var dataid = $(this).data("id");
            $.ajax({
                type: "get",
                url: "{{ route('cart.addtocart') }}",
                data: {
                    id: dataid,
                },
                datatype: 'json',
                success: function(data) {
                    if (data == 1) {
                        /*   swal({
                              title: "Success",
                              text: "Add to cart",
                              timer: 2000,
                              icon: "success",
                              showConfirmButton: false,

                          }); */

                        swal("Success", "Add to cart", "success", {
                                buttons: {
                                    cancel: "Continue Shopping",
                                    Show: "Go To Checkout",
                                   /*  cancel: {
                                        text: "",
                                        
                                    }, */
                                    cancel:true,
                                },
                            })
                            .then((value) => {
                                switch (value) {
                                    case "Show":
                                        url = "{{ route('checkouts')}}",
                                            window.location.href=url;
                                        break;
                                   /*  case "catch":

                                        url = "{{ route('allproducts')}}",
                                            window.location.href =url;
                                        break; */
                                    default:
                                        //swal("Thank You For Your Choice");
                                }
                            });
                        LoadData()
                    } else {



                        swal("Sorry! Faild", "Stock Not Available", "error");
                    }

                },
                error: function(data) {
                    swal("Opps! Faild", "Form Submited Faild", "error");
                    console.log(data)
                }
            });
        });


        function LoadData() {
            $.ajax({
                type: "get",
                url: "{{ route('cart.getcart') }}",
                datatype: 'json',
                success: function(data) {
                    if (!$.trim(data)) {
                        $('.cart-load').hide();
                        $('.empty-lode').show();
                    } else {
                        $('.cart-load').show();
                        $('.empty-lode').hide();
                        LoadDataMinicart(data)
                        LoadDataMainCart(data)
                    }
                    //  $(".icon-shopping-cart").html("Tk " + data.totalprice + "");
                    $(".cart_quantity").html("" + data.totalqty + "");
                },
                error: function(data) {
                    swal("Opps! Faild", "Form Submited Faild", "error");
                    console.log(data)
                }
            });


        }

        function LoadDataMinicart(data) {

            $('.mincartAllItem').html('');
            $('.subtotal').html("AED " + data.totalprice);
            data = data.products;
            $.each(data, function(i, item) {
                var imagesrc;
                // $('#product-profile').attr('src', '');
                if (data[i].item['image'] !== null) {
                    imagesrc = "{{ asset('storage/app/public/product/image/profile') }}/" + data[i].item['image'];
                    // $('#product-profile').attr('src', imagesrc);
                }
                var link = '{{ route("product.productDetails", ":id") }}';
                link = link.replace(':id', data[i].item['id']);
                var html = '<li> <a class="close-cart carttrush" data-id="' + data[i].item['id'] + '"><i class="fa fa-times-circle"></i></a>' +
                    '<div class="media"> <a class="pull-left" href="' + link + '"> <img alt="Shopholic" src="' + imagesrc + '""></a>' +
                    '<div class="media-body"> <span><a href="' + link + '">' + data[i].item['name'] + '</a></span>' +
                    '<p class="cart-price">AED ' + data[i].price + '</p>' +
                    '<div class="product-qty">' +
                    '<label>Qty:</label>' +
                    '<div class="custom-qty">' +
                    '<input type="text" name="qty" value="' + data[i].qty + '" title="Qty" class="input-text qty">' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</li>'

                $('.mincartAllItem').append(html);
            });
        }

        function LoadDataMainCart(data) {
            $("#tablebody").empty();
            $('.subtotals').html('AED <b>' + data.totalprice + '</b>');
            datamain = data
            data = data.products;
            $.each(data, function(i, item) {
                var imagesrc;
                // $('#product-profile').attr('src', '');
                if (data[i].item['image'] !== null) {
                    imagesrc = "{{ asset('storage/app/public/product/image/profile') }}/" + data[i].item['image'];
                    // $('#product-profile').attr('src', imagesrc);
                }
                var link = '{{ route("product.productDetails", ":id") }}';
                link = link.replace(':id', data[i].item['id']);
                /*    var color = (data[i].color) == 'emp' ? " " : '<strong>Color:</strong>' + data[i].color;
                   var size = (data[i].size) == 'emp' ? " " : '<strong>Size:</strong>' + data[i].size;
                   $(".data-table tbody").append("<tr>" +
                           '<td class="product_remove"><a class="carttrush" data-id="' + data[i].item['id'] + '"><i class="fa fa-trash-o"></i></a></td>' +
                           '<td class="product_thumb"><a href="' + link + '"><img src="' + imagesrc + '" alt=""></a></td>' +
                           '<td class="product_name"><a href="' + link + '">' + data[i].item['name'] + '</a></td>' +
                           '<td class="product_name">' + color + '<br>' + size + '</td>' +
                           '<td class="product-price">TK ' + data[i].price + '</td>' +
                           '<td class="product_quantity"><label></label><button class="btn btn-default plus-btn add-to-cart" data-id="' + data[i].item['id'] + '" >+</button><input value="' + data[i].qty + '" type="text" disabled><button class="btn btn-default minus-btn carttrushbyone" data-id="' + data[i].item['id'] + '">-</button></td>' +
                           '<td class="product_total">TK ' + datamain.totalprice + '</td>' +
                           "</tr>").hide()
                       .fadeIn(1000); */

                $(".data-table tbody").append('<tr>' +
                        '<td><a href="' + link + '"><div class="product-image"><img alt="Shopholic" src="' + imagesrc + '"></div></a></td>' +
                        '<td><div class="product-title"><a href="' + link + '">' + data[i].item['name'] + '</a></div></td>' +
                        '<td><ul><li><div class="base-price price-box"><span class="price">AED ' + data[i].unitprice + '</span></div></li></ul></td>' +
                        '<td class="input-box"><label></label><button class="btn btn-default plus-btn add-to-cart" data-id="' + data[i].item['id'] + '" >+</button><input value="' + data[i].qty + '" type="text" disabled><button class="btn btn-default minus-btn carttrushbyone" data-id="' + data[i].item['id'] + '">-</button></td>' +
                        '<td><div class="total-price price-box"><span class="price">AED ' + datamain.price + '</span></div></td>' +
                        '<td><i title="Remove Item From Cart" data-id="' + data[i].item['id'] + '" class="fa fa-trash cart-remove-item carttrush"></i></td>' +
                        '</tr>').hide()
                    .fadeIn(1000);


            });
        }


        window.onload = LoadData();

        $(document).on("click", ".carttrush", function() {
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this  data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var dataid = $(this).data("id");
                        $.ajax({
                            type: "get",
                            url: "{{ url('Cart/removCart')}}" + '/' + dataid,
                            success: function() {
                                LoadData();
                            },
                            error: function() {
                                swal("Opps! Faild", "Form Submited Faild", "error");

                            }
                        });

                        swal("Poof! Your cart item has been deleted!", {
                            timer: 2000,
                            icon: "success",
                        });
                    } else {
                        swal("Your cart item file is safe!");
                    }
                });
        });

        $(document).on("click", ".carttrushbyone", function() {
            var dataid = $(this).data("id");
            $.ajax({
                type: "get",
                url: "{{ url('Cart/removCartByOne')}}" + '/' + dataid,
                success: function() {
                    LoadData();
                },
                error: function() {

                }
            });

        });
        $("#itemsearch").keyup(function() {

            var item = $("#itemsearch").val();
            if (!item == "") {
                $.ajax({

                    type: 'get',
                    data: {
                        search: item

                    },
                    url: "{{ route('product.itemdatalistsearch') }}",
                    datatype: 'JSON',
                    success: function(data) {
                        $('#productsearch').html(data);
                    },
                    error: function(data) {
                        console.log(data)
                    }
                });
            }

        });
        var down = false;
        $(document).on("click", "#bell", function(e) {
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
        $(document).on('click', ".notification-item", function() {
            var id = $(this).data("id")
            url = "{{ url('Notification/markAsRead')}}" + '/' + id,
                window.location = url;
        });
        $(document).on('click', '.mobile-cart', function() {
            url = "{{ route('carts')}}",
                window.location = url;

        });


        function AllProductLoad() {
            $.ajax({
                type: 'get',
                url: "{{ route('product.itemdatalistsearch') }}",
                datatype: 'JSON',
                success: function(data) {
                    $('#product').html(data);
                },
                error: function(data) {}
            });
        }
        window.onload = AllProductLoad();
        $('#currency').change(function() {
            console.log("helo");
            var currency = $(this).val();
            CurencyChange(currency);
        });

        function CurencyChange(currency) {

            $.ajax({
                type: "GET",
                url: "{{ route('product.currencyChange')}}",
                data: {
                    currency: currency,
                },
                success: function(res) {
                    location.reload();
                }
            });

        }
    });


    /*     function AllProductLoad() {

            $.ajax({
                type: "GET",
                url: "{{route('product.itemdatalist')}}",
                success: function(res) {
                    if (res) {
                        $("#search-category").empty();
                        $("#search-category").append('<option>Select</option>');
                        $.each(res, function(key, value) {
                            $("#search-category").append('<option value="' + key + '">' + value + '</option>');
                        });
                    } else {
                        $("#search-category").empty();
                    }
                }
            });

        } */
    /*     $(document).on('click', ".newssubmit", function() {

            var email = $(".newsemail").val();
            if (email == "") {

            } else {

                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (regex.test(email) == true) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('newslatter.store') }}",
                        data: {
                            email: email
                        },
                        success: function() {
                            swal("Succcse", "Thank you For become our subscriber", "success");
                            $(".newsemail").val("");

                        },
                        error: function() {
                            swal("!sorry", "Your are Already Subscribe", "error");
                        }

                    });

                } else {
                    swal("!Opps", "Your Email is not valid", "error");
                }
            }


        }); */
    /* 
        document.onreadystatechange = function() {
            var state = document.readyState

            if (state == 'complete') {
                setTimeout(function() {
                    document.getElementById('interactive');
                    document.getElementById('load').style.visibility = "hidden";
                }, 500);
            }
        } */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
</script>