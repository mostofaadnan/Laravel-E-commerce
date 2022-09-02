<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use DataTables;

class ColorController extends Controller
{
    public function index()
    {
        // $cate = Category::orderBy("id", "asc")->paginate(1);
        return view('setup.color');
    }
    public function LoadAll()
    {
        $Country = Color::orderBy('name', 'asc')
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
        $Color = new Color();
        $Color->name = $request->name;
        $Color->save();
        return response()->json($Color);
    }

    public function show(Request $request)
    {
        $id = $request->dataid;
        $Color = Color::find($id);
        return response()->json($Color);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $Color = Color::find($id);
        $Color->name = $request->name;
        $Color->update();
        return response()->json($Color);
    }

    public function destroy($id)
    {

        $Color = Color::find($id);
        if (!is_null($Color)) {
            $Color->delete();
        }
    }
}
