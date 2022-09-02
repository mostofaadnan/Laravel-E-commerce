<section class="featured_categories mb-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_title">
                    <h2>@lang('home.popular') @lang('home.category')</h2>
                </div>
                <div class="featured_container">
                    <div class="featured_carousel featured_column4 owl-carousel">
                        @foreach($categories as $category)
                        <div class="single_items">
                            <div class="single_featured">
                                <div class="featured_thumb">
                                    <a href="#"><img src="{{asset('storage/app/public/category/'.$category->image)}}" alt=""></a>
                                </div>
                                <div class="featured_content">
                                    <h3 class="product_name"><a href="{{ route('product.categoryproduct',$category) }} ">{{ $category->title }}</a></h3>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>