<aside class="sidebar_widget">
    <div class="widget_inner">

        <div class="widget_list widget_categories">
            <h2>categories</h2>
            <ul>
                @foreach($categories as $category)
                <li>
                    <a href="{{ route('product.categoryproduct',$category) }}">{{ $category->title }}</a>
                </li>
                <hr class="hr-text">
                @endforeach

            </ul>
        </div>

        <div class="widget_list widget_categories">
            <h2>Brands</h2>
            <ul>
                @foreach($brands as $brand)
                <li>
                    <a href="{{ route('product.brandproduct',$brand) }}">{{  $brand->title }}</a>
                </li>
                <hr class="hr-text">
                @endforeach
            </ul>
        </div>
    </div>
    <div class="shop_sidebar_banner">
        @foreach($bannersside as $banner)
        <a href="#"><img src="{{asset('storage/app/public/banner/'.$banner->image)}}" alt=""></a>
        @endforeach
    </div>
</aside>