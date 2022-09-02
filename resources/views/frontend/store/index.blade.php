@extends('frontend.layout.master')
@section('content')
<div class="banner inner-banner1">
    <div class="container">
        <section class="banner-detail center-xs">
            <h1 class="banner-title">Store Information</h1>
            <div class="bread-crumb right-side float-none-xs">
                <ul>
                    <li><a href="index.html"><i class="fa fa-home"></i>Home</a>/</li>
                    <li><span>Store Information</span></li>
                </ul>
            </div>
        </section>
    </div>
</div>
<!-- Bread Crumb END -->

<!-- CONTAIN START -->
<section class="ptb-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="blog-listing">
                    <div class="row mlr_-20">
                        @foreach($Stories as $store)
                        <div class="col-xl-4 col-lg-6 col-12 plr-20">
                            <div class="blog-item">
                                <div class="blog-media mb-20">
                                    <img src="{{asset('storage/app/public/CompanyStore/'.$store->image)}}" alt="{{ $store->name }}">
                                    <div class="blog-effect"></div>
                                    <a href="{{ route('storeInformation.details',$store->name) }}" title="Click For Read More" class="read">&nbsp;</a>
                                </div>
                                <div class="blog-detail">
                                    <h3><a href="{{ route('storeInformation.details',$store->name) }}">{{ $store->name }}</a></h3>
                                    <hr>
                                    <span class="post-date">{{ $store->address }}</span><br>
                                    <span class="post-date">{{ $store->mobile }}</span>
                                    <hr>
                                    <p>{{ $store->description }}</p>
                                    <!--  <hr>
                                    <div class="post-info">
                                        <ul>
                                            <li><span>By</span><a href="#"> cormon jons</a></li>
                                            <li><a href="#">(5) comments</a></li>
                                        </ul>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <!--   <div class="row">
                        <div class="col-12">
                            <div class="pagination-bar">
                                <ul>
                                    <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                                    <li class="active"><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection