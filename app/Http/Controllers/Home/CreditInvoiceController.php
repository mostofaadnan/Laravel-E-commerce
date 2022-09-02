<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\InvoiceDetails;
use App\Models\customer;
use App\Models\DayClose;
use App\Models\CustomerDebts;
use App\Models\NumberFormat;
use App\Models\SaleConfig;
use DataTables;
use PDF;


class CreditInvoiceController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:invoice-list|invoice-create|invoice-edit|invoice-delete', ['only' => ['index', 'show', 'profile']]);
    $this->middleware('permission:invoice-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:invoice-edit', ['only' => ['edit', 'update', 'DataUpdate']]);
    $this->middleware('permission:invoice-delete', ['only' => ['delete']]);
    $this->middleware('permission:mail-list', ['only' => ['SendMail',]]);
  }
  public function index()
  {
    return view('creditinvoice.index');
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
      $invoice = Invoice::where('type_id', 2)
        ->whereBetween('inputdate', array($fromdate, $todate))
        ->orderBy('id', 'desc')
        ->latest()
        ->get();
    } else {
      $invoice = Invoice::where('type_id', 2)
        ->orderBy('id', 'desc')
        ->latest()
        ->get();
    }
    return Datatables::of($invoice)
      ->addIndexColumn()
      ->addColumn('customer', function (invoice $invoice) {
        return $invoice->CustomerName->name;
      })
      ->addColumn('user', function (invoice $invoice) {
        return $invoice->username ? $invoice->username->name : 'Deleted User';
      })
      ->addColumn('action', function ($invoice) {
        $button = '<div class="btn-group" role="group">';
        $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
        $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
        $button .= '<a class="dropdown-item" id="datashow" data-id="' . $invoice->id . '">View</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="pdf" data-id="' . $invoice->id . '">PDF</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="printslip" data-id="' . $invoice->id . '">Print</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="mail" data-id="' . $invoice->id . '">Send Mail</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="datashow" data-id="' . $invoice->id . '">Return</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="canceldata" data-id="' . $invoice->id . '">Cancel</a>';
        $button .= '</div></div>';
        return $button;
      })

      ->make(true);
  }
  public function create()
  {
    $date = date('m/d/Y');
    $DayClose = DayClose::where('date', $date)->first();
    if ($DayClose == null) {
      return view('creditinvoice.create');
    } else {
      return redirect()->Route('dayclose.daycloseerror');
    }
  }
  public function InvoiceCode()
  {
    $NumberFormat = NumberFormat::select('creditinvoice')->where('id', 1)->first();
    $numb = $NumberFormat->creditinvoice;
    $Invoice = new Invoice();
    $lastInvoice = $Invoice->pluck('id')->last();
    $InvoiceCode = $lastInvoice + 1;
    return response()->json($numb . $InvoiceCode);
  }
  public function Store(Request $request)
  {
    $netotal = $request->nettotal;
    $datareponse = "";
    $invoice = new Invoice();
    $invoice->invoice_no = $request->invoicecode;
    $invoice->inputdate = $request->openingdate;
    $invoice->ref_no = $request->refno;
    $invoice->type_id = 2;
    $invoice->customer_id = $request->customer_id;
    $invoice->amount = $request->amount;
    $invoice->discount = $request->discount;
    $invoice->vat = $request->vat;
    $invoice->shipment = $request->shipment;
    $invoice->nettotal = $netotal;
    $invoice->paymenttype_id = 5;
    $invoice->pay = 0;

    $invoice->status = 0;
    $invoice->user_id = Auth::id();
    $invoice->comment = 'Credit Invoice';
    if ($invoice->save() == true) {
      //Item Details
      $tableData = $request->itemtables;
      foreach ($tableData as $items) {
        $itemid = $items['code'];
        $invoiceqty = $items['qty'];
        $product = Product::select('tp', 'unit_id')->where('id', $itemid)->first();
        $invoiceDetails = new InvoiceDetails();
        $invoiceDetails->invoice_id = $invoice->id;
        $invoiceDetails->item_id = $itemid;
        $invoiceDetails->mrp = $items['unitprice'];
        $invoiceDetails->tp = $product->tp;
        $invoiceDetails->unit_id =  $product->unit_id;
        $invoiceDetails->qty = $invoiceqty;
        $invoiceDetails->amount = $items['amount'];
        $invoiceDetails->vat = $items['vat'];
        $invoiceDetails->discount = $items['discount'];
        $invoiceDetails->nettotal = $items['nettotal'];
        $invoiceDetails->customer_id = $request->customer_id;
        $invoiceDetails->save();
      }
      //customer Update
      $discount =  $request->discount;
      $creditinvoice = $netotal + $discount;
      $CustomerDebts = new CustomerDebts();
      $CustomerDebts->customer_id = $request->customer_id;
      $CustomerDebts->openingBalance = 0;
      $CustomerDebts->cashinvoice = 0;
      $CustomerDebts->creditinvoice = $creditinvoice;
      $CustomerDebts->totaldiscount = $discount;
      $CustomerDebts->payment = 0;
      $CustomerDebts->remark = 'Credit Invoice';
      $CustomerDebts->trn_id = $invoice->id;
      $CustomerDebts->save();
      $datareponse = $invoice->id;
    } else {
      $datareponse = 0;
    }
    return response()->json($datareponse);
  }
  public function show($id)
  {
    $this->invid($id);
    return view('creditinvoice.view');
  }
  public function invid($id)
  {
    Session::put('invid', $id);
  }
  public function GetListCustomerCredit(Request $request)
  {

    $invoice = Invoice::where('type_id', 2)
      ->where('customer_id', $request->customerid)
      ->orderBy('id', 'desc')
      ->latest()
      ->get();

    return Datatables::of($invoice)
      ->addIndexColumn()
      ->addColumn('customer', function (invoice $invoice) {
        return $invoice->CustomerName->name;
      })
      ->addColumn('user', function (invoice $invoice) {
        return $invoice->username->name;
      })
      ->addColumn('action', function ($invoice) {
        $button = '<div class="btn-group" role="group" aria-label="Basic example">';
        $button .= '<button id="datashowcredit" type="button" name="edit" data-id="' . $invoice->id . '" class="edit btn btn-outline-default btn-sm">Show</button>';
        $button .= '</div>';
        return $button;
      })

      ->make(true);
  }

  public function InvoiceodeDataList(Request $request)
  {
    if ($request->ajax()) {
      $invoices = Invoice::where('type_id', 2)
        ->orderBy("id", 'asc')
        ->get();
      return view('datalist.invoicecodedatalist', compact('invoices'))->render();
    }
  }


  public function invoicepdf($id)
  {
    $invoice = Invoice::find($id);
    $title = "Credit Invoice";
    $pdf = PDF::loadView('pdf.creditinvoice', compact('invoice', 'title'));
    return $pdf->stream('creditinvoice.pdf');
  }
  public function LoadPrintslip($id)
  {
    $title = "Credit Invoice";
    $invoice = Invoice::find($id);
    $SaleConfig = SaleConfig::find(1);
    $print_credit = $SaleConfig->print_credit;
    if ($print_credit == 1) {
      return view('creditinvoice.partials.creditinvoice', compact('invoice', 'title', 'SaleConfig'));
    } else {
      return view('pdf.creditinvoice', compact('invoice', 'title', 'SaleConfig'));
    }
  }
  public function SendMail($id)
  {
    $invoice = Invoice::find($id);
    return view('creditinvoice.sendmail', compact('invoice'));
  }
}
