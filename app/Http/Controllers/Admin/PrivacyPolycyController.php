<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Storage;

class PrivacyPolycyController extends Controller
{
    public function index()
    {
        // $cate = Category::orderBy("id", "asc")->paginate(1);
        return view('pages.privacy');
    }
    public function LoadAll()
    {
        $PrivacyPolicy = PrivacyPolicy::orderBy('name', 'asc')
            ->latest()
            ->get();
        return Datatables::of($PrivacyPolicy)
            ->addIndexColumn()

            ->addColumn('action', function ($PrivacyPolicy) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $PrivacyPolicy->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $PrivacyPolicy->id . '">Delete</a>';
                return $button;
            })
            ->make(true);
    }


    public function store(Request $request)
    {
        $PrivacyPolicy = new PrivacyPolicy();
        $PrivacyPolicy->name = $request->name;
        $PrivacyPolicy->description = $request->description;
        $PrivacyPolicy->save();

        return response()->json($PrivacyPolicy);
    }

    public function show(Request $request)
    {
        $id = $request->dataid;
        $color = PrivacyPolicy::find($id);
        return response()->json($color);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $PrivacyPolicy = PrivacyPolicy::find($id);
        $PrivacyPolicy->name = $request->name;
        $PrivacyPolicy->description = $request->description;
        $PrivacyPolicy->update();
        return response()->json($PrivacyPolicy);
    }

    public function destroy($id)
    {

        $PrivacyPolicy = PrivacyPolicy::find($id);
        if (!is_null($PrivacyPolicy)) {
            $PrivacyPolicy->delete();
        }
    }
}
