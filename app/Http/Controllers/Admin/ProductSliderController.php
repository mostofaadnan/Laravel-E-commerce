<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\productSliderType;
use App\Models\ProductSlider;
use DataTables;



class ProductSliderController extends Controller
{
    public function index()
    {
        $types = productSliderType::orderby('id', 'asc')->get();
        return view('setup.productslider', compact('types'));
    }
    public function LoadAll()
    {
        $ProductSlider = ProductSlider::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($ProductSlider)
            ->addIndexColumn()
            ->addColumn('type', function (ProductSlider $ProductSlider) {
                return $ProductSlider->typeName->name;
            })
            ->addColumn('product', function (ProductSlider $ProductSlider) {
                return $ProductSlider->productName->name;
            })
            ->addColumn('status', function (ProductSlider $ProductSlider) {
                return $ProductSlider->status == 1 ? 'Active' : 'Inactive';
            })

            ->addColumn('action', function ($ProductSlider) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $ProductSlider->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $ProductSlider->id . '">Delete</a>';
                return $button;
            })
            ->make(true);
    }


    public function store(Request $request)
    {


        $typeid = $request->typeid;
        $productid = $request->productid;
        $insert = ProductSlider::insert([
            "type_id" => $typeid,
            "product_id" => $productid,
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
        $HomeProductCategory = ProductSlider::with('productName')->find($id);
        return response()->json($HomeProductCategory);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $update = ProductSlider::find($id);
        if (!is_null($update)) {
            $update->type_id = $request->typeid;
            $update->product_id = $request->productid;
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
        $subcategordelete = ProductSlider::find($id);
        $subcategordelete->delete();
    }
}
