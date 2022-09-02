<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class IncomeController extends Controller
{

    public function index()
    {
        return view('income.index');
    }
    public function LoadAll()
    {
        $Invoice = DB::table("invoices")
            ->select("invoices.id as id","invoices.nettotal as amount", "invoices.invoice_no as number", "invoices.inputdate as inputdate", "invoices.comment as source")
            ->where('type_id', 1)
            ->where('cancel', 0);
        $CustomerPayment = DB::table("customer_payment_recieves")
            ->select("customer_payment_recieves.id as id","customer_payment_recieves.recieve as amount", "customer_payment_recieves.payment_no as number", "customer_payment_recieves.inputdate as inputdate", "customer_payment_recieves.comment as source")
            ->union($Invoice)
            ->orderBy('inputdate', 'desc')
            ->get();

        return Datatables::of($CustomerPayment)
            ->addIndexColumn()
            ->addColumn('action', function ($CustomerPayment) {
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
                $button .= '<button id="datashow" type="button" name="edit" data-type="' . $CustomerPayment->source . '"  data-id="' . $CustomerPayment->id . '" class="edit btn btn-outline-success btn-sm">Show</button>';
                $button .= '</div>';
                return $button;
            })
            ->make(true);
    }
}
