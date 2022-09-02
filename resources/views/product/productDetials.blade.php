@extends('layouts.master')
@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<style>
  img {
    max-width: 100%;
  }

  .preview {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
  }

  @media screen and (max-width: 996px) {
    .preview {
      margin-bottom: 20px;
    }
  }

  .preview-pic {
    -webkit-box-flex: 1;
    -webkit-flex-grow: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
  }

  .preview-thumbnail.nav-tabs {
    border: none;
    margin-top: 15px;
  }

  .preview-thumbnail.nav-tabs li {
    width: 18%;
    margin-right: 2.5%;
  }

  .preview-thumbnail.nav-tabs li img {
    max-width: 100%;
    display: block;
  }

  .preview-thumbnail.nav-tabs li a {
    padding: 0;
    margin: 0;
  }

  .preview-thumbnail.nav-tabs li:last-of-type {
    margin-right: 0;
  }

  .tab-content {
    overflow: hidden;
  }

  .tab-content img {
    width: 100%;
    -webkit-animation-name: opacity;
    animation-name: opacity;
    -webkit-animation-duration: .3s;
    animation-duration: .3s;
  }

  .card {
    margin-top: 0px;
    background: #eee;
    padding: 3em;
    line-height: 1.5em;
  }

  @media screen and (min-width: 997px) {
    .wrapper {
      display: -webkit-box;
      display: -webkit-flex;
      display: -ms-flexbox;
      display: flex;
    }
  }

  .details {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
  }

  .colors {
    -webkit-box-flex: 1;
    -webkit-flex-grow: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
  }

  .product-title,
  .price,
  .sizes,
  .colors {
    text-transform: UPPERCASE;
    font-weight: bold;
  }

  .checked,
  .price span {
    color: #ff9f1a;
  }

  .product-title,
  .rating,
  .product-description,
  .price,
  .vote,
  .sizes {
    margin-bottom: 15px;
  }

  .product-title {
    margin-top: 0;
  }

  .size {
    margin-right: 10px;
  }

  .size:first-of-type {
    margin-left: 40px;
  }

  .color {
    display: inline-block;
    vertical-align: middle;
    margin-right: 10px;
    height: 2em;
    width: 2em;
    border-radius: 2px;
  }

  .color:first-of-type {
    margin-left: 20px;
  }

  .add-to-cart,
  .like {
    background: #ff9f1a;
    padding: 1.2em 1.5em;
    border: none;
    text-transform: UPPERCASE;
    font-weight: bold;
    color: #fff;
    -webkit-transition: background .3s ease;
    transition: background .3s ease;
  }

  .add-to-cart:hover,
  .like:hover {
    background: #b36800;
    color: #fff;
  }

  .not-available {
    text-align: center;
    line-height: 2em;
  }

  .not-available:before {
    font-family: fontawesome;
    content: "\f00d";
    color: #fff;
  }

  .orange {
    background: #ff9f1a;
  }

  .green {
    background: #85ad00;
  }

  .blue {
    background: #0076ad;
  }

  .tooltip-inner {
    padding: 1.3em;
  }

  @-webkit-keyframes opacity {
    0% {
      opacity: 0;
      -webkit-transform: scale(3);
      transform: scale(3);
    }

    100% {
      opacity: 1;
      -webkit-transform: scale(1);
      transform: scale(1);
    }
  }

  @keyframes opacity {
    0% {
      opacity: 0;
      -webkit-transform: scale(3);
      transform: scale(3);
    }

    100% {
      opacity: 1;
      -webkit-transform: scale(1);
      transform: scale(1);
    }
  }

  nav>.nav.nav-tabs {

    border: none;
    color: #fff;
    background: #272e38;
    border-radius: 0;

  }

  nav>div a.nav-item.nav-link,
  nav>div a.nav-item.nav-link.active {
    border: none;
    padding: 8px 5px;
    color: #fff;
    background: #272e38;
    border-radius: 0;
  }

  nav>div a.nav-item.nav-link.active:after {
    content: "";
    position: relative;
    bottom: -60px;
    left: -10%;
    border: 15px solid transparent;
    border-top-color: #e74c3c;
  }

  .tab-content {
    background: #fdfdfd;
    line-height: 25px;
    border: 1px solid #ddd;
    border-top: 5px solid #e74c3c;
    border-bottom: 5px solid #e74c3c;
    padding: 30px 25px;
  }

  nav>div a.nav-item.nav-link:hover,
  nav>div a.nav-item.nav-link:focus {
    border: none;
    background: #e74c3c;
    color: #fff;
    border-radius: 0;
    transition: background 0.20s linear;
  }

  .carousel-inner img {
    width: 100%;
    height: 100%
  }

  #custCarousel .carousel-indicators {
    position: static;
    margin-top: 20px
  }

  #custCarousel .carousel-indicators>li {
    width: 100px
  }

  #custCarousel .carousel-indicators li img {
    display: block;
    opacity: 0.5
  }

  #custCarousel .carousel-indicators li.active img {
    opacity: 1
  }

  #custCarousel .carousel-indicators li:hover img {
    opacity: 0.75
  }

  .carousel-item img {
    width: 80%
  }

  #descriptions {
    padding: 10px;
  }

  .item-list li {
    background: transparent;



    text-transform: UPPERCASE;
  }

  .item-list li>b {

    color: #26B99A;



  }
</style>
<div class="container">
  <div class="card-header profile-view">
    <div class="row">
      <div class="col-sm-6 col-md-6">

      </div>
      <div class="col-sm-6 col-md-6">
        <div class="input-group  mb-1">
          <div class="input-group-prepend">
            <span class="input-group-text" id="">@lang('home.search')</span>
          </div>
          <input type="text" class="form-control" id="search" placeholder="Search" list="product" required>
          <datalist id="product">
          </datalist>
        </div>
      </div>
    </div>
  </div>
  <div class="card">

    <div class="container-fliud">

      <div class="wrapper row">
        <div class="preview col-md-6">
          <div id="custCarousel" class="carousel" data-ride="carousel" align="center">
            <!-- slides -->
            <div class="carousel-inner">

              <!--
                <div class="carousel-item active"> <img src="#" id="imgProfile" alt="Hills"> </div>
              <div class="carousel-item"> <img src="https://i.imgur.com/Rpxx6wU.jpg" alt="Hills"> </div>
              <div class="carousel-item"> <img src="https://i.imgur.com/83fandJ.jpg" alt="Hills"> </div>
              <div class="carousel-item"> <img src="https://i.imgur.com/JiQ9Ppv.jpg" alt="Hills"> </div>
-->
            </div>

            <a class="carousel-control-prev" href="#custCarousel" data-slide="prev"> <span class="carousel-control-prev-icon"></span> </a> <a class="carousel-control-next" href="#custCarousel" data-slide="next"> <span class="carousel-control-next-icon"></span> </a>
            <ol class="carousel-indicators list-inline">
              <!--
            <li class="list-inline-item active"> <a id="carousel-selector-0" class="selected" data-slide-to="0" data-target="#custCarousel"> <img src="#" id="profile-fluid" class="img-fluid"> </a> </li>
              <li class="list-inline-item"> <a id="carousel-selector-1" data-slide-to="1" data-target="#custCarousel"> <img src="https://i.imgur.com/Rpxx6wU.jpg" class="img-fluid"> </a> </li>
              <li class="list-inline-item"> <a id="carousel-selector-2" data-slide-to="2" data-target="#custCarousel"> <img src="https://i.imgur.com/83fandJ.jpg" class="img-fluid"> </a> </li>
              <li class="list-inline-item"> <a id="carousel-selector-2" data-slide-to="3" data-target="#custCarousel"> <img src="https://i.imgur.com/JiQ9Ppv.jpg" class="img-fluid"> </a> </li>
                -->
            </ol>
          </div>

        </div>
        <div class="details col-md-6">
          <div class="row">
            <div class="col-sm-8">
              <h5 class="product-title" id="productname"></h5>
              <ul class="list-group item-list">
                <li class="list-group-item" id="openingdate"></li>
                <li class="list-group-item" id="barcode"></li>
                <li class="list-group-item" id="category"></li>
                <li class="list-group-item" id="subcategory"></li>
                <li class="list-group-item" id="brand"></li>
                <li class="list-group-item" id="unit"></li>
                <li class="list-group-item" id="tp"></li>
                <li class="list-group-item" id="mrp"></li>
                <li class="list-group-item" id="status"></li>
                <li class="list-group-item"><b>Color:</b>
                  <ul id="color"></ul>
                </li>
                <li class="list-group-item"><b>Size:</b>
                  <ul id="size"></ul>
                </li>
                <li class="list-group-item" id="currentqty"></li>
              </ul>
            </div>
            <div class="col-sm-4">
              <img src="#" id="imgProfile" class="rounded float-left img-thumbnail" alt="...">
            </div>
          </div>
          <hr>
          <div class="action">
            <div class="btn-group button-grp" role="group" aria-label="Basic example">
              <button class="btn btn-info" type="button" id="dataedit" data-id="{{ $id }}">EDIT</button>
              <button class="btn btn-danger" type="button" id="datadelete" data-id="{{ $id }}">DELETE</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<div class="container">
  <div class="row">
    <div class="col-xs-12 ">
      <nav>
        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Description</a>
          <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Review</a>

        </div>
      </nav>
      <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
          <div id="descriptions"></div>

        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
          <div class="reviews_wrapper">
            @include('product.partials.productReview')
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<script>
  var productid = 0;
  var table;
  var invoicetable;

  function ItemDatalist() {
    $.ajax({
      type: 'get',
      url: "{{ route('product.itemdatalist') }}",
      datatype: 'JSON',
      success: function(data) {
        $('#product').html(data);
      },
      error: function(data) {}
    });
  }
  window.onload = ItemDatalist();

  function ItemInformation(id) {
    $.ajax({
      type: 'get',
      data: {
        id: id
      },
      url: "{{ route('product.getDataById') }}",
      datatype: 'JSON',
      success: function(data) {

        productid = data.id;
        LoadData(data);
        ColorDetails(data.color_name);
        SizeDetails(data.size_name);
        var arrEdited = new Array();
        ImageRetrive(data.muli_image)
        CurrentStock();
        getOpening();
        Reviews(data.id)
      },
      error: function(data) {
        console.log(data);
      }
    });
  }
  window.onload = ItemInformation("{{$id}}");

  function LoadData(data) {
    $('#imgProfilev').attr('src', '');
    $('#profile-fluid').attr('src', '')
    var filename = 'ProductConfig-' + data.id + '.txt';

    var imagesrc = "{{ asset('storage/app/public/product/image/profile') }}/" + data.image;
    var file = "{{ asset('storage/app/public/product/description') }}/" + filename;

    $('#descriptions').load(file, function(data) { // dummy DIV to hold data 
      var line = data.split('\n')
    });
    $('#imgProfile').attr('src', imagesrc);
    $('#profile-fluid').attr('src', imagesrc);
    $("#productname").html(data.name);
    //  $("#productid").html(data.id);
    $("#barcode").html('<b>Barcode:</b> ' + data.barcode);
    $("#category").html('<b>Category:</b> ' + data.category_name['title']);
    data.subcategory_id > 0 ? $("#subcategory").html('<b>Sub-Category:</b> ' + data.subcategory_name['title']) : '';
    data.brand_id > 0 ? $("#brand").html('<b>Brand/Caompany:</b> ' + data.brand_name['title']) : '';
    $("#unit").html('<b>Unit:</b> ' + data.unit_name['Shortcut']);
    $("#openingdate").html('<b>Opening Date:</b> ' + data.openingDate);
    $("#tp").html('<b>TP:</b> TK' + data.tp);
    $("#mrp").html('<b>MRP:</b> TK' + data.mrp);
    /* $("#vatvalue").html(data.vat_name['value'] + '%')*/
    $("#status").html(data.status == 1 ? '<b>Status:</b> ' + 'Active' : '<b>Status:</b> ' + 'Inactive');
    $("#user").html(data.username['name']);
  }

  function ColorDetails(data) {

    data.forEach(function(value) {
      $("#color").append("<ul>" +
        "<li>" + value.color_name + "</li>");
    })
  }

  function SizeDetails(data) {

    data.forEach(function(value) {
      $("#size").append("<ul>" +
        "<li>" + value.size_name + "</li>");
    })

  }

  function ImageRetrive(datas) {
    $(".carousel-inner").empty();
    $(".list-inline").empty();
    var file = "{{ asset('storage/app/public/product/image/multiple') }}/";
    datas.forEach(function(value) {
      $(".carousel-inner").append("<div class='carousel-item'><img src='" + file + value.image + "' /></div>");
    });
    // NOW ADD THE .active TO FIRST ONE
    $('.carousel-inner').find('.carousel-item').eq(0).addClass('active');

    datas.forEach(function(values, index) {

      $(".list-inline").append("<li class='list-inline-item'><a id='carousel-selector-" + index + "' data-slide-to='" + index + "' data-target='#custCarousel'> <img src='" + file + values.image + "'  class='img-fluid'> </a> </li>");
    });
    $('.list-inline').find('.list-inline-item').eq(0).addClass('active');
  }
  $("#search").on('input', function() {
    var val = this.value;
    if ($('#product option').filter(function() {
        return this.value.toUpperCase() === val.toUpperCase();
      }).length) {
      productid = $('#product').find('option[value="' + val + '"]').attr('id');
      ItemInformation(productid);

    }
  });

  function Reviews(id) {

    $.ajax({
      type: 'get',
      url: "{{ route('product.productreview') }}",
      data: {
        id: id
      },
      datatype: 'json',
      success: function(data) {

        LoadReview(data);
      },
      error: function(data) {
        console.log(data);
      }
    })

  }

  function LoadReview(data) {
    $('.Pro_reviews').html("");
    var le = data.length;
    $("#total-review").html(le);

    $.each(data, function(i, item) {
      var date = new Date(data[i].created_at);
      var html = '<div class="reviews_comment_box">' +
        '<div class="comment_text">' +
        '<div class="reviews_meta">' +
        '<div class="row"><div class="col-sm-11"><p><strong>' + data[i].review_name + ' </strong>- ' + date.toDateString() + '</p></div><div class="col-sm-1"> <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>' +
        '<div class="dropdown-menu">' +
        '<a href="#" class="nav-link deletereview"  data-id="' + data[i].id + '" >Delete</a>' +
        '</div>' +
        '</div></div>' +
        '<span>' + data[i].comment + '</span>' +
        '<div id="reviewreplays' + data[i].id + '"></div>' +
        '<hr><div class="form-group mb-1">' +
        '<label for="inputGroupSelect01"><b>Reply</b></label>' +
        '<textarea name="address" class="form-control" id="replaytext' + data[i].id + '" cols="30" rows="2" placeholder="">' +
        '</textarea>' +
        '<button type="submit" class="btn btn-success mt-1 pull-right replaysubmit" data-productid="' + data[i].product_id + '" data-id=' + data[i].id + '>Reply</button>'
      '</div>' +
      '</div>' +
      '</div>' +
      '</div>'
      $('.Pro_reviews').append(html);
      LoadReplay(data[i].reply, data[i].product_id);
    });

  }

  function LoadReplay(data, productid) {
    //$('.reviewreplays').html("");
    $.each(data, function(i, item) {
      var date = new Date(data[i].created_at);
      var htmldata = '<hr><h5 style="color:blue">Reply:</h5><div class="reviews_comment_box" style="background:#fff" >' +
        '<div class="comment_text" >' +
        '<div class="reviews_meta">' +
        '<div class="row"><div class="col-sm-11"><p><strong>' + data[i].name + ' </strong>- ' + date.toDateString() + '</p></div><div class="col-sm-1"> <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>' +
        '<div class="dropdown-menu">' +
        '<a href="#" class="nav-link deleterply"  data-id="' + data[i].id + '" data-productid="' + productid + '" >Delete</a>' +
        '</div>' +
        '</div></div>' +
        '<span>' + data[i].reply + '</span>' +
        '</div>' +
        '</div>' +
        '</div>'
      $('#reviewreplays' + data[i].review_id + '').append(htmldata);
    });

  }

  function CurrentStock() {
    $.ajax({
      type: 'get',
      data: {
        id: productid
      },
      url: "{{ route('product.currentstock') }}",
      datatype: 'JSON',
      success: function(data) {
        data > 0 ? $("#currentqty").html('<span> Current Stock:' + data + '</span>') : $("#currentqty").html('<span style="color:red"><b>Current Stock:' + data + '</b></span>')
      },
      error: function(data) {}
    });
  }

  function getOpening() {
    $.ajax({
      type: 'get',
      url: "{{ url('Admin/Product/getopening')}}" + '/' + productid,
      datatype: 'JSON',
      success: function(data) {
        $('#qty').html(data);

      },
      error: function(data) {}
    });
  }

  $(document).on('click', '#datashowinvoice', function() {
    var id = $(this).data("id");
    url = "{{ url('Admin/Invoice/show')}}" + '/' + id,
      window.location = url;
  });


  function Replay(reviewid, productid) {
    var replay = $("#replaytext" + reviewid + "").val();
    if (replaytext = "") {
      swal('Error', 'Mark Field Requirment', 'error');
    } else {
      $.ajax({
        type: 'post',
        url: "{{ route('product.reviewreply') }}",
        data: {
          reviewid: reviewid,
          replay: replay,
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


  function clear() {

  }


  $(document).on('click', '.deletereview', function() {
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
            type: "post",
            url: "{{ url('Admin/Product/deleterReview')}}" + '/' + dataid,
            success: function(data) {
              Reviews(data);
            },
            error: function() {
              swal("Opps! Faild", "Form Submited Faild", "error");

            }
          });

          swal("Poof! Your imaginary file has been deleted!", {
            icon: "success",
          });
        } else {
          swal("Your imaginary file is safe!");
        }
      });


  });
  $(document).on('click', '.deleterply', function() {
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
          var productid = $(this).data("productid");
          $.ajax({
            type: "post",
            url: "{{ url('Admin/Product/deleterReply')}}" + '/' + dataid,
            success: function() {
              Reviews(productid);
            },
            error: function() {
              swal("Opps! Faild", "Form Submited Faild", "error");

            }
          });

          swal("Poof! Your imaginary file has been deleted!", {
            icon: "success",
          });
        } else {
          swal("Your imaginary file is safe!");
        }
      });


  });
  $(document).on('click', "#dataedit", function() {
    var dataid = $(this).data("id");
    url = "{{ url('Admin/Product/edit')}}" + '/' + dataid,
      window.location = url;
  });

  $(document).on('click', '#datadelete', function() {
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
            type: "post",
            url: "{{ url('Admin/Product/delete')}}" + '/' + dataid,
            success: function(data) {
              url = "{{ route('products')}}",
                window.location = url;
            },
            error: function() {
              swal("Opps! Faild", "Form Submited Faild", "error");

            }
          });

          swal("Poof! Your imaginary file has been deleted!", {
            icon: "success",
          });
        } else {
          swal("Your imaginary file is safe!");
        }
      });


  });
</script>
@endsection