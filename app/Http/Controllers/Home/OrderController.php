<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetails;
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
//use Yajra\DataTables\Contracts\DataTables;
use Stripe;
use App\Accounts\Account;
use Exception;
use Illuminate\Validation\Rules\Unique;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;
use App\Models\SaleConfig;
use App\Models\NumberFormat;
use App\Models\OrderDelivery;
use Illuminate\Support\Facades\Session;
use App\Notifications\RecievedNotification;
use App\Notifications\DeliveryNotification;
use App\User;
use App\Models\PaymentInfo;


class OrderController extends Controller
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
    return view('order.index');
  }
  public function create()
  {
    $date = date('m/d/Y');

    $DayClose = DayClose::where('date', $date)->first();
    if ($DayClose == null) {
      return view('order.create');
    } else {
      return redirect()->Route('dayclose.daycloseerror');
    }
  }
  public function LoadAll(Request $request)
  {
    $a = $this->DataTables($request);
    return $a;
  }
  public function Recent(Request $request)
  {
    $sevendays = \Carbon\Carbon::today()->subDays(7);
    $order = Order::where('created_at', '>=', $sevendays)
      ->where('cancel', 0)
      ->where('status', 0)
      ->orderBy('id', 'DESC')
      ->latest()
      ->get();
    return Datatables::of($order)
      ->addIndexColumn()
      ->addColumn('customer', function (Order $order) {
        return $order->CustomerName->name;
      })
      ->addColumn('paymenttype', function (Order $order) {
        $payment = $order->paymenttype;
        return  $payment;
      })
      ->addColumn('status', function (Order $invoice) {
        $status = $invoice->status;
        switch ($status) {
          case 0:
            $paymenttype = 'New Order';
            break;
          case 1:
            $paymenttype = 'Recieved';
            break;
          default:
            $paymenttype = 'Delivered';
            break;
        }
        return  $paymenttype;
      })

      ->addColumn('action', function ($order) {
        $button = '<div class="btn-group" role="group">';
        $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
        $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
        $button .= '<a class="dropdown-item" id="datashow" data-id="' . $order->id . '">View</a>';
        $button .= '<div class="dropdown-divider"></div>';
        switch ($order->status) {
          case 0:
            $button .= '<a class="dropdown-item" id="recieved" data-id="' . $order->id . '">Recieve</a>';
            $button .= '<div class="dropdown-divider"></div>';
            break;
          case 1:
            $button .= '<a class="dropdown-item" id="delivery" data-id="' . $order->id . '">Delivery</a>';
            $button .= '<div class="dropdown-divider"></div>';
            break;
          default:
            break;
        }
        $button .= '<a class="dropdown-item" id="pdf" data-id="' . $order->id . '">PDF</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="printslip" data-id="' . $order->id . '">Print</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="mail" data-id="' . $order->id . '">Send Mail</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="datashow" data-id="' . $order->id . '">Return</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="canceldata" data-id="' . $order->id . '">Cancel</a>';
        $button .= '</div></div>';
        return $button;
      })

      ->make(true);
  }
  public function DataTables($request)
  {
    if (!empty($request->fromdate) && !empty($request->todate)) {
      $fromdate = date('Y/m/d', strtotime($request->fromdate));
      $todate = date('Y/m/d', strtotime($request->todate));
      $order = Order::Where('type_id', 1)
        ->where('cancel', 0)
        ->whereBetween('inputdate', array($fromdate, $todate))
        ->orderBy('id', 'DESC')
        ->latest()
        ->get();
    } else {
      $order = Order::Where('type_id', 1)
        ->where('cancel', 0)
        ->orderBy('id', 'DESC')
        ->latest()
        ->get();
    }
    return Datatables::of($order)
      ->addIndexColumn()
      ->addColumn('customer', function (Order $order) {
        return $order->CustomerName->name;
      })
      ->addColumn('paymenttype', function (Order $order) {
        $payment = $order->paymenttype;
        return  $payment;
      })
      ->addColumn('status', function (Order $invoice) {
        $status = $invoice->status;
        switch ($status) {
          case 0:
            $paymenttype = 'New Order';
            break;
          case 1:
            $paymenttype = 'Recieved';
            break;
          default:
            $paymenttype = 'Delivered';
            break;
        }
        return  $paymenttype;
      })

      ->addColumn('action', function ($order) {
        $button = '<div class="btn-group" role="group">';
        $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
        $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
        $button .= '<a class="dropdown-item" id="datashow" data-id="' . $order->id . '">View</a>';
        $button .= '<div class="dropdown-divider"></div>';
        switch ($order->status) {
          case 0:
            $button .= '<a class="dropdown-item" id="recieved" data-id="' . $order->id . '">Recieve</a>';
            $button .= '<div class="dropdown-divider"></div>';
            break;
          case 1:
            $button .= '<a class="dropdown-item" id="delivery" data-id="' . $order->id . '">Delivery</a>';
            $button .= '<div class="dropdown-divider"></div>';
            break;
          default:
            break;
        }
        $button .= '<a class="dropdown-item" id="pdf" data-id="' . $order->id . '">PDF</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="printslip" data-id="' . $order->id . '">Print</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="mail" data-id="' . $order->id . '">Send Mail</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="datashow" data-id="' . $order->id . '">Return</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="canceldata" data-id="' . $order->id . '">Cancel</a>';
        $button .= '</div></div>';
        return $button;
      })

      ->make(true);
  }
  public function GetList()
  {
    $currentdatetime = date('Y/m/d');
    $orders = Order::with('CustomerName')
      ->Where('inputdate', $currentdatetime)
      ->orderBy('invoice_no', 'desc')
      ->get();
    return response()->json($orders);
  }
  public function GetListCustomerCash(Request $request)
  {
    $invoice = Order::Where('type_id', 1)
      ->where('customer_id', $request->customerid)
      ->orderBy('invoice_no', 'desc')
      ->latest()
      ->get();

    return Datatables::of($invoice)
      ->addIndexColumn()
      ->addColumn('customer', function (Order $invoice) {
        return $invoice->CustomerName->name;
      })
      ->addColumn('paymenttype', function (Order $invoice) {
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

      ->addColumn('user', function (Order $invoice) {
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



  public function InvoiceodeDataList(Request $request)
  {
    if ($request->ajax()) {
      $invoices = Order::where('type_id', 1)
        ->where('cancel', 0)
        ->orderBy("id", 'asc')->get();
      return view('datalist.ordercodedatalist', compact('invoices'))->render();
    }
  }

  public function LoadNotification()
  {

    $order = Order::with('CustomerName')->where('status', 0)->orderBy('id', 'DESC')->get();
    return response()->json($order);
  }
  public function DeliveryLoadNotification()
  {
    $order = Order::with('CustomerName')->where('status', 1)->orderBy('id', 'DESC')->get();
    return response()->json($order);
  }
  public function Show($id)
  {

    return view('order.view', compact('id'));
  }

  public function Profile()
  {
    return view('invoice.view');
  }
  public function invid($id)
  {
    Session::put('invid', $id);
  }
  public function GetView(Request $request)
  {
    $id = $request->id;
    $invoice = Order::with('CustomerName', 'InvDetails', 'InvDetails.productName', 'InvDetails.UnitName', 'CustomerName.CountryName', 'CustomerName.StateName', 'CustomerName.CityName','payment')->find($id);
    return  response()->json($invoice);
  }
  public function OrderRecived($id)
  {
    return view('order.recieved', compact('id'));
  }
  public function Recived(Request $request, $id)
  {
    $order = Order::find($id);
    $order->status = 1;
    $order->delivery_date = $request->delivarydate;
    $order->update();
    User::find($order->user_id)->notify(new RecievedNotification($order));
    return response()->json($order);
  }

  public function OrderDelivery($id)
  {
    return view('order.orderDelivery', compact('id'));
  }

  public function Delivery(Request $request, $id)
  {

    $OrderDelivery = new OrderDelivery();
    $OrderDelivery->invoice_id = $id;
    $OrderDelivery->employeer_id = $request->empid;
    $OrderDelivery->deliveri_exp = $request->exp;
    $OrderDelivery->remark = $request->remark;
    $OrderDelivery->inputdate = $request->delivarydate;
    if ($OrderDelivery->save()) {
      $order = Order::find($id);
      $order->status = 2;
      $order->update();
      User::find($order->user_id)->notify(new DeliveryNotification($order));
    }
    return response()->json($order);
  }
  public function orderpdf($id)
  {
    $invoice = Order::find($id);
    $title = "Order";
    $ordername = "Order #" . $invoice->invoice_no;
    $pdf = PDF::loadView('pdf.order', compact('invoice', 'title'));
    return $pdf->stream($ordername . '.pdf');
  }
  public function deliverPdf($id)
  {
    $invoice = Order::with('DeliveryNote')->find($id);

    $title = "Order";
    $ordername = "Order #" . $invoice->invoice_no;
    $pdf = PDF::loadView('pdf.deliverNote', compact('invoice', 'title'));
    return $pdf->stream($ordername . '.pdf');
  }
  public function InvoiceItem(Request $request)
  {
    $productd = $request->productid;
    $invoicedetails = OrderDetails::where('item_id', $productd)
      ->orderBy('invoice_id', 'desc')
      ->get();

    return Datatables::of($invoicedetails)
      ->addIndexColumn()
      ->addColumn('invoiceno', function (OrderDetails $InvoiceDetails) {
        return $InvoiceDetails->invoicename->invoice_no;
      })
      ->addColumn('inputdate', function (OrderDetails $InvoiceDetails) {
        return $InvoiceDetails->invoicename->inputdate;
      })
      ->addColumn('unit', function (OrderDetails $InvoiceDetails) {
        return $InvoiceDetails->UnitName->Shortcut;
      })
      ->addColumn('customer', function (OrderDetails $InvoiceDetails) {
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
    $invoice = Order::find($id);
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
    $invoice = Order::find($id);
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
    $cancelinv = Order::select('paymenttype_id', 'customer_id')->where('id', $id)->first();
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
      $invoiceDetails = OrderDetails::where('invoice_id', $id)->get();
      foreach ($invoiceDetails as $details) {
        OrderDetails::where('invoice_id', $details->invoice_id)
          ->update(['cancel' => $canceled]);
      }
      Order::where('id', $id)
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
      $invoice = Order::Where('type_id', 1)
        ->where('cancel', 1)
        ->whereBetween('inputdate', array($fromdate, $todate))
        ->orderBy('id', 'DESC')
        ->latest()
        ->get();
    } else {
      $invoice = Order::Where('type_id', 1)
        ->where('cancel', 1)
        ->orderBy('id', 'DESC')
        ->latest()
        ->get();
    }
    return Datatables::of($invoice)
      ->addIndexColumn()
      ->addColumn('customer', function (Order $invoice) {
        return $invoice->CustomerName->name;
      })
      ->addColumn('paymenttype', function (Order $invoice) {
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
      ->addColumn('user', function (Order $invoice) {
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
    $invoicedelete = Order::find($id);
    if (!is_null($invoicedelete)) {
      $invoiceDetails = OrderDetails::where('invoice_id', $id)->get();
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


  //Payment Info

  public function paymentInfo()
  {
    return view('order.paymentinfo');
  }
  public function paymentInfoLoad()
  {
    $order = PaymentInfo::orderBy('id', 'DESC')
      ->latest()
      ->get();
    return Datatables::of($order)
      ->addIndexColumn()
      ->addColumn('action', function ($order) {
        $button = '<div class="btn-group" role="group">';
        $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
        $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
        $button .= '<a class="dropdown-item" id="datashow" data-id="' . $order->invoice_id . '">View</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="pdf" data-id="' . $order->invoice_id . '">PDF</a>';
       /*  $button .= '<div class="dropdown-divider"></div>'; */
      /*   $button .= '<a class="dropdown-item" id="datashow" data-id="' . $order->invoice_id . '">Refund</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item" id="canceldata" data-id="' . $order->invoice_id . '">Cancel</a>'; */
        $button .= '</div></div>';
        return $button;
      })

      ->make(true);
  }
}
