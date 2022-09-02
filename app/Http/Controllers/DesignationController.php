<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\designation;
use DataTables;

class DesignationController extends Controller
{
    public function index()
    {
        return view('setup.designation');
    }
    public function LoadAll()
    {
        $designation = designation::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($designation)
            ->addIndexColumn()
            ->addColumn('status', function (designation $ExpensesType) {
                return $ExpensesType->status == 1 ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($designation) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $designation->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $designation->id . '">Delete</a>';
                return $button;
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        $designation = new designation();
        $designation->name = $request->name;
        $designation->status = $request->status;
        $designation->save();
        return response()->json($designation);
    }

    public function show(Request $request)
    {
        $id=$request->id;
        $designation = designation::find($id);
        return response()->json($designation);
    }


    public function update(Request $request)
    {
        $designation = designation::find($request->id);
        $designation->name = $request->name;
        $designation->status = $request->status;
        $designation->update();
        return response()->json($designation);
    }

    public function destroy($id)
    {
        $designation = designation::find($id);
        if (!is_null($designation)) {
            $designation->delete();
            return response()->json($designation);
        }
    }
}
