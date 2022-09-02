<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\salary;
use App\Models\salaryDetails;
use App\Models\CashDrawer;
use App\Models\Bank;
use DataTables;
use PDF;

class SalaryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:salary-list|salary-create|salary-edit|salary-delete', ['only' => ['index', 'show', 'Salarypayment', 'SalaryPaymentShow']]);
        $this->middleware('permission:salary-create', ['only' => ['Create', 'Store', 'CreateSalaryPayment']]);
        $this->middleware('permission:salary-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:transfer-delete', ['only' => ['destroy', 'SalaryPaymentDelete']]);
    }
    public function index()
    {
        return view('salary.index');
    }
    public function LoadAll()
    {
        $salary = salary::orderBy('id', 'desc')->latest()->get();
        return Datatables::of($salary)
            ->addIndexColumn()
            ->addColumn('payment', function ($salary) {
                if ($salary->payment_type == 1) {
                    $source = 'Cash';
                } else if ($salary->payment_type == 2) {
                    $source = 'Bank';
                } else {
                    $source = '';
                }
                return $source;
            })

            ->addColumn('action', function ($salary) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $salary->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                if ($salary->status == 0) {
                    $button .= '<a class="dropdown-item" id="dataedit" data-id="' . $salary->id . '">Edit</a>';
                    $button .= '<div class="dropdown-divider"></div>';
                }
                if ($salary->status == 0) {
                    $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $salary->id . '">Delete</a>';
                    $button .= '<div class="dropdown-divider"></div>';
                }
                $button .= '<a class="dropdown-item" id="pdf" data-id="' . $salary->id . '">Pdf</a>';

                $button .= '</div></div>';
                return $button;
            })
            ->make(true);
    }

    public function Create()
    {
        return view('salary.create');
    }

    public function PaymentCode()
    {

        $numb = '100';
        $salary = new salary();
        $lastsalary = $salary->pluck('id')->last();
        $salarycode = $lastsalary + 1;
        return response()->json($numb . $salarycode);
    }
    public function Store(Request $request)
    {
        $datareponse = "";
        $salary = new salary();
        $salary->payment_no = $request->paymentno;
        $salary->inputdate = $request->inputdate;
        $salary->from_date = $request->fromdate;
        $salary->to_date = $request->todate;
        $salary->total_salary = $request->salary;
        $salary->total_over_time = $request->overtime;
        $salary->total_bonus = $request->bonus;
        $salary->total_reduction = $request->reduction;
        $salary->netsalary = $request->nettotals;
        $salary->status = 0;

        if ($salary->save() == true) {
            //purchase Details
            $tableData = $request->itemtables;
            foreach ($tableData as $items) {
                $salaryDetails = new salaryDetails();
                $salaryDetails->salary_id = $salary->id;
                $salaryDetails->employee_id = $items['id'];
                $salaryDetails->from_date = $request->fromdate;
                $salaryDetails->to_date = $request->todate;
                $salaryDetails->salary = $items['salary'];
                $salaryDetails->over_time = $items['overtime'];
                $salaryDetails->bonus = $items['bonus'];
                $salaryDetails->reduction = $items['reduction'];
                $salaryDetails->netsalary = $items['nettotal'];
                $salaryDetails->status = 0;
                $salaryDetails->save();
            }
        }
        $datareponse = $salary->id;
        return response()->json($datareponse);
    }
    public function Show()
    {
        return view('salary.view');
    }
    public function SalaryCodeDataList(Request $request)
    {
        if ($request->ajax()) {
            $salarys = salary::orderBy("id", 'asc')->get();
            return view('datalist.salarycodedatalist', compact('salarys'))->render();
        }
    }
    public function SalaryCodedataListActive(Request $request)
    {
        if ($request->ajax()) {
            $salarys = salary::orderBy("id", 'asc')->where('status', 1)->get();
            return view('datalist.salarycodedatalist', compact('salarys'))->render();
        }
    }
    public function SalaryCodedataListInactive(Request $request)
    {
        if ($request->ajax()) {
            $salarys = salary::orderBy("id", 'asc')->where('status', 0)->get();
            return view('datalist.salarycodedatalist', compact('salarys'))->render();
        }
    }
    public function GetView($id)
    {

        $salarys = salary::with('Details', 'Details.employeeName')->find($id);
        return response()->json($salarys);
    }
    public function Pdf($id)
    {
        $title = "Salary Sheet";
        $salary = salary::find($id);
        $pdf = PDF::loadView('pdf.salarysheet', compact('salary', 'title'))->setPaper('a4', 'landscape');
        return $pdf->stream('salarysheet.pdf');
    }
    public function Edit()
    {
        return view('salary.edit');
    }
    public function Update(Request $request)
    {
        $datareponse = "";
        $salary = salary::find($request->salaryid);
        if ($salary->status == 0) {
            $salary->payment_no = $request->paymentno;
            $salary->inputdate = $request->inputdate;
            $salary->from_date = $request->fromdate;
            $salary->to_date = $request->todate;
            $salary->total_salary = $request->salary;
            $salary->total_over_time = $request->overtime;
            $salary->total_bonus = $request->bonus;
            $salary->total_reduction = $request->reduction;
            $salary->netsalary = $request->nettotals;
            $salary->status = 0;

            if ($salary->save() == true) {
                $salaryDetails = salaryDetails::where('salary_id', $request->salaryid)->get();
                foreach ($salaryDetails as $sddelete) {
                    $sddelete->delete();
                }
                //purchase Details
                $tableData = $request->itemtables;
                foreach ($tableData as $items) {
                    $salaryDetails = new salaryDetails();
                    $salaryDetails->salary_id = $request->salaryid;
                    $salaryDetails->employee_id = $items['id'];
                    $salaryDetails->from_date = $request->fromdate;
                    $salaryDetails->to_date = $request->todate;
                    $salaryDetails->salary = $items['salary'];
                    $salaryDetails->over_time = $items['overtime'];
                    $salaryDetails->bonus = $items['bonus'];
                    $salaryDetails->reduction = $items['reduction'];
                    $salaryDetails->netsalary = $items['nettotal'];
                    $salaryDetails->status = 0;
                    $salaryDetails->save();
                }
            }
            $datareponse = $salary->id;
            return response()->json($datareponse);
        }
    }

    //Salary Payment
    public function Salarypayment()
    {
        return view('salary.salarypayment');
    }

    public function SalarypaymentLoadAll()
    {
        $salary = salary::orderBy('id', 'desc')->latest()->get();
        return Datatables::of($salary)
            ->addIndexColumn()
            ->addColumn('payment', function ($salary) {
                if ($salary->payment_type == 1) {
                    $source = 'Cash';
                } else if ($salary->payment_type == 2) {
                    $source = 'Bank';
                } else {
                    $source = '';
                }
                return $source;
            })

            ->addColumn('action', function ($salary) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $salary->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $salary->id . '">Delete</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="pdf" data-id="' . $salary->id . '">Pdf</a>';
                $button .= '</div></div>';
                return $button;
            })
            ->make(true);
    }
    public function CreateSalaryPayment()
    {
        return view('salary.creayesalartpayment');
    }
    public function SalaryPaymentStore(Request $request)
    {
        $response = "";
        $paymentype = $request->paymenttype;
        $salary = salary::find($request->paymentid);
        $salary->inputdate = $request->inputdate;
        $salary->payment_type = $request->paymenttype;
        $salary->remark = $request->remark;
        $salary->payment_description = $request->paymentdescription;
        $salary->status = 1;
        if ($salary->update() == true) {
            $salaryDetails = salaryDetails::where('salary_id', $salary->id)->get();
            foreach ($salaryDetails as $sdupdate) {
                $sdupdate->status = 1;
                $sdupdate->update();
            }
            $amount = $salary->netsalary;
            $cashin = CashDrawer::sum('cashin');
            $cashout = CashDrawer::sum('cashout');
            $balance = $cashin - $cashout;
            $newbalance = $balance - $amount;
            $cashinbank = Bank::sum('cashin');
            $cashoutbank = Bank::sum('cashout');
            $balancebank = $cashinbank - $cashoutbank;
            $newbalancebank =  $balancebank - $amount;
            if ($paymentype == 1) {
                $this->CashDrawerUpdate($request->inputdate, $amount, $newbalance, $salary->id);
            } else {
                $this->BankTransactionUpdate($request->inputdate, $amount, $newbalancebank, $salary->id, $request->bankname, $request->accno, $request->bankdescrip);
            }
            $response = $salary->id;
        } else {
            $response = 0;
        }

        return response()->json($response);
    }
    public function CashDrawerUpdate($openingdate, $amount, $newbalance, $invoiceid)
    {
        $Drware = new CashDrawer();
        $Drware->inputdate = $openingdate;
        $Drware->cashin = 0;
        $Drware->cashout = $amount;
        $Drware->balance = $newbalance;
        $Drware->payment_id = $invoiceid;
        $Drware->type = "Salary Payment";
        $Drware->type_id = 7;
        $Drware->user_id = Auth::id();
        $Drware->save();
    }
    public function BankTransactionUpdate($openingdate, $amount, $newbalance, $invoiceid, $bankname, $accno, $bankdescr)
    {
        $Drware = new Bank();
        $Drware->inputdate = $openingdate;
        $Drware->cashin = 0;
        $Drware->cashout = $amount;
        $Drware->balance = $newbalance;
        $Drware->payment_id = $invoiceid;
        $Drware->type = "Salary Payment";
        $Drware->type_id = 7;
        $Drware->bank = $bankname;
        $Drware->accno = $accno;
        $Drware->description = $bankdescr;
        $Drware->user_id = Auth::id();
        $Drware->save();
    }
    public function SalaryPaymentShow()
    {
        return view('salary.paymentview');
    }
    public function SalaryPaymentDelete($id)
    {
        $salary = salary::find($id);
        if (!is_null($salary)) {
            $type = $salary->payment_type;
            if ($type == 1) {
                $cashdelete = CashDrawer::where('type',  'Salary Payment')
                    ->where('payment_id', $id)
                    ->first();
                if (!is_null($cashdelete)) {
                    $cashdelete->delete();
                }
            } else {
                $bankdelete = Bank::where('type', 'Salary Payment')
                    ->where('payment_id', $id)
                    ->first();
                if (!is_null($bankdelete)) {
                    $bankdelete->delete();
                }
            }
            $salary->delete();
        }
    }
}
