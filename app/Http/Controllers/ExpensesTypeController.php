<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpensesType;
use DataTables;

class ExpensesTypeController extends Controller
{

    public function index()
    {
        return view('setup.expenstype');
    }
    public function LoadAll()
    {
        $ExpensesType = ExpensesType::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($ExpensesType)
            ->addIndexColumn()
            ->addColumn('status', function (ExpensesType $ExpensesType) {
                return $ExpensesType->status == 1 ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($ExpensesType) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $ExpensesType->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $ExpensesType->id . '">Delete</a>';
                return $button;
            })
            ->make(true);
    }
    public function ExpensesTypeDataList(Request $request)
    {
        if ($request->ajax()) {
            $ExpensesTypes = ExpensesType::orderBy("id", 'asc')->where('status', 1)->get();
            return view('datalist.expensestypedatalist', compact('ExpensesTypes'))->render();
        }
    }

    public function store(Request $request)
    {
        $ExpensesType = new ExpensesType();
        $ExpensesType->name = $request->name;
        $ExpensesType->remark = $request->description;
        $ExpensesType->status = $request->status;
        $ExpensesType->save();
        return response()->json($ExpensesType);
    }

    public function show(Request $request)
    {
        $id=$request->id;
        $ExpensesType = ExpensesType::find($id);
        return response()->json($ExpensesType);
    }


    public function update(Request $request)
    {
        $ExpensesType = ExpensesType::find($request->id);
        $ExpensesType->name = $request->name;
        $ExpensesType->remark = $request->description;
        $ExpensesType->status = $request->status;
        $ExpensesType->update();
        return response()->json($ExpensesType);
    }

    public function destroy($id)
    {
        $ExpensesType = ExpensesType::find($id);
        if (!is_null($ExpensesType)) {
            $ExpensesType->delete();
            return response()->json($ExpensesType);
        }
    }
}
