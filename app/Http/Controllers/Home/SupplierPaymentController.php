<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\SupplierPayment;
use App\Models\CashDrawer;
use App\Models\supplier;
use App\Models\DayClose;
use App\Models\SupplierDebt;
use App\Models\Bank;
use DataTables;
use PDF;
use Illuminate\Support\Facades\Session;
use App\Models\NumberFormat;

class SupplierPaymentController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:purchase payment-list|purchase payment-create|purchase payment-edit|purchase payment-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:purchase payment-create', ['only' => ['create', 'Store']]);
        $this->middleware('permission:purchase-edit', ['only' => ['edit', 'update', 'DataUpdate']]);
        $this->middleware('permission:purchase-delete', ['only' => ['destroy']]);
        $this->middleware('permission:mail-list', ['only' => ['SendMail',]]);
    }
    public function index()
    {
        return view('supplierpayment.index');
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
            $payments = SupplierPayment::orderBy('id', 'desc')
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $payments = SupplierPayment::orderBy('id', 'desc')->latest()->get();
        }
        return Datatables::of($payments)
            ->addIndexColumn()
            ->addColumn('supplier', function (SupplierPayment $SupplierPayment) {
                return $SupplierPayment->SupplierName->name;
            })
            ->addColumn('paymenttype', function (SupplierPayment $SupplierPayment) {
                $payment = $SupplierPayment->payment_id;
                switch ($payment) {
                    case 1:
                        $paymenttype = 'Cash';
                        break;
                    case 2:
                        $paymenttype = 'Bank';
                        break;
                    default:

                        break;
                }
                return  $paymenttype;
            })
            ->addColumn('user', function (SupplierPayment $SupplierPayment) {
                return $SupplierPayment->username ? $SupplierPayment->username->name : 'Deleted User';
            })
            ->addColumn('action', function ($SupplierPayments) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $SupplierPayments->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="datadelete" data-id="' . $SupplierPayments->id . '">Delete</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="pdf" data-id="' . $SupplierPayments->id . '">Pdf</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="mail" data-id="' . $SupplierPayments->id . '">Send Mail</a>';
                $button .= '</div></div>';
                return $button;
            })
            ->make(true);
    }
    public function GetList()
    {
        $currentdatetime = date('Y/m/d');
        $SupplierPayment = SupplierPayment::with('SupplierName')->orderBy('id', 'desc')->get();
        return response()->json($SupplierPayment);
    }

    public function create()
    {
        $date = date('m/d/Y');
        $DayClose = DayClose::where('date', $date)->first();
        if ($DayClose == null) {
            return view('supplierpayment.create');
        } else {
            return redirect()->Route('dayclose.daycloseerror');
        }
    }
    public function PaymentNo()
    {
        $NumberFormat = NumberFormat::select('supplierpayment')->where('id', 1)->first();
        $numb = $NumberFormat->supplierpayment;
        $SupplierPayment = new SupplierPayment();
        $lastSupplierPayment = $SupplierPayment->pluck('id')->last();
        $PaymentCode = $lastSupplierPayment + 1;
        return response()->json($numb . $PaymentCode);
    }

    public function Store(Request $request)
    {
        $respnse = "";
        $payment = $request->payment;
        $paymentype = $request->paymenttype;
        $supplierpayment = new SupplierPayment();
        $supplierpayment->payment_no = $request->paymentno;
        $supplierpayment->inputdate = $request->inputdate;
        $supplierpayment->supplier_id = $request->supplier_id;
        $supplierpayment->amount = $request->amount;
        $supplierpayment->payment =  $payment;
        $supplierpayment->balancedue = $request->newbalancedue;
        $supplierpayment->payment_id =  $paymentype;
        $supplierpayment->paymentdescription = $request->paymentdescription;
        $supplierpayment->remark = $request->remark;
        $supplierpayment->user_id = Auth::id();
        if ($supplierpayment->save()) {
            //Update supplier
            $SupplierDebt = new SupplierDebt();
            $SupplierDebt->supplier_id = $request->supplier_id;
            $SupplierDebt->openingBalance = 0;
            $SupplierDebt->consignment = 0;
            $SupplierDebt->totaldiscount = 0;
            $SupplierDebt->payment = $payment;
            $SupplierDebt->remark = 'Payment';
            $SupplierDebt->trn_id =  $supplierpayment->id;
            $SupplierDebt->save();
            //balance update
            $cashin = CashDrawer::sum('cashin');
            $cashout = CashDrawer::sum('cashout');
            $balance = $cashin - $cashout;
            $newbalance = $balance - $payment;

            $cashinbank = Bank::sum('cashin');
            $cashoutbank = Bank::sum('cashout');
            $balancebank = $cashinbank - $cashoutbank;
            $newbalancebank =  $balancebank - $payment;

            if ($paymentype == 1) {
                $this->CashDrawerUpdate($request->inputdate, $payment, $newbalance, $supplierpayment->id);
            } else {
                $this->BankTransactionUpdate($request->inputdate, $payment, $newbalancebank, $supplierpayment->id, $request->bankname, $request->accno, $request->bankdescrip);
            }

            $respnse = $supplierpayment->id;
        } else {

            $respnse = 0;
        }
        return response()->json($respnse);
    }
    public function CashDrawerUpdate($openingdate, $netotal, $newbalance, $invoiceid)
    {
        $Drware = new CashDrawer();
        $Drware->inputdate = $openingdate;
        $Drware->cashin = 0;
        $Drware->cashout = $netotal;
        $Drware->balance = $newbalance;
        $Drware->payment_id = $invoiceid;
        $Drware->type = "Supplier Payment";
        $Drware->type_id = 2;
        $Drware->user_id = Auth::id();
        $Drware->save();
    }
    public function BankTransactionUpdate($openingdate, $netotal, $newbalance, $invoiceid, $bankname, $accno, $bankdescr)
    {
        $Drware = new Bank();
        $Drware->inputdate = $openingdate;
        $Drware->cashin = 0;
        $Drware->cashout = $netotal;
        $Drware->balance = $newbalance;
        $Drware->payment_id = $invoiceid;
        $Drware->type = "Supplier Payment";
        $Drware->type_id = 2;
        $Drware->bank = $bankname;
        $Drware->accno = $accno;
        $Drware->description = $bankdescr;
        $Drware->user_id = Auth::id();
        $Drware->save();
    }
    public function show($id)
    {
        $this->spaymentid($id);
        return view('supplierpayment.view');
    }

    public function spaymentid($id)
    {
        Session::put('spaymentid', $id);
    }
    public function PaymentCodeDatalist(Request $request)
    {
        if ($request->ajax()) {
            $payments = SupplierPayment::orderBy("id", 'asc')->get();
            return view('datalist.paymentcodedatalist', compact('payments'))->render();
        }
    }

    public function GetView()
    {
        $id = Session::get('spaymentid');
        $supplierpayment = SupplierPayment::with('SupplierName', 'SupplierName.CountryName', 'SupplierName.StateName', 'SupplierName.CityName')->find($id);;
        return  response()->json($supplierpayment);
    }
    public function Pdf($id)
    {
        $title = "Supplier Payment";
        $supplierpayment = SupplierPayment::find($id);
        $supplierDebd = SupplierDebt::where('supplier_id', $supplierpayment->supplier_id)
            ->get();
        $consignment = $supplierDebd->sum('consignment');
        $discount = $supplierDebd->sum('totaldiscount');
        $netConsignment = ($consignment - $discount);
        $payments = $supplierDebd->sum('payment');
        $balancedue = $netConsignment - $payments;

        $pdf = PDF::loadView('pdf.supplierpayment', compact('supplierpayment', 'consignment', 'discount', 'payments', 'balancedue', 'title'));
        return $pdf->stream('supplierpayment.pdf');
    }

    public function SendMail($id)
    {
        $supplierpayment = SupplierPayment::find($id);
        return view('supplierpayment.sendmail', compact('supplierpayment'));
    }
    public function GetListSupplier(Request $request)
    {
        $payments = SupplierPayment::where('supplier_id', $request->supplier_id)
            ->orderBy('id', 'desc')->latest()->get();

        return Datatables::of($payments)
            ->addIndexColumn()
            ->addColumn('supplier', function (SupplierPayment $SupplierPayment) {
                return $SupplierPayment->SupplierName->name;
            })
            ->addColumn('paymenttype', function (SupplierPayment $SupplierPayment) {
                $payment = $SupplierPayment->payment_id;
                switch ($payment) {
                    case 1:
                        $paymenttype = 'Cash';
                        break;
                    case 2:
                        $paymenttype = 'Card';
                        break;
                    default:
                        $paymenttype = 'Bank';
                        break;
                }
                return  $paymenttype;
            })
            ->addColumn('user', function (SupplierPayment $SupplierPayment) {
                return $SupplierPayment->username->name;
            })

            ->addColumn('action', function ($SupplierPayments) {
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
                $button .= '<button id="datashow" type="button" name="edit" data-id="' . $SupplierPayments->id . '" class="edit btn btn-outline-success btn-sm">Show</button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button id="pdf" type="button" name="delete" data-id="' . $SupplierPayments->id . '" class="delete btn btn-outline-info btn-sm">Pdf</button>';
                $button .= '</div>';
                return $button;
            })
            ->make(true);
    }

    public function destroy($id)
    {
        $SupplierPayment = SupplierPayment::find($id);
        if (!is_null($SupplierPayment)) {
            $SupplierDebt = SupplierDebt::where('trn_id', $id)
                ->where('remark', 'Payment')
                ->first();
            if (!is_null($SupplierDebt)) {
                $SupplierDebt->delete();
            }
            $type = $SupplierPayment->payment_id;
            switch ($type) {
                case 1:
                    $CashDrawer = CashDrawer::where('type', 'Supplier Payment')
                        ->where('type_id', 2)
                        ->where('payment_id', $id)
                        ->first();
                    if (!is_null($CashDrawer)) {
                        $CashDrawer->delete();
                    }
                    break;
                case 2:
                    $Bank = Bank::where('type', 'Supplier Payment')
                        ->where('type_id', 2)
                        ->where('payment_id', $id)
                        ->first();
                    if (!is_null($Bank)) {
                        $Bank->delete();
                    }
                    break;
                default:
                    break;
            }
            $SupplierPayment->delete();
        }
    }
}
