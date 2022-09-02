<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Wish;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class WishlistController extends Controller
{
    public function index()
    {
        $pagetitle = "Wishlist";
        $brands = Brand::all();
        $categories = Category::all();
        if (!Session::has('wish')) {
            return view('frontend.wish.index', [
                'products' => null,
                'pagetitle' => $pagetitle,
                'brands' => $brands,
                'categories' => $categories
            ]);
        }
        $oldCart = Session::get('wish');
        $cart = new Wish($oldCart);

        return view('frontend.wish.index', [
            'products' => $cart->items,
            'pagetitle' => $pagetitle,
            'categories' => $categories
        ]);
    }

    public function addToWish(Request $request, $id)
    {


        $product = Product::find($id);

        $oldCart = Session::has('wish') ? Session::get('wish') : null;
        $cart = new Wish($oldCart);

        $cart->add($product, $product->id);
        $request->session()->put('wish', $cart);



        //dd($request->session()->get('cart'));
        return back();
    }


    public function RemoveItem($id)
    {
        $oldCart = Session::has('wish') ? Session::get('wish') : null;
        $cart = new Wish($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0) {
            Session::put('wish', $cart);
        } else {
            Session::forget('wish');
        }
        return back();
    }
}
