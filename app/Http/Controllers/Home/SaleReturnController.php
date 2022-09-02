<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\SaleReturn;
use App\Models\invoice;
use App\Models\Product;
use App\Models\SaleReturnDetails;
use App\Models\customer;
use App\Models\CashDrawer;
use App\Models\DayClose;
use App\Models\CustomerDebts;
use App\Models\NumberFormat;
use App\Models\SaleConfig;
use DataTables;
use PDF;

class SaleReturnController extends Controller
{
    function __construct()
    {
        //$this->DayCloseController->DayClosePermission('2020-07-21');
        $this->middleware('permission:invoice-list|invoice-create|invoice-edit|invoice-delete', ['only' => ['index', 'show', 'profile']]);
        $this->middleware('permission:invoice-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:invoice-edit', ['only' => ['edit', 'update', 'DataUpdate']]);
        $this->middleware('permission:invoice-delete', ['only' => ['delete']]);
        $this->middleware('permission:mail-list', ['only' => ['SendMail',]]);
    }

    public function index()
    {
        return view('salereturn.index');
    }
    public function LoadAll(Request $request)
    {
        if (!empty($request->fromdate) && !empty($request->todate)) {
            $fromdate = date('Y/m/d', strtotime($request->fromdate));
            $todate = date('Y/m/d', strtotime($request->todate));
            $SaleReturn = SaleReturn::orderBy('id', 'desc')
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $SaleReturn = SaleReturn::orderBy('id', 'desc')
                ->latest()
                ->get();
        }

        return Datatables::of($SaleReturn)
            ->addIndexColumn()
            ->addColumn('customer', function (SaleReturn $SaleReturn) {
                return $SaleReturn->CustomerName->name;
            })
            ->addColumn('user', function (SaleReturn $SaleReturn) {
                return $SaleReturn->username ? $SaleReturn->username->name : 'Deleted User';
            })
            ->addColumn('action', function ($SaleReturn) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $SaleReturn->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="pdfdata" data-id="' . $SaleReturn->id . '">PDF</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="printslip" data-id="' . $SaleReturn->id . '">Print</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $SaleReturn->id . '">Cancel</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="mail" data-id="' . $SaleReturn->id . '">Send Mail</a>';
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
            return view('salereturn.create');
        } else {
            return redirect()->Route('dayclose.daycloseerror');
        }
    }
    public function ReturnCode()
    {
        $NumberFormat = NumberFormat::select('salereturn')->where('id', 1)->first();
        $numb = $NumberFormat->salereturn;
        $SaleReturn = new SaleReturn();
        $lastSaleReturn = $SaleReturn->pluck('id')->last();
        $salercode = $lastSaleReturn + 1;
        return response()->json($numb . $salercode);
    }
    public function invoicecodedatalist(Request $request)
    {
        if ($request->ajax()) {
            $invoices = invoice::orderBy("id", 'asc')->get();
            return view('datalist.invoicecodedatalist', compact('invoices'))->render();
        }
    }
    public function Store(Request $request)
    {
        $type = $request->type;
        $balance = 0;
        $cashin = 0;
        $cashout = 0;

        $netotal = $request->nettotal;
        $datareponse = "";
        $SaleReturn = new SaleReturn();
        $SaleReturn->return_no = $request->returncode;
        $SaleReturn->invoice_id = $request->invoicecode;
        $SaleReturn->inputdate = $request->openingdate;
        $SaleReturn->type_id = $request->type;
        $SaleReturn->customer_id = $request->customer_id;
        $SaleReturn->amount = $request->amount;
        $SaleReturn->discount = $request->discount;
        $SaleReturn->vat = $request->vat;
        $SaleReturn->nettotal = $netotal;
        $SaleReturn->user_id = Auth::id();
        if ($SaleReturn->save() == true) {
            //Item Details
            $tableData = $request->itemtables;
            foreach ($tableData as $items) {
                $itemid = $items['code'];
                $invoiceqty = $items['qty'];
                $product = Product::select('tp', 'unit_id')->where('id', $itemid)->first();
                $SaleReturnDetails = new SaleReturnDetails();
                $SaleReturnDetails->retun_id = $SaleReturn->id;
                $SaleReturnDetails->item_id = $itemid;
                $SaleReturnDetails->mrp = $items['unitprice'];
                $SaleReturnDetails->tp = $product->tp;
                $SaleReturnDetails->unit_id =  $product->unit_id;
                $SaleReturnDetails->qty = $invoiceqty;
                $SaleReturnDetails->amount = $items['amount'];
                $SaleReturnDetails->vat = $items['vat'];
                $SaleReturnDetails->discount = $items['discount'];
                $SaleReturnDetails->nettotal = $items['nettotal'];
                $SaleReturnDetails->save();
            }
            //balance update
            if ($type == 1) {
                $cashin = CashDrawer::sum('cashin');
                $cashout = CashDrawer::sum('cashout');
                $balance = $cashin - $cashout;
                $newbalance = $netotal + $balance;
                $Drware = new CashDrawer();
                $Drware->inputdate = $request->openingdate;
                $Drware->cashin = 0;
                $Drware->cashout = $netotal;
                $Drware->balance = $newbalance;
                $Drware->payment_id = $SaleReturn->id;
                $Drware->type = "Sale Return";
                $Drware->type_id=4;
                $Drware->user_id = Auth::id();
                $Drware->save();
            }
            //customer Update
            $discount =  $request->discount;
            $returnamount = $netotal + $discount;
            $CustomerDebts = new CustomerDebts();
            $CustomerDebts->customer_id = $request->customer_id;
            $CustomerDebts->openingBalance = 0;
            $CustomerDebts->cashinvoice = 0;
            $CustomerDebts->creditinvoice = 0;
            $CustomerDebts->totaldiscount = 0;
            $CustomerDebts->payment = 0;
            $CustomerDebts->salereturn = $returnamount;
            $CustomerDebts->remark = 'Sale Return';
            $CustomerDebts->trn_id = $SaleReturn->id;
            $CustomerDebts->save();
            $datareponse = $SaleReturn->id;
        } else {
            $datareponse = 0;
        }
        return response()->json($datareponse);
        /* foreach($request->itemtables as $items){
     ;
    
    } */
    }
    public function Show($id)
    {
        $this->salereturnid($id);
        return view('salereturn.view');
    }
    public function salereturnid($id)
    {
        Session::put('salereturnid', $id);
    }
    public function SaleReturnCodeDatalist(Request $request)
    {
        if ($request->ajax()) {
            $salereturns = SaleReturn::orderBy("id", 'asc')->get();
            return view('datalist.salereturncodedatalist', compact('salereturns'))->render();
        }
    }
    public function GetView()
    {
        $id = Session::get('salereturnid');
        $invoice = SaleReturn::with('CustomerName', 'returnDetails', 'returnDetails.productName', 'returnDetails.productName.UnitName', 'CustomerName.CountryName', 'CustomerName.StateName', 'CustomerName.CityName')->find($id);
        return  response()->json($invoice);
    }
    public function ReturnPdf($id)
    {
        $title = "Sale Return";
        $SaleReturn = SaleReturn::find($id);
        $pdf = PDF::loadView('pdf.salereturn', compact('SaleReturn', 'title'));
        return $pdf->stream('salereturn.pdf');
    }
    public function LoadPrintslip($id)
    {
        $title = "Sale Return";
        $SaleReturn = SaleReturn::find($id);
        $SaleConfig = SaleConfig::find(1);
        $print = $SaleConfig->print;
        if ($print == 1) {
            return view('salereturn.partials.salereturn', compact('SaleReturn', 'title'));
        } else {
            return view('pdf.salereturn', compact('SaleReturn', 'title'));
        }
    }
    public function sendmail($id)
    {
        $SaleReturn = SaleReturn::find($id);
        return view('SaleReturn.sendmail', compact('SaleReturn'));
    }
    public function Destroy($id)
    {
        $SaleReturn = SaleReturn::find($id);
        if (!is_null($SaleReturn)) {
            $customerid = $SaleReturn->customer_id;
            $this->CashDrawerDelete($id);
            $customerDelete = CustomerDebts::where('customer_id', $customerid)
                ->where('remark', 'Sale Return')
                ->where('trn_id', $id)
                ->first();
            if (!is_null($customerDelete)) {
                $customerDelete->delete();
            }
            $SaleReturn->delete();
        }
    }


    public function CashDrawerDelete($trn)
    {
        $cashdrawer = CashDrawer::where('type', 'Sale Return')
            ->where('payment_id', $trn)
            ->first();
        if (!is_null($cashdrawer)) {
            $cashdrawer->delete();
        }
    }
}
