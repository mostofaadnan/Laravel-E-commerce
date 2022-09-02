<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\BrandCategories;
use DataTables;
use Image;
use File;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:brand-setup', ['only' => ['index', 'show']]);
        $this->middleware('permission:brand-setup', ['only' => ['create', 'store']]);
        $this->middleware('permission:brand-setup', ['only' => ['edit', 'update', 'Active', 'Inactive']]);
        $this->middleware('permission:brand-setup', ['only' => ['destroy']]);
    }
    public function index()
    {
        $categories = Category::orderBy("id", "asc")->get();
        return view('setup.brand', compact('categories'));
    }

    public function LoadAll()
    {
        $Brand = Brand::orderBy('id', 'desc')
            ->with('CategoryName')
            ->latest()
            ->get();
        return Datatables::of($Brand)
            ->addIndexColumn()
            /*   ->addColumn('type', function (Brand $Brand) {
                  $type=$Brand->CategoryName()->CatName->pluck('title')->implode(',');
                 return $type;
             }) */
            ->addColumn('type', function (Brand $Brand) {
                return $Brand->CategoryName->map(function ($post) {
                    return $post->CatName->title;
                })->implode(',');
            })
            ->addColumn('status', function (Brand $Brand) {
                return $Brand->status == 1 ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($Brand) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $Brand->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $Brand->id . '">Delete</a>';
                return $button;
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        $brand = new Brand();
        $brand->title = $request->title;
        $brand->description = $request->description;
        $brand->status = $request->status;
        if ($request->hasFile('file')) {
            $image = $request->File('file');
            $img = time() . $image->getClientOriginalExtension();
            $location = storage_path('app/public/brand/' . $img);
            Image::make($image)->save($location);
            $brand->image = $img;
        }
        if ($brand->save() == true) {
            $multicategory = json_decode($request->itemlist,true);
                foreach ($multicategory as $mcat) {
                    $BrandCategoriess = new BrandCategories();
                    $BrandCategoriess->category_id  = $mcat;
                    $BrandCategoriess->brand_id = $brand->id;
                    $BrandCategoriess->save();
                }
            return response()->json($multicategory);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->dataid;
        $Brand = Brand::with('CategoryName')->find($id);
        return response()->json($Brand);
    }


    public function update(Request $request)
    {
        $id = $request->id;
        $brand = Brand::find($id);
        $brand->title = $request->title;
        $brand->description = $request->description;
        $brand->status = $request->status;
        if ($request->hasFile('file')) {
            if (File::exists('storage/app/public/brand/' . $brand->image)) {
                File::delete('storage/app/public/brand/' . $brand->image);
            }
            $image = $request->File('file');
            $img = time() . $image->getClientOriginalExtension();
            $location = storage_path('app/public/brand/' . $img);
            Image::make($image)->save($location);
            $brand->image = $img;
        }
        if ($brand->update()) {
            $multicategory = json_decode($request->itemlist,true);
            if (!is_null($multicategory)) {
                $multicategoryDelete = BrandCategories::where('brand_id', $id)->get();
                foreach ($multicategoryDelete as $mdelete) {
                    $mdelete->delete();
                }
                foreach ($multicategory as $mcat) {
                    $BrandCategoriess = new BrandCategories();
                    $BrandCategoriess->category_id  = $mcat;
                    $BrandCategoriess->brand_id = $brand->id;
                    $BrandCategoriess->save();
                }
            }
            return response()->json($brand);
        }
    }
    public function destroy($id)
    {
        $branddelete = Brand::find($id);
        if (!is_null($branddelete)) {
            if (File::exists('storage/app/public/brand/' . $branddelete->image)) {
                File::delete('storage/app/public/brand/' . $branddelete->image);
            }
            
            $branddelete->delete();
            return response()->json($branddelete);
        }
    }
}
