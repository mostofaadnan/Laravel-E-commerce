<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Category;

class StoreController extends Controller
{
    public function index()
    {
        $Stories = Store::all();
        $categories = Category::all();
        return view('frontend.store.index', compact('Stories', 'categories'));
    }
    public function Details(Store $store){
        $Store = Store::find($store->id);
        $categories = Category::all();
        return view('frontend.store.details', compact('Store', 'categories'));
    }
}
