<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use DataTables;

class QuantityControll extends Controller
{
    public function index()
    {
        return view('stockmanage.index');
    }
    public function LoadAll()
    {
        $products = Product::orderBy('id', 'desc')->latest()->get();
        return Datatables::of($products)
            ->addIndexColumn()
            ->addColumn('stock', function ($products) {
                $openigqty =  $products->openingStock()->sum('qty');
                $invoice = $products->QuantityOutBySale()->sum('qty');
                $order= $products->QuantityOrder()->sum('qty');
                $invoiceReturn = $products->QuantityOutBySaleReturn()->sum('qty');
                $totalinvoiceqty = $invoice - $invoiceReturn;
                $purchase = $products->QuantityOutByPurchase()->sum('qty');
                $PurchaseReturn = $products->QuantityOutByPurchaseReturn()->sum('qty');
                $totalPurchaseqty = $purchase - $PurchaseReturn;
                $stock = $openigqty + ($totalPurchaseqty - $totalinvoiceqty+$order);
                return   $stock;
            })
            ->addColumn('stockamount', function ($products) {
                $openigqty =  $products->openingStock()->sum('qty');
                $invoice = $products->QuantityOutBySale()->sum('qty');
                $order= $products->QuantityOrder()->sum('qty');
                $invoiceReturn = $products->QuantityOutBySaleReturn()->sum('qty');
                $totalinvoiceqty = $invoice - $invoiceReturn;
                $purchase = $products->QuantityOutByPurchase()->sum('qty');
                $PurchaseReturn = $products->QuantityOutByPurchaseReturn()->sum('qty');
                $totalPurchaseqty = $purchase - $PurchaseReturn;
                $stock = $openigqty + ($totalPurchaseqty - $totalinvoiceqty+$order);
                $mrp = $products->mrp;
                $stockamount = $stock * $mrp;
                return    $stockamount;
            })
            ->addColumn('unit', function (product $products) {
                return $products->UnitName->Shortcut;
            })
            ->make(true);
    }
}
