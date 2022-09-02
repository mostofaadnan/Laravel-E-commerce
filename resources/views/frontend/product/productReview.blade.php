<!-- <div class="proRev">
    <h2 id="review_head"></h2>
    <div class="Pro_reviews">
    </div>


    <div class="comment_title">
        <h2>Add a review </h2>
        <p>Your email address will not be published. Required fields are marked </p>
    </div>
    <div class="product_ratting mb-10">
        <h3>Your rating</h3>
        <ul>
            <li><a href="#"><i class="fa fa-star"></i></a></li>
            <li><a href="#"><i class="fa fa-star"></i></a></li>
            <li><a href="#"><i class="fa fa-star"></i></a></li>
            <li><a href="#"><i class="fa fa-star"></i></a></li>
            <li><a href="#"><i class="fa fa-star"></i></a></li>
        </ul>
    </div>
    <div class="product_review_form">

        <div class="row">
            <div class="col-12">
                <label for="review_comment">Your review </label>
                <textarea name="comment" id="review_comment"></textarea>
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="">Name</label>
                <input id="name" type="text" value="@if(auth::user()){{ Auth::user()->name }}@else @endif">

            </div>
            <div class="col-lg-6 col-md-6">
                <label for="email">Email </label>
                <input id="email" type="text" value="@if(auth::user()){{ Auth::user()->email }}@else @endif">
            </div>
        </div>
        <button id="submitdata">Submit</button>

    </div>

</div>
 -->



<div class="items-Reviews">
    <div class="comments-area">
        <h4>Comments<span id="total-review"></span></h4>
        <ul class="comment-list mt-30">
            <li>
                <div class="comment-detail Pro_reviews">
                </div>
                
            </li>
        </ul>
    </div>
    <hr>
    <div class="main-form mt-30">
        <h4>Leave a Comments</h4>
        <div class="row mt-30 mlr_-20">
            <div class="col-md-4 mb-20 plr-20">
                <input type="text" placeholder="Name" id="name" required>
            </div>
            <div class="col-md-4 mb-20 plr-20">
                <input type="email" id="email" placeholder="Email" required>
            </div>
            <div class="col-12 mb-20 plr-20">
                <textarea cols="30" rows="3" id="review_comment" placeholder="Message" required></textarea>
            </div>
            <div class="col-12 plr-20">
                <button class="btn btn-color" name="submit" type="submit" id="submitdata">Submit</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        function Reviews() {
            var id = "{{ $product->id }}";
            $.ajax({
                type: 'get',
                url: "{{ route('product.productreview') }}",
                data: {
                    id: id
                },
                datatype: 'json',
                success: function(data) {

                    LoadData(data);

                },
                error: function(data) {
                    console.log(data);
                }
            })

        }

        function LoadData(data) {
            $('.Pro_reviews').html("");
            var le = data.length;
            $("#total-review").html("(" + le + ")");
            // $("#review_head").html(le + " review for{{ $product->name }}")
            $.each(data, function(i, item) {
                var date = new Date(data[i].created_at);
                /*  var html = '<div class="reviews_comment_box">' +
                     '<div class="comment_text">' +
                     '<div class="reviews_meta">' +
                     '<div class="star_rating">' +
                     '<ul>' +
                     '<li><a href="#"><i class="ion-ios-star"></i></a></li>' +
                     '<li><a href="#"><i class="ion-ios-star"></i></a></li>' +
                     '<li><a href="#"><i class="ion-ios-star"></i></a></li>' +
                     '<li><a href="#"><i class="ion-ios-star"></i></a></li>' +
                     '<li><a href="#"><i class="ion-ios-star"></i></a></li>' +
                     '</ul>' +
                     '</div>' +
                     '<p><strong>' + data[i].review_name + ' </strong>- ' + date.toDateString() + '</p>' +
                     '<span>' + data[i].comment + '</span>' +
                     '<div id="reviewreplays' + data[i].id + '"></div>' +
                     '<hr><div class="product_review_form">' +
                     '<div class="row"><div class="col-12"><label for="inputGroupSelect01"><b>Reply</b></label>' +
                     '<textarea name="address" class="form-control" id="replaytext' + data[i].id + '" cols="30" rows="2" placeholder="">' +
                     '</textarea></div>' +
                     '<div class="col-lg-6 col-md-6 mb-2"><input type="text" placeholder="Name" id="replayname' + data[i].id + '" required></div><div class="col-lg-6 col-md-6"><input type="email" placeholder="email" id="replayemail' + data[i].id + '" required></div></div>' +
                     '<button  class="mt-2 pull-right replaysubmit" data-productid="' + data[i].product_id + '" data-id=' + data[i].id + '>Reply</button>' +
                     '</div>' +
                     '</div>' +
                     '</div>'
                 $('.Pro_reviews').append(html); */

                var html = '<div class="user-name">' + data[i].name + '</div>' +
                    '<div class="post-info">' +
                    '<ul>' +
                    '<li> ' + date.toDateString() + '</li>' +
                    '</ul>' +
                    '</div>' +
                    '<p>' + data[i].comment + '</p>' +
                    '<ul class="comment-list child-comment" id="reviewreplays' + data[i].id + '">'+
                    '</ul>'+
                    '<hr>'+
                    '<ul class="comment-list child-comment">' +
                    '<li>' +
                    '<div class="main-form mt-2">' +
                    '<div class="row mt-30 mlr_-20">' +
                    '<div class="col-md-3 mb-20 plr-20">' +
                    '<input type="text" placeholder="Name" id="replayname' + data[i].id + '" required>' +
                    '</div>' +
                    '<div class="col-md-3 mb-20 plr-20">' +
                    '<input type="email" id="replayemail' + data[i].id + '"  placeholder="Email" required>' +
                    '</div>' +
                    '<div class="col-md-6 mb-20 plr-20">' +
                    '<input type="text" id="replaytext' + data[i].id + '" placeholder="Reply" required>' +
                    '</div>' +
                    '<div class="col-12 mb-3">' +
                    '<button class="btn btn-color pull-right replaysubmit" name="submit" type="submit" data-productid="' + data[i].product_id + '" data-id=' + data[i].id + '>Reply</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</li>' +
                    '</ul>'
                $('.Pro_reviews').append(html);
               LoadReplay(data[i].reply);
       
            });

        }

        function LoadReplay(data) {
            $('#reviewreplays').html("");
            $.each(data, function(i, item) {
                var date = new Date(data[i].created_at);
                    var htmldata='<li>'+
                        '<div class="comment-detail">'+
                            '<div class="user-name">' + data[i].name + '</div>'+
                            '<div class="post-info">'+
                                '<ul>'+
                                    '<li>' + date.toDateString() + '</li>'+
                                    '<li><a href="#"><i class="fa fa-reply"></i>Reply</a></li>'+
                                '</ul>'+
                            '</div>'+
                            '<p>' + data[i].reply + '.</p>'+
                        '</div>'+
                    '</li>'
                $('#reviewreplays' + data[i].review_id + '').append(htmldata);
            });

        }

        function Replay(reviewid, productid) {
            var replay = $("#replaytext" + reviewid + "").val();
            var names = $("#replayname" + reviewid + "").val();
            var emails = $("#replayemail" + reviewid + "").val();
            if (replay == "" || name == "" || email == "") {
                swal('Error', 'Mark Field Requirment', 'error');
            } else {
                $.ajax({
                    type: 'post',
                    url: "{{ route('product.reviewreplys') }}",
                    data: {
                        reviewid: reviewid,
                        replay: replay,
                        name: names,
                        email: emails
                    },
                    datatype: 'json',
                    success: function(data) {
                        $("#replaytext" + reviewid + "").val("");
                        Reviews(productid)
                        // Reviews(data);
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        }

        $(document).on('click', ".replaysubmit", function() {
            var reviewid = $(this).data("id")
            var productid = $(this).data("productid")
            Replay(reviewid, productid);
        });

        function StoreReview() {
            var id = "{{ $product->id }}";
            var names = $("#name").val();
            console.log(name);
            var email = $("#email").val();
            var comment = $("#review_comment").val();
            if (name = "" || email == "" || comment == "") {
                swal('Error', 'Mark Field Requirment', 'error');
            } else {
                $.ajax({
                    type: 'post',
                    url: "{{ route('review.store') }}",
                    data: {
                        product_id: id,
                        name: names,
                        email: email,
                        comment: comment
                    },
                    datatype: 'json',
                    success: function(data) {
                        //  swal('Success', 'Review Succeccfuly Submit', 'success');
                        console.log(data);
                        clear();
                        Reviews();

                    },
                    error: function(data) {
                        console.log(data);
                    }


                });
            }


        }

        $(document).on('click', "#submitdata", function() {
            console.log("aa");
            StoreReview();

        });


        function clear() {
            $("#name").val("");
            $("#email").val("");
            $("#review_comment").val("")

        }
        window.onload = Reviews();
    });
</script>