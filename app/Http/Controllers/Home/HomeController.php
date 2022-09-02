<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\slider;
use App\Models\banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\HomeProductCategory;
use App\Models\productSliderType;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
  public function index()
  {
    if (!Session::has('currency')) {
     $currency="AED";
    }else{
      $currency=Session::get('currency');
      
    }
    //dd($currency);
    $pagetitle="Home";
    $sliders = slider::all();
 /*    $banners = banner::where('type',2)->get(); */
    //$bannersbottom = banner::where('type',3)->get();
    $products = Product::all();
    $categories=Category::all();
    $brands=Brand::all();
    $productSliders=productSliderType::all();
    $HomeProductCategories=HomeProductCategory::all();
    return view('frontend.home.index', compact('sliders','currency','productSliders','products','categories','brands','HomeProductCategories','pagetitle'));
  }
}
