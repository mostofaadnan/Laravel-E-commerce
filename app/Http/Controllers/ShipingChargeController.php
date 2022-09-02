<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\state;
use App\Models\shipmentCharge;
use Yajra\DataTables\Facades\DataTables;

class ShipingChargeController extends Controller
{
  public function index(){
    $Countrys = Country::orderBy('name', 'asc')->where('status',1)->get();
      return view('setup.shippingcharge',compact('Countrys'));
  }
  public function LoadAll()
  {
      $shipmentCharge = shipmentCharge::orderBy('id', 'desc')
          ->latest()
          ->get();
      return Datatables::of($shipmentCharge)
          ->addIndexColumn()
          ->addColumn('country', function (shipmentCharge $shipmentCharge) {
              return $shipmentCharge->CountryName->name;
          })
          ->addColumn('state', function (shipmentCharge $shipmentCharge) {
            return $shipmentCharge->StateName->name;
          })

          ->addColumn('action', function ($shipmentCharge) {
              $button = '<div class="btn-group" role="group">';
              $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
              $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
              $button .= '<a class="dropdown-item" id="datashow" data-id="' . $shipmentCharge->id . '">View</a>';
              $button .= '<div class="dropdown-divider"></div>';
              $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $shipmentCharge->id . '">Delete</a>';
              return $button;
          })
          ->make(true);
  }


  public function store(Request $request)
  {


      $insert = shipmentCharge::insert([
       
          "country_id" => $request->categoryid,
          "state_id" =>  $request->stateid,
          "charge" => $request->charge,
      ]);
      return response()->json($insert);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

  public function show(Request $request)
  {
      $id = $request->dataid;
      $shipmentCharge = shipmentCharge::find($id);
      return response()->json($shipmentCharge);
  }

  public function update(Request $request)
  {
      $id = $request->id;
      $update = shipmentCharge::find($id);
      if (!is_null($update)) {
       
          $update->country_id = $request->categoryid;
          $update->state_id =  $request->stateid;
          $update->charge =$request->charge;
          $update->update();
      }
      return response()->json($update);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

  public function destroy($id)
  {
      $shipmentCharge = shipmentCharge::find($id);
      $shipmentCharge->delete();
    
  }
}
