<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\Product;
use App\Models\CashDrawer;
use App\Models\customer;
use App\Models\DayClose;
use App\Models\Bank;
use App\Models\CustomerDebts;
use App\Models\CardPayment;
use App\Models\PayPalCartDetails;
use App\Models\PayPalCart;
use App\Models\PaypalPayment;
use PDF;
use DataTables;
use Stripe;
use App\Accounts\Account;
use Exception;
use Illuminate\Validation\Rules\Unique;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;
use App\Models\SaleConfig;
use App\Models\NumberFormat;
use Illuminate\Support\Facades\Session;

class InvoiceController extends Controller
{

  function __construct()
  {
    //$this->DayCloseController->DayClosePermission('2020-07-21');
    $this->middleware('permission:invoice-list|invoice-create|invoice-edit|invoice-delete', ['only' => ['index', 'show', 'profile']]);
    $this->middleware('permission:invoice-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:invoice-edit', ['only' => ['edit', 'update', 'DataUpdate']]);
    $this->middleware('permission:invoice-delete', ['only' => ['delete']]);
    $this->middleware('permission:mail-list', ['only' => ['SendMail',]]);
  }

  public function index()
  {
    return view('invoice.index');


    /*  foreach ($history['data'] as $balance)
   {
       var_dump($balance['id']);
   } */
    //echo $balance['pending']['amount'];
  }
  public function create()
  {
    $date = date('m/d/Y');

    $DayClose = DayClose::where('date', $date)->first();
    if ($DayClose == null) {
      return view('invoice.create');
    } else {
      return redirect()->Route('dayclose.daycloseerror');
    }
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
      $invoice = Invoice::Where('type_id', 1)
        ->where('cancel', 0)
        ->whereBetween('inputdate', array($fromdate, $todate))
        ->orderBy('id', 'DESC')
        ->latest()
        ->get();
    } else {
      $invoice = Invoice::Where('type_id', 1)
        ->where('cancel', 0)
        ->orderBy('id', 'DESC')
        ->latest()
        ->get();
    }
    return Datatables::of($invoice)
      ->addIndexColumn()
      ->addColumn('customer', function (invoice $invoice) {
        return $invoice->CustomerName->name;
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
            break;
        }
        return  $paymenttype;
      })
      ->addColumn('user', function (invoice $invoice) {
        return $invoice->username ? $invoice->username->name : 'Deleted User';
      })
      ->addColumn('action', function ($invoice) {

        $button = '<div class="btn-group" role="group">';
        $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
        $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
        $button .= '<a class="dropdown-item" id="datashow" data-id="' . $invoice->id . '">View</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="pdf" data-id="' . $invoice->id . '">PDF</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="printslip" data-id="' . $invoice->id . '">Print</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="mail" data-id="' . $invoice->id . '">Send Mail</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="datashow" data-id="' . $invoice->id . '">Return</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="canceldata" data-id="' . $invoice->id . '">Cancel</a>';
        $button .= '</div></div>';
        return $button;
      })

      ->make(true);
  }
  public function GetList()
  {
    $currentdatetime = date('Y/m/d');
    $invoices = Invoice::with('CustomerName')
      ->Where('inputdate', $currentdatetime)
      ->orderBy('invoice_no', 'desc')
      ->get();
    return response()->json($invoices);
  }
  public function GetListCustomerCash(Request $request)
  {
    $invoice = invoice::Where('type_id', 1)
      ->where('customer_id', $request->customerid)
      ->orderBy('invoice_no', 'desc')
      ->latest()
      ->get();

    return Datatables::of($invoice)
      ->addIndexColumn()
      ->addColumn('customer', function (invoice $invoice) {
        return $invoice->CustomerName->name;
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
          default:
            $paymenttype = 'Card';
            break;
        }
        return  $paymenttype;
      })
      ->addColumn('user', function (invoice $invoice) {
        return $invoice->username->name;
      })
      ->addColumn('action', function ($invoice) {
        $button = '<div class="btn-group" role="group" aria-label="Basic example">';
        $button .= '<button id="datashowcash" type="button" name="edit" data-id="' . $invoice->id . '" class="edit btn btn-outline-default btn-sm">Show</button>';
        $button .= '</div>';
        return $button;
      })
      ->make(true);
  }

  public function InvoiceCode()
  {
    $NumberFormat = NumberFormat::select('cashinvoice')->where('id', 1)->first();
    $numb = $NumberFormat->cashinvoice;
    $Invoice = new Invoice();
    $lastInvoice = $Invoice->pluck('id')->last();
    $InvoiceCode = $lastInvoice + 1;
    return response()->json($numb . $InvoiceCode);
  }
  public function Store(Request $request)
  {
    $netotal = $request->nettotal;
    $paymentype = $request->paymenttype_id;
    $datareponse = "";
    $invoice = new invoice();
    $invoice->invoice_no = $request->invoicecode;
    $invoice->inputdate = $request->openingdate;
    $invoice->ref_no = $request->refno;
    $invoice->type_id = 1;
    $invoice->customer_id = $request->customer_id;
    $invoice->amount = $request->amount;
    $invoice->discount = $request->discount;
    $invoice->vat = $request->vat;
    $invoice->shipment = $request->shipment;
    $invoice->nettotal = $netotal;
    $invoice->paymenttype_id = $paymentype;
    $invoice->pay = $request->pay;
    $invoice->change = $request->change;
    $invoice->status = 0;
    $invoice->user_id = Auth::id();
    $invoice->comment = 'Cash Invoice';
    if ($invoice->save() == true) {
      //Item Details
      $tableData = $request->itemtables;
      foreach ($tableData as $items) {
        $itemid = $items['code'];
        $invoiceqty = $items['qty'];
        $product = Product::select('tp', 'unit_id')->where('id', $itemid)->first();
        $invoiceDetails = new InvoiceDetails();
        $invoiceDetails->invoice_id = $invoice->id;
        $invoiceDetails->item_id = $itemid;
        $invoiceDetails->mrp = $items['unitprice'];
        $invoiceDetails->tp = $product->tp;
        $invoiceDetails->unit_id = $product->unit_id;
        $invoiceDetails->qty = $invoiceqty;
        $invoiceDetails->amount = $items['amount'];
        $invoiceDetails->vat = $items['vat'];
        $invoiceDetails->discount = $items['discount'];
        $invoiceDetails->nettotal = $items['nettotal'];
        $invoiceDetails->customer_id = $request->customer_id;
        $invoiceDetails->save();
      }
      $cashin = CashDrawer::where('cancel', 0)->sum('cashin');
      $cashout = CashDrawer::where('cancel', 0)->sum('cashout');
      $balance = $cashin - $cashout;
      $newbalance = $netotal + $balance;

      $cashinbank = Bank::where('cancel', 0)->sum('cashin');
      $cashoutbank = Bank::where('cancel', 0)->sum('cashout');
      $balancebank = $cashinbank - $cashoutbank;
      $newbalancebank = $netotal + $balancebank;

      $cashincard = CardPayment::sum('cashin');
      $cashoutcard = CardPayment::sum('cashout');
      $balancecard = $cashincard - $cashoutcard;
      $newbalancecard = $netotal + $balancecard;
      //balance update

      switch ($paymentype) {
        case 1:
          $this->CashDrawerUpdate($request->openingdate, $netotal, $newbalance, $invoice->id);
          break;
        case 2:

          $this->BankTransactionUpdate($request->openingdate, $netotal, $newbalancebank, $invoice->id, $request->bankname, $request->accno, $request->bankdescrip);
          break;
        default:
          $this->CardTransactionUpdate($request->token, $request->openingdate, $netotal, $newbalancecard, $invoice->id);
          //$this->BankTransactionUpdate($request->openingdate, $netotal, $newbalancebank, $invoice->id,$request->bankname,$request->accno, $request->bankdescrip);
      }
      $discount =  $request->discount;
      $cashinvoice = $netotal + $discount;
      $CustomerDebts = new CustomerDebts();
      $CustomerDebts->customer_id = $request->customer_id;
      $CustomerDebts->openingBalance = 0;
      $CustomerDebts->cashinvoice = $cashinvoice;
      $CustomerDebts->creditinvoice = 0;
      $CustomerDebts->totaldiscount = $discount;
      $CustomerDebts->payment = 0;
      $CustomerDebts->remark = 'Cash Invoice';
      $CustomerDebts->trn_id = $invoice->id;
      $CustomerDebts->save();
      $datareponse = $invoice->id;
    } else {
      $datareponse = 0;
    }
    return response()->json($datareponse);

    /* foreach($request->itemtables as $items){
   ;
  
  } */
  }
  public function CashDrawerUpdate($openingdate, $netotal, $newbalance, $invoiceid)
  {
    $Drware = new CashDrawer();
    $Drware->inputdate = $openingdate;
    $Drware->cashin = $netotal;
    $Drware->cashout = 0;
    $Drware->balance = $newbalance;
    $Drware->payment_id = $invoiceid;
    $Drware->type = "Cash Invoice";
    $Drware->type_id = 1;
    $Drware->user_id = Auth::id();
    $Drware->save();
  }
  public function BankTransactionUpdate($openingdate, $netotal, $newbalance, $invoiceid, $bankname, $accno, $bankdescr)
  {
    $Drware = new Bank();
    $Drware->inputdate = $openingdate;
    $Drware->cashin = $netotal;
    $Drware->cashout = 0;
    $Drware->balance = $newbalance;
    $Drware->payment_id = $invoiceid;
    $Drware->type = "Cash Invoice";
    $Drware->type_id = 1;
    $Drware->bank = $bankname;
    $Drware->accno = $accno;
    $Drware->description = $bankdescr;
    $Drware->user_id = Auth::id();
    $Drware->save();
  }

  protected function  CardTransactionUpdate($token, $openingdate, $netotal, $newbalancecard, $invoiceid)
  {
    $charge = Stripe::charges()->create([
      'amount' => $netotal,
      'description' => 'Order',
      'currency' => 'USD',
      'source' => $token['id'],
    ]);

    $card = $token['card'];
    $CardPayment = new CardPayment();
    $CardPayment->inputdate = $openingdate;
    $CardPayment->cashin = $netotal;
    $CardPayment->cashout = 0;
    $CardPayment->balance = $newbalancecard;
    $CardPayment->payment_id = $invoiceid;
    $CardPayment->card_id = $card['id'];
    $CardPayment->strip_id = $token['id'];
    $CardPayment->banktransection_id = $charge['balance_transaction'];
    $CardPayment->source = $charge['id'];
    $CardPayment->card_on_name = $card['name'];
    $CardPayment->brand = $card['brand'];
    $CardPayment->last_four = $card['last4'];
    $CardPayment->country = $card['country'];
    $CardPayment->type = "Order";
    $CardPayment->type_id = 1;
    $CardPayment->user_id = Auth::id();
    $CardPayment->save();
  }

  protected function  PaypalTransactionUpdate($token, $payerID, $currency, $time, $amount, $typeid)
  {

    $PaypalPayment = new PaypalPayment();
    $PaypalPayment->token = $token;
    $PaypalPayment->payerid = $payerID;
    $PaypalPayment->time = $time;
    $PaypalPayment->currency = $currency;
    $PaypalPayment->description = "Cash Invoice";
    $PaypalPayment->type = 1;
    $PaypalPayment->amount = $amount;
    $PaypalPayment->type_id = $typeid;
    $PaypalPayment->user_id = Auth::id();
    $PaypalPayment->save();
  }
  public function PayPalCartStore(Request $request)
  {
    $netotal = $request->nettotal;
    $paymentype = $request->paymenttype_id;
    $PayPalCart = new PayPalCart();
    $PayPalCart->invoice_no = $request->invoicecode;
    $PayPalCart->tokenid = "";
    $PayPalCart->inputdate = $request->openingdate;
    $PayPalCart->ref_no = $request->refno;
    $PayPalCart->customer_id = $request->customer_id;
    $PayPalCart->amount = $request->amount;
    $PayPalCart->discount = $request->discount;
    $PayPalCart->vat = $request->vat;
    $PayPalCart->nettotal = $netotal;
    $PayPalCart->paymenttype_id = $paymentype;
    $PayPalCart->user_id = Auth::id();
    if ($PayPalCart->save() == true) {
      //Item Details
      $tableData = $request->itemtables;
      foreach ($tableData as $items) {
        $itemid = $items['code'];
        $invoiceqty = $items['qty'];
        $product = Product::select('tp', 'unit_id', 'name')->where('id', $itemid)->first();
        $PayPalCartDetails = new PayPalCartDetails();
        $PayPalCartDetails->paypal_id = $PayPalCart->id;
        $PayPalCartDetails->item_id = $itemid;
        $PayPalCartDetails->name = $product->name;
        $PayPalCartDetails->mrp = $items['unitprice'];
        $PayPalCartDetails->tp = $product->tp;
        $PayPalCartDetails->unit_id = $product->unit_id;
        $PayPalCartDetails->qty = $invoiceqty;
        $PayPalCartDetails->amount = $items['amount'];
        $PayPalCartDetails->vat = $items['vat'];
        $PayPalCartDetails->discount = $items['discount'];
        $PayPalCartDetails->nettotal = $items['nettotal'];
        $PayPalCartDetails->save();
      }
    }
    return response()->json($PayPalCart->id);
  }
  protected function PaypalProcess($id)
  {
    $data = [];
    $data['items'] = [];
    $PayPalCart = PayPalCart::find($id);
    $PayPalCartDetails = PayPalCartDetails::where('paypal_id', $id)->get();
    foreach ($PayPalCartDetails as $key => $cartsdetails) {
      $qty = $cartsdetails->qty;
      $mrp = $cartsdetails->mrp;
      $dis = ($cartsdetails->discount) / $qty;
      $vat = ($cartsdetails->vat) / $qty;
      $price = $mrp + $dis + $vat;
      $itemdeatils = [
        'name' => $cartsdetails->name,
        'price' => $price,
        'qty' => $cartsdetails->qty
      ];
      $data['items'][] = $itemdeatils;
    }

    $data['invoice_id'] = $PayPalCart->invoice_no;
    $data['invoice_description'] = "Invoice #{$data['invoice_id']} Invoice";
    $data['return_url'] = url('/Invoice/paypalpaymentsuccess');
    $data['cancel_url'] = route('invoice.create');
    $total = 0;
    foreach ($data['items'] as $item) {
      $total += $item['price'] * $item['qty'];
    }
    $data['total'] = $total;
    $provider = new ExpressCheckout;

    //   $response = $provider->setExpressCheckout($data);
    $response = $provider->setExpressCheckout($data);
    return redirect($response['paypal_link']);
  }
  public function CartDetails($paypalid)
  {
    $data = [];
    $data['items'] = [];
    $PayPalCart = PayPalCart::find($paypalid);
    $PayPalCartDetails = PayPalCartDetails::where('paypal_id', $paypalid)->get();
    foreach ($PayPalCartDetails as $key => $cartsdetails) {

      $itemdeatils = [
        'name' => $cartsdetails->name,
        'price' => $cartsdetails->mrp,
        'qty' => $cartsdetails->qty
      ];
      $data['items'][] = $itemdeatils;
    }

    $data['invoice_id'] = $PayPalCart->invoice_no;
    $data['invoice_description'] = "Invoice #{$data['invoice_id']} Invoice";
    $data['return_url'] = url('/Invoice/paypalpayment-success');
    $data['cancel_url'] = route('invoice.create');
    $total = 0;
    foreach ($data['items'] as $item) {
      $total += $item['price'] * $item['qty'];
    }

    $data['total'] = $total;
    return $data;
  }
  protected function PaypalPaymentSuccess(Request $request)
  {
    $provider = new ExpressCheckout;
    $token = $request->token;
    $response = $provider->getExpressCheckoutDetails($token);
    $tokenid = $response['TOKEN'];
    $invioceid = $response['INVNUM'];
    $payerID = $response['PAYERID'];
    $currency = $response['CURRENCYCODE'];
    $time = $response['TIMESTAMP'];
    $PayPalCart = PayPalCart::where('invoice_no', $invioceid)->first();
    if (!is_null($PayPalCart)) {
      $invoice = new invoice();
      $invoice->invoice_no = $PayPalCart->invoice_no;
      $invoice->inputdate = $PayPalCart->inputdate;
      $invoice->ref_no = $PayPalCart->ref_no;
      $invoice->type_id = 1;
      $invoice->customer_id = $PayPalCart->customer_id;
      $invoice->amount = $PayPalCart->amount;
      $invoice->discount = $PayPalCart->discount;
      $invoice->vat = $PayPalCart->vat;
      $invoice->nettotal = $PayPalCart->nettotal;
      $invoice->paymenttype_id = 4;
      $invoice->pay = 0;
      $invoice->change = 0;
      $invoice->status = 0;
      $invoice->user_id = Auth::id();
      if ($invoice->save() == true) {
        //Item Details
        $PayPalCartDetails = PayPalCartDetails::where('paypal_id', $PayPalCart->id)->get();
        foreach ($PayPalCartDetails as $items) {
          $invoiceDetails = new InvoiceDetails();
          $invoiceDetails->invoice_id = $invoice->id;
          $invoiceDetails->item_id = $items->item_id;
          $invoiceDetails->mrp = $items->mrp;
          $invoiceDetails->tp = $items->tp;
          $invoiceDetails->unit_id = $items->unit_id;
          $invoiceDetails->qty = $items->qty;
          $invoiceDetails->amount = $items->amount;
          $invoiceDetails->vat = $items->vat;
          $invoiceDetails->discount = $items->discount;
          $invoiceDetails->nettotal = $items->nettotal;
          $invoiceDetails->save();
        }

        $this->PaypalTransactionUpdate($tokenid, $payerID, $currency, $time, $PayPalCart->nettotal, $invoice->id);
        $discount =  $invoice->discount;
        $netotal = $invoice->netotal;
        $cashinvoice = $netotal + $discount;
        $CustomerDebts = new CustomerDebts();
        $CustomerDebts->customer_id = $invoice->customer_id;
        $CustomerDebts->openingBalance = 0;
        $CustomerDebts->cashinvoice = $cashinvoice;
        $CustomerDebts->creditinvoice = 0;
        $CustomerDebts->totaldiscount = $discount;
        $CustomerDebts->payment = 0;
        $CustomerDebts->remark = 'Cash Invoice';
        $CustomerDebts->trn_id = $invoice->id;
        $CustomerDebts->save();


        foreach ($PayPalCartDetails as $pdetails) {
          $pdetails->delete();
        }
        $PayPalCart->delete();
      }

      return redirect()->Route('invoice.show', $invoice->id);
    }
  }
  public function InvoiceodeDataList(Request $request)
  {
    if ($request->ajax()) {
      $invoices = Invoice::where('type_id', 1)
        ->where('cancel', 0)
        ->orderBy("id", 'asc')->get();
      return view('datalist.invoicecodedatalist', compact('invoices'))->render();
    }
  }
  public function show($id)
  {
    $this->invid($id);
    return view('invoice.view');
  }
  public function Profile()
  {
    return view('invoice.view');
  }
  public function invid($id)
  {
    Session::put('invid', $id);
  }
  public function GetView()
  {
    $id = Session::get('invid');
    $invoice = Invoice::with('CustomerName', 'InvDetails', 'InvDetails.productName', 'InvDetails.UnitName', 'CustomerName.CountryName', 'CustomerName.StateName', 'CustomerName.CityName')->find($id);
    return  response()->json($invoice);
  }

  public function invoicepdf($id)
  {
    $invoice = Invoice::find($id);
    $title = "Cash Invoice";
    $pdf = PDF::loadView('pdf.invoice', compact('invoice', 'title'));
    return $pdf->stream('invoice.pdf');
  }
  public function InvoiceItem(Request $request)
  {
    $productd = $request->productid;
    $invoicedetails = InvoiceDetails::where('item_id', $productd)
      ->orderBy('invoice_id', 'desc')
      ->get();

    return Datatables::of($invoicedetails)
      ->addIndexColumn()
      ->addColumn('invoiceno', function (InvoiceDetails $InvoiceDetails) {
        return $InvoiceDetails->invoicename->invoice_no;
      })
      ->addColumn('inputdate', function (InvoiceDetails $InvoiceDetails) {
        return $InvoiceDetails->invoicename->inputdate;
      })
      ->addColumn('unit', function (InvoiceDetails $InvoiceDetails) {
        return $InvoiceDetails->UnitName->Shortcut;
      })
      ->addColumn('customer', function (InvoiceDetails $InvoiceDetails) {
        return $InvoiceDetails->invoicename->CustomerName->name;
      })
      ->addColumn('action', function ($InvoiceDetails) {
        $button = '<div class="btn-group" role="group" aria-label="Basic example">';
        $button .= '<button id="datashowinvoice" type="button" name="view" data-id="' . $InvoiceDetails->invoice_id . '" class="edit btn btn-outline-success btn-sm">Show</button>';
        $button .= '</div>';
        return $button;
      })
      ->make(true);
  }
  public function LoadPrintslip($id)
  {
    $title = "Cash Invoice";
    $invoice = Invoice::find($id);
    $SaleConfig = SaleConfig::find(1);
    $print = $SaleConfig->print;
    if ($print == 1) {
      return view('invoice.partials.invoice', compact('invoice', 'title', 'SaleConfig'));
    } else {
      return view('pdf.invoice', compact('invoice', 'title', 'SaleConfig'));
    }
  }
  public function SendMail($id)
  {
    $invoice = Invoice::find($id);
    return view('invoice.sendmail', compact('invoice'));
  }
  //Cancel
  public function Cancels()
  {
    return view('cancel.index');
  }
  public function Cancel($id)
  {
    $canceled = 1;
    $cancelinv = Invoice::select('paymenttype_id', 'customer_id')->where('id', $id)->first();
    if (!is_null($cancelinv)) {
      $type = $cancelinv->paymenttype_id;
      $customerid = $cancelinv->customer_id;
      switch ($type) {
        case 1:
          CashDrawer::where('type', 'Cash Invoice')
            ->where('payment_id', $id)
            ->update(['cancel' => $canceled]);
          break;
        case 2:
          Bank::where('type', 'Cash Invoice')
            ->where('payment_id', $id)
            ->update(['cancel' => $canceled]);
          break;
        case 3:
          $cardpayment = CardPayment::where('type', 'Cash Invoice')->where('payment_id', $id)->first();
          CardPayment::where('type', 'Cash Invoice')
            ->where('payment_id', $id)
            ->update(['cancel' => $canceled]);
          //Stripe::charges()->create
          Stripe::refunds()->create($cardpayment->source);
          break;
        default:
          $provider = new ExpressCheckout;
          PaypalPayment::where('description', 'Cash Invoice')
            ->where('type_id', $id)
            ->update(['cancel' => $canceled]);
          $PaypalPayment = PaypalPayment::where('description', 'Cash Invoice')->where('type_id', $id)->first();
          $provider->refundTransaction($PaypalPayment->payerid, $PaypalPayment->cashin);
          break;
      }
      CustomerDebts::where('customer_id', $customerid)
        ->where('remark', 'Cash Invoice')
        ->where('trn_id', $id)
        ->update(['cancel' => $canceled]);
      $invoiceDetails = InvoiceDetails::where('invoice_id', $id)->get();
      foreach ($invoiceDetails as $details) {
        InvoiceDetails::where('invoice_id', $details->invoice_id)
          ->update(['cancel' => $canceled]);
      }
      invoice::where('id', $id)
        ->update(['cancel' => $canceled]);
    }
  }

  public function CancelLoad(Request $request)
  {

    $a = $this->DataTablesCancel($request);
    return $a;
  }
  public function DataTablesCancel($request)
  {
    if (!empty($request->fromdate) && !empty($request->todate)) {
      $fromdate = date('Y/m/d', strtotime($request->fromdate));
      $todate = date('Y/m/d', strtotime($request->todate));
      $invoice = Invoice::Where('type_id', 1)
        ->where('cancel', 1)
        ->whereBetween('inputdate', array($fromdate, $todate))
        ->orderBy('id', 'DESC')
        ->latest()
        ->get();
    } else {
      $invoice = Invoice::Where('type_id', 1)
        ->where('cancel', 1)
        ->orderBy('id', 'DESC')
        ->latest()
        ->get();
    }
    return Datatables::of($invoice)
      ->addIndexColumn()
      ->addColumn('customer', function (invoice $invoice) {
        return $invoice->CustomerName->name;
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
            break;
        }
        return  $paymenttype;
      })
      ->addColumn('user', function (invoice $invoice) {
        return $invoice->username ? $invoice->username->name : 'Deleted User';
      })
      ->addColumn('action', function ($invoice) {
        $button = '<div class="btn-group" role="group">';
        $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
        $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
        $button .= '<a class="dropdown-item" id="datashow" data-id="' . $invoice->id . '">View</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="datadelete" data-id="' . $invoice->id . '">Delete</a>';
        $button .= '</div></div>';
        return $button;
      })
      ->make(true);
  }
  public function CancelView($id)
  {
    $this->invid($id);
    return view('cancel.view');
  }
  public function CancelDestroy($id)
  {
    $invoicedelete = Invoice::find($id);
    if (!is_null($invoicedelete)) {
      $invoiceDetails = InvoiceDetails::where('invoice_id', $id)->get();
      foreach ($invoiceDetails as $details) {
        $details->delete();
      }
      $type = $invoicedelete->paymenttype_id;
      $customerid = $invoicedelete->customer_id;
      switch ($type) {
        case 1:
          $this->CashDrawerDelete($id);
          break;
        case 2:
          $this->BankpaymentDelete($id);
          break;
        case 3:
          $this->CardpaymentDelete($id);
          break;
        default:
          $this->PaypalPaymentDelete($id);
          break;
      }
      $customerDelete = CustomerDebts::where('customer_id', $customerid)
        ->where('remark', 'Cash Invoice')
        ->where('trn_id', $id)
        ->first();
      if (!is_null($customerDelete)) {
        $customerDelete->delete();
      }
      $invoicedelete->delete();
    }
  }
  public function CashDrawerDelete($trn)
  {
    $cashdrawer = CashDrawer::where('type', 'Cash Invoice')
      ->where('payment_id', $trn)
      ->first();
    if (!is_null($cashdrawer)) {
      $cashdrawer->delete();
    }
  }
  public function BankpaymentDelete($trn)
  {
    $Bank = Bank::where('type', 'Cash Invoice')
      ->where('payment_id', $trn)
      ->first();
    if (!is_null($Bank)) {
      $Bank->delete();
    }
  }
  public function CardpaymentDelete($trn)
  {
    $CardPayment = CardPayment::where('type', 'Cash Invoice')
      ->where('payment_id', $trn)
      ->first();
    if (!is_null($CardPayment)) {
      $CardPayment->delete();
    }
  }
  public function PaypalPaymentDelete($trn)
  {
    $CardPayment = PaypalPayment::where('description', 'Cash Invoice')
      ->where('type_id', $trn)
      ->first();
    if (!is_null($CardPayment)) {
      $CardPayment->delete();
    }
  }
}
