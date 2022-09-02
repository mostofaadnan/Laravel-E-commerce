<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CustomerReview;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\ReviewReply;
use App\Models\banner;
use Illuminate\Support\Facades\Session;

class ProductControllers extends Controller
{

    public function index()
    {
        $pagetitle = 'Products';
        $products = Product::paginate(100);
        $brands = Brand::all();
        $categories = Category::all();

        $countpro = Product::withCount('categoryName')->get();
        return view('frontend.product.index', compact('products', 'categories', 'brands', 'pagetitle'));
    }

    public function productDetails(Product $product)
    {


        $pagetitle = 'Details';
        $brands = Brand::all();
        $categories = Category::all();
        // $product = Product::find($id);
        $title = $product->name;
        $RelatedProducts = Product::where('category_id', $product->category_id)->get();
        return view('frontend.product.productDetails', compact('product', 'RelatedProducts', 'title', 'pagetitle', 'categories', 'brands'));
    }

    public function getByid(Request $request)
    {
        $id = $request->dataid;
        $product = Product::with('CategoryName', 'SubcategoryName', 'UnitName', 'BrandName', 'VatName', 'username','MuliImage')->find($id);
        return response()->json($product);
    }

    public function CurrentStock($productid)
    {
        $id = $productid;
        $products = Product::find($id);
        $openigqty =  $products->openingStock()->sum('qty');
        $invoice = $products->QuantityOutBySale()->sum('qty');
        $invoiceReturn = $products->QuantityOutBySaleReturn()->sum('qty');
        $totalinvoiceqty = $invoice - $invoiceReturn;
        $purchase = $products->QuantityOutByPurchase()->sum('qty');
        $PurchaseReturn = $products->QuantityOutByPurchaseReturn()->sum('qty');
        $totalPurchaseqty = $purchase - $PurchaseReturn;
        $stock = $openigqty + ($totalPurchaseqty - $totalinvoiceqty);
        return $stock;
        // return response()->json($stock);
    }

    public function productReview(Request $request)
    {
        $id = $request->id;
        $review = CustomerReview::with('Reply')->where('product_id', $id)->get();
        return response()->json($review);
    }
    public function ReviewReply(Request $request)
    {
        $ReviewReply = new ReviewReply();
        $ReviewReply->review_id = $request->reviewid;
        $ReviewReply->reply = $request->replay;
        $ReviewReply->name = $request->name;
        $ReviewReply->email = $request->email;
        $ReviewReply->save();
        return response()->json($request->reviewid);
    }
    public function ReviewReplay(Request $request)
    {
        $id = $request->id;
        $replay = ReviewReply::where('review_id', $id)->get();
        return response()->json($replay);
    }


    public function CategoryProduct(Category $category)
    {

        $pagetitle = 'Products';
        $products = Product::where('category_id', $category->id)->paginate(14);
        $brands = Brand::all();
        $categories = Category::all();


        //   $countpro = Product::withCount('categoryName')->get();
        return view('frontend.product.categoryProduct', compact('products', 'categories', 'category', 'brands', 'pagetitle'));
    }

    public function SubCategoryProduct(Subcategory $subcategory)
    {
        $pagetitle = 'Products';

        $bannersside = banner::where('type', 1)->get();
        $products = Product::where('subcategory_id', $subcategory->id)->paginate(14);
        $brands = Brand::all();
        $categories = Category::all();
        $countpro = Product::withCount('categoryName')->get();
        return view('frontend.product.subcategoryProduct', compact('products', 'categories', 'subcategory', 'brands', 'pagetitle', 'bannersside'));
    }

    public function BrandProduct(Brand $brand)
    {
        $pagetitle = 'Products';
        $brands = Brand::all();
        $categories = Category::all();
        $bannersside = banner::where('type', 1)->get();
        $category = $brand;
        $products = Product::where('brand_id', $brand->id)->paginate(14);
        $countpro = Product::withCount('categoryName')->get();
        return view('frontend.product.categoryProduct', compact('products', 'categories', 'category', 'brands', 'pagetitle' . 'bannersside'));
    }

    public function ItemDataList(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::where('status', 1)->orderBy("id", 'asc')->Where('name', 'LIKE', "%{$request->search}%")->get();
            $Categories = Category::orderBy("id", 'asc')->Where('title', 'LIKE', "%{$request->search}%")->get();
            return view('datalist.itemlistsearch', compact('products', 'Categories'))->render();
        }
    }

    function Search(Request $request)
    {
        $data = $request->search;
        $pagetitle = "Serch";
        $products = Product::query()
            ->Where('name', 'LIKE', "%{$data}%")
            ->OrwhereHas('CategoryName', function ($query) use ($data) {
                $query->where('title', 'LIKE', "%{$data}%");
            })
            ->OrwhereHas('SubcategoryName', function ($query) use ($data) {
                $query->where('title', 'LIKE', "%{$data}%");
            })
            ->OrwhereHas('BrandName', function ($query) use ($data) {
                $query->where('title', 'LIKE', "%{$data}%");
            })
            ->paginate(14);
        $bannersside = banner::where('type', 1)->get();
        $brands = Brand::all();
        $categories = Category::all();
        $countpro = Product::withCount('categoryName')->get();
        return view('frontend.product.searchProduct', compact('products', 'categories', 'brands', 'data', 'pagetitle', 'bannersside'));
    }

    function SetCurrency(Request $request)
    {
        $currency = $request->currency;
        $request->session()->put('currency',$currency );
    }
}
