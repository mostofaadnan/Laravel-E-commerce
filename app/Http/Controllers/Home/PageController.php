<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
use App\Models\TermCondition;
use App\Models\FaqModel;
use App\Models\Brand;
use App\Models\Category;

class PageController extends Controller
{
    public function about(){
        $pagetitle='About';
        $brands = Brand::all();
        $categories = Category::all();
        return view('frontend.pages.about',compact('pagetitle','brands','categories'));
    }
    public function privacy(){
        $PrivacyPolicies=PrivacyPolicy::OrderBy('id','ASC')->get();
        $pagetitle='Privacy';
        $brands = Brand::all();
        $categories = Category::all();
        return view('frontend.pages.privacy',compact('pagetitle','PrivacyPolicies','brands','categories'));
    }
    public function term(){
        $TermConditions=TermCondition::OrderBy('id','ASC')->get();
        $pagetitle='Condition';
        $brands = Brand::all();
        $categories = Category::all();
        return view('frontend.pages.condition',compact('pagetitle','TermConditions','brands','categories'));
    }
    public function faq(){
        $faqs=FaqModel::OrderBy('id','ASC')->get();
        $pagetitle='FAQ';
        $brands = Brand::all();
        $categories = Category::all();
        return view('frontend.pages.faq',compact('pagetitle','faqs','brands','categories'));
    }
    public function payment(){
        $pagetitle='Payment';
        $brands = Brand::all();
        $categories = Category::all();
        return view('frontend.pages.payment',compact('pagetitle','brands','categories'));
    }
}
