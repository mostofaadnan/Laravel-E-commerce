<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use DataTables;

class SubcategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:subcategory-setup', ['only' => ['index', 'show']]);
        $this->middleware('permission:subcategory-setup', ['only' => ['create', 'store']]);
        $this->middleware('permission:subcategory-setup', ['only' => ['edit', 'update', 'Active', 'Inactive']]);
        $this->middleware('permission:subcategory-setup', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $category = Category::orderby('id', 'asc')->get();
        return view('setup.subcategory', compact('category'));
    }
    public function LoadAll()
    {
        $subcategory = Subcategory::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($subcategory)
            ->addIndexColumn()
            ->addColumn('category', function (subcategory $subcategory) {
                return $subcategory->Categoryname->title;
            })
            ->addColumn('status', function (subcategory $subcategory) {
                return $subcategory->status == 1 ? 'Active' : 'Inactive';
            })

            ->addColumn('action', function ($subcategory) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $subcategory->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $subcategory->id . '">Delete</a>';
                return $button;
            })
            ->make(true);
    }


    public function store(Request $request)
    {

        $title = $request->title;
        $categoryid = $request->categoryid;
        $description = $request->description;
        $status = $request->status;


        $insert = Subcategory::insert([
            "title" => $title,
            "category_id" => $categoryid,
            "description" => $description,
            "status" => $status,
        ]);
        return response()->json($insert);
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
        $subcategory = Subcategory::find($id);
        return response()->json($subcategory);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $update = Subcategory::find($id);
        if (!is_null($update)) {
            $update->title = $request->title;
            $update->category_id = $request->categoryid;
            $update->description = $request->description;
            $update->status = $request->status;
            $update->update();
        }
        return response()->json($update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $subcategordelete = Subcategory::find($id);
        $subcategordelete->delete();
      
    }
}
