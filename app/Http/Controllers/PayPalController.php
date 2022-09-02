<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\PaypalPayment;
use DataTables;

class PayPalController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:card-paypal', ['only' => ['index']]);
    }
    public function index()
    {
        return view('paypal.index');
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
            $PaypalPayment = PaypalPayment::orderBy('id', 'desc')
                ->where('cancel',0)
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $PaypalPayment = PaypalPayment::orderBy('id', 'desc')
                ->where('cancel',0)
                ->latest()
                ->get();
        }
        return Datatables::of($PaypalPayment)
            ->addIndexColumn()
            ->addColumn('created_at', function (PaypalPayment $PaypalPayment) {
                return date('Y/m/d', strtotime($PaypalPayment->created_at));
            })
         /*    ->addColumn('time', function (PaypalPayment $PaypalPayment) {
                return Carbon::parse( $PaypalPayment->time)->format('H:i:s A');
            }) */
            ->addColumn('user', function (PaypalPayment $PaypalPayment) {
                return $PaypalPayment->username ? $PaypalPayment->username->name : 'Deleted User';
            })
            ->addColumn('action', function ($PaypalPayment) {
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
                $button .= '<button id="datashow" type="button" name="edit" data-type="' . $PaypalPayment->description . '"  data-id="' . $PaypalPayment->id . '" class="edit btn btn-outline-success btn-sm">Show</button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '</div>';
                return $button;
            })

            ->make(true);
    }
}
