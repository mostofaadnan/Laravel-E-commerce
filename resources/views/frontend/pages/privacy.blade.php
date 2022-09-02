@extends('frontend.layout.master')
@section('content')

<div class="banner inner-banner1">
    <div class="container">
        <section class="banner-detail center-xs">
            <h1 class="banner-title">Privacy policy</h1>
            <div class="bread-crumb right-side float-none-xs">
                <ul>
                    <li><a href="index.html"><i class="fa fa-home"></i>Home</a>/</li>
                    <li><span>privacy policy</span></li>
                </ul>
            </div>
        </section>
    </div>
</div>
<!--breadcrumbs area end-->

<!--Privacy Policy area start-->
<div class="privacy_policy_main_area">
    <div class="container">
        <div class="row main_content">
            <div class="col-12">
                <h3 align="center" style="color:#fdb813;">Privacy Policy</h3>
                <div class="privacy_content section_3">
                <p style="text-align:justify;">
                Ajmal International Trading Co. LLC, a company incorporated and REGISTERED in Dubai, UAE and (who we refer to as "we", "us" and "our" below), take your privacy very seriously. This Privacy Statement explains what personal information we collect, how and when it is collected, what we use it for now and how we will use it in the FUTURE and details of the circumstances in which we may disclose it to third parties. If you have any questions about the way in which your information is being collected or used which are not answered by this Privacy Statement and/or any complaints please contact us on estore@ajmal.net</p>
                </div>
                <hr>
                @foreach($PrivacyPolicies as $policy)
                <div class="privacy_content section_3">
                    <h3>{{ $policy->name }}</h3>
                    <p style="text-align:justify;">{{ $policy->description }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection