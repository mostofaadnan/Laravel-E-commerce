<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NumberFormat;

class numberFormatController extends Controller
{
    public function index(){
        return view('setup.numberconfig');
    }
    public function View()
    {

        $SaleConfig = NumberFormat::find(1);
        return response()->json($SaleConfig);
    }
    public function Update(Request $request)
    {
        $NumberFormat = NumberFormat::find(1);
        $NumberFormat->branch = $request->branch;
        $NumberFormat->product = $request->product;
        $NumberFormat->purchase = $request->purchase;
        $NumberFormat->purchasereturn = $request->purchasereturn;
        $NumberFormat->grn = $request->grn;
        $NumberFormat->cashinvoice = $request->cashinvoice;
        $NumberFormat->creditinvoice = $request->creditinvoice;
        $NumberFormat->salereturn = $request->salereturn;
        $NumberFormat->supplierpayment = $request->supplierpayment;
        $NumberFormat->creditpayment = $request->creditpayment;
        $NumberFormat->expneses = $request->expneses;
        $NumberFormat->update();
    }
}
