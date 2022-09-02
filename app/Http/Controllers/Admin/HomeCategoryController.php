<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\HomeProductCategory;
use DataTables;

class HomeCategoryController extends Controller
{

    public function index()
    {
        $category = Category::orderby('id', 'asc')->get();
        return view('setup.homeCategory', compact('category'));
    }
    public function LoadAll()
    {
        $HomeProductCategory = HomeProductCategory::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($HomeProductCategory)
            ->addIndexColumn()
            ->addColumn('category', function (HomeProductCategory $HomeProductCategory) {
                return $HomeProductCategory->Categoryname->title;
            })
            ->addColumn('status', function (HomeProductCategory $HomeProductCategory) {
                return $HomeProductCategory->status == 1 ? 'Active' : 'Inactive';
            })

            ->addColumn('action', function ($HomeProductCategory) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $HomeProductCategory->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $HomeProductCategory->id . '">Delete</a>';
                return $button;
            })
            ->make(true);
    }


    public function store(Request $request)
    {


        $categoryid = $request->categoryid;
        $status = $request->status;


        $insert = HomeProductCategory::insert([
            "category_id" => $categoryid,
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
        $HomeProductCategory = HomeProductCategory::find($id);
        return response()->json($HomeProductCategory);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $update = HomeProductCategory::find($id);
        if (!is_null($update)) {
            $update->category_id = $request->categoryid;
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
        $subcategordelete = HomeProductCategory::find($id);
        $subcategordelete->delete();
    }
}
