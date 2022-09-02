@extends('frontend.layout.master')
@section('content')

<div class="banner inner-banner1">
    <div class="container">
        <section class="banner-detail center-xs">
            <h1 class="banner-title">Terms & Conditions</h1>
            <div class="bread-crumb right-side float-none-xs">
                <ul>
                    <li><a href="index.html"><i class="fa fa-home"></i>Home</a>/</li>
                    <li><span>Terms & Conditions</span></li>
                </ul>
            </div>
        </section>
    </div>
</div>
<!--breadcrumbs area end-->

<!--Privacy Policy area start-->
<div class="privacy_policy_main_area ">
    <div class="container">
        <div class="row">
            <div class="col-12 main_content">
                <h3 align="center" style="color: #fdb813;">Terms & Conditions</h3>
                <hr>
                @foreach($TermConditions as $term)
                <div class="privacy_content section_2">
                    <h3>{{ $term->name }}</h3>
                    <p style="text-align:justify;">{{ $term->description }}</p>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
@endsection