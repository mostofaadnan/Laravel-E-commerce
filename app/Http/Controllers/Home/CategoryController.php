<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use DataTables;
use Image;
use File;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:category-setup', ['only' => ['index', 'show']]);
        $this->middleware('permission:category-setup', ['only' => ['create', 'store']]);
        $this->middleware('permission:category-setup', ['only' => ['edit', 'update', 'Active', 'Inactive']]);
        $this->middleware('permission:category-setup', ['only' => ['destroy']]);
    }
    public function index()
    {
        // $cate = Category::orderBy("id", "asc")->paginate(1);
        return view('setup.category');
    }
    public function LoadAll(Request $request)
    {
        $Category = Category::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($Category)
            ->addIndexColumn()

            ->addColumn('status', function (Category $Category) {
                return $Category->status == 1 ? 'Active' : 'Inactive';
            })

            ->addColumn('action', function ($Category) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $Category->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $Category->id . '">Delete</a>';

                return $button;
            })

            ->make(true);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Category = new Category;
        $Category->title = $request->title;
        $Category->description = $request->description;
        $Category->status = $request->status;
        if ($request->hasFile('file')) {
            $image = $request->File('file');
            $img = time() . $image->getClientOriginalExtension();
            $location = storage_path('app/public/category/' . $img);
            Image::make($image)->save($location);
            $Category->image = $img;
        }
        $Category->save();
        return response()->json($Category);
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
        $category = Category::find($id);
        return response()->json($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $Category = Category::find($id);
        $Category->title = $request->title;
        $Category->description = $request->description;
        $Category->status = $request->status;
        if ($request->hasFile('file')) {
            if (File::exists('storage/app/public/category/' . $Category->image)) {
                File::delete('storage/app/public/category/' . $Category->image);
            }
            $image = $request->File('file');
            $img = time() . $image->getClientOriginalExtension();
            $location = storage_path('app/public/category/' . $img);
            Image::make($image)->save($location);
            $Category->image = $img;
        }
        $Category->update();
        return response()->json($Category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $categorydelete = Category::find($id);
        if (!is_null($categorydelete)) {
            if (File::exists('storage/app/public/category/' . $categorydelete->image)) {
                File::delete('storage/app/public/category/' . $categorydelete->image);
            }
            $subcategordelete = subcategory::where('category_id', $id)->get();
            if (!is_null($subcategordelete)) {
                foreach ($subcategordelete  as $subcate) {
                    $subcate->delete();
                }
            }
            $categorydelete->delete();

            return response()->json($categorydelete);
        }
    }
}
