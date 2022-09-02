<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;
use App\Models\SaleConfig;

class SaleConfigaration extends Controller
{
    public function index()
    {
        $customers = customer::all();

        return view('saleconfig.index', compact('customers'));
    }
    public function View()
    {
        $SaleConfig = SaleConfig::find(1);
        return response()->json($SaleConfig);
    }
    public function Update(Request $request)
    {
        $SaleConfig = SaleConfig::find(1);
        $SaleConfig->customer_id = $request->customer_id;
        $SaleConfig->autometic_store = $request->autometic_store;
        $SaleConfig->vat_applicable = $request->vat_applicable;
        $SaleConfig->print = $request->print;
        $SaleConfig->print_credit=$request->print_credit;
        $SaleConfig->footermsg = $request->footermsg;
        $SaleConfig->cash_invoice = $request->cash_invoice;
        $SaleConfig->credit_invoice = $request->credit_invoice;
        $SaleConfig->card_key = $request->card_key;
        $SaleConfig->card_secret = $request->card_secret;
        $SaleConfig->paypal_username = $request->paypal_username;
        $SaleConfig->paypal_password = $request->paypal_password;
        $SaleConfig->paypal_secret = $request->paypal_secret;
        $SaleConfig->update();
    }
}
