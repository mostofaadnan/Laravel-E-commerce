<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\productSliderType;
use DataTables;

class productSlideTypeController extends Controller
{
    public function index()
    {
       
        return view('setup.productSlideType');
    }
    public function LoadAll()
    {
        $HomeProductCategory = productSliderType::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($HomeProductCategory)
            ->addIndexColumn()
            ->addColumn('status', function (productSliderType $productSliderType) {
                return $productSliderType->status == 1 ? 'Active' : 'Inactive';
            })

            ->addColumn('action', function ($productSliderType) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $productSliderType->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $productSliderType->id . '">Delete</a>';
                return $button;
            })
            ->make(true);
    }


    public function store(Request $request)
    {


        $name = $request->name;
        $status = $request->status;
        $insert = productSliderType::insert([
            "name" => $name,
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
        $productSliderType = productSliderType::find($id);
        return response()->json($productSliderType);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $update = productSliderType::find($id);
        if (!is_null($update)) {
            $update->name = $request->name;
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
        $productSliderType = productSliderType::find($id);
        $productSliderType->delete();
    }
}
