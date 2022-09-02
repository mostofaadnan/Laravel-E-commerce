<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CardPayment;
use DataTables;
use Stripe;

class CardPaymentController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:card-list', ['only' => ['index']]);
    }
    public function index()
    {
        return view('card.index');
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
            $CardPayment = CardPayment::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $CardPayment = CardPayment::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->latest()
                ->get();
        }
        return Datatables::of($CardPayment)
            ->addIndexColumn()
            ->addColumn('user', function (CardPayment $CardPayment) {
                return $CardPayment->username ? $CardPayment->username->name : 'Deleted User';
            })
            ->addColumn('action', function ($CardPayment) {
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
                $button .= '<button id="datashow" type="button" name="edit" data-type="' . $CardPayment->type . '"  data-id="' . $CardPayment->id . '" class="edit btn btn-outline-success btn-sm">Show</button>';
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
        $cashin = CardPayment::sum('cashin');
        $cashout = CardPayment::sum('cashout');
        $balance = $cashin - $cashout;
        return response()->json($balance);
    }

    public function StripeBalancseHistry()
    {
        $historys = Stripe::balance()->all();
        return view('card.stripehistory', compact('historys'));
    }

    public function StripeLoad()
    {
        // $todate = date('Y/m/d', strtotime($request->todate));
        $historys = Stripe::balance()->all();
        return Datatables::of($historys['data'])
            ->addIndexColumn()
            ->make(true);
    }
  
}
