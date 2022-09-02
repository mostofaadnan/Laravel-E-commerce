<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\DayClose;
use DataTables;
use App\Models\Invoice;
use App\Models\purchase;
use App\Models\SupplierPayment;
use App\Models\CustomerPaymentRecieve;
use App\Models\CashDrawer;
use App\Models\Expenses;
use App\Models\PurchaseReturn;
use App\Models\SaleReturn;
use App\Models\CashInCashOut;
use App\Models\Product;
use App\Models\PurchaseRecieved;
use App\Models\Bank;
use PDF;


class DayCloseController extends Controller
{
    public function index()
    {
        return view('dayclose.index');
    }
    public function LoadAll(Request $request)
    {

        $type = 1;
        $a = $this->DataTables($request, $type);
        return $a;
    }
    public function LoadAllMonthly(Request $request)
    {
        $type = 2;
        $a = $this->DataTables($request, $type);
        return $a;
    }
   
    public function DataTables($request, $type)
    {

        if (!empty($request->fromdate) && !empty($request->todate)) {
            $fromdate = date('Y/m/d', strtotime($request->fromdate));
            $todate = date('Y/m/d', strtotime($request->todate));
            $DayClose = DayClose::orderBy('id', 'desc')
                ->where('type', $type)
                ->WhereBetween('date', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $DayClose = DayClose::orderBy('id', 'desc')
                ->where('type', $type)
                ->latest()
                ->get();
        }
        return Datatables::of($DayClose)
            ->addIndexColumn()
            ->addColumn('status', function (DayClose $DayClose) {
                return $DayClose->status == 1 ? 'Close' : 'Open';
            })
            ->addColumn('created', function (DayClose $DayClose) {
                $todate = date('m/d/Y', strtotime($DayClose->created_at));
                return $todate;
            })
            ->addColumn('closetype', function (DayClose $DayClose) {
                $type = $DayClose->type;
                switch ($type) {
                    case 1:
                        $dtype = 'Daily';
                        break;
                    case 2:
                        $dtype = 'Month';
                        break;
                    case 3:
                        $dtype = 'Yearly';
                        break;
                    default:
                        break;
                }
                return  $dtype;
            })
            ->addColumn('action', function ($DayClose) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $DayClose->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="pdf" data-id="' . $DayClose->id . '">PDF</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="printslip" data-id="' . $DayClose->id . '">Print</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="reopen" data-id="' . $DayClose->id . '">Re-open</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $DayClose->id . '">Delete</a>';
                $button .= '</div></div>';
                return $button;
            })

            ->make(true);
    }
    public function Create()
    {
        return view('dayclose.create');
    }

    function GetData(Request $request)
    {
        $date = $request->date;
        $cashin = 0;
        $cashout = 0;
        $data['cashinvoice'] = Invoice::where('type_id', 1)
            ->where('inputdate', $date)
            ->where('cancel', 0)
            ->sum('nettotal');
        $data['creditinvoice'] = Invoice::where('type_id', 2)
            ->where('inputdate', $date)
            ->where('cancel', 0)
            ->sum('nettotal');
        $data['salereturn'] = SaleReturn::where('inputdate', $date)
            ->sum('nettotal');
        $data['purchase'] = purchase::where('inputdate', $date)
            ->sum('nettotal');
        $data['grn'] = PurchaseRecieved::join('purchases', 'purchases.id', '=', 'purchase_recieveds.purchase_id')
            ->where('purchase_recieveds.inputdate', '=', $date)
            ->get([DB::raw('sum(purchases.nettotal) as value')])
            ->sum('value');
        $data['SupplierPayment'] = SupplierPayment::where('inputdate', $date)
            ->sum('payment');
        $data['CustomerRecieved'] = CustomerPaymentRecieve::where('inputdate', $date)
            ->sum('recieve');
        $data['purchasereturn'] = PurchaseReturn::where('inputdate', $date)
            ->sum('nettotal');
        $cashincurrentdate = CashDrawer::where('inputdate', $date)
            ->sum('cashin');
        $cashoutcurrentdate = CashDrawer::where('inputdate', $date)
            ->where('cancel', 0)
            ->sum('cashout');
        $acountcashin = CashInCashOut::where('type', 1)
            ->where('inputdate', $date)
            ->sum('amount');
        $acountcashout = CashInCashOut::where('type', 2)
            ->where('inputdate', $date)
            ->sum('amount');
        $data['totalcashin'] = $cashincurrentdate + $acountcashin;
        $data['totalcashout'] = $cashoutcurrentdate + $acountcashout;
        $cashin = CashDrawer::where('cancel', 0)->sum('cashin');
        $cashout = CashDrawer::where('cancel', 0)->sum('cashout');
        $data['balance'] = $cashin - $cashout;
        $data['Expenses'] = Expenses::where('inputdate', $date)
            ->where('void', 0)
            ->sum('amount');
        $cashinbank = Bank::where('cancel', 0)->sum('cashin');
        $cashoutbank = Bank::where('cancel', 0)->sum('cashout');
        $data['Bank'] = $cashinbank - $cashoutbank;

        $product = Product::all();
        $netstock = 0;
        foreach ($product as $products) {
            $openigqty =  $products->openingStock()->sum('qty');
            $invoice = $products->QuantityOutBySale()->sum('qty');
            $invoiceReturn = $products->QuantityOutBySaleReturn()->sum('qty');
            $totalinvoiceqty = $invoice - $invoiceReturn;
            $purchase = $products->QuantityOutByPurchase()->sum('qty');
            $PurchaseReturn = $products->QuantityOutByPurchaseReturn()->sum('qty');
            $totalPurchaseqty = $purchase - $PurchaseReturn;
            $stock = $openigqty + ($totalPurchaseqty - $totalinvoiceqty);
            $mrp = $products->mrp;
            $stockamount =  $stock * $mrp;
            $netstock += $stockamount;
        }
        $data['stockamount']  = $netstock;

        return response()->json($data);
    }
    public function Store(Request $request)
    {
        if ($request->type == 1) {
            $this->validate($request, [
                'status' => 'required',
                'date' =>  [
                    'required',
                    Rule::unique('day_closes')
        
                ]
            ]);
            $input = $request->all();
            $input['user_id'] = Auth::id();
            $input['type'] = $request->type;
            // print_r($input);
            $dayclose = new DayClose;
            $dayclose->create($input);
            Session()->flash('success', 'Day has insert successfully');
            return redirect()->Route('daycloses');
        } else if ($request->type == 2) {
            $this->validate($request, [
                'status' => 'required',
                'month' =>  [
                    'required',
                    Rule::unique('day_closes')
                ]
            ]);
            $input = $request->all();
            $input['user_id'] = Auth::id();
            $input['type'] = $request->type;
            $dayclose = new DayClose;
            $dayclose->create($input);
            Session()->flash('success', 'Monthly Closeing has insert successfully');
            return redirect()->Route('dayclose.monthly');
        } else {
            $this->validate($request, [
                'status' => 'required',
                'year' =>  [
                    'required',
                    Rule::unique('day_closes')
                        
                ]
            ]);
            $input = $request->all();
            $input['user_id'] = Auth::id();
            $input['type'] = $request->type;
            $dayclose = new DayClose;
            $dayclose->create($input);
            Session()->flash('success', 'Yearly Closeing has insert successfully');
            return redirect()->Route('dayclose.yearly');
        }
    }
    public function Show()
    {

        return view('dayclose.view');
    }
    public function GetView($id)
    {
        $DayClose = DayClose::find($id);
        return response()->json($DayClose);
    }
    public function GetViewByDate(Request $request)
    {
        $DayClose = DayClose::where('date', $request->date)->first();
        return response()->json($DayClose);
    }
    public function DayClosePdf($id)
    {
        $DayClose = DayClose::find($id);
        $pdf = PDF::loadView('pdf.dayclose', compact('DayClose'));
        return $pdf->stream('dayclose.pdf');
    }

    public function DayClosePermission()
    {   /* $date = date('Y-m-d'); */
        return view('dayclose.daycloseerror');
    }

    public function destroy($id)
    {
        $DayClose = DayClose::find($id);
        $DayClose->delete();
    }

    //Monthly

    public function Monthly()
    {
        return view('dayclose.monthlyindex');
    }
    public function MonthlyCreate()
    {
        return view('dayclose.monthlycreate');
    }

    function getDataMonthly(Request $request)
    {
        $date = $request->date;
        $splitName = explode('-', $date, 2);
        $month = $splitName[0];
        $year = $splitName[1];
        $cashin = 0;
        $cashout = 0;
        $data['cashinvoice'] = Invoice::where('type_id', 1)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('cancel', 0)
            ->sum('nettotal');
        $data['creditinvoice'] = Invoice::where('type_id', 2)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('cancel', 0)
            ->sum('nettotal');
        $data['salereturn'] = SaleReturn::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->sum('nettotal');
        $data['purchase'] = purchase::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            
            ->sum('nettotal');
        $data['grn'] = PurchaseRecieved::join('purchases', 'purchases.id', '=', 'purchase_recieveds.purchase_id')
            ->whereMonth('purchase_recieveds.created_at', '=', $month)
            ->whereYear('purchase_recieveds.created_at', '=', $year)
            ->get([DB::raw('sum(purchases.nettotal) as value')])
            ->sum('value');
        $data['SupplierPayment'] = SupplierPayment::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            
            ->sum('payment');
        $data['CustomerRecieved'] = CustomerPaymentRecieve::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            
            ->sum('recieve');
        $data['purchasereturn'] = PurchaseReturn::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            
            ->sum('nettotal');
        $cashincurrentdate = CashDrawer::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            
            ->sum('cashin');
        $cashoutcurrentdate = CashDrawer::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            
            ->where('cancel', 0)
            ->sum('cashout');
        $acountcashin = CashInCashOut::where('type', 1)
            
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->sum('amount');
        $acountcashout = CashInCashOut::where('type', 2)
            
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->sum('amount');
        $data['totalcashin'] = $cashincurrentdate + $acountcashin;
        $data['totalcashout'] = $cashoutcurrentdate + $acountcashout;
        $cashin = CashDrawer::where('cancel', 0)->sum('cashin');
        $cashout = CashDrawer::where('cancel', 0)->sum('cashout');
        $data['balance'] = $cashin - $cashout;
        $data['Expenses'] = Expenses::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            
            ->where('void', 0)
            ->sum('amount');
        $cashinbank = Bank::where('cancel', 0)->sum('cashin');
        $cashoutbank = Bank::where('cancel', 0)->sum('cashout');
        $data['Bank'] = $cashinbank - $cashoutbank;

        $product = Product::all();
        $netstock = 0;
        foreach ($product as $products) {
            $openigqty =  $products->openingStock()->sum('qty');
            $invoice = $products->QuantityOutBySale()->sum('qty');
            $invoiceReturn = $products->QuantityOutBySaleReturn()->sum('qty');
            $totalinvoiceqty = $invoice - $invoiceReturn;
            $purchase = $products->QuantityOutByPurchase()->sum('qty');
            $PurchaseReturn = $products->QuantityOutByPurchaseReturn()->sum('qty');
            $totalPurchaseqty = $purchase - $PurchaseReturn;
            $stock = $openigqty + ($totalPurchaseqty - $totalinvoiceqty);
            $mrp = $products->mrp;
            $stockamount =  $stock * $mrp;
            $netstock += $stockamount;
        }
        $data['stockamount']  = $netstock;
        return response()->json($data);
    }

    //yearly

    public function Yearly()
    {
        return view('dayclose.yearlyindex');
    }

    public function LoadAllYearly(Request $request)
    {
      
        $type = 3;
        $a = $this->DataTables($request, $type);
        return $a;
    }

    public function YearlyCreate()
    {
        return view('dayclose.yearlycreate');
    }

    function getDataYearly(Request $request)
    {
        $year = $request->date;
        $cashin = 0;
        $cashout = 0;
        $data['cashinvoice'] = Invoice::where('type_id', 1)
            ->whereYear('created_at', $year)
            ->where('cancel', 0)
            
            ->sum('nettotal');
        $data['creditinvoice'] = Invoice::where('type_id', 2)
            ->whereYear('created_at', $year)
            ->where('cancel', 0)
            
            ->sum('nettotal');
        $data['salereturn'] = SaleReturn::whereYear('created_at', $year)
            
            ->sum('nettotal');
        $data['purchase'] = purchase::whereYear('created_at', $year)
            
            ->sum('nettotal');
        $data['grn'] = PurchaseRecieved::join('purchases', 'purchases.id', '=', 'purchase_recieveds.purchase_id')
            ->whereYear('purchase_recieveds.created_at', '=', $year)
            ->get([DB::raw('sum(purchases.nettotal) as value')])
            ->sum('value');
        $data['SupplierPayment'] = SupplierPayment::whereYear('created_at', $year)
            
            ->sum('payment');
        $data['CustomerRecieved'] = CustomerPaymentRecieve::whereYear('created_at', $year)
            
            ->sum('recieve');
        $data['purchasereturn'] = PurchaseReturn::whereYear('created_at', $year)
            
            ->sum('nettotal');
        $cashincurrentdate = CashDrawer::whereYear('created_at', $year)
            
            ->sum('cashin');
        $cashoutcurrentdate = CashDrawer::whereYear('created_at', $year)
            
            ->where('cancel', 0)
            ->sum('cashout');
        $acountcashin = CashInCashOut::where('type', 1)
            
            ->whereYear('created_at', $year)
            ->sum('amount');
        $acountcashout = CashInCashOut::where('type', 2)
            
            ->whereYear('created_at', $year)
            ->sum('amount');
        $data['totalcashin'] = $cashincurrentdate + $acountcashin;
        $data['totalcashout'] = $cashoutcurrentdate + $acountcashout;
        $cashin = CashDrawer::where('cancel', 0)->sum('cashin');
        $cashout = CashDrawer::where('cancel', 0)->sum('cashout');
        $data['balance'] = $cashin - $cashout;
        $data['Expenses'] = Expenses::whereYear('created_at', $year)
            
            ->where('void', 0)
            ->sum('amount');
        $cashinbank = Bank::where('cancel', 0)->sum('cashin');
        $cashoutbank = Bank::where('cancel', 0)->sum('cashout');
        $data['Bank'] = $cashinbank - $cashoutbank;

        $product = Product::all();
        $netstock = 0;
        foreach ($product as $products) {
            $openigqty =  $products->openingStock()->sum('qty');
            $invoice = $products->QuantityOutBySale()->sum('qty');
            $invoiceReturn = $products->QuantityOutBySaleReturn()->sum('qty');
            $totalinvoiceqty = $invoice - $invoiceReturn;
            $purchase = $products->QuantityOutByPurchase()->sum('qty');
            $PurchaseReturn = $products->QuantityOutByPurchaseReturn()->sum('qty');
            $totalPurchaseqty = $purchase - $PurchaseReturn;
            $stock = $openigqty + ($totalPurchaseqty - $totalinvoiceqty);
            $mrp = $products->mrp;
            $stockamount =  $stock * $mrp;
            $netstock += $stockamount;
        }
        $data['stockamount']  = $netstock;
        return response()->json($data);
    }
}
