<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {

        $products = Product::all();
        $categories = Category::all();
        return response()->json([
            'products' => $products,
            'categories' => $categories
        ]);
    }
}
