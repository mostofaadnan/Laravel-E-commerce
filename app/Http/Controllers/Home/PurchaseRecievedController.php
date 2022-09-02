<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\PurchaseRecieved;
use App\Models\purchase;
use App\Models\purchasedetails;
use App\Models\Product;
use App\Models\supplier;
use App\Models\DayClose;
use App\Models\SupplierDebt;
use App\Models\Expenses;
use PDF;
use DataTables;
use App\Models\NumberFormat;
use Illuminate\Support\Facades\Session;

class PurchaseRecievedController extends Controller
{
  function __construct()
  {
   // $this->middleware('permission:grn-list|grn-create|grn-edit|grn-delete', ['only' => ['index', 'show', 'profile']]);
   /// $this->middleware('permission:grn-create', ['only' => ['Recieved', 'Store']]);
    // $this->middleware('permission:grn-edit', ['only' => ['edit', 'update','DataUpdate']]);
    // $this->middleware('permission:grn-delete', ['only' => ['delete']]);
    //$this->middleware('permission:mail-list', ['only' => ['SendMail',]]);
  }
  public function index()
  {
    return view("purchaserecieved.index");
  }
  public function LoadAll(Request $request)
  {
    $a = $this->DataTables($request);
    return $a;
  }

  public function DataTables($request)
  {
    if (!empty($request->fromdate) && !empty($request->todate)) {
      $fromdate = date('Y/m/d', strtotime($request->fromdate));
      $todate = date('Y/m/d', strtotime($request->todate));
      $precieves = PurchaseRecieved::orderBy('id', 'desc')
        ->whereBetween('inputdate', array($fromdate, $todate))
        ->latest()
        ->get();
    } else {
      $precieves = PurchaseRecieved::orderBy('id', 'desc')
        ->latest()
        ->get();
    }
    return Datatables::of($precieves)
      ->addIndexColumn()
      ->addColumn('purchasedate', function (PurchaseRecieved $precieve) {
        return $precieve->purchaseDetails->inputdate;
      })
      ->addColumn('purchasecode', function (PurchaseRecieved $precieve) {
        return $precieve->purchaseDetails->purchasecode;
      })
      ->addColumn('supplier', function (PurchaseRecieved $precieve) {
        return $precieve->purchaseDetails->SupplierName->name;
      })
      ->addColumn('amount', function (PurchaseRecieved $precieve) {
        return $precieve->purchaseDetails->amount;
      })
      ->addColumn('discount', function (PurchaseRecieved $precieve) {
        return $precieve->purchaseDetails->discount;
      })
      ->addColumn('vat', function (PurchaseRecieved $precieve) {
        return $precieve->purchaseDetails->vat;
      })
      ->addColumn('nettotal', function (PurchaseRecieved $precieve) {
        return $precieve->purchaseDetails->nettotal;
      })
      ->addColumn('user', function (PurchaseRecieved $precieve) {
        return $precieve->username ? $precieve->username->name : 'Deleted User';
    
      })
      /*  ->addColumn('status', function (purchase $purchase) {
        return $purchase->status == 1 ? 'Active' : 'Inactive';
      }) */
      ->addColumn('action', function (PurchaseRecieved $precieves) {
        $button = '<div class="btn-group" role="group">';
        $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
        $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
        $button .= '<a class="dropdown-item" id="datashow" data-id="' . $precieves->id . '">View</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $precieves->id . '">Delete</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="print" data-id="' . $precieves->id . '">Print</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="datapdf" data-id="' . $precieves->id . '">Pdf</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="mail" data-id="' . $precieves->id . '">Send Mail</a>';
        $button .= '</div></div>';
        return $button;
      })->make(true);
  }
  public function GetList(Request $request)
  {
    $currentdatetime = $request->value;
    $purchaserecieved = PurchaseRecieved::with('purchaseDetails')
      ->where('inputdate', $currentdatetime)
      ->orderBy('id', 'desc')
      ->get();
    return response()->json($purchaserecieved);
  }
  public function DateBetween(Request $request)
  {
    $purchases = PurchaseRecieved::with('purchaseDetails')
      ->whereBetween('created_at', [$request->start_date, $request->end_date])
      ->orderBy('id', 'desc')
      ->get();
    return response()->json($purchases);
  }
  public function Recieved()
  {
    $date = date('m/d/Y');
    $DayClose = DayClose::where('date', $date)->first();
    if ($DayClose == null) {
      return view("purchaserecieved.recievd");
    } else {
      return redirect()->Route('dayclose.daycloseerror');
    }
  }

  public function RecievedById($id)
  {
    $date = date('m/d/Y');
    $DayClose = DayClose::where('date', $date)->first();
    if ($DayClose == null) {
      $this->purchaseId($id);
      return view("purchaserecieved.recievd");
    } else {
      return redirect()->Route('dayclose.daycloseerror');
    }
  }

  public function purchaseId($id)
  {
    Session::put('purchaseId', $id);
  }
  public function grnid($id)
  {
    Session::put('grnid', $id);
  }
  public function RecieveNo()
  {
    $NumberFormat = NumberFormat::select('grn')->where('id', 1)->first();
    $numb = $NumberFormat->grn;
    $PurchaseRecieved = new PurchaseRecieved();
    $lastPurchase = $PurchaseRecieved->pluck('id')->last();
    $purchasecode = $lastPurchase + 1;
    return response()->json($numb . $purchasecode);
  }
  public function PurchaseCodeDataList(Request $request)
  {
    if ($request->ajax()) {
      $purchases = purchase::select('id', 'purchasecode')
        ->where('status', 0)
        ->get();
      return view('datalist.purchasenodatalist', compact('purchases'))->render();
    }
  }
  public function RecieveCodeDataList(Request $request)
  {
    if ($request->ajax()) {
      $precives = PurchaseRecieved::select('id', 'purchaseRecievdNo')
        ->get();
      return view('datalist.recievecodedatalist', compact('precives'))->render();
    }
  }
  public function Store(Request $request)
  {
    $purchase = Purchase::select('id', 'supplier_id', 'status', 'discount', 'nettotal')->where('id', $request->parchasecode)->first();
    if ($purchase->status == 0) {
      $status = 1;
      $response = "";
      $purchaserecieve = new PurchaseRecieved();
      $purchaserecieve->purchaseRecievdNo = $request->recieveno;
      $purchaserecieve->purchase_id = $request->parchasecode;
      $purchaserecieve->supplier_id = $purchase->supplier_id;
      $purchaserecieve->inputdate = $request->inputdate;
      $purchaserecieve->remark = $request->remark;
      $purchaserecieve->user_id = Auth::id();
      if ($purchaserecieve->save() == true) {
        $tableData = $request->itemtables;
        foreach ($tableData as $items) {
          $itemid = $items['code'];
          $product = purchasedetails::select('status', 'itemcode', 'purchase_id')
            ->where('purchase_id', $request->parchasecode)
            ->where('itemcode', $itemid)
            ->get();
          //Status Update
          if (!is_null($product)) {
            $dataupdate = purchasedetails::where(
              [
                'itemcode' => $itemid,
                'purchase_id' => $request->parchasecode,

              ]
            )
              ->update(['status' => $status]);
          }
        }
        //supplier Update
        $discount = $purchase->discount;
        $netotal = $purchase->nettotal;
        $consignment = $netotal + $discount;
        $SupplierDebt = new SupplierDebt();
        $SupplierDebt->supplier_id = $purchase->supplier_id;
        $SupplierDebt->openingBalance = 0;
        $SupplierDebt->consignment = $consignment;
        $SupplierDebt->payment = 0;
        $SupplierDebt->remark = 'Consignment';
        $SupplierDebt->trn_id = $purchase->id;
        $SupplierDebt->save();
        //status Update
        $pupdate = Purchase::where('id', $request->parchasecode)
          ->update(['status' => $status]);
        $response =  $purchaserecieve->id;
        return response()->json($response);
      } else {
        $response = 'All Data Sucessfully Save';
      }
    }
  }
  public function Show($id)
  {
    $this->grnid($id);
    return view('purchaserecieved.view');
  }
  public function GetView()
  {
    $id = Session::get('grnid');
    $precieve = PurchaseRecieved::with('purchaseDetails', 'purchaseDetails.PDetails', 'purchaseDetails.PDetails.productName', 'purchaseDetails.PDetails.UnitName', 'purchaseDetails.SupplierName', 'purchaseDetails.SupplierName.CountryName', 'purchaseDetails.SupplierName.StateName', 'purchaseDetails.SupplierName.CityName')->find($id);
    return response()->json($precieve);
  }
  public function Pdf($id)
  {
    $precieve = PurchaseRecieved::find($id);
    $supplierDebd = SupplierDebt::where('supplier_id', $precieve->purchaseDetails->supplier_id)
      ->get();
    $consignment = $supplierDebd->sum('consignment');
    $discount = $supplierDebd->sum('totaldiscount');
    $netConsignment = ($consignment - $discount);
    $payments = $supplierDebd->sum('payment');
    $balancedue = $netConsignment - $payments;
    $title = "Goods Recieved Note(GRN)";
    $pdf = PDF::loadView('pdf.purchaseRecived', compact('precieve', 'consignment', 'discount', 'payments', 'balancedue', 'title'));
    return $pdf->stream('grn.pdf');
  }
  public function LoadPrintslip($id)
  {
    $precieve = PurchaseRecieved::find($id);
    $supplierDebd = SupplierDebt::where('supplier_id', $precieve->purchaseDetails->supplier_id)
      ->get();
    $consignment = $supplierDebd->sum('consignment');
    $discount = $supplierDebd->sum('totaldiscount');
    $netConsignment = ($consignment - $discount);
    $payments = $supplierDebd->sum('payment');
    $balancedue = $netConsignment - $payments;
    $title = "Goods Recieved Note(GRN)";
    $purchase = purchase::find($id);
    return view('pdf.purchaseRecived', compact('precieve', 'consignment', 'discount', 'payments', 'balancedue', 'title'));
  }
  public function SendMail($id)
  {
    $precieve = PurchaseRecieved::find($id);
    return view('purchaserecieved.sendmail', compact('precieve'));
  }
  public function destroy($id)
  {
    $precieve = PurchaseRecieved::find($id);
    if (!is_null($precieve)) {
      $precieve->delete();
    }
  }
}
