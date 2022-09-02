<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\purchase;
use App\Models\purchasedetails;
use App\Models\country;
use App\Models\state;
use App\Models\city;
use App\Models\DayClose;
use Facade\FlareClient\Http\Response;
use App\Models\NumberFormat;
use PDF;
use DataTables;
use App\Charts\PurchaseChart;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class PurchaseController extends Controller
{
  public $dataid;
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

    return view('purchase.index');
  }

  public function GetListSupplier(Request $request)
  {
    /*   $supplierid = $request->supplierid;
    $purchases = purchase::Where('supplier_id', $supplierid)->orderBy('purchasecode', 'desc')->get();
    return response()->json($purchases); */

    $supplierid = $request->supplierid;
    $purchases = purchase::Where('supplier_id', $supplierid)->orderBy('purchasecode', 'desc')->get();
    return Datatables::of($purchases)
      ->addIndexColumn()
      ->addColumn('status', function (purchase $purchase) {
        return $purchase->status == 1 ? 'Active' : 'Inactive';
      })
      ->addColumn('action', function ($purchase) {
        $button = '<button id="datashow" type="button" name="edit" data-id="' . $purchase->id . '" class="edit btn btn-outline-success btn-sm">Show</button>';
        return $button;
      })

      ->make(true);
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
      $purchases = purchase::orderBy('id', 'desc')
        ->whereBetween('inputdate', array($fromdate, $todate))
        ->latest()
        ->get();
    } else {
      $purchases = purchase::orderBy('id', 'desc')
        ->latest()
        ->get();
    }


    /* $table = Datatables::of($purchases);
     return $table->make(true); */
    return Datatables::of($purchases)
      ->addIndexColumn()
      ->addColumn('supplier', function (purchase $purchase) {
        return $purchase->SupplierName->name;
      })

      ->addColumn('status', function (purchase $purchase) {
        return $purchase->status == 1 ? 'Active' : 'Inactive';
      })
      ->addColumn('user', function (purchase $purchases) {

        return $purchases->username ? $purchases->username->name : 'Deleted User';
      })
      ->addColumn('action', function ($purchase) {

        $button = '<div class="btn-group" role="group">';
        $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
        $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
        $button .= '<a class="dropdown-item" id="datashow" data-id="' . $purchase->id . '">View</a>';
        $button .= '<div class="dropdown-divider"></div>';
        if ($purchase->status == 0) {
          $button .= '<a class="dropdown-item" id="dataedit" data-id="' . $purchase->id . '">Edit</a>';
          $button .= '<div class="dropdown-divider"></div>';
        } else {
          $button .= '<a class="dropdown-item" id="modify" data-id="' . $purchase->id . '">Modification</a>';
          $button .= '<div class="dropdown-divider"></div>';
        }
        if ($purchase->status == 0) {
          $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $purchase->id . '">Delete</a>';
          $button .= '<div class="dropdown-divider"></div>';
        }
        $button .= '<a class="dropdown-item" id="print" data-id="' . $purchase->id . '">Print</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="pdfdata" data-id="' . $purchase->id . '">Pdf</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="mail" data-id="' . $purchase->id . '">Send Mail</a>';
        $button .= '</div></div>';
        return $button;
      })

      ->make(true);
  }

  public function GetList(Request $request)
  {
    $currentdatetime = $request->value;
    $purchases = purchase::with('SupplierName')->Where('inputdate', $currentdatetime)->orderBy('purchasecode', 'desc')->get();
    return response()->json($purchases);
  }
  public function DateBetween(Request $request)
  {
    $purchases = purchase::with('SupplierName')
      ->whereBetween('created_at', [$request->start_date, $request->end_date])
      ->orderBy('purchasecode', 'desc')
      ->get();
    return response()->json($purchases);
  }
  public function create()
  {
    $date = date('m/d/Y');
    $DayClose = DayClose::where('date', $date)->first();
    if ($DayClose == null) {
      return view('purchase.create');
    } else {
      return redirect()->Route('dayclose.daycloseerror');
    }
  }
  public function Purchasecode()
  {
    $NumberFormat = NumberFormat::select('purchase')->where('id', 1)->first();
    $numb = $NumberFormat->purchase;
    $Purchase = new Purchase();
    $lastPurchase = $Purchase->pluck('id')->last();
    $purchasecode = $lastPurchase + 1;
    return response()->json($numb . $purchasecode);
  }
  public function Store(Request $request)
  {

    $datareponse = "";
    $purchase = new purchase();
    $purchase->purchasecode = $request->parchasecode;
    $purchase->ref_no = $request->refno;
    $purchase->inputdate = $request->openingdate;
    $purchase->supplier_id = $request->suplierid;
    $purchase->amount = $request->amount;
    $purchase->discount = $request->discount;
    $purchase->vat = $request->vat;
    $purchase->nettotal = $request->nettotal;
    $purchase->shipment = $request->shipment;
    $purchase->remark = $request->remark;
    $purchase->status = 0;
    $purchase->user_id = Auth::id();
    if ($purchase->save() == true) {

      $tableData = $request->itemtables;
      foreach ($tableData as $items) {

        $purchaseDeatils = new purchasedetails();
        $purchaseDeatils->purchase_id = $purchase->id;
        $purchaseDeatils->itemcode = $items['code'];
        $purchaseDeatils->mrp = $items['mrp'];
        $purchaseDeatils->tp = $items['unitprice'];
        $purchaseDeatils->unit_id = $items['unitid'];
        $purchaseDeatils->qty = $items['qty'];
        $purchaseDeatils->amount = $items['amount'];
        $purchaseDeatils->vat = $items['vat'];
        $purchaseDeatils->supplier_id = $request->suplierid;
        $purchaseDeatils->discount = $items['discount'];
        $purchaseDeatils->nettotal = $items['nettotal'];
        $purchaseDeatils->save();

        Product::select('tp')
          ->where('id', $items['code'])
          ->update(['tp' => $items['unitprice']]);
      }
    }
    $datareponse = $purchase->id;
    return response()->json($datareponse);
  }
  public function PurchaseCodeDataList(Request $request)
  {
    if ($request->ajax()) {
      $purchases = purchase::orderBy("id", 'asc')
        ->get();
      return view('datalist.purchasenodatalist', compact('purchases'))->render();
    }
  }
  public function purchaseId($id)
  {
    Session::put('purchaseId', $id);
  }
  public function Show($id)
  {
    $this->purchaseId($id);
    return view('purchase.purchaseview');
  }
  public function Edit($id)
  {
    $this->purchaseId($id);
    return view('purchase.view');
  }
  public function DataUpdate()
  {
    return view('purchase.view');
  }
  public function Profile()
  {
    return view('purchase.purchaseview');
  }
  public function transferid(Request $request)
  {
    $dataid = $request->dataid;
    return response()->json($dataid);
  }
  public function GetView()
  {
    $id = Session::get('purchaseId');
    $purchase = Purchase::with('PDetails', 'PDetails.productName', 'PDetails.UnitName', 'SupplierName', 'SupplierName.CountryName', 'SupplierName.StateName', 'SupplierName.CityName')->find($id);
    return  response()->json($purchase);
  }
  public function PurchasePdf($id)
  {
    $purchase = purchase::find($id);
    $title = "Purchase Order";
    $pdf = PDF::loadView('pdf.purchase', compact('purchase', 'title'));
    return $pdf->stream('purchase.pdf');
  }
  public function SendMail($id)
  {
    $purchase = purchase::find($id);
    return view('purchase.sendmail', compact('purchase'));
  }
  public function LoadPrintslip($id)
  {
    $title = "Purchase Order";
    $purchase = purchase::find($id);
    return view('pdf.purchase', compact('purchase', 'title'));
  }
  //Search Section

  public function GetSupplierByid(Request $request)
  {
    $suplierid = $request->dataid;
    //$categories = purchase::where("suplier_id", 'LIKE', '%' . $request->search . "%")->get();
    $supplier = purchase::with('SupplierName')->where('supplier_id', $suplierid)->orderBy('purchasecode', 'desc')->get();
    return response()->json($supplier);
  }
  //load for Item view
  public function PurchaseItem(Request $request)
  {
    $purchasedetails = purchasedetails::where('itemcode',  $request->productid)
      ->orderBy('id', 'desc')
      ->get();
    return Datatables::of($purchasedetails)
      ->addIndexColumn()
      ->addColumn('inputdate', function (purchasedetails $purchasedetails) {
        return $purchasedetails->purchasename->inputdate;
      })
      ->addColumn('purchasecode', function (purchasedetails $purchasedetails) {
        return $purchasedetails->purchasename->purchasecode;
      })
      ->addColumn('supplier', function (purchasedetails $purchasedetails) {
        return $purchasedetails->purchasename->SupplierName->name;
      })
      ->addColumn('status', function (purchasedetails $purchasedetails) {
        $status = $purchasedetails->purchasename->status == 1 ? 'Recieved' : 'Not Recieved';
        return $status;
      })
      ->addColumn('name', function (purchasedetails $purchasedetails) {
        return $purchasedetails->productName->name;
      })
      ->addColumn('unit', function (purchasedetails $purchasedetails) {
        return $purchasedetails->UnitName->Shortcut;
      })
      ->addColumn('action', function ($purchasedetails) {
        $button = '<div class="btn-group" role="group" aria-label="Basic example">';
        $button .= '<button id="datashow" type="button" name="edit" data-id="' . $purchasedetails->purchasename->id . '" class="edit btn btn-outline-default btn-sm">Show</button>';
        $button .= '</div>';
        return $button;
      })

      ->make(true);
  }
  public function Update(Request $request)
  {
    $datareponse = "";
    $purchase = purchase::find($request->purchaseid);
    if (!is_null($purchase)) {
      if ($purchase->status == 0) {
        $purchase->purchasecode = $request->purchaseid;
        $purchase->ref_no = $request->refno;
        $purchase->inputdate = $request->openingdate;
        $purchase->supplier_id = $request->suplierid;
        $purchase->amount = $request->amount;
        $purchase->discount = $request->discount;
        $purchase->vat = $request->vat;
        $purchase->nettotal = $request->nettotal;
        $purchase->shipment = $request->shipment;
        $purchase->remark = $request->remark;
        $purchase->status = 0;
        if ($purchase->update() == true) {
          //purchase Details
          $purchasedetailsdlt = purchasedetails::where('purchase_id', $request->purchaseid)->get();
          foreach ($purchasedetailsdlt as $pddelete) {
            $pddelete->delete();
          }
          $tableData = $request->itemtables;
          foreach ($tableData as $items) {
            $purchaseDeatils = new purchasedetails();
            $purchaseDeatils->purchase_id =  $request->purchaseid;
            $purchaseDeatils->itemcode = $items['code'];
            $purchaseDeatils->mrp = $items['mrp'];;
            $purchaseDeatils->tp = $items['unitprice'];
            $purchaseDeatils->unit_id = $items['unitid'];
            $purchaseDeatils->qty = $items['qty'];
            $purchaseDeatils->amount = $items['amount'];
            $purchaseDeatils->vat = $items['vat'];
            $purchaseDeatils->discount = $items['discount'];
            $purchaseDeatils->nettotal = $items['nettotal'];
            $purchaseDeatils->save();
            Product::select('tp')
            ->where('id', $items['code'])
            ->update(['tp' => $items['unitprice']]);
          }
        }
        $datareponse = $purchase->id;
        return response()->json($datareponse);
      }
    }
  }
  public function Delete($id)
  {
    $purchase = purchase::find($id);
    if ($purchase->status == 0) {
      if (!is_null($purchase)) {
        $purchase->delete();
      }
    }
  }
}
