<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\productColor;
use App\Models\productSize;
use Session;
use App\Models\Brand;
use App\Models\Category;

class CartController extends Controller
{
    public function index()
    {
        $pagetitle="Cart";
        $brands = Brand::all();
        $categories = Category::all();
        return view('frontend.cart.index',compact('pagetitle','categories','brands'));
    }

    public function addToCart(Request $request)
    {

        $id = $request->id;
        $product = Product::find($id);
       // $stock = $this->checkQuantity($product);
       /*  if ($stock > 0) { */
            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            $cart = new Cart($oldCart);
            $cart->add($product, $product->id);
            $request->session()->put('cart', $cart);
            $message = 1;
      /*   } else {
            $message = 0;
        } */
        return response()->json($message);
    }

    public function checkQuantity($product)
    {
        $openigqty = $product->openingStock()->sum('qty');
        $invoice = $product->QuantityOutBySale()->sum('qty');
        $invoiceReturn = $product->QuantityOutBySaleReturn()->sum('qty');
        $totalinvoiceqty = $invoice - $invoiceReturn;
        $purchase = $product->QuantityOutByPurchase()->sum('qty');
        $PurchaseReturn = $product->QuantityOutByPurchaseReturn()->sum('qty');
        $totalPurchaseqty = $purchase - $PurchaseReturn;
        $stock = $openigqty + ($totalPurchaseqty - $totalinvoiceqty);
        return $stock;
    }

    public function RemoveItem($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }

        return back();
    }

    public function RemoveItemByOne($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItemByOne($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        return back();
    }

    public function getCartItem()
    {

        $data['products'] = Session::has('cart') ? Session::get('cart')->items : null;
        $data['totalprice'] = Session::has('cart') ? Session::get('cart')->totalPrice : '';
        $data['totalqty'] = Session::has('cart') ? Session::get('cart')->totalQty : '0';
        return response()->json($data);
    }
}
