<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankName;
use DataTables;
class BankNameController extends Controller
{


    public function index()
    {
        return view('setup.bankname');
    }
    public function LoadAll()
    {
        $BankName = BankName::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($BankName)
            ->addIndexColumn()
            ->addColumn('status', function (BankName $BankName) {
                return $BankName->status == 1 ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($BankName) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $BankName->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $BankName->id . '">Delete</a>';
                return $button;
            })
            ->make(true);
    }
    public function BankDataList(Request $request)
    {
        if ($request->ajax()) {
            $BankName = BankName::get();
            return view('datalist.banknamedatalist', compact('BankName'))->render();
        }
    }

    public function store(Request $request)
    {
        $BankName = new BankName();
        $BankName->name = $request->name;
        $BankName->remark = $request->description;
        $BankName->status = $request->status;
        $BankName->save();
        return response()->json($BankName);
    }

    public function show(Request $request)
    {
        $id = $request->id;
        $BankName = BankName::find($id);
        return response()->json($BankName);
    }


    public function update(Request $request)
    {
        $BankName = BankName::find($request->id);
        $BankName->name = $request->name;
        $BankName->remark = $request->description;
        $BankName->status = $request->status;
        $BankName->update();
        return response()->json($BankName);
    }

    public function destroy($id)
    {
        $BankName = BankName::find($id);
        if (!is_null($BankName)) {
            $BankName->delete();
            return response()->json($BankName);
        }
    }
}
