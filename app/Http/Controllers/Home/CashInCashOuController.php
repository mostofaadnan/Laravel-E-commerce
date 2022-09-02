<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CashInCashOut;
use App\Models\CashDrawer;
use App\Models\Bank;
use DataTables;
use PDF;

class CashInCashOuController extends Controller
{


    public function index()
    {
        return view('cashincashout.index');
    }

    public function LoadAll(Request $request)
    {
      
        $a = $this->DataTables();
        return $a;
    }

    public function DataTables()
    {
        $CashInCashOut = CashInCashOut::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($CashInCashOut)
            ->addIndexColumn()
            ->addColumn('cashin', function ($CashInCashOut) {
                if ($CashInCashOut->type == 1) {
                    return $CashInCashOut->amount;
                } else {
                    return 0;
                }
            })
            ->addColumn('cashout', function ($CashInCashOut) {
                if ($CashInCashOut->type == 2) {
                    return $CashInCashOut->amount;
                } else {
                    return 0;
                }
            })
            ->addColumn('type', function ($CashInCashOut) {
                return $CashInCashOut->type == 1 ?  'CashIn' : 'CashOut';
            })
            ->addColumn('source', function ($CashInCashOut) {
                switch ($CashInCashOut->source) {
                    case 1:
                        $source = 'Cash';
                        break;
                    case 2:
                        $source = 'Bank';
                        break;
                    default:
                        $source = "";
                        break;
                }
                return $source;
            })
            ->addColumn('user', function (CashInCashOut $CashInCashOut) {
                return $CashInCashOut->username ? $CashInCashOut->username->name : 'Deleted User';
            })
            ->addColumn('action', function ($CashInCashOut) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $CashInCashOut->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="datadelete" data-id="' . $CashInCashOut->id . '">Delete</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="pdf" data-id="' . $CashInCashOut->id . '">Pdf</a>';
                $button .= '</div></div>';
                return $button;
            })
            ->make(true);
    }
    public function Create()
    {
        return view('cashincashout.create');
    }
    public function PaymentNo()
    {

        $id = 0;
        // $commentts='P-';
        $start = 1000;
        $increament = 1;
        $CashInCashOut  = CashInCashOut::latest('id')->first();
        if (!is_null($CashInCashOut)) {
            $id = $CashInCashOut->id;
        } else {
            $id = 0;
        }
        $paymentcode = $id + $start + $increament;
        return response()->json($paymentcode);
    }

    public function Store(Request $request)
    {
        $type_id = $request->type;
        $amount = $request->amount;
        $source = $request->source;
        $cashincashout = new CashInCashOut();
        $cashincashout->payment_no = $request->paymentno;
        $cashincashout->type = $type_id;
        $cashincashout->inputdate = $request->inputdate;
        $cashincashout->amount = $amount;
        $cashincashout->source = $request->source;
        $cashincashout->remark = $request->remark;
        $cashincashout->user_id = Auth::id();
        $cashincashout->payment_description = $request->paymentdescription;
        if ($cashincashout->save()) {
            $cashin = CashDrawer::where('cancel', 0)->sum('cashin');
            $cashout = CashDrawer::where('cancel', 0)->sum('cashout');
            $balance = $cashin - $cashout;
            if ($type_id == 1) {
                $newbalancebank = $balance + $amount;
            } else {
                $newbalancebank = $balance - $amount;
            }


            $cashinbank = Bank::where('cancel', 0)->sum('cashin');
            $cashoutbank = Bank::where('cancel', 0)->sum('cashout');
            $balancebank = $cashinbank - $cashoutbank;

            if ($type_id == 1) {
                $newbalance = $balancebank + $amount;
            } else {
                $newbalance = $balancebank - $amount;
            }
            if ($source == 1) {
                $this->CashDrawerUpdate($type_id, $request->inputdate, $amount, $newbalance, $cashincashout->id);
            } else {
                $this->BankTransactionUpdate($type_id, $request->inputdate, $amount, $newbalancebank, $cashincashout->id, $request->bankname, $request->accno, $request->bankdescrip);
            }
            $response = $cashincashout->id;
        } else {
            $response = 0;
        }
        return response()->json($response);
    }
    public function CashDrawerUpdate($type, $openingdate, $amount, $newbalance, $id)
    {
        $Drware = new CashDrawer();
        $Drware->inputdate = $openingdate;
        if ($type == 1) {
            $Drware->cashin = $amount;
            $Drware->cashout = 0;
            $Drware->type = "Cash In";
        } else {
            $Drware->cashin = 0;
            $Drware->cashout = $amount;
            $Drware->type = "Cash Out";
        }
        $Drware->balance = $newbalance;
        $Drware->payment_id = $id;
        $Drware->type_id = 8;
        $Drware->user_id = Auth::id();;
        $Drware->save();
    }
    public function BankTransactionUpdate($type, $openingdate, $amount, $newbalance, $id, $bankname, $accno, $bankdescr)
    {
        $Drware = new Bank();
        $Drware->inputdate = $openingdate;
        if ($type == 1) {
            $Drware->cashin = $amount;
            $Drware->cashout = 0;
            $Drware->type = "Cash In";
        } else {
            $Drware->cashin = 0;
            $Drware->cashout = $amount;
            $Drware->type = "Cash Out";
        }
        $Drware->balance = $newbalance;
        $Drware->payment_id = $id;
        $Drware->bank = $bankname;
        $Drware->accno = $accno;
        $Drware->description = $bankdescr;
        $Drware->type_id = 8;
        $Drware->user_id = Auth::id();

        $Drware->save();
    }
    public function GetList()
    {
        //  $currentdatetime = date('Y/m/d');
        /*  $CashDrawer = CashDrawer::Where('inputdate', $currentdatetime)->orderBy('purchasecode', 'desc')->get(); */
        $CashInCashOut = CashInCashOut::orderBy('id', 'desc')->get();
        return response()->json($CashInCashOut);
    }
    public function GetView($id)
    {
        $CashInCashOut = CashInCashOut::find($id);
        return response()->json($CashInCashOut);
    }

    public function Show()
    {
        return view('cashincashout.view');
    }
    public function CiCoCodeDataList(Request $request)
    {
        if ($request->ajax()) {
            $CashInCashOuts = CashInCashOut::orderBy("id", 'asc')->get();
            return view('datalist.cicocodedatalist', compact('CashInCashOuts'))->render();
        }
    }
    public function Pdf($id)
    {
        $title = "Cashin/Cashout";
        $CashInCashOut = CashInCashOut::find($id);
        $pdf = PDF::loadView('pdf.cashincashout', compact('CashInCashOut', 'title'));
        return $pdf->stream('cashincashout.pdf');
    }
    public function Delete($id)
    {
        $CashInCashOut = CashInCashOut::find($id);
        if (!is_null($CashInCashOut)) {
            if ($CashInCashOut->source == 1) {
                //Cash Drawer Delete
                $CashDrawer = CashDrawer::where('type_id', 7)
                    ->where('payment_id', $CashInCashOut->id)
                    ->first();
                if (!is_null($CashDrawer)) {
                    $CashDrawer->delete();
                }
            } else {
                //Bank Delete
                $Bank = Bank::where('type_id', 7)
                    ->where('payment_id', $CashInCashOut->id)
                    ->first();
                if (!is_null($Bank)) {
                    $Bank->delete();
                }
            }
            $CashInCashOut->delete();
        }
    }

}
