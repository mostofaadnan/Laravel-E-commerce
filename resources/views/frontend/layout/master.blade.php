<?php $company = \App\Models\Company::where('id', 1)->first(); ?>
<!DOCTYPE html>
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->

<head>
  <!-- Basic Page Needs
      ================================================== -->
  <meta charset="utf-8">
  <title>{{ $company->name }}</title>
  <!-- SEO Meta
      ================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="distribution" content="global">
  <meta name="revisit-after" content="2 Days">
  <meta name="robots" content="ALL">
  <meta name="rating" content="8 YEARS">
  <meta name="Language" content="en-us">
  <meta name="GOOGLEBOT" content="NOARCHIVE">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="{{  $company->description}}">
  <!-- Mobile Specific Metas
      ================================================== -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <!-- CSS
      ================================================== -->
  @include('frontend.partials.style')
  <!--     <link rel="stylesheet" type="text/css" href="css/custom.css?v=1.3">
    <link rel="stylesheet" type="text/css" href="css/responsive.css?v=1.3"> -->
  <link rel="apple-touch-icon" sizes="57x57" href="{{asset('assets/images/apple-icon-57x57.png')}}">
  <link rel="apple-touch-icon" sizes="60x60" href="{{asset('assets/images/apple-icon-60x60.png')}}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{asset('assets/images/apple-icon-72x72.png')}}">
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/images/apple-icon-76x76.png')}}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{asset('assets/images/apple-icon-114x114.png')}}">
  <link rel="apple-touch-icon" sizes="120x120" href="{{asset('assets/images/apple-icon-120x120.png')}}">
  <link rel="apple-touch-icon" sizes="144x144" href="{{asset('assets/images/apple-icon-144x144.png')}}">
  <link rel="apple-touch-icon" sizes="152x152" href="{{asset('assets/images/apple-icon-152x152.png')}}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/images/apple-icon-180x180.png')}}">
  <link rel="icon" type="image/png" sizes="192x192" href="{{asset('assets/images/android-icon-192x192.png')}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/images/favicon-32x32.png')}}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/images/favicon-96x96.png')}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon-16x16.png')}}">
  <link rel="manifest" href="{{asset('assets/images/manifest.json')}}">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="{{asset('assets/images/ms-icon-144x144.png')}}">
  <meta name="theme-color" content="#ffffff">

</head>

<body class="homepage">
  <!-- <div class="se-pre-con"></div> -->
  <div id="newslater-popup" class="mfp-hide white-popup-block open align-center">
    <div class="nl-popup-main">
      <div class="nl-popup-inner">
        <div class="newsletter-inner">
          <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-8">
              <h2 class="main_title">join now</h2>
              <span>before it's too late</span>
              <p>Sing up now to receive this exclusive offer for a liited time only!</p>
              <form>
                <input type="email" placeholder="Email Here...">
                <button class="btn-black" title="Subscribe">Subscribe</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="main">
    <!-- PRODUCT-POPUP START -->
    @include('frontend.product.quickView')

    @include('frontend.partials.header')
    @yield('content')
    @include('frontend.footer.index')
    <!-- FOOTER END -->
  </div>
  <!--     <script src="js/jquery-1.12.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script> 
    <script src="js/bootstrap.js"></script>  
    <script src="js/jquery.downCount.js"></script>
    <script src="js/jquery-ui.min.js"></script> 
    <script src="js/fotorama.js"></script>
    <script src="js/jquery.magnific-popup.js"></script> 
    <script src="js/owl.carousel.min.js"></script>  
    <script src="js/custom.js"></script>

    <script>
      /* ------------ Newslater-popup JS Start ------------- */
      $(window).load(function() {
        $.magnificPopup.open({
          items: {src: '#newslater-popup'},type: 'inline'}, 0);
      });
        /* ------------ Newslater-popup JS End ------------- */
    </script> -->

  @include('frontend.partials.script')
  
  
</body>

</html>