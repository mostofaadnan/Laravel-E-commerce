<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FaqModel;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    public function index()
    {
      
        return view('pages.faq');
    }
    public function LoadAll()
    {
        $FaqModel = FaqModel::orderBy('name', 'asc')
            ->latest()
            ->get();
        return Datatables::of($FaqModel)
            ->addIndexColumn()

            ->addColumn('action', function ($FaqModel) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $FaqModel->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $FaqModel->id . '">Delete</a>';
                return $button;
            })
            ->make(true);
    }


    public function store(Request $request)
    {
        $FaqModel = new FaqModel();
        $FaqModel->name = $request->name;
        $FaqModel->description = $request->description;
        $FaqModel->save();

        return response()->json($FaqModel);
    }

    public function show(Request $request)
    {
        $id = $request->dataid;
        $FaqModel = FaqModel::find($id);
        return response()->json($FaqModel);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $FaqModel = FaqModel::find($id);
        $FaqModel->name = $request->name;
        $FaqModel->description = $request->description;
        $FaqModel->update();
        return response()->json($FaqModel);
    }

    public function destroy($id)
    {

        $FaqModel = FaqModel::find($id);
        if (!is_null($FaqModel)) {
            $FaqModel->delete();
        }
    }
}
