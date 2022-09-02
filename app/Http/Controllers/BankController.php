<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Bank;
use DataTables;

class BankController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:bank-list', ['only' => ['index','LoadAll','PrasentBalance']]);
    }
    public function index()
    {
        return view('bank.index');
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
            $Bank = Bank::orderBy('id', 'desc')
                ->where('cancel',0)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $Bank = Bank::orderBy('id', 'desc')
                ->where('cancel',0)
                ->latest()
                ->get();
        }
        return Datatables::of($Bank)
            ->addIndexColumn()
            ->addColumn('user', function (Bank $Bank) {
                return $Bank->username ? $Bank->username->name : 'Deleted User';
            })
            ->addColumn('action', function ($Bank) {
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
                $button .= '<button id="datashow" type="button" name="edit" data-type="' . $Bank->type_id . '"  data-id="' . $Bank->payment_id . '" class="edit btn btn-outline-success btn-sm">Show</button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '</div>';
                return $button;
            })

            ->make(true);
    }
    public function PrasentBalance()
    {
        $balance = 0;
        $cashin = 0;
        $cashout = 0;
        $cashin = Bank::where('cancel',0)->sum('cashin');
        $cashout = Bank::where('cancel',0)->sum('cashout');
        $balance = $cashin - $cashout;
        return response()->json($balance);
    }
}
