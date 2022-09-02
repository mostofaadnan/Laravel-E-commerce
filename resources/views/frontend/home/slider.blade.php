
<section class="main-wrap">
    <div class="container">
        <div class="row mlr_-20">
            <div class="col-xl-3 col-lg-3 plr-20">
            </div>
            <div class="col-xl-9 col-lg-9 mt-20 plr-20 right-side float-none-sm float-right-imp">
                <!-- BANNER STRAT -->
                <section class="banner-main">
                    <div class="banner">
                        <div class="main-banner">
                        @foreach($sliders as $slider)
                            <div class="banner-1"> <img src="{{asset('storage/app/public/slider/'.$slider->image)}}" alt="Shopholic">
                                <div class="banner-detail">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-xl-6 col-7"></div>
                                            <div class="col-xl-6 col-5">
                                                <div class="banner-detail-inner">
                                                    <h1 class="banner-title">{{ $slider->title }}</h1>
                                                    <!-- <p>Top brands like Armour, Nike, adidas, Clarks, Puma, Red Tape, Bata Buy Online</p> -->
                                                </div>
                                                <a class="btn big-btn btn-color" href="shop.html">Shop Now!</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         @endforeach
                        
                        </div>
                    </div>
                </section>
                <!-- BANNER END -->
            </div>
        </div>
    </div>
</section>
