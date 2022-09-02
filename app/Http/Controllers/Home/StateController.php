<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\state;
use App\Models\city;
use DataTables;

class StateController extends Controller
{
    public function index()
    {
        $Countrys = Country::orderBy('name', 'asc')->where('status',1)->get();
        return view('setup.state',compact('Countrys'));
    }
    public function LoadAll()
    {
        $state = state::orderBy('name', 'asc')
            ->latest()
            ->get();
        return Datatables::of($state)
            ->addIndexColumn()
            ->addColumn('country', function (state $state) {
                return $state->CountryName->name;
            })
            ->addColumn('action', function ($state) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $state->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $state->id . '">Delete</a>';
                return $button;
            })
            ->make(true);
    }


    public function store(Request $request)
    {
        $state = new state();
        $state->name = $request->name;
        $state->country_id = $request->country_id;
        $state->save();
        return response()->json($state);
    }

    public function show(Request $request)
    {
        $id = $request->dataid;
        $state = state::find($id);
        return response()->json($state);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $state = state::find($id);
        $state->name = $request->name;
        $state->country_id = $request->country_id;
        $state->update();
        return response()->json($state);
    }

    public function destroy($id)
    {

        $state = state::find($id);
        if (!is_null($state)) {
            $states = state::where('state_id', $id)->get();
            $citys = city::where('state_id', $states->id);
            if (!is_null($citys)) {
                foreach ($citys as $city) {
                    $city->delete();
                }
            }
            $state->delete();
        }
    }
    public function getStateList(Request $request)
    {
        $states = state::orderBy('name', 'asc')
            ->where("country_id", $request->country_id)
            ->pluck("name", "id");
        return response()->json($states);
    }
}
