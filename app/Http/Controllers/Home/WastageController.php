<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Wastage;
use App\Models\WastageDetails;
use DataTables;
use PDF;

class WastageController extends Controller
{
    public function index()
    {
        return view('wastage.index');
    }
    public function LoadAll(Request $request)
    {
        if (!empty($request->fromdate) && !empty($request->todate)) {
            $fromdate = date('Y/m/d', strtotime($request->fromdate));
            $todate = date('Y/m/d', strtotime($request->todate));
            $Wastage = Wastage::orderBy('id', 'desc')
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $Wastage = Wastage::orderBy('id', 'desc')
                ->latest()
                ->get();
        }
        /* $table = Datatables::of($purchases);
     return $table->make(true); */
        return Datatables::of($Wastage)
            ->addIndexColumn()
            ->addColumn('user', function (Wastage $Wastage) {
                return $Wastage->username ? $Wastage->username->name : 'Deleted User';
            })
            ->addColumn('action', function ($Wastage) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $Wastage->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="dataedit" data-id="' . $Wastage->id . '">Edit</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $Wastage->id . '">Delete</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="pdfdata" data-id="' . $Wastage->id . '">Pdf</a>';
                return $button;
            })->make(true);
    }
    public function Create()
    {
        return view('wastage.create');
    }
    public function Store(Request $request)
    {
        $datareponse = "";
        $Wastage = new Wastage();
        $Wastage->inputdate = $request->openingdate;
        $Wastage->nettotal = $request->nettotal;
        $Wastage->remark = $request->remark;
        $Wastage->user_id = Auth::id();
        if ($Wastage->save() == true) {
            //purchase Details
            $tableData = $request->itemtables;
            foreach ($tableData as $items) {
                $WastageDetails = new WastageDetails();
                $WastageDetails->wastage_id = $Wastage->id;
                $WastageDetails->item_id = $items['code'];
                $WastageDetails->tp = $items['unitprice'];
                $WastageDetails->unit_id = $items['unitid'];
                $WastageDetails->qty = $items['qty'];
                $WastageDetails->amount = $items['amount'];
                $WastageDetails->save();
            }
        }
        $datareponse = $Wastage->id;
        return response()->json($datareponse);
    }
    public function Show()
    {
        return view('wastage.view');
    }
    public function GetView($id)
    {
        $Wastage = Wastage::with('WDatils', 'WDatils.productName', 'WDatils.productName.UnitName')->find($id);
        return  response()->json($Wastage);
    }
    public function WastagePdf($id)
    {
        $title = "Wastage";
        $wastage = Wastage::find($id);
        $pdf = PDF::loadView('pdf.wastage', compact('wastage', 'title'));
        return $pdf->stream('wastage.pdf');
    }
}
