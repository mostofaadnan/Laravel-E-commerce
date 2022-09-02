<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\size;
use DataTables;
class SizeController extends Controller
{
    public function index()
    {
        // $cate = Category::orderBy("id", "asc")->paginate(1);
        return view('setup.size');
    }
    public function LoadAll()
    {
        $Country = size::orderBy('name', 'asc')
            ->latest()
            ->get();
        return Datatables::of($Country)
            ->addIndexColumn()

            ->addColumn('action', function ($Country) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $Country->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $Country->id . '">Delete</a>';
                return $button;
            })
            ->make(true);
    }


    public function store(Request $request)
    {
        $size = new size();
        $size->name = $request->name;
        $size->save();
        return response()->json($size);
    }

    public function show(Request $request)
    {
        $id = $request->dataid;
        $size = size::find($id);
        return response()->json($size);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $size = size::find($id);
        $size->name = $request->name;
        $size->update();
        return response()->json($size);
    }

    public function destroy($id)
    {

        $size = size::find($id);
        if (!is_null($size)) {
            $size->delete();
        }
    }
}
