<div id="product_popup" class="quick-view-popup white-popup-block mfp-hide popup-position ">
    <div class="popup-detail">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 mb-xs-30">
                            <div class="fotorama modelmainimage" data-nav="thumbs" data-allowfullscreen="native">
                                <!--  <a href="#"><img src="{{asset('assets/frontend/images/1.jpg')}}" alt="Shopholic"></a>
                                <a href="#"><img src="{{asset('assets/frontend/images/images/2.jpg')}}" alt="Shopholic"></a>
                                <a href="#"><img src="{{asset('assets/frontend/images/images/3.jpg')}}" alt="Shopholic"></a>
                                <a href="#"><img src="{{asset('assets/frontend/images/images/4.jpg')}}" alt="Shopholic"></a>
                                <a href="#"><img src="{{asset('assets/frontend/images/images/5.jpg')}}" alt="Shopholic"></a>
                                <a href="#"><img src="{{asset('assets/frontend/images/images/6.jpg')}}" alt="Shopholic"></a>
                                <a href="#"><img src="{{asset('assets/frontend/images/images/4.jpg')}}" alt="Shopholic"></a>
                                <a href="#"><img src="{{asset('assets/frontend/images/images/5.jpg')}}" alt="Shopholic"></a>
                                <a href="#"><img src="{{asset('assets/frontend/images/images/6.jpg')}}" alt="Shopholic"></a> -->
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7">
                            <div class="row">
                                <div class="col-12">
                                    <div class="product-detail-main">
                                        <div class="product-item-details">
                                            <h1 class="product-item-name" id="product_header"></h1>
                                            <div class="rating-summary-block">
                                                <div title="53%" class="rating-result"> <span style="width:53%"></span> </div>
                                            </div>
                                            <div class="price-box" id="price-model">

                                            </div>
                                            <div class="product-info-stock-sku">
                                                <div>
                                                    <label>Availability: </label>
                                                    <span class="info-deta">In stock</span>
                                                </div>
                                                <div>
                                                    <label>SKU: </label>
                                                    <span class="info-deta">20MVC-18</span>
                                                </div>
                                            </div>
                                            <hr class="mb-20">
                                            <div id="descriptions"></div>
                                            <hr class="mb-20">
                                            <div class="mb-20">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-12">
                                                                <span>Qty:</span>
                                                            </div>
                                                            <div class="col-lg-9 col-md-12">
                                                                <div class="custom-qty">
                                                                    <button onclick="var result = document.getElementById('qty1'); var qty1 = result.value; if( !isNaN( qty1 ) &amp;&amp; qty1 &gt; 1 ) result.value--;return false;" class="reduced items" type="button"> <i class="fa fa-minus"></i> </button>
                                                                    <input type="text" class="input-text qty" title="Qty" value="1" maxlength="8" id="qty1" name="qty">
                                                                    <button onclick="var result = document.getElementById('qty1'); var qty1 = result.value; if( !isNaN( qty1 )) result.value++;return false;" class="increase items" type="button"> <i class="fa fa-plus"></i> </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="mb-20">
                                            <div class="mb-20">
                                                <div class="bottom-detail cart-button responsive-btn">
                                                    <ul id="cart-add">

                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="share-link">
                                                <label>Share This : </label>
                                                <div class="social-link">
                                                    <ul class="social-icon">
                                                        <li><a class="facebook" title="Facebook" href="#"><i class="fa fa-facebook"> </i></a></li>
                                                        <li><a class="twitter" title="Twitter" href="#"><i class="fa fa-twitter"> </i></a></li>
                                                        <li><a class="linkedin" title="Linkedin" href="#"><i class="fa fa-linkedin"> </i></a></li>
                                                        <li><a class="rss" title="RSS" href="#"><i class="fa fa-rss"> </i></a></li>
                                                        <li><a class="pinterest" title="Pinterest" href="#"><i class="fa fa-pinterest"> </i></a></li>
                                                    </ul>
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
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".productview").on('click', function() {
            var dataid = $(this).data("id");
            $("#price-model").empty();

            $.ajax({
                type: 'get',
                url: "{{ route('allproduct.getById') }}",
                data: {
                    dataid: dataid,
                },
                datatype: 'JSON',
                success: function(data) {
                    if (data) {
                        console.log(data)

                        $("#product_header").html(data.name);
                        var pricehtmlwithdiscount = '<span class="new_price">AED ' + data.mrp + '</span>' +
                            '<span class="old_price">AED ' + data.discount + '</span>';
                        var pricehtmlwithoutdiscount = '<span class="current_price">AED ' + data.mrp + '</span>';

                        if (data.discount > 0) {
                            $("#price-model").append(pricehtmlwithdiscount);
                        } else {
                            $("#price-model").append(pricehtmlwithoutdiscount);
                        }
                        var link = '{{ route("wishlist.addToWish", ":id") }}';
                        link = link.replace(':id', data.id);
                        var filename = 'ProductConfig-' + data.id + '.txt';
                        var file = "{{ asset('storage/app/public/product/description') }}/" + filename;
                        var cartHtml = ' <li class="pro-cart-icon">' +
                            '<a title="Add to Cart" class="btn btn-color add-to-cart" data-id="' + data.id + '"><span></span> Add to Cart</a>' +
                            '</li>' +
                            '<li class="pro-wishlist-icon"><a href="'+link+'" title="Wishlist"><span></span> Wishlist</a></li>'
                        $("#cart-add").append(cartHtml);
                        $('#descriptions').load(file, function(data) { // dummy DIV to hold data 
                            var line = data.split('\n')
                        });
                        ImageRetrive(data.muli_image)

                    } else {
                        itemclear();
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        function itemclear() {

        }

        function ImageRetrive(datas) {
            $(".modelmainimage").empty();
            var file = "{{ asset('storage/app/public/product/image/multiple') }}/";
            datas.forEach(function(value) {
                $(".modelmainimage").append("<a href='#'><img src='" + file + value.image + "' alt='Shopholic'></a>");
            });
            // NOW ADD THE .active TO FIRST ONE
            /* $('.modelmainimage').find('.tab-pane').eq(0).addClass('active'); */

            //thumbnail

            /*  datas.forEach(function(values, index) {
                 $(".itemlist").append("<li> <a class='nav-link' data-toggle='tab' href='#tab" + values.id + "' role='tab' aria-controls='tab" + values.id + "' aria-selected='false'><img src='" + file + values.image + "'></a></li>");
             });
             $('.itemlist').find('.nav-link').eq(0).addClass('active'); */
        }
    });
</script>