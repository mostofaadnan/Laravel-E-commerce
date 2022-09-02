<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Expenses;
use App\Models\DayClose;
use Image;
use Illuminate\Auth\Events\Failed;
use DataTables;
use App\Models\CashDrawer;
use App\Models\NumberFormat;
use App\Models\Bank;
use PDF;
use App\Models\ExpensesType;

class ExpensesController extends Controller
{
   function __construct()
   {
      $this->middleware('permission:expenses-list|expenses-create|expenses-edit|expenses-delete', ['only' => ['index', 'show', 'profile']]);
      $this->middleware('permission:expenses-create', ['only' => ['create', 'store']]);
      $this->middleware('permission:expenses-edit', ['only' => ['edit', 'update', 'DataUpdate']]);
      $this->middleware('permission:expenses-delete', ['only' => ['delete']]);
   }
   public function index()
   {
      return view('expenses.index');
   }
   public function LoadAll(Request $request)
   {
      $a = $this->DataTables();
      return $a;
   }


   public function DataTables()
   {
      $Expenses = Expenses::orderBy('id', 'desc')

         ->latest()
         ->get();
      return Datatables::of($Expenses)
         ->addIndexColumn()
         ->addColumn('exptype', function (Expenses $Expenses) {
            return $Expenses->ExpnensesType->name;
         })
         ->addColumn('source', function ($Expenses) {
            if ($Expenses->payment_type == 1) {
               $source = 'Cash';
            } else {
               $source = 'Bank';
            }
            return $source;
         })
         ->addColumn('user', function (Expenses $Expenses) {
          
            return $Expenses->username ? $Expenses->username->name : 'Deleted User';
         })
         ->addColumn('action', function ($Expenses) {
            $button = '<div class="btn-group" role="group">';
            $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
            $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
            $button .= '<a class="dropdown-item" id="datashow" data-id="' . $Expenses->id . '">View</a>';
            $button .= '<div class="dropdown-divider"></div>';
            if ($Expenses->void == 0) {
               $button .= '<a class="dropdown-item" id="canceldata" data-id="' . $Expenses->id . '"><span style="color:red">Void</span></a>';
            } else {
               $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $Expenses->id . '">Delete</a>';
            }
            if ($Expenses->void == 1) {
               $button .= '<div class="dropdown-divider"></div>';
               $button .= '<a class="dropdown-item" id="retrivedata" data-id="' . $Expenses->id . '"><span style="color:gren">Retrive</span></a>';
            }
            $button .= '<div class="dropdown-divider"></div>';
            $button .= '<a class="dropdown-item" id="print" data-id="' . $Expenses->id . '">Print</a>';
            $button .= '<div class="dropdown-divider"></div>';
            $button .= '<a class="dropdown-item" id="pdfdata" data-id="' . $Expenses->id . '">Pdf</a>';
            $button .= '</div></div>';
            return $button;
         })

         ->make(true);
   }
   public function GetList()
   {
      $Expenses = Expenses::with('ExpnensesType')->orderBy('id', 'desc')->get();
      return response()->json($Expenses);
   }
   public function ExpensesCodeDataList(Request $request)
   {
      if ($request->ajax()) {
         $ExpensesCodes = Expenses::orderBy("id", 'asc')->get();
         return view('datalist.expensescodedatalist', compact('ExpensesCodes'))->render();
      }
   }
   public function create()
   {
      $date = date('m/d/Y');
      $DayClose = DayClose::where('date', $date)->first();
      if ($DayClose == null) {
         return view('expenses.create');
      } else {
         return redirect()->Route('dayclose.daycloseerror');
      }
   }
   public function Expensesno()
   {

      $NumberFormat = NumberFormat::select('expneses')->where('id', 1)->first();
      $numb = $NumberFormat->expneses;
      $Expenses = new Expenses();
      $lastExpenses = $Expenses->pluck('id')->last();
      $PaymentCode = $lastExpenses + 1;
      return response()->json($numb . $PaymentCode);
   }
   public function Store(Request $request)
   {
      $response = "";

      $validator = $request->validate([
         'title' => 'required',
         'expenses_type' => 'required|numeric',
         'amount' => 'required|numeric',
         'paymenttype' => 'required|numeric',

      ]);
      $amount = $request->amount;
      $paymentype = $request->paymenttype;
      $dateinput = $request->dateinput;
      $expenses = new Expenses();
      $expenses->expenses_no = $request->expensesno;
      $expenses->Exp_Title = $request->title;
      $expenses->expenses_id = $request->expenses_type;
      $expenses->inputdate = $dateinput;
      $expenses->amount = $amount;
      $expenses->description = $request->remark;
      $expenses->payment_type =  $paymentype;
      $expenses->payment_description = $request->paymentdescription;
      $expenses->voucherno = $request->voucher_no;
      $expenses->user_id = Auth::id();
      /*  single image insert   */
      if ($expenses->save()) {
         $cashin = CashDrawer::sum('cashin');
         $cashout = CashDrawer::sum('cashout');
         $balance = $cashin - $cashout;
         $newbalance = $balance - $amount;

         $cashinbank = Bank::sum('cashin');
         $cashoutbank = Bank::sum('cashout');
         $balancebank = $cashinbank - $cashoutbank;
         $newbalancebank =  $balancebank - $amount;

         if ($paymentype == 1) {
            $this->CashDrawerUpdate($request->expensestype, $request->dateinput, $amount, $newbalance, $expenses->id);
         } else {
            $this->BankTransactionUpdate($request->expensestype, $dateinput, $amount, $newbalancebank, $expenses->id, $request->bankname, $request->accno, $request->bankdescrip);
         }

         $response = $expenses->id;
      } else {
         $response = 0;
      }
      return response()->json($response);
      //return redirect()->Route('expenses.create');
   }
   public function CashDrawerUpdate($title, $openingdate, $netotal, $newbalance, $invoiceid)
   {
      $Drware = new CashDrawer();
      $Drware->inputdate = $openingdate;
      $Drware->cashin = 0;
      $Drware->cashout = $netotal;
      $Drware->balance = $newbalance;
      $Drware->payment_id = $invoiceid;
      $Drware->type = "Expenses:" . $title;
      $Drware->type_id = 5;
      $Drware->user_id = Auth::id();
      $Drware->save();
   }
   public function BankTransactionUpdate($title, $openingdate, $netotal, $newbalance, $invoiceid, $bankname, $accno, $bankdescr)
   {
      $Drware = new Bank();
      $Drware->inputdate = $openingdate;
      $Drware->cashin = 0;
      $Drware->cashout = $netotal;
      $Drware->balance = $newbalance;
      $Drware->payment_id = $invoiceid;
      $Drware->type = "Expenses:" . $title;
      $Drware->type_id = 5;
      $Drware->bank = $bankname;
      $Drware->accno = $accno;
      $Drware->description = $bankdescr;
      $Drware->user_id = Auth::id();
      $Drware->save();
   }
   public function Cancel($id)
   {
      $canceled = 1;
      $cancelinv = Expenses::find($id);
      $exptype = "Expenses:" . $cancelinv->ExpnensesType->name;;
      if (!is_null($cancelinv)) {
         $type = $cancelinv->payment_type;
         if ($type == 1) {
            CashDrawer::where('type',  $exptype)
               ->where('payment_id', $id)
               ->update(['cancel' => $canceled]);
         } else {
            Bank::where('type',  $exptype)
               ->where('payment_id', $id)
               ->update(['cancel' => $canceled]);
         }
         Expenses::where('id', $id)
            ->update(['void' => $canceled]);
      }
   }
   public function Retrive($id)
   {
      $canceled = 0;
      $cancelinv = Expenses::find($id);
      $exptype = "Expenses:" . $cancelinv->ExpnensesType->name;;
      if (!is_null($cancelinv)) {
         $type = $cancelinv->payment_type;
         if ($type == 1) {
            CashDrawer::where('type',  $exptype)
               ->where('payment_id', $id)
               ->update(['cancel' => $canceled]);
         } else {
            Bank::where('type',  $exptype)
               ->where('payment_id', $id)
               ->update(['cancel' => $canceled]);
         }
         Expenses::where('id', $id)
            ->update(['void' => $canceled]);
      }
   }
   public function Destroy($id)
   {
      $canceled = 1;
      $expensesDeelete = Expenses::find($id);
      $exptype = "Expenses:" . $expensesDeelete->ExpnensesType->name;;
      if (!is_null($expensesDeelete)) {
         $type = $expensesDeelete->payment_type;
         if ($type == 1) {
            $cashdelete = CashDrawer::where('type',  $exptype)
               ->where('payment_id', $id)
               ->first();
            if (!is_null($cashdelete)) {
               $cashdelete->delete();
            }
         } else {
            $bankdelete = Bank::where('type',  $exptype)
               ->where('payment_id', $id)
               ->first();
            if (!is_null($bankdelete)) {
               $bankdelete->delete();
            }
         }
         $expensesDeelete->delete();
      }
   }
   public function Show($id)
   {
      $this->expensesid($id);
      return view('expenses.view');
   }
   public function expensesid($id)
   {
      Session::put('expensesid', $id);
   }
   public function GetView()
   {
      $id = Session::get('expensesid');
      $Expenses = Expenses::with('ExpnensesType')->orderBy('id', 'desc')->where('id', $id)->first();
      return response()->json($Expenses);
   }
   public function Pdf($id)
   {
      $title = "Expenses";
      $Expenses = Expenses::find($id);
      $pdf = PDF::loadView('pdf.expenses', compact('Expenses', 'title'));
      return $pdf->stream('Expenses.pdf');
   }

   public function LoadPrintslip($id)
   {
      $title = "Expenses";
      $Expenses = Expenses::find($id);
      return view('pdf.expenses', compact('Expenses', 'title'));
   }
   public function Print($id)
   {
      $Expenses = Expenses::find($id);
      return view('pdf.expenses', compact('Expenses'));
   }
   public function SectorexpenditureView()
   {
      return view('expenses.sectorexpenditureview');
   }
   public function Sectorexpenditure()
   {
      $Expenses = ExpensesType::orderBy('id', 'desc')
         ->latest()
         ->get();
      return Datatables::of($Expenses)
         ->addIndexColumn()
         ->addColumn('cashamount', function ($Expenses) {
            return  $Expenses->totalAmount(1)->sum('amount');
         })
         ->addColumn('bankamount', function ($Expenses) {
            return  $Expenses->totalAmount(2)->sum('amount');
         })
         ->addColumn('total', function ($Expenses) {
         
            $cash = $Expenses->totalAmount(1)->sum('amount');
            $bank = $Expenses->totalAmount(2)->sum('amount');
            $total = $cash + $bank;
            return $total;
         })


         ->make(true);
   }
}
