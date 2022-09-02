@extends('frontend.layout.master')
@section('content')
<div class="banner inner-banner1">
    <div class="container">
        <section class="banner-detail center-xs">
            <h1 class="banner-title">{{ $Store->name }}</h1>
            <div class="bread-crumb right-side float-none-xs">
                <ul>
                    <li><a href="{{ route('home') }}"><i class="fa fa-home"></i>Home</a>/</li>
                    <li><a href="{{ route('storeInformations') }}">Store Information</a>/</li>
                    <li><span>{{ $Store->name }}</span></li>
                </ul>
            </div>
        </section>
    </div>
</div>
<!-- Bread Crumb END -->

<!-- CONTAIN START -->
<section class="ptb-60">
    <div class="container">
        <div class="row mlr_-20">
            <div class="col-lg-12 plr-20">
                <div class="row">
                    <div class="col-12 mb-10">
                        <div class="blog-media mb-20">
                            <img src="{{asset('storage/app/public/CompanyStore/'.$Store->image)}}" alt="{{ $Store->name }}">
                        </div>
                        <div class="blog-detail ">

                            <h3>{{ $Store->name }}</h3>
                            <p>{{ $Store->description }}</p>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="pt-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="map">
                    <div class="map-part">
                        <div id="map" class="map-inner-part"></div>
                    </div>
                    <iframe src="{{ $Store->googleMap }}" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="pt-10 client-main align-center mb-20">
    <div class="container">
        <div class="contact-info">
            <div class="row m-0">
                <div class="col-md-4 p-0">
                    <div class="contact-box">
                        <div class="contact-icon contact-phone-icon"></div>
                        <span><b>Tel</b></span>
                        <p>{{ $Store->mobile }}</p>
                    </div>
                </div>
                <div class="col-md-4 p-0">
                    <div class="contact-box">
                        <div class="contact-icon contact-mail-icon"></div>
                        <span><b>Mail</b></span>
                        <p>{{ $Store->email }}</p>
                    </div>
                </div>
                <div class="col-md-4 p-0">
                    <div class="contact-box">
                        <div class="contact-icon contact-open-icon"></div>
                        <span><b>Address</b></span>
                        <p>{{ $Store->address }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




@endsection