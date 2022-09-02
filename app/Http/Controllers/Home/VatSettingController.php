<?php

namespace App\Http\Controllers;

use App\Models\VatSetting;
use Illuminate\Http\Request;
use DataTables;

class VatSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:vat-setting', ['only' => ['index', 'show']]);
        $this->middleware('permission:vat-setting', ['only' => ['create', 'store']]);
        $this->middleware('permission:vat-setting', ['only' => ['edit', 'update', 'Active', 'Inactive']]);
        $this->middleware('permission:vat-setting', ['only' => ['destroy']]);
    }
    public function index()
    {
        return view('setup.vat');
    }
    public function LoadAll()
    {
        $subcategory = VatSetting::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($subcategory)
            ->addIndexColumn()
            ->addColumn('status', function (VatSetting $VatSetting) {
                return $VatSetting->status == 1 ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($VatSetting) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $VatSetting->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $VatSetting->id . '">Delete</a>';
                return $button;
            })
            ->make(true);
    }
    public function GetList()
    {
        $vats = VatSetting::orderBy('name', 'asc')->pluck("name", "id", "value");
        return response()->json($vats);
    }
    public function GetListVat()
    {
        $VatSettings = VatSetting::orderBy("id", "asc")->get();
        return view('modeldata.vatsettingdatalist', compact('VatSettings'))->render();;
    }


    public function Show(Request $get)
    {
        $id = $get->dataid;
        $VatSettings = VatSetting::find($id);
        return response()->json($VatSettings);
    }

    public function store(Request $request)
    {
        $response = "";
        $validator = $request->validate([
            'name' => 'required',
            'value' => 'required|numeric',
        ]);
        $vatsetting = new VatSetting();
        $vatsetting->name = $request->name;
        $vatsetting->value = $request->value;
        $vatsetting->remark = $request->remark;
        $vatsetting->status = $request->status;
        if ($vatsetting->save()) {
            $response = 'Successfully Data save';
        } else {
            $response = 'Fail to Data save';
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $response = "";
        $validator = $request->validate([
            'name' => 'required',
            'value' => 'required|numeric',
        ]);
        $vatsetting = VatSetting::find($request->id);
        $vatsetting->name = $request->name;
        $vatsetting->value = $request->value;
        $vatsetting->remark = $request->remark;
        $vatsetting->status = $request->status;
        if ($vatsetting->save()) {
            $response = 'Successfully Data Update';
        } else {
            $response = 'Fail to Data Update';
        }
        return response()->json($response);
    }
    public function updateValue(Request $request)
    {
        $validator = $request->validate([
            'value' => 'required|numeric',
        ]);
        VatSetting::where('id', $request->id)
            ->update(['value' => $request->value]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getView($id)
    {
        $VatSetting = VatSetting::find($id);
        return response()->json($VatSetting);
    }
    public function destroy($id)
    {
        $VatSetting = VatSetting::find($id);
        if (!is_null($VatSetting)) {
            $VatSetting->delete();
            return response()->json($VatSetting);
        }
    }
}
