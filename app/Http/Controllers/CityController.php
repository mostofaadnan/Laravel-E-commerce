<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\state;
use App\Models\city;
use DataTables;

class CityController extends Controller
{
    public function index()
    {

        $Countrys = Country::orderBy('name', 'asc')->where('status', 1)->get();
        return view('setup.city', compact('Countrys'));
    }
    public function LoadAll()
    {
        $city = city::orderBy('name', 'asc')
            ->latest()
            ->get();
        return Datatables::of($city)
            ->addIndexColumn()
            /*  ->addColumn('state', function (city $city) {
                return $city->StateName->name;
            }) */
            /*  ->addColumn('country', function (city $city) {
                return $city->StateName->CountryName->name;
            }) */
            ->addColumn('action', function ($city) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $city->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $city->id . '">Delete</a>';
                return $button;
            })
            ->make(true);
    }


    public function store(Request $request)
    {
        $city = new city();
        $city->name = $request->name;
        $city->state_id = $request->state_id;
        $city->save();
        return response()->json($city);
    }

    public function show(Request $request)
    {
        $id = $request->dataid;
        $city = city::with('StateName', 'StateName.CountryName')->find($id);
        return response()->json($city);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $city = city::find($id);
        $city->name = $request->name;
        $city->state_id = $request->state_id;
        $city->update();
        return response()->json($city);
    }

    public function destroy($id)
    {
        $city = city::find($id);
        if (!is_null($city)) {
            $city->delete();
        }
    }
    public function getCityList(Request $request)
    {
        $cities = city::orderBy('name', 'asc')
            ->where("state_id", $request->state_id)
            ->pluck("name", "id");
        return response()->json($cities);
    }
}
