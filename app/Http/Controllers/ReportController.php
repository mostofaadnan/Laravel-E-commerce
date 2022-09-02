<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\purchase;
use App\Models\Invoice;
use App\Models\SupplierPayment;
use App\Models\CustomerPaymentRecieve;
use App\Models\Category;
use App\Models\Product;
use App\Models\CashDrawer;
use App\Models\Bank;
use App\Models\CardPayment;
use App\Models\PaypalPayment;
use App\Models\ExpensesType;
use App\Models\Expenses;
use App\Models\SaleReturn;
use App\Models\InvoiceDetails;
use App\Models\purchasedetails;
use App\Models\SupplierDebt;
use App\Models\CustomerDebts;
use App\Models\VatCollection;
use App\Models\VatPayment;
use App\Models\Order;
use DataTables;
use PDF;

use DB;

class ReportController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:report-list', ['only' => [
            'index',
            'invoice',
            'InvoiceQuery',
            'InvoiceQueryPdf',
            'InvoicePdfView',
            'purchase',
            'PurchaseQuery',
            'PurchaseQueryPdf',
            'PurchasePdfView',
            'spayment',
            'spQueryPdf',
            'spPdfView',
            'cpayment',
            'cpQueryPdf',
            'cpPdfView',
            'stockReport',
            'stockReportQueryPdf',
            'cashdrawer',
            'cashdrawerQueryPdf',
            'cashdrawerPdfView',
            'Bank',
            'bankQuery',
            'bankQueryPdf',
            'bankPdfView',
            'Card',
            'cardQuery',
            'cardQueryPdf',
            'cardPdfView',
            'Paypal',
            'paypalQueryPdf',
            'paypalPdfView',
            'expenses',
            'expensesQueryPdf',
            'salereturn',
            'salereturnQuery',
            'salereturnQueryPdf',
            'invoicedetails',
            'invoicedetailsQueryPdf',
            'invoicedetailsPdfView',
            'purchasedeatils',
            'purchasedeatilsQueryPdf',
            'purchasedeatilsPdfView',
            'supplierstatement',
            'supplierstatementQueryPdf',
            'supplierstatementPdfView',
            'customerstatement',
            'customerstatementQueryPdf',
            'customerstatementPdfView',
            'income',
            'incomeQueryPdf',
            'incomePdfView',
            'vat',
            'vatQueryPdf',
            'vatPdfView',
            'vatpayment',
            'vatpaymentQuery',
            'vatpaymentQueryPdf',
            'vatpaymentPdfView',
        ]]);
    }
    public function invoice()
    {
        return view('report.invoice');
    }
    public function InvoiceQuery(Request $request)
    {
        $type = $request->type;

        /*  $customerid = $request->customer; */
        $fromdate = $request->fromdate;
        $todate = $request->todate;


        if ($type > 0) {
            $invoice = Invoice::orderBy('id', 'desc')
                ->where('cancel',  0)
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->where('type_id', $type)
                ->latest()
                ->get();
        } else {
            $invoice = Invoice::orderBy('id', 'desc')
                ->where('cancel',  0)
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        }

        return Datatables::of($invoice)
            ->addIndexColumn()
            ->addColumn('type', function (invoice $invoice) {
                $type = $invoice->type_id;
                switch ($type) {
                    case 1:
                        $invtype = 'Cash Invoice';
                        break;
                    case 2:
                        $invtype = 'Credit Invoice';
                        break;
                        break;
                    default:
                        break;
                }
                return  $invtype;
            })
            ->addColumn('paymenttype', function (invoice $invoice) {
                $payment = $invoice->paymenttype_id;
                switch ($payment) {
                    case 1:
                        $paymenttype = 'Cash';
                        break;
                    case 2:
                        $paymenttype = 'Bank';
                        break;
                    case 3:
                        $paymenttype = 'Card';
                        break;
                    case 4:
                        $paymenttype = 'Paypal';
                        break;
                    default:
                        $paymenttype = 'Credit';
                        break;
                }
                return  $paymenttype;
            })
            ->addColumn('customer', function (Invoice $invoice) {
                return $invoice->CustomerName->name;
            })
            ->make(true);
    }
    public function InvoiceQueryPdf(Request $request)
    {
        /*  $data['details'] = $request->itemtables; */
        $data['type'] = $request->type;
        /*    $data['customer'] = $request->customer; */
        $data['todate'] = $request->todate;
        $data['fromdate'] = $request->fromdate;
        $data['totalamout'] = $request->totalamout;
        $data['printconfirm'] = $request->printconfirm;
        Session::put('invoicedata', $data);
    }

    public function InvoicePdfView()
    {
        $title = "Invoice Report";
        $data = Session::get('invoicedata');
        $type = $data['type'];
        $fromdate = $data['fromdate'];
        $todate = $data['todate'];
        $printconfirm = $data['printconfirm'];
        if ($type > 0) {
            $data['details'] = Invoice::orderBy('id', 'desc')
                ->where('cancel',  0)
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->where('type_id', $type)
                ->latest()
                ->get();
        } else {
            $data['details'] = Invoice::orderBy('id', 'desc')
                ->where('cancel',  0)
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        if ($printconfirm == 1) {
            $pdf = PDF::loadView('pdf.report.invoice', compact('data', 'title'));
            return $pdf->stream('invoice.pdf');
        } else {
            return View('pdf.report.invoice', compact('data', 'title'));
        }
    }
    //Order
    public function order()
    {
        return view('report.order');
    }
    public function OrderQuery(Request $request)
    {



        $fromdate = date('Y-m-d', strtotime($request->fromdate));
        $todate = date('Y-m-d', strtotime($request->todate));
        $Order = Order::orderBy('id', 'desc')
            ->where('cancel',  0)
            ->whereBetween('inputdate', array($fromdate, $todate))
            ->latest()
            ->get();

        return Datatables::of($Order)
            ->addIndexColumn()

            ->addColumn('paymenttype', function (Order $Order) {
                $payment = $Order->paymenttype_id;
                switch ($payment) {
                    case 1:
                        $paymenttype = 'Cash';
                        break;
                    case 2:
                        $paymenttype = 'Bank';
                        break;
                    case 3:
                        $paymenttype = 'Card';
                        break;
                    case 4:
                        $paymenttype = 'Paypal';
                        break;
                    default:
                        $paymenttype = 'Credit';
                        break;
                }
                return  $paymenttype;
            })
            ->addColumn('customer', function (Order $Order) {
                return $Order->CustomerName->name;
            })
            ->make(true);
    }
    public function OrderQueryPdf(Request $request)
    {
        $fromdate = date('Y-m-d', strtotime($request->fromdate));
        $todate = date('Y-m-d', strtotime($request->todate));

        /*    $data['customer'] = $request->customer; */
        $data['todate'] =   $todate;
        $data['fromdate'] = $fromdate;
        $data['totalamout'] = $request->totalamout;
        $data['printconfirm'] = $request->printconfirm;
        Session::put('orderdata', $data);
    }

    public function OrderPdfView()
    {
        $title = "Order Report";
        $data = Session::get('orderdata');
        $fromdate = $data['fromdate'];
        $todate = $data['todate'];
        $printconfirm = $data['printconfirm'];

        $data['details'] = Order::orderBy('id', 'desc')
            ->where('cancel',  0)
            ->whereBetween('inputdate', array($fromdate, $todate))
            ->latest()
            ->get();

        if ($printconfirm == 1) {
            $pdf = PDF::loadView('pdf.report.order', compact('data', 'title'));
            return $pdf->stream('order.pdf');
        } else {
            return View('pdf.report.order', compact('data', 'title'));
        }
    }
    //purchase
    public function purchase()
    {
        return view('report.purchase');
    }

    public function PurchaseQuery(Request $request)
    {
        $supplierid = $request->supplierid;
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        if ($supplierid == 0) {
            $purchases = purchase::orderBy('id', 'desc')
                ->where('status',  1)
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $purchases = purchase::orderBy('id', 'desc')
                ->where('supplier_id', $supplierid)
                ->where('status',  1)
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        return Datatables::of($purchases)
            ->addIndexColumn()
            ->addColumn('supplier', function (purchase $purchase) {
                return $purchase->SupplierName->name;
            })
            ->make(true);
    }

    public function PurchaseQueryPdf(Request $request)
    {
        $data['supplier'] = $request->supplier;
        $data['supplierid'] = $request->supplierid;
        $data['todate'] = $request->todate;
        $data['fromdate'] = $request->fromdate;
        $data['printconfirm'] = $request->printconfirm;
        Session::put('purchasedata', $data);
    }

    public function PurchasePdfView()
    {
        $data = Session::get('purchasedata');
        $supplierid = $data['supplierid'];
        $supplier = $data['supplier'];
        $fromdate = $data['fromdate'];
        $todate = $data['todate'];
        $printconfirm = $data['printconfirm'];
        $title = "Purchase Report";
        if ($supplierid == 0) {
            $data['details'] = purchase::orderBy('id', 'desc')
                ->where('status',  1)
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $data['details'] = purchase::orderBy('id', 'desc')
                ->where('supplier_id', $supplierid)
                ->where('status',  1)
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        if ($printconfirm == 1) {
            $pdf = PDF::loadView('pdf.report.purchase', compact('data', 'title'));
            return $pdf->stream('purchase.pdf');
        } else {
            return View('pdf.report.purchase', compact('data', 'title'));
        }
    }

    //Supplier Payment
    public function spayment()
    {
        return view('report.spayment');
    }
    public function spQuery(Request $request)
    {
        $supplierid = $request->supplierid;
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        if ($supplierid == 0) {
            $SupplierPayment = SupplierPayment::orderBy('id', 'desc')
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $SupplierPayment = SupplierPayment::orderBy('id', 'desc')
                ->where('supplier_id', $supplierid)
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        return Datatables::of($SupplierPayment)
            ->addIndexColumn()
            ->addColumn('paymenttype', function (SupplierPayment $SupplierPayment) {
                $payment = $SupplierPayment->payment_id;
                switch ($payment) {
                    case 1:
                        $paymenttype = 'Cash';
                        break;
                    case 2:
                        $paymenttype = 'Bank';
                        break;
                    default:
                        break;
                }
                return  $paymenttype;
            })
            ->addColumn('supplier', function (SupplierPayment $SupplierPayment) {
                return $SupplierPayment->SupplierName->name;
            })
            ->make(true);
    }
    public function spQueryPdf(Request $request)
    {
        $data['supplier'] = $request->supplier;
        $data['supplierid'] = $request->supplierid;
        $data['todate'] = $request->todate;
        $data['fromdate'] = $request->fromdate;
        $data['printconfirm'] = $request->printconfirm;
        Session::put('spdata', $data);
    }

    public function spPdfView()
    {
        $title = "Supplier Payment Report";
        $data = Session::get('spdata');
        $supplierid = $data['supplierid'];
        $supplier = $data['supplier'];
        $fromdate = $data['fromdate'];
        $todate = $data['todate'];
        $printconfirm = $data['printconfirm'];
        if ($supplierid == 0) {
            $data['details'] = SupplierPayment::orderBy('id', 'desc')
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $data['details'] = SupplierPayment::orderBy('id', 'desc')
                ->where('supplier_id', $supplierid)
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        if ($printconfirm == 1) {
            $pdf = PDF::loadView('pdf.report.spayment', compact('data', 'title'));
            return $pdf->stream('supplierpayment.pdf');
        } else {
            return view('pdf.report.spayment', compact('data', 'title'));
        }
    }
    //customer Payment
    public function cpayment()
    {
        return view('report.cpayment');
    }
    public function cpQuery(Request $request)
    {
        $customerid = $request->customerid;
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        if ($customerid == 0) {
            $CustomerPaymentRecieve = CustomerPaymentRecieve::orderBy('id', 'desc')
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $CustomerPaymentRecieve = CustomerPaymentRecieve::orderBy('id', 'desc')
                ->where('customer_id ', $customerid)
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        return Datatables::of($CustomerPaymentRecieve)
            ->addIndexColumn()
            ->addColumn('paymenttype', function (CustomerPaymentRecieve $CustomerPaymentRecieve) {
                $payment = $CustomerPaymentRecieve->payment_id;
                switch ($payment) {
                    case 1:
                        $paymenttype = 'Cash';
                        break;
                    case 2:
                        $paymenttype = 'Bank';
                        break;
                    case 3:
                        $paymenttype = 'Card';
                        break;
                    case 4:
                        $paymenttype = 'Paypal';
                        break;
                    default:

                        break;
                }
                return  $paymenttype;
            })
            ->addColumn('customer', function (CustomerPaymentRecieve $CustomerPaymentRecieve) {
                return $CustomerPaymentRecieve->CustomerName->name;
            })
            ->make(true);
    }
    public function cpQueryPdf(Request $request)
    {
        $data['customerid'] = $request->customerid;
        $data['customer'] = $request->customer;
        $data['todate'] = $request->todate;
        $data['fromdate'] = $request->fromdate;
        $data['printconfirm'] = $request->printconfirm;
        Session::put('cpdata', $data);
    }
    public function cpPdfView()
    {
        $title = "Credit Payment Report";
        $data = Session::get('cpdata');
        $customerid = $data['customerid'];
        $customer = $data['customer'];
        $fromdate = $data['fromdate'];
        $todate = $data['todate'];
        $printconfirm = $data['printconfirm'];
        if ($customerid == 0) {
            $data['details'] = CustomerPaymentRecieve::orderBy('id', 'desc')
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $data['details'] = CustomerPaymentRecieve::orderBy('id', 'desc')
                ->where('customer_id ', $customerid)
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        }

        if ($printconfirm == 1) {
            $pdf = PDF::loadView('pdf.report.cpayment', compact('data', 'title'));
            return $pdf->stream('customerpayment.pdf');
        } else {
            return view('pdf.report.cpayment', compact('data', 'title'));
        }
    }

    //stock report
    public function stockReport()
    {
        $categories = Category::orderBy('id', 'asc')->get();
        return view('report.stock', compact('categories'));
    }
    public function stockReportQuery(Request $request)
    {
        $categoryid = $request->categoryid;
        $productid = $request->productid;
        if ($productid == 0 and $categoryid > 0) {
            $products = Product::orderBy('id', 'desc')
                ->where('category_id', $categoryid)
                ->latest()
                ->get();
        } else if ($productid > 0 and $categoryid > 0) {
            $products = Product::orderBy('id', 'desc')
                ->where('category_id', $categoryid)
                ->where('id', $productid)
                ->latest()
                ->get();
        } else if ($productid > 0 and $categoryid == 0) {
            $products = Product::orderBy('id', 'desc')
                ->where('id', $productid)
                ->latest()
                ->get();
        } else if ($productid == 0 and $categoryid == 0) {
            $products = Product::orderBy('id', 'desc')
                ->latest()
                ->get();
        } else {
        }
        return Datatables::of($products)
            ->addIndexColumn()
            ->addColumn('stock', function ($products) {
                $openigqty =  $products->openingStock()->sum('qty');
                $invoice = $products->QuantityOutBySale()->sum('qty');
                $invoiceReturn = $products->QuantityOutBySaleReturn()->sum('qty');
                $totalinvoiceqty = $invoice - $invoiceReturn;
                $purchase = $products->QuantityOutByPurchase()->sum('qty');
                $PurchaseReturn = $products->QuantityOutByPurchaseReturn()->sum('qty');
                $totalPurchaseqty = $purchase - $PurchaseReturn;
                $stock = $openigqty + ($totalPurchaseqty - $totalinvoiceqty);
                return   $stock;
            })
            ->addColumn('stockamount', function ($products) {
                $openigqty =  $products->openingStock()->sum('qty');
                $invoice = $products->QuantityOutBySale()->sum('qty');
                $invoiceReturn = $products->QuantityOutBySaleReturn()->sum('qty');
                $totalinvoiceqty = $invoice - $invoiceReturn;
                $purchase = $products->QuantityOutByPurchase()->sum('qty');
                $PurchaseReturn = $products->QuantityOutByPurchaseReturn()->sum('qty');
                $totalPurchaseqty = $purchase - $PurchaseReturn;
                $stock = $openigqty + ($totalPurchaseqty - $totalinvoiceqty);
                $mrp = $products->mrp;
                $stockamount = $stock * $mrp;
                return    $stockamount;
            })
            ->addColumn('category', function (product $products) {
                return $products->CategoryName->title;
            })
            ->addColumn('unit', function (product $products) {
                return $products->UnitName->Shortcut;
            })
            ->make(true);
    }
    public function stockReportQueryPdf(Request $request)
    {
        $data['productid'] = $request->productid;
        $data['categoryid'] = $request->categoryid;
        $data['product'] = $request->product;
        $data['category'] = $request->category;
        $data['printconfirm'] = $request->printconfirm;
        Session::put('stockdata', $data);
    }
    public function stockReportPdfView()
    {
        $title = "Stock Report";
        $data = Session::get('stockdata');
        $categoryid = $data['productid'];
        $productid = $data['categoryid'];
        $printconfirm = $data['printconfirm'];
        if ($productid == 0 and $categoryid > 0) {
            $data['details'] = Product::orderBy('id', 'desc')
                ->where('category_id', $categoryid)
                ->latest()
                ->get();
        } else if ($productid > 0 and $categoryid > 0) {
            $data['details'] = Product::orderBy('id', 'desc')
                ->where('category_id', $categoryid)
                ->where('id', $productid)
                ->latest()
                ->get();
        } else if ($productid > 0 and $categoryid == 0) {
            $data['details'] = Product::orderBy('id', 'desc')
                ->where('id', $productid)
                ->latest()
                ->get();
        } else if ($productid == 0 and $categoryid == 0) {
            $data['details'] = Product::orderBy('id', 'desc')
                ->latest()
                ->get();
        } else {
        }
        if ($printconfirm == 1) {
            $pdf = PDF::loadView('pdf.report.stock', compact('data', 'title'));
            return $pdf->stream('stockreport.pdf');
        } else {
            return view('pdf.report.stock', compact('data', 'title'));
        }
    }
    //cashdrawer
    public function cashdrawer()
    {
        return view('report.cashdrawer');
    }
    public function cashdrawerQuery(Request $request)
    {
        $type = $request->type;
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        if ($type > 0) {
            $CashDrawer = CashDrawer::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->where('type_id', $type)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $CashDrawer = CashDrawer::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        return Datatables::of($CashDrawer)
            ->addIndexColumn()
            ->make(true);
    }
    public function cashdrawerQueryPdf(Request $request)
    {

        $data['type'] = $request->type;
        $data['typeid'] = $request->typeid;
        $data['todate'] = $request->todate;
        $data['fromdate'] = $request->fromdate;
        $data['printconfirm'] = $request->printconfirm;
        Session::put('cashdrawerdata', $data);
    }
    public function cashdrawerPdfView()
    {
        $data = Session::get('cashdrawerdata');
        $typeid = $data['typeid'];
        $fromdate = $data['fromdate'];
        $todate = $data['todate'];
        $printconfirm = $data['printconfirm'];
        $title = "Cash Drawer Report";
        if ($typeid > 0) {
            $data['details']  = CashDrawer::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->where('type_id', $typeid)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $data['details']  = CashDrawer::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        if ($printconfirm == 1) {
            $pdf = PDF::loadView('pdf.report.cashdrawer', compact('data', 'title'));
            return $pdf->stream('cashdrawer.pdf');
        } else {
            return view('pdf.report.cashdrawer', compact('data', 'title'));
        }
    }
    //Bank
    public function Bank()
    {
        return view('report.bank');
    }
    public function bankQuery(Request $request)
    {
        $type = $request->type;
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        if ($type > 0) {
            $CashDrawer = Bank::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->where('type_id', $type)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $CashDrawer = Bank::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        return Datatables::of($CashDrawer)
            ->addIndexColumn()
            ->make(true);
    }
    public function bankQueryPdf(Request $request)
    {
        $data['typeid'] = $request->typeid;
        $data['type'] = $request->type;
        $data['todate'] = $request->todate;
        $data['fromdate'] = $request->fromdate;
        $data['printconfirm'] = $request->printconfirm;
        Session::put('bankdata', $data);
    }
    public function bankPdfView()
    {
        $title = "Bank Transection Report";
        $data = Session::get('bankdata');
        $type = $data['typeid'];
        $todate = $data['todate'];
        $fromdate = $data['fromdate'];
        $printconfirm = $data['printconfirm'];

        if ($type > 0) {
            $data['details']  = Bank::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->where('type_id', $type)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $data['details']  = Bank::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        if ($printconfirm == 2) {
            return View('pdf.report.bank', compact('data', 'title'));
        } else {
            $pdf = PDF::loadView('pdf.report.bank', compact('data', 'title'));
            return $pdf->stream('bank.pdf');
        }
    }

    //card
    public function Card()
    {
        return view('report.card');
    }
    public function cardQuery(Request $request)
    {
        $type = $request->type;
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        if ($type > 0) {
            $CashDrawer = CardPayment::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->where('type_id', $type)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $CashDrawer = CardPayment::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        return Datatables::of($CashDrawer)
            ->addIndexColumn()
            ->make(true);
    }
    public function cardQueryPdf(Request $request)
    {
        $data['printconfirm'] = $request->printconfirm;
        $data['typeid'] = $request->typeid;
        $data['type'] = $request->type;
        $data['todate'] = $request->todate;
        $data['fromdate'] = $request->fromdate;
        Session::put('carddata', $data);
    }
    public function cardPdfView()
    {
        $title = "Cart Payment Report";
        $data = Session::get('carddata');
        $type = $data['typeid'];
        $todate = $data['todate'];
        $fromdate = $data['fromdate'];
        $printconfirm = $data['printconfirm'];
        if ($type > 0) {
            $data['details']  = CardPayment::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->where('type_id', $type)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $data['details']  = CardPayment::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        if ($printconfirm == 1) {
            $pdf = PDF::loadView('pdf.report.card', compact('data', 'title'));
            return $pdf->stream('card.pdf');
        } else {
            return View('pdf.report.card', compact('data', 'title'));
        }
    }

    //Paypal
    public function Paypal()
    {
        return view('report.paypal');
    }
    public function paypalQuery(Request $request)
    {
        $type = $request->type;
        $fromdate = date('Y-m-d', strtotime($request->fromdate));
        $todate = date('Y-m-d', strtotime($request->todate));
        if ($type > 0) {
            $PaypalPayment = PaypalPayment::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->where('type', $type)
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $PaypalPayment = PaypalPayment::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        return Datatables::of($PaypalPayment)
            ->addIndexColumn()
            ->addColumn('inputdate', function ($PaypalPayment) {
                $date = $PaypalPayment->created_at;
                $inputdate = date('m/d/Y', strtotime($date));
                return $inputdate;
            })
            ->make(true);
    }
    public function paypalQueryPdf(Request $request)
    {
        $data['typeid'] = $request->typeid;
        $data['type'] = $request->type;
        $data['todate'] = $request->todate;
        $data['fromdate'] = $request->fromdate;
        $data['printconfirm'] = $request->printconfirm;
        Session::put('paypaldata', $data);
    }
    public function paypalPdfView()
    {
        $title = "Paypal Payment Report";
        $data = Session::get('paypaldata');
        $type = $data['typeid'];
        $printconfirm = $data['printconfirm'];
        $fromdate = date('Y-m-d', strtotime($data['fromdate']));
        $todate = date('Y-m-d', strtotime($data['todate']));
        if ($type > 0) {
            $data['details']  = PaypalPayment::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->where('type', $type)
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $data['details']  = PaypalPayment::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        if ($printconfirm == 1) {
            $pdf = PDF::loadView('pdf.report.paypal', compact('data', 'title'));
            return $pdf->stream('paypal.pdf');
        } else {
            return view('pdf.report.paypal', compact('data', 'title'));
        }
    }
    //Expenses
    public function expenses()
    {
        $expensesType = ExpensesType::select('id', 'name')->orderBy('id', 'desc')->get();
        return view('report.expenses', compact('expensesType'));
    }
    public function expensesQuery(Request $request)
    {
        $type = $request->type;
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        if ($type > 0) {
            $Expenses = Expenses::orderBy('id', 'desc')
                ->where('expenses_id', $type)
                ->where('void', 0)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $Expenses = Expenses::orderBy('id', 'desc')
                ->where('void', 0)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        return Datatables::of($Expenses)
            ->addIndexColumn()
            ->addColumn('exptype', function (Expenses $Expenses) {
                return $Expenses->ExpnensesType->name;
            })
            ->addColumn('source', function ($Expenses) {
                if ($Expenses->payment_type == 1) {
                    $source = 'Cash';
                } else {
                    $source = 'Bank';
                }
                return $source;
            })
            ->make(true);
    }
    public function expensesQueryPdf(Request $request)
    {

        $data['type'] = $request->type;
        $data['typeid'] = $request->typeid;
        $data['todate'] = $request->todate;
        $data['fromdate'] = $request->fromdate;
        $data['totalamount'] = $request->totalamount;
        $data['printconfirm'] = $request->printconfirm;
        Session::put('expensesdata', $data);
    }
    public function expensesPdfView()
    {
        $title = "Expenses Report";
        $data = Session::get('expensesdata');
        $type = $data['typeid'];
        $todate = $data['todate'];
        $fromdate = $data['fromdate'];
        $printconfirm = $data['printconfirm'];
        if ($type > 0) {
            $data['details']  = Expenses::orderBy('id', 'desc')
                ->where('expenses_id', $type)
                ->where('void', 0)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $data['details'] = Expenses::orderBy('id', 'desc')
                ->where('void', 0)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        if ($printconfirm == 1) {
            $pdf = PDF::loadView('pdf.report.expenses', compact('data', 'title'));
            return $pdf->stream('expenses.pdf');
        } else {
            return view('pdf.report.expenses', compact('data', 'title'));
        }
    }
    //Sector Expenditure
    public function sectorexpenditure()
    {
        $expensesType = ExpensesType::select('id', 'name')->orderBy('id', 'desc')->get();
        return view('report.sectorexpenses', compact('expensesType'));
    }

    public function sectorexpenditureQuery(Request $request)
    {
    }
    //sale return
    public function salereturn()
    {
        return view('report.salereturn');
    }
    public function salereturnQuery(Request $request)
    {
        $customerid = $request->customer;
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        if ($customerid > 0) {
            $SaleReturn = SaleReturn::orderBy('id', 'desc')
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->where('customer_id', $customerid)
                ->latest()
                ->get();
        } else {
            $SaleReturn = SaleReturn::orderBy('id', 'desc')
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        }

        return Datatables::of($SaleReturn)
            ->addIndexColumn()
            ->addColumn('type', function (SaleReturn $SaleReturn) {
                $type = $SaleReturn->type_id;
                switch ($type) {
                    case 1:
                        $invtype = 'Cash Invoice';
                        break;
                    case 2:
                        $invtype = 'Credit Invoice';
                        break;
                        break;
                    default:
                        break;
                }
                return  $invtype;
            })
            ->addColumn('customer', function (SaleReturn $SaleReturn) {
                return $SaleReturn->CustomerName->name;
            })
            ->make(true);
    }
    public function salereturnQueryPdf(Request $request)
    {

        $data['todate'] = $request->todate;
        $data['customer'] = $request->customer;
        $data['customerid'] = $request->customerid;
        $data['fromdate'] = $request->fromdate;
        $data['printconfirm'] = $request->printconfirm;

        Session::put('returndata', $data);
    }
    public function salereturnPdfView()
    {
        $title = "Sale Return Report";
        $data = Session::get('returndata');
        $customerid = $data['customerid'];
        $todate = $data['todate'];
        $fromdate = $data['fromdate'];
        $printconfirm = $data['printconfirm'];
        if ($customerid > 0) {
            $data['details'] = SaleReturn::orderBy('id', 'desc')
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->where('customer_id', $customerid)
                ->latest()
                ->get();
        } else {
            $data['details'] = SaleReturn::orderBy('id', 'desc')
                ->whereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        if ($printconfirm == 1) {
            $pdf = PDF::loadView('pdf.report.salereturn', compact('data', 'title'));
            return $pdf->stream('salereturn.pdf');
        } else {
            return view('pdf.report.salereturn', compact('data', 'title'));
        }
    }
    //Invoice Details 
    public function invoicedetails()
    {
        return view('report.invoicedetails');
    }
    public function invoicedetailsQuery(Request $request)
    {
        $customerid = $request->customerid;
        $fromdate = date('Y-m-d', strtotime($request->fromdate));
        $todate = date('Y-m-d', strtotime($request->todate));
        if ($customerid > 0) {
            $InvoiceDetails = InvoiceDetails::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->where('customer_id', $customerid)
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $InvoiceDetails = InvoiceDetails::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->latest()
                ->get();
        }

        return Datatables::of($InvoiceDetails)
            ->addIndexColumn()
            ->addColumn('inputdate', function (InvoiceDetails $InvoiceDetails) {
                return $InvoiceDetails->invoicename->inputdate;
            })
            ->addColumn('name', function (InvoiceDetails $InvoiceDetails) {
                return $InvoiceDetails->productName->name;
            })
            ->addColumn('invoiceno', function (InvoiceDetails $InvoiceDetails) {
                return $InvoiceDetails->invoicename->invoice_no;
            })

            ->addColumn('customer', function (InvoiceDetails $InvoiceDetails) {
                return $InvoiceDetails->invoicename->CustomerName->name;
            })

            ->make(true);
    }

    public function invoicedetailsQueryPdf(Request $request)
    {


        $data['customer'] = $request->customer;
        $data['customerid'] = $request->customerid;
        $data['fromdate'] = $request->fromdate;
        $data['todate'] = $request->todate;
        $data['printconfirm'] = $request->printconfirm;
        Session::put('invoicedetailsdata', $data);
    }
    public function invoicedetailsPdfView()
    {
        $title = "Invoice Detils Report";
        $data = Session::get('invoicedetailsdata');
        $customerid = $data['customerid'];
        $fromdate = date('Y-m-d', strtotime($data['fromdate']));
        $todate = date('Y-m-d', strtotime($data['todate']));
        $printconfirm = $data['printconfirm'];
        if ($customerid > 0) {
            $data['details'] = InvoiceDetails::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->where('customer_id', $customerid)
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $data['details'] = InvoiceDetails::orderBy('id', 'desc')
                ->where('cancel', 0)
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        if ($printconfirm == 1) {
            $pdf = PDF::loadView('pdf.report.invoicedetails', compact('data', 'title'))->setPaper('a4', 'landscape');
            return $pdf->stream('invoicedetails.pdf');
        } else {
            return View('pdf.report.invoicedetails', compact('data', 'title'));
        }
    }

    //purchase Details
    public function purchasedeatils()
    {
        return view('report.purchasedetails');
    }
    public function purchasedeatilsQuery(Request $request)
    {
        $supplierid = $request->supplierid;
        $fromdate = date('Y-m-d', strtotime($request->fromdate));
        $todate = date('Y-m-d', strtotime($request->todate));
        if ($supplierid > 0) {
            $purchasedetails = purchasedetails::orderBy('id', 'desc')
                ->where('status', 1)
                ->where('supplier_id', $supplierid)
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $purchasedetails = purchasedetails::orderBy('id', 'desc')
                ->where('status', 1)
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->latest()
                ->get();
        }

        return Datatables::of($purchasedetails)
            ->addIndexColumn()
            ->addColumn('inputdate', function (purchasedetails $purchasedetails) {
                return $purchasedetails->purchasename->inputdate;
            })
            ->addColumn('name', function (purchasedetails $purchasedetails) {
                return $purchasedetails->productName->name;
            })
            ->addColumn('purchaseno', function (purchasedetails $purchasedetails) {
                return $purchasedetails->purchasename->purchasecode;
            })

            ->addColumn('supplier', function (purchasedetails $purchasedetails) {
                return $purchasedetails->purchasename->SupplierName->name;
            })

            ->make(true);
    }
    public function purchasedeatilsQueryPdf(Request $request)
    {
        $data['supplierid'] = $request->supplierid;
        $data['supplier'] = $request->supplier;
        $data['todate'] = $request->todate;
        $data['fromdate'] = $request->fromdate;
        $data['printconfirm'] = $request->printconfirm;
        Session::put('purchasedetailsdata', $data);
    }
    public function purchasedeatilsPdfView()
    {
        $title = "Purchase Details Report";
        $data = Session::get('purchasedetailsdata');
        $supplierid = $data['supplierid'];
        $fromdate = date('Y-m-d', strtotime($data['fromdate']));
        $todate = date('Y-m-d', strtotime($data['todate']));
        $printconfirm = $data['printconfirm'];
        if ($supplierid > 0) {
            $data['details'] = purchasedetails::orderBy('id', 'desc')
                ->where('status', 1)
                ->where('supplier_id', $supplierid)
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $data['details'] = purchasedetails::orderBy('id', 'desc')
                ->where('status', 1)
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        if ($printconfirm == 1) {
            $pdf = PDF::loadView('pdf.report.purchasedeatils', compact('data', 'title'))->setPaper('a4', 'landscape');
            return $pdf->stream('purchasedetails.pdf');
        } else {
            return view('pdf.report.purchasedeatils', compact('data', 'title'));
        }
    }
    public function supplierstatement()
    {
        return view('report.supplierstatement');
    }
    public function supplierstatementQuery(Request $request)
    {
        $supplierid = $request->supplierid;
        $fromdate = date('Y-m-d', strtotime($request->fromdate));
        $todate = date('Y-m-d', strtotime($request->todate));
        if ($supplierid > 0) {
            $SupplierDebt = SupplierDebt::orderBy('id', 'desc')
                ->where('supplier_id', $request->supplierid)
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->get();
        } else {
            $SupplierDebt = SupplierDebt::orderBy('id', 'desc')
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->get();
        }
        return Datatables::of($SupplierDebt)
            ->addIndexColumn()
            ->addColumn('inputdate', function ($SupplierDebt) {
                $fromdate = date('m/d/Y', strtotime($SupplierDebt->created_at));
                return  $fromdate;
            })

            ->addColumn('supplier', function (SupplierDebt $SupplierDebt) {
                return $SupplierDebt->SupplierName->name;
            })
            ->make(true);
    }
    public function supplierstatementQueryPdf(Request $request)
    {
        $data['todate'] = $request->todate;
        $data['supplier'] = $request->supplier;
        $data['supplierid'] = $request->supplierid;
        $data['fromdate'] = $request->fromdate;
        $data['printconfirm'] = $request->printconfirm;
        Session::put('suppliaerstatementdata', $data);
    }
    public function supplierstatementPdfView()
    {
        $title = "Supplier Statement";
        $data = Session::get('suppliaerstatementdata');
        $supplierid = $data['supplierid'];
        $fromdate = date('Y-m-d', strtotime($data['fromdate']));
        $todate = date('Y-m-d', strtotime($data['todate']));
        $printconfirm = $data['printconfirm'];
        if ($supplierid > 0) {
            $data['details'] = SupplierDebt::orderBy('id', 'desc')
                ->where('supplier_id',   $supplierid)
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->get();
        } else {
            $data['details'] = SupplierDebt::orderBy('id', 'desc')
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->get();
        }
        if ($printconfirm == 1) {
            $pdf = PDF::loadView('pdf.report.supplierstatement', compact('data', 'title'))->setPaper('a4', 'landscape');
            return $pdf->stream('supplierstatement.pdf');
        } else if ($printconfirm == 1) {
            return view('pdf.report.supplierstatement', compact('data', 'title'))->setPaper('a4', 'landscape');
        } else {
            return redirect()->Route('supplier.sendmail');
        }
    }
    //customer statement
    public function customerstatement()
    {
        return view('report.customerstatement');
    }
    public function customerstatementQuery(Request $request)
    {
        $customerid = $request->customerid;
        $fromdate = date('Y-m-d', strtotime($request->fromdate));
        $todate = date('Y-m-d', strtotime($request->todate));
        if ($customerid > 0) {
            $CustomerDebts = CustomerDebts::orderBy('id', 'desc')
                ->where('customer_id', $request->customerid)
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->get();
        } else {
            $CustomerDebts = CustomerDebts::orderBy('id', 'desc')
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->get();
        }
        return Datatables::of($CustomerDebts)
            ->addIndexColumn()
            ->addColumn('inputdate', function ($CustomerDebts) {
                $fromdate = date('m/d/Y', strtotime($CustomerDebts->created_at));
                return  $fromdate;
            })

            ->addColumn('customer', function (CustomerDebts $CustomerDebts) {
                return $CustomerDebts->CustomerName->name;
            })
            ->make(true);
    }
    public function customerstatementQueryPdf(Request $request)
    {
        $data['todate'] = $request->todate;
        $data['fromdate'] = $request->fromdate;
        $data['customer'] = $request->customer;
        $data['customerid'] = $request->customerid;
        $data['printconfirm'] = $request->printconfirm;
        Session::put('customerstatementdata', $data);
    }
    public function customerstatementPdfView()
    {
        $title = "Customer Statement";
        $data = Session::get('customerstatementdata');
        $customerid = $data['customerid'];
        $printconfirm = $data['printconfirm'];
        $fromdate = date('Y-m-d', strtotime($data['fromdate']));
        $todate = date('Y-m-d', strtotime($data['todate']));
        if ($customerid > 0) {
            $data['details'] = CustomerDebts::orderBy('id', 'desc')
                ->where('customer_id', $customerid)
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->get();
        } else {
            $data['details'] = CustomerDebts::orderBy('id', 'desc')
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->get();
        }
        if ($printconfirm == 1) {
            $pdf = PDF::loadView('pdf.report.customerstatement', compact('data', 'title'))->setPaper('a4', 'landscape');
            return $pdf->stream('customerstatement.pdf');
        } else if ($printconfirm == 1) {
            return view('pdf.report.customerstatement', compact('data', 'title'));
        } else {
            return redirect()->Route('customer.sendmail');
        }
    }
    //income
    public function income()
    {
        return view('report.income');
    }
    public function incomeQuery(Request $request)
    {
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $Invoice = DB::table("invoices")
            ->select("invoices.id as id", "invoices.nettotal as amount", "invoices.invoice_no as number", "invoices.inputdate as inputdate", "invoices.comment as source")
            ->where('type_id', 1)
            ->where('cancel', 0)
            ->WhereBetween('inputdate', array($fromdate, $todate));
        $CustomerPayment = DB::table("customer_payment_recieves")
            ->select("customer_payment_recieves.id as id", "customer_payment_recieves.recieve as amount", "customer_payment_recieves.payment_no as number", "customer_payment_recieves.inputdate as inputdate", "customer_payment_recieves.comment as source")
            ->WhereBetween('inputdate', array($fromdate, $todate))
            ->union($Invoice)
            ->orderBy('inputdate', 'desc')
            ->get();
        return Datatables::of($CustomerPayment)
            ->addIndexColumn()
            ->make(true);
    }
    public function incomeQueryPdf(Request $request)
    {

        $data['todate'] = $request->todate;
        $data['fromdate'] = $request->fromdate;
        $data['printconfirm'] = $request->printconfirm;
        Session::put('incomedata', $data);
    }
    public function incomePdfView()
    {
        $title = "Income Report";
        $data = Session::get('incomedata');
        $todate = $data['todate'];
        $fromdate = $data['fromdate'];
        $printconfirm = $data['printconfirm'];
        $Invoice = DB::table("invoices")
            ->select("invoices.id as id", "invoices.nettotal as amount", "invoices.invoice_no as number", "invoices.inputdate as inputdate", "invoices.comment as source")
            ->where('type_id', 1)
            ->where('cancel', 0)
            ->WhereBetween('inputdate', array($fromdate, $todate));
        $data['details'] = DB::table("customer_payment_recieves")
            ->select("customer_payment_recieves.id as id", "customer_payment_recieves.recieve as amount", "customer_payment_recieves.payment_no as number", "customer_payment_recieves.inputdate as inputdate", "customer_payment_recieves.comment as source")
            ->WhereBetween('inputdate', array($fromdate, $todate))
            ->union($Invoice)
            ->orderBy('inputdate', 'desc')
            ->get();
        if ($printconfirm == 1) {
            $pdf = PDF::loadView('pdf.report.income', compact('data', 'title'));
            return $pdf->stream('income.pdf');
        } else {
            return view('pdf.report.income', compact('data', 'title'));
        }
    }
    //vat
    public function vat()
    {
        return view('report.vat');
    }
    public function vatQuery(Request $request)
    {
        $type = $request->type;
        $fromdate = date('Y-m-d', strtotime($request->fromdate));
        $todate = date('Y-m-d', strtotime($request->todate));
        if ($type == 2) {
            $VatCollection = VatCollection::orderBy('id', 'desc')
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $VatCollection = VatCollection::orderBy('id', 'desc')
                ->where('payment', $type)
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        return Datatables::of($VatCollection)
            ->addIndexColumn()
            ->addColumn('inputdate', function (VatCollection $VatCollection) {
                return date('m/d/Y', strtotime($VatCollection->created_at));
            })
            ->addColumn('status', function (VatCollection $VatCollection) {
                return $VatCollection->payment == 0 ? 'Due' : 'Paid';
            })
            ->make(true);
    }
    public function vatQueryPdf(Request $request)
    {
        $data['todate'] = $request->todate;
        $data['fromdate'] = $request->fromdate;
        $data['type'] = $request->type;
        $data['typeid'] = $request->typeid;
        $data['printconfirm'] = $request->printconfirm;
        Session::put('vatdata', $data);
    }
    public function vatPdfView()
    {
        $title = "Vat/Tax Collection Report";
        $data = Session::get('vatdata');
        $type = $data['typeid'];
        $fromdate = date('Y-m-d', strtotime($data['fromdate']));
        $todate = date('Y-m-d', strtotime($data['todate']));
        $printconfirm = $data['printconfirm'];
        if ($type == 2) {
            $data['details'] = VatCollection::orderBy('id', 'desc')
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $data['details'] = VatCollection::orderBy('id', 'desc')
                ->where('payment', $type)
                ->WhereBetween('created_at', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        if ($printconfirm == 1) {
            $pdf = PDF::loadView('pdf.report.vat', compact('data', 'title'));
            return $pdf->stream('vat.pdf');
        } else {
            return view('pdf.report.vat', compact('data', 'title'));
        }
    }

    //Vat Payment
    public function vatpayment()
    {
        return view('report.vatpayment');
    }
    public function vatpaymentQuery(Request $request)
    {
        $type = $request->type;
        $fromdate = $request->fromdate;
        $todate = $request->todate;

        if ($type > 0) {
            $VatPayment = VatPayment::orderBy('id', 'desc')
                ->where('payment_type', $type)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $VatPayment = VatPayment::orderBy('id', 'desc')
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        return Datatables::of($VatPayment)
            ->addIndexColumn()

            ->addColumn('collection_no', function (VatPayment $VatPayment) {
                return $VatPayment->Vat_Collection->collection_no;
            })
            ->addColumn('paymenttype', function (VatPayment $VatPayment) {
                $payment = $VatPayment->payment_type;
                switch ($payment) {
                    case 1:
                        $paymenttype = 'Cash';
                        break;
                    case 2:
                        $paymenttype = 'Bank';
                        break;
                    default:

                        break;
                }
                return  $paymenttype;
            })


            ->make(true);
    }
    public function vatpaymentQueryPdf(Request $request)
    {

        $data['todate'] = $request->todate;
        $data['fromdate'] = $request->fromdate;
        $data['type'] = $request->type;
        $data['typeid'] = $request->typeid;
        $data['printconfirm'] = $request->printconfirm;
        Session::put('vatpaymentdata', $data);
    }
    public function vatpaymentPdfView()
    {
        $title = "Vat/Tax Payment";
        $data = Session::get('vatpaymentdata');
        $todate = $data['todate'];
        $fromdate = $data['fromdate'];
        $type = $data['typeid'];
        $printconfirm = $data['printconfirm'];
        if ($type > 0) {
            $data['details'] = VatPayment::orderBy('id', 'desc')
                ->where('payment_type', $type)
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $data['details'] = VatPayment::orderBy('id', 'desc')
                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        }
        if ($printconfirm == 1) {
            $pdf = PDF::loadView('pdf.report.vatpayment', compact('data', 'title'));
            return $pdf->stream('vatpayment.pdf');
        } else {
            return view('pdf.report.vatpayment', compact('data', 'title'));
        }
    }
}
