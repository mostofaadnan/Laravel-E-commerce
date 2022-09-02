<div class="brand_area brand_three mb-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="brand_container owl-carousel">
                    @foreach($brands as $brand)
                    <div class="single_brand">
                        <a href="{{ route('product.brandproduct',$brand) }}"><img src="{{asset('storage/app/public/brand/'.$brand->image)}}" alt=""></a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>