<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\state;
use App\Models\city;
use DataTables;

class CountryController extends Controller
{
    public function index()
    {
        // $cate = Category::orderBy("id", "asc")->paginate(1);
        return view('setup.country');
    }
    public function LoadAll()
    {
        $Country = Country::orderBy('name', 'asc')
            ->latest()
            ->get();
        return Datatables::of($Country)
            ->addIndexColumn()

            ->addColumn('status', function (Country $Country) {
                return $Country->status == 1 ? 'Active' : 'Inactive';
            })

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
        $Country = new Country();
        $Country->sortname = $request->shortname;
        $Country->name = $request->name;
        $Country->status = $request->status;
        $Country->phonecode = $request->phonecode;
        $Country->save();
        return response()->json($Country);
    }

    public function show(Request $request)
    {
        $id = $request->dataid;
        $Country = Country::find($id);
        return response()->json($Country);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $Country = Country::find($id);
        $Country->sortname = $request->shortname;
        $Country->name = $request->name;
        $Country->status = $request->status;
        $Country->phonecode = $request->phonecode;
        $Country->update();
        return response()->json($Country);
    }

    public function destroy($id)
    {

        $Country = Country::find($id);
        if (!is_null($Country)) {
            $states = state::where('country_id', $id)->get();
            if (!is_null($states)) {
                foreach ($states as $state) {
                    $state->delete();
                }
                $citys = city::where('state_id', $state->id);
                if (!is_null($citys)) {
                    foreach ($citys as $city) {
                        $city->delete();
                    }
                }
            }
            $Country->delete();
        }
    }
}
