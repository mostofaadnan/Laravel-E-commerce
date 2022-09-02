<div class="banner_area mb-60">
    <div class="container">
        <div class="row">
            @foreach($banners as $banner)
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="single_banner">
                    <div class="banner_thumb">
                        <a href="#"><img src="{{asset('storage/app/public/banner/'.$banner->image)}}" alt=""></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>