<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnDetails;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\DayClose;
use App\Models\SupplierDebt;
use App\Models\NumberFormat;
use DataTables;
use PDF;

class PurchaseReturnController extends Controller
{
    function __construct()
    {
      $this->middleware('permission:purchase-list|purchase-create|purchase-edit|purchase-delete', ['only' => ['index', 'show', 'profile']]);
      $this->middleware('permission:purchase-create', ['only' => ['create', 'store']]);
      $this->middleware('permission:purchase-edit', ['only' => ['edit', 'update', 'DataUpdate']]);
      $this->middleware('permission:purchase-delete', ['only' => ['delete']]);
      $this->middleware('permission:mail-list', ['only' => ['SendMail',]]);
    }
    public function index()
    {
        return view('purchasereturn.index');
    }
    public function LoadAll(Request $request)
    {
        if (!empty($request->fromdate) && !empty($request->todate)) {
            $fromdate = date('Y/m/d', strtotime($request->fromdate));
            $todate = date('Y/m/d', strtotime($request->todate));
            $PurchaseReturn = PurchaseReturn::orderBy('id', 'desc')
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $PurchaseReturn = PurchaseReturn::orderBy('id', 'desc')->latest()->get();
        }

        /* $table = Datatables::of($purchases);
      return $table->make(true); */
        return Datatables::of($PurchaseReturn)
            ->addIndexColumn()
            ->addColumn('supplier', function (PurchaseReturn $PurchaseReturn) {
                return $PurchaseReturn->SupplierName->name;
            })
            ->addColumn('user', function (PurchaseReturn $PurchaseReturn) {
                return $PurchaseReturn->username ? $PurchaseReturn->username->name : 'Deleted User';
              
            })
            ->addColumn('action', function ($PurchaseReturn) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $PurchaseReturn->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="dataedit" data-id="' . $PurchaseReturn->id . '">Edit</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $PurchaseReturn->id . '">Delete</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="pdfdata" data-id="' . $PurchaseReturn->id . '">Pdf</a>';
                $button .= '</div></div>';
                return $button;
            })

            ->make(true);
    }
    public function PurchaseReturncode()
    {
        $NumberFormat = NumberFormat::select('purchasereturn')->where('id', 1)->first();
        $numb = $NumberFormat->purchasereturn;
        $Purchasereturn = new PurchaseReturn();
        $lastPurchasereturn = $Purchasereturn->pluck('id')->last();
        $prcode = $lastPurchasereturn + 1;
        return response()->json($numb . $prcode);
    }
    public function create()
    {
        $date = date('m/d/Y');
        $DayClose = DayClose::where('date', $date)->first();
        if ($DayClose == null) {
            return view('purchasereturn.create');
        } else {
            return redirect()->Route('dayclose.daycloseerror');
        }
    }

    public function edit()
    {
        $date = date('m/d/Y');
        $DayClose = DayClose::where('date', $date)->first();
        if ($DayClose == null) {
            return view('purchasereturn.edit');
        } else {
            return redirect()->Route('dayclose.daycloseerror');
        }
    }
    public function Store(Request $request)
    {
        $datareponse = "";
        $PurchaseReturn = new PurchaseReturn();
        $PurchaseReturn->return_code = $request->returncode;
        $PurchaseReturn->purchasecode = $request->parchasecode;
        $PurchaseReturn->ref_no = $request->refno;
        $PurchaseReturn->inputdate = $request->openingdate;
        $PurchaseReturn->supplier_id = $request->suplierid;
        $PurchaseReturn->amount = $request->amount;
        $PurchaseReturn->discount = $request->discount;
        $PurchaseReturn->vat = $request->vat;
        $PurchaseReturn->nettotal = $request->nettotal;
        $PurchaseReturn->remark = $request->remark;
        $PurchaseReturn->user_id = Auth::id();
        if ($PurchaseReturn->save() == true) {
            //purchase Details
            $tableData = $request->itemtables;
            foreach ($tableData as $items) {
                $itemid = $items['code'];
                $qtys = $items['qty'];
                $purchaseDeatils = new PurchaseReturnDetails();
                $purchaseDeatils->return_id = $PurchaseReturn->id;
                $purchaseDeatils->itemcode =  $itemid;
                $purchaseDeatils->mrp = $items['mrp'];;
                $purchaseDeatils->tp = $items['unitprice'];
                $purchaseDeatils->unit_id = $items['unitid'];
                $purchaseDeatils->qty =  $qtys;
                $purchaseDeatils->amount = $items['amount'];
                $purchaseDeatils->vat = $items['vat'];
                $purchaseDeatils->discount = $items['discount'];
                $purchaseDeatils->nettotal = $items['nettotal'];
                $purchaseDeatils->save();
            }
            //Update supplier
            $amount = $request->nettotal;
            $totaldiscount = $request->totaldiscount;
            $returnamount = $amount + $totaldiscount;
            $SupplierDebt = new SupplierDebt();
            $SupplierDebt->supplier_id = $request->suplierid;
            $SupplierDebt->openingBalance = 0;
            $SupplierDebt->consignment = 0;
            $SupplierDebt->totaldiscount = 0;
            $SupplierDebt->returnamount = $returnamount;
            $SupplierDebt->payment = 0;
            $SupplierDebt->remark = 'Purchase Return';
            $SupplierDebt->trn_id =  $PurchaseReturn->id;
            $SupplierDebt->save();
        }
        $datareponse = $PurchaseReturn->id;
        return response()->json($datareponse);
    }
    public function Update(Request $request)
    {
        $datareponse = "";
        $PurchaseReturn = PurchaseReturn::find($request->returnid);
        $PurchaseReturn->purchasecode = $request->parchasecode;
        $PurchaseReturn->ref_no = $request->refno;
        $PurchaseReturn->inputdate = $request->openingdate;
        $PurchaseReturn->amount = $request->amount;
        $PurchaseReturn->discount = $request->discount;
        $PurchaseReturn->vat = $request->vat;
        $PurchaseReturn->nettotal = $request->nettotal;
        $PurchaseReturn->remark = $request->remark;
        $PurchaseReturn->user_id = Auth::id();
        if ($PurchaseReturn->update() == true) {
            //purchase Details
            $prdetails = PurchaseReturnDetails::where('return_id', $request->returnid)->get();

            foreach ($prdetails as $pddelete) {
                $pddelete->delete();
            }
            $tableData = $request->itemtables;
            foreach ($tableData as $items) {
                $itemid = $items['code'];
                $qtys = $items['qty'];
                $purchaseDeatils = new PurchaseReturnDetails();
                $purchaseDeatils->return_id = $PurchaseReturn->id;
                $purchaseDeatils->itemcode =  $itemid;
                $purchaseDeatils->mrp = $items['mrp'];;
                $purchaseDeatils->tp = $items['unitprice'];
                $purchaseDeatils->unit_id = $items['unitid'];
                $purchaseDeatils->qty =  $qtys;
                $purchaseDeatils->amount = $items['amount'];
                $purchaseDeatils->vat = $items['vat'];
                $purchaseDeatils->discount = $items['discount'];
                $purchaseDeatils->nettotal = $items['nettotal'];
                $purchaseDeatils->save();
            }

            //Update supplier
            $amount = $request->nettotal;
            $totaldiscount = $request->totaldiscount;
            $returnamount = $amount + $totaldiscount;
            $SupplierDebt = SupplierDebt::where('trn_id', $request->returnid)
                ->where('remark', 'Purchase Return')
                ->first();
            $SupplierDebt->supplier_id = $request->suplierid;
            $SupplierDebt->openingBalance = 0;
            $SupplierDebt->consignment = 0;
            $SupplierDebt->totaldiscount = 0;
            $SupplierDebt->returnamount = $returnamount;
            $SupplierDebt->payment = 0;
            $SupplierDebt->remark = 'Purchase Return';
            $SupplierDebt->trn_id =  $PurchaseReturn->id;
            $SupplierDebt->update();
        }
        $datareponse = $PurchaseReturn->id;
        return response()->json($datareponse);
    }

    public function Show()
    {
        return view('purchasereturn.view');
    }
    public function retuncodedatalist(Request $request)
    {
        if ($request->ajax()) {
            $purchasereturns = PurchaseReturn::orderBy("id", 'asc')
                ->get();
            return view('datalist.purchasereturncodedatalist', compact('purchasereturns'))->render();
        }
    }
    public function GetView($id)
    {
        $PurchaseReturn = PurchaseReturn::with('PDetails', 'PDetails.ProductName', 'PDetails.ProductName.UnitName', 'SupplierName', 'SupplierName.CountryName', 'SupplierName.StateName', 'SupplierName.CityName')->find($id);
        return  response()->json($PurchaseReturn);
    }
    public function PurchaseReturnPdf($id)
    {
        $PurchaseReturn = PurchaseReturn::find($id);
        $title = "Purchase Return";
        $pdf = PDF::loadView('pdf.purchasereturn', compact('PurchaseReturn', 'title'));
        return $pdf->stream('purchasereturn.pdf');
    }
    public function SendMail($id)
    {
        $PurchaseReturn = PurchaseReturn::find($id);
        return view('purchasereturn.sendmail',compact('PurchaseReturn'));
    }
    public function destroy($id)
    {
        $PurchaseReturn = PurchaseReturn::find($id);
        if (!is_null($PurchaseReturn)) {

            $PurchaseReturn->delete();
            /*   $prdetails = PurchaseReturnDetails::where('return_id', $id)->get();
      
              foreach ($prdetails as $pddelete) {
                  $pddelete->delete();
              } */
            $SupplierDebt = SupplierDebt::where('trn_id', $id)
                ->where('remark', 'Purchase Return')
                ->first();
            if (!is_null($SupplierDebt)) {
                $SupplierDebt->delete();
            }
        }
    }
}
