<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermCondition;
use Yajra\DataTables\Facades\DataTables;

class TermAndConditionController extends Controller
{
    public function index()
    {
        // $cate = Category::orderBy("id", "asc")->paginate(1);
        return view('pages.term');
    }
    public function LoadAll()
    {
        $terms = TermCondition::orderBy('name', 'asc')
            ->latest()
            ->get();
        return Datatables::of($terms)
            ->addIndexColumn()

            ->addColumn('action', function ($terms) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $terms->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $terms->id . '">Delete</a>';
                return $button;
            })
            ->make(true);
    }


    public function store(Request $request)
    {
        $terms = new TermCondition();
        $terms->name = $request->name;
        $terms->description = $request->description;
        $terms->save();

        return response()->json($terms);
    }

    public function show(Request $request)
    {
        $id = $request->dataid;
        $terms = TermCondition::find($id);
        return response()->json($terms);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $terms = TermCondition::find($id);
        $terms->name = $request->name;
        $terms->description = $request->description;
        $terms->update();
        return response()->json($terms);
    }

    public function destroy($id)
    {

        $terms = TermCondition::find($id);
        if (!is_null($terms)) {
            $terms->delete();
        }
    }
}
