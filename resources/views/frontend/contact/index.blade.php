@extends('frontend.layout.master')
@section('content')

<!-- Bread Crumb STRAT -->
<div class="banner inner-banner1">
    <div class="container">
        <section class="banner-detail center-xs">
            <h1 class="banner-title">Contact</h1>
            <div class="bread-crumb right-side float-none-xs">
                <ul>
                    <li><a href="index.html"><i class="fa fa-home"></i>Home</a>/</li>
                    <li><span>Contact</span></li>
                </ul>
            </div>
        </section>
    </div>
</div>
<!-- Bread Crumb END -->

<!-- CONTAIN START ptb-95-->

<div class="contact_content">
<section class="pt-10">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="map">
                    <div class="map-part">
                        <div id="map" class="map-inner-part"></div>
                    </div>
                    <!--        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3608.0943152339264!2d55.315378014485745!3d25.267412535049992!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f5d7639921405%3A0x56624caf5ab8c182!2sReeha%20Perfumes%20Dubai!5e0!3m2!1sen!2sbd!4v1618853362406!5m2!1sen!2sbd"></iframe> -->
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3608.0943152339264!2d55.315378014485745!3d25.267412535049992!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f5d7639921405%3A0x56624caf5ab8c182!2sReeha%20Perfumes%20Dubai!5e0!3m2!1sen!2sbd!4v1618853362406!5m2!1sen!2sbd" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
    <section class="pt-10 client-main align-center">
        <div class="container">
            <div class="contact-info">
                <div class="row m-0">
                    <div class="col-md-4 p-0">
                        <div class="contact-box">
                            <div class="contact-icon contact-phone-icon"></div>
                            <span><b>Tel</b></span>
                            <p>{{ $company->mobile_no }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 p-0">
                        <div class="contact-box">
                            <div class="contact-icon contact-mail-icon"></div>
                            <span><b>Mail</b></span>
                            <p>{{ $company->companyemail }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 p-0">
                        <div class="contact-box">
                            <div class="contact-icon contact-open-icon"></div>
                            <span><b>Address</b></span>
                            <p>{{ $company->address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('frontend.contact.contactusform')

</div>

@endsection