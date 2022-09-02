<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CashDrawer;
use DataTables;

class CashDrawerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:cashdrawer-list', ['only' => ['index']]);
    }

    public function index()
    {
        return view('cashdrawer.index');
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
            $CashDrawer = CashDrawer::orderBy('id', 'desc')
                ->where('cancel',0)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $CashDrawer = CashDrawer::orderBy('id', 'desc')
                ->where('cancel',0)
                ->latest()
                ->get();
        }
        return Datatables::of($CashDrawer)
            ->addIndexColumn()
            ->addColumn('user', function (CashDrawer $CashDrawer) {
                return $CashDrawer->username ? $CashDrawer->username->name : 'Deleted User';
            })
            ->addColumn('action', function ($CashDrawer) {
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
                $button .= '<button id="datashow" type="button" name="edit" data-type="' . $CashDrawer->type_id . '"  data-id="' . $CashDrawer->payment_id . '" class="edit btn btn-outline-success btn-sm">Show</button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '</div>';
                return $button;
            })

            ->make(true);
    }
    public function GetList()
    {
        //  $currentdatetime = date('Y/m/d');
        /*  $CashDrawer = CashDrawer::Where('inputdate', $currentdatetime)->orderBy('purchasecode', 'desc')->get(); */
        $CashDrawer = CashDrawer::orderBy('id', 'desc')->get();
        return response()->json($CashDrawer);
    }
    public function PrasentBalance()
    {
        $balance = 0;
        $cashin = 0;
        $cashout = 0;
        $cashin = CashDrawer::where('cancel',0)->sum('cashin');
        $cashout = CashDrawer::where('cancel',0)->sum('cashout');
        $balance = $cashin - $cashout;
        return response()->json($balance);
    }
    public function BalanceCheck(Request $request)
    {
        $check = 0;
        $balance = 0;
        $cashin = 0;
        $cashout = 0;
        $cashin = CashDrawer::where('cancel',0)->sum('cashin');
        $cashout = CashDrawer::where('cancel',0)->sum('cashout');
        $balance = $cashin - $cashout;
        $payment = $request->payment;
        if ($payment <= $balance) {
            $check = 1;
        } else {
            $check = 0;
        }
        return response()->json($check);
    }
}
