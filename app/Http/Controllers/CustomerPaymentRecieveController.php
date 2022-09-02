<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CustomerPaymentRecieve;
use App\Models\CashDrawer;
use App\Models\customer;
use App\Models\DayClose;
use App\Models\CustomerDebts;
use DataTables;
use PDF;
use App\Models\Bank;
use App\Models\CardPayment;
use App\Models\PaypalPayment;
use Stripe;
use App\Models\PayPalCustomerPaymentTemp;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Models\NumberFormat;
use Illuminate\Support\Facades\Session;

class CustomerPaymentRecieveController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:credit payment-list|credit payment-create|credit payment-edit|credit payment-delete', ['only' => ['index', 'show', 'profile']]);
        $this->middleware('permission:credit payment-create', ['only' => ['create', 'Store']]);
        $this->middleware('permission:credit payment-edit', ['only' => ['edit', 'update', 'DataUpdate']]);
        $this->middleware('permission:credit payment-delete', ['only' => ['delete']]);
        $this->middleware('permission:mail-list', ['only' => ['SendMail',]]);
    }
    public function index()
    {
        return view('customerpaymentrecive.index');
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
            $CustomerPaymentRecieve = CustomerPaymentRecieve::orderBy('id', 'desc')

                ->WhereBetween('inputdate', array($fromdate, $todate))
                ->latest()
                ->get();
        } else {
            $CustomerPaymentRecieve = CustomerPaymentRecieve::orderBy('id', 'desc')

                ->latest()
                ->get();
        }
        return DataTables::of($CustomerPaymentRecieve)
            ->addIndexColumn()
            ->addColumn('customer', function (CustomerPaymentRecieve $CustomerPaymentRecieve) {
                return $CustomerPaymentRecieve->CustomerName->name;
            })
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
                        $paymenttype = '';
                        break;
                }
                return  $paymenttype;
            })
            ->addColumn('user', function (CustomerPaymentRecieve $CustomerPaymentRecieve) {
                return $CustomerPaymentRecieve->username ? $CustomerPaymentRecieve->username->name : 'Deleted User';
            })
            ->addColumn('action', function ($CustomerPaymentRecieve) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $CustomerPaymentRecieve->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="datadelete" data-id="' . $CustomerPaymentRecieve->id . '">Delete</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="pdf" data-id="' . $CustomerPaymentRecieve->id . '">Pdf</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="mail" data-id="' . $CustomerPaymentRecieve->id . '">Send Mail</a>';
                $button .= '</div></div>';
                return $button;
            })
            ->make(true);
    }
    public function GetList()
    {
        $currentdatetime = date('Y/m/d');
        $CustomerRecieve = CustomerPaymentRecieve::with('CustomerName')->orderBy('id', 'desc')->get();
        return response()->json($CustomerRecieve);
    }
    public function GetListCustomer(Request $request)
    {
        $CustomerPaymentRecieve = CustomerPaymentRecieve::orderBy('id', 'desc')

            ->where('customer_id', $request->customerid)
            ->latest()
            ->get();

        return DataTables::of($CustomerPaymentRecieve)
            ->addIndexColumn()
            ->addColumn('customer', function (CustomerPaymentRecieve $CustomerPaymentRecieve) {
                return $CustomerPaymentRecieve->CustomerName->name;
            })
            ->addColumn('paymenttype', function (CustomerPaymentRecieve $CustomerPaymentRecieve) {
                $payment = $CustomerPaymentRecieve->payment_type;
                $paymenttype = "";
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
                        $paymenttype = '';
                        break;
                }
                return  $paymenttype;
            })
            ->addColumn('user', function (CustomerPaymentRecieve $CustomerPaymentRecieve) {

                return $CustomerPaymentRecieve->username ? $CustomerPaymentRecieve->username->name : 'Deleted User';
            })
            ->addColumn('action', function ($CustomerPaymentRecieve) {
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
                $button .= '<button id="datashow" type="button" name="edit" data-id="' . $CustomerPaymentRecieve->id . '" class="edit btn btn-outline-default btn-sm">Show</button>';
                $button .= '</div>';
                return $button;
            })
            ->make(true);
    }
    public function create()
    {
        $date = date('m/d/Y');
        $DayClose = DayClose::where('date', $date)->first();
        if ($DayClose == null) {
            return view('customerpaymentrecive.create');
        } else {
            return redirect()->Route('dayclose.daycloseerror');
        }
    }
    public function PaymentNo()
    {

        $NumberFormat = NumberFormat::select('creditpayment')->where('id', 1)->first();
        $numb = $NumberFormat->creditpayment;
        $CustomerPaymentRecieve = new CustomerPaymentRecieve();
        $lastCustomerPaymentRecieve = $CustomerPaymentRecieve->pluck('id')->last();
        $PaymentCode = $lastCustomerPaymentRecieve + 1;
        return response()->json($numb . $PaymentCode);
    }

    public function Store(Request $request)
    {
        $paymentype = $request->paymenttype;
        $respnse = "";
        $recieve = $request->recieve;
        $customerpayment = new CustomerPaymentRecieve();
        $customerpayment->payment_no = $request->paymentno;
        $customerpayment->inputdate = $request->inputdate;
        $customerpayment->customer_id = $request->customer_id;
        $customerpayment->amount = $request->amount;
        $customerpayment->recieve =  $recieve;
        $customerpayment->balancedue = $request->newbalancedue;
        $customerpayment->payment_id = $request->paymenttype;
        $customerpayment->paymentdescription = $request->paymentdescription;
        $customerpayment->remark = $request->remark;
        $customerpayment->user_id = Auth::id();
        $customerpayment->comment = 'Credit Payment';
        if ($customerpayment->save()) {
            //Update customer Payment
            $CustomerDebts = new CustomerDebts();
            $CustomerDebts->customer_id = $request->customer_id;
            $CustomerDebts->openingBalance = 0;
            $CustomerDebts->cashinvoice = 0;
            $CustomerDebts->creditinvoice = 0;
            $CustomerDebts->order = 0;
            $CustomerDebts->totaldiscount = 0;
            $CustomerDebts->payment =  $recieve;
            $CustomerDebts->remark = 'credit Payment';
            $CustomerDebts->trn_id = $customerpayment->id;
            $CustomerDebts->save();
            //balance update
            $cashin = CashDrawer::where('cancel', 0)->sum('cashin');
            $cashout = CashDrawer::where('cancel', 0)->sum('cashout');
            $balance = $cashin - $cashout;
            $newbalance = $recieve + $balance;

            $cashinbank = Bank::where('cancel', 0)->sum('cashin');
            $cashoutbank = Bank::where('cancel', 0)->sum('cashout');
            $balancebank = $cashinbank - $cashoutbank;
            $newbalancebank = $recieve + $balancebank;

            $cashincard = CardPayment::sum('cashin');
            $cashoutcard = CardPayment::sum('cashout');
            $balancecard = $cashincard - $cashoutcard;
            $newbalancecard = $recieve + $balancecard;

            switch ($paymentype) {
                case 1:
                    $this->CashDrawerUpdate($request->inputdate, $recieve, $newbalance, $customerpayment->id);
                    break;
                case 2:

                    $this->BankTransactionUpdate($request->inputdate, $recieve, $newbalancebank, $customerpayment->id, $request->bankname, $request->accno, $request->bankdescrip);
                    break;
                case 3:
                    $this->CardTransactionUpdate($request->token, $request->inputdate, $recieve, $newbalancecard, $customerpayment->id);
                    //$this->BankTransactionUpdate($request->openingdate, $netotal, $newbalancebank, $invoice->id,$request->bankname,$request->accno, $request->bankdescrip);
                    break;
                default:
            }
            $respnse =  $customerpayment->id;
        } else {

            $respnse = 0;
        }
        return response()->json($respnse);
    }

    public function CashDrawerUpdate($openingdate, $netotal, $newbalance, $invoiceid)
    {
        $Drware = new CashDrawer();
        $Drware->inputdate = $openingdate;
        $Drware->cashin = $netotal;
        $Drware->cashout = 0;
        $Drware->balance = $newbalance;
        $Drware->payment_id = $invoiceid;
        $Drware->type = "credit Payment";
        $Drware->type_id = 3;
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
        $Drware->type = "credit Payment";
        $Drware->type_id = 3;
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
            'description' => 'Invoice',
            'currency' => 'CAD',
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
        $CardPayment->type = "credit Payment";
        $CardPayment->user_id = Auth::id();
        $CardPayment->save();
    }

    public function PaypalStore(Request $request)
    {
        $recieve = $request->recieve;
        $PayPalCustomerPaymentTemp = new PayPalCustomerPaymentTemp();
        $PayPalCustomerPaymentTemp->payment_no = $request->paymentno;
        $PayPalCustomerPaymentTemp->inputdate = $request->inputdate;
        $PayPalCustomerPaymentTemp->customer_id = $request->customer_id;
        $PayPalCustomerPaymentTemp->amount = $request->amount;
        $PayPalCustomerPaymentTemp->recieve =  $recieve;
        $PayPalCustomerPaymentTemp->balancedue = $request->newbalancedue;
        $PayPalCustomerPaymentTemp->remark = $request->remark;
        $PayPalCustomerPaymentTemp->user_id = Auth::id();
        $PayPalCustomerPaymentTemp->save();
        return response()->json($PayPalCustomerPaymentTemp->id);
    }
    protected function PaypalProcess($id)
    {
        $PayPalCustomerPaymentTemp = PayPalCustomerPaymentTemp::find($id);
        $data = [];
        $data['items'] = [
            [
                'name' => $PayPalCustomerPaymentTemp->CustomerName->name,
                'price' => $PayPalCustomerPaymentTemp->recieve,
                'desc'  => 'Credit Invoice',
                'qty' => 1
            ]
        ];

        $data['invoice_id'] = $PayPalCustomerPaymentTemp->payment_no;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Payment No";
        $data['return_url'] = url('/CustomerPayment/paypalpaymentsuccess');
        $data['cancel_url'] = route('customerpayment.create');
        $data['total'] =  $PayPalCustomerPaymentTemp->recieve;

        $provider = new ExpressCheckout;
        $response = $provider->setExpressCheckout($data);
        $response = $provider->setExpressCheckout($data, true);
        return redirect($response['paypal_link']);
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
        $paymentdescription = 'Token Id' . $tokenid . "\n" . 'Payer Id:' . $payerID . "\n" . 'Currency' . $currency;
        $PayPalCustomerPaymentTemp = PayPalCustomerPaymentTemp::where('payment_no', $invioceid)->first();
        if (!is_null($PayPalCustomerPaymentTemp)) {
            $recieve = $PayPalCustomerPaymentTemp->recieve;
            $customerpayment = new CustomerPaymentRecieve();
            $customerpayment->payment_no = $invioceid;
            $customerpayment->inputdate = $PayPalCustomerPaymentTemp->inputdate;
            $customerpayment->customer_id = $PayPalCustomerPaymentTemp->customer_id;
            $customerpayment->amount = $PayPalCustomerPaymentTemp->amount;
            $customerpayment->recieve =  $recieve;
            $customerpayment->balancedue = $PayPalCustomerPaymentTemp->balancedue;
            $customerpayment->payment_id = 4;
            $customerpayment->paymentdescription = $paymentdescription;
            $customerpayment->remark = $PayPalCustomerPaymentTemp->remark;
            $customerpayment->user_id = Auth::id();
            if ($customerpayment->save()) {
                //Update customer Payment
                $CustomerDebts = new CustomerDebts();
                $CustomerDebts->customer_id = $PayPalCustomerPaymentTemp->customer_id;
                $CustomerDebts->openingBalance = 0;
                $CustomerDebts->cashinvoice = 0;
                $CustomerDebts->creditinvoice = 0;
                $CustomerDebts->totaldiscount = 0;
                $CustomerDebts->payment =  $recieve;
                $CustomerDebts->remark = 'credit Payment';
                $CustomerDebts->trn_id = $customerpayment->id;
                $CustomerDebts->save();
                $this->PaypalTransactionUpdate($tokenid, $payerID, $currency, $time, $recieve, $customerpayment->id);
            }
        }

        return redirect()->Route('customerpayment.show', $customerpayment->id);
    }

    protected function  PaypalTransactionUpdate($token, $payerID, $currency, $time, $amount, $typeid)
    {
        $PaypalPayment = new PaypalPayment();
        $PaypalPayment->token = $token;
        $PaypalPayment->payerid = $payerID;
        $PaypalPayment->time = $time;
        $PaypalPayment->currency = $currency;
        $PaypalPayment->description = "credit Payment";
        $PaypalPayment->amount = $amount;
        $PaypalPayment->type_id = $typeid;
        $PaypalPayment->user_id = Auth::id();
        $PaypalPayment->save();
    }
    public function show($id)
    {
        $this->cpaymentid($id);
        return view('customerpaymentrecive.view');
    }
    public function cpaymentid($id)
    {
        Session::put('cpaymentid', $id);
    }
    public function PaymentCodeDatalist(Request $request)
    {
        if ($request->ajax()) {
            $recives = CustomerPaymentRecieve::orderBy("id", 'asc')
                ->get();
            return view('datalist.paymentrecievecodedatalist', compact('recives'))->render();
        }
    }

    public function GetView()
    {
        $id = Session::get('cpaymentid');
        $customerpayment = CustomerPaymentRecieve::with('CustomerName', 'CustomerName.CountryName', 'CustomerName.StateName', 'CustomerName.CityName')->find($id);
        return  response()->json($customerpayment);
    }
    public function Pdf($id)
    {
        $title = "Credit Payment";
        $customerpayment = CustomerPaymentRecieve::find($id);
        $pdf = PDF::loadView('pdf.customerpayment', compact('customerpayment', 'title'));
        return $pdf->stream('customerpayment.pdf');
    }

    public function SendMail($id)
    {
        $customerpayment = CustomerPaymentRecieve::find($id);
        return view('customerpaymentrecive.sendmail', compact('customerpayment'));
    }

    public function destroy($id)
    {
        $CustomerPaymentRecieve = CustomerPaymentRecieve::find($id);
        if (!is_null($CustomerPaymentRecieve)) {
            $SupplierDebt = CustomerDebts::where('trn_id', $id)
                ->where('remark', 'credit Payment')
                ->first();
            if (!is_null($SupplierDebt)) {
                $SupplierDebt->delete();
            }
            $type = $CustomerPaymentRecieve->payment_id;
            switch ($type) {
                case 1:
                    $CashDrawer = CashDrawer::where('type', 'credit Payment')
                        ->where('type_id', 3)
                        ->where('payment_id', $id)
                        ->first();
                    if (!is_null($CashDrawer)) {
                        $CashDrawer->delete();
                    }
                    break;
                case 2:
                    $Bank = Bank::where('type', 'credit Payment')
                        ->where('type_id', 3)
                        ->where('payment_id', $id)
                        ->first();
                    if (!is_null($Bank)) {
                        $Bank->delete();
                    }
                    break;
                case 3:
                    $cardpayment = CardPayment::where('type', 'credit Payment')
                        ->where('payment_id', $id)
                        ->first();
                    if (!is_null($cardpayment)) {
                        Stripe::refunds()->create($cardpayment->source);
                        $cardpayment->delete();
                    }
                    break;
                case 3:
                    $provider = new ExpressCheckout;
                    $PaypalPayment = PaypalPayment::where('description', 'credit Payment')
                        ->where('type_id', $id)
                        ->first();
                    if (!is_null($PaypalPayment)) {
                        $provider->refundTransaction($PaypalPayment->payerid, $PaypalPayment->cashin);
                        $PaypalPayment->delete();
                    }
                    break;
                default:
                    break;
            }
            $CustomerPaymentRecieve->delete();
        }
    }
}
