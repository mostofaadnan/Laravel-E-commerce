<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use App\Models\Cart;
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
use Stripe;
use App\Accounts\Account;
use Exception;
use Illuminate\Validation\Rules\Unique;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;
use App\Models\SaleConfig;
use App\Models\NumberFormat;
use Illuminate\Support\Facades\Session;
use App\Models\state;
use App\Models\city;
use App\Notifications\OrderNotification;
use App\User;
use App\Admin;
use App\Events\RealTimeMessage;
use App\Models\shipmentCharge;
use App\Models\sslorder;
use App\Library\SslCommerz\SslCommerzNotification;
use DB;
use App\Models\PaymentInfo;
use Symfony\Component\Console\Input\Input;
use App\Models\Brand;
use App\Models\Category;

class CheckOutController extends Controller
{

    public function ShipingAddress()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $countrys = Country::orderBy('name', 'asc')->get();
        $customer = customer::where('user_id', Auth::id())->first();
        if (!is_null($customer)) {
            $states =  state::where('country_id', $customer->country_id)->get();
            $cities =  city::where('state_id', $customer->state_id)->get();
            $shipmentCharge = shipmentCharge::where('state_id', $customer->state_id)->first();
            if (!is_null($shipmentCharge)) {
                $shipment = $shipmentCharge->charge;
            } else {
                $shipment = 0;
            }
        } else {
            $states = '';
            $cities = '';
            $shipment = 0;
        }
        return view('frontend.checkout.billingaddress', [
            'countrys' => $countrys,
            'customer' => $customer,
            'states' => $states,
            'cities' => $cities,
            'shipment' => $shipment,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }
    public function OverView()
    {
        if (!Session::has('address')) {
            return back();
        } else {

            $address = Session::get('address');
            $shipment = 0;
            $nettotal = 0;
            $vat = 0;
            $brands = Brand::all();
            $categories = Category::all();
            if (!Session::has('cart')) {
                return view('frontend.checkout.overview', ['products' => null, 'categories' => $categories, 'brands' => $brands, 'address' => $address]);
            }
            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);
            $totalprice = $cart->totalPrice;
            $shipment = $address['shipment'];
            $nettotal = $totalprice + $shipment;
            $vat = 0.15 * $nettotal;
            return view('frontend.checkout.overview', [
                'products' => $cart->items,
                'totalprice' => $cart->totalPrice,
                'shipment' => $shipment,
                'netotal' => $nettotal,
                'vat' => $vat,
                'categories' => $categories,
                'brands' => $brands,
                'address' => $address,
            ]);
        }
    }
    public function AddCustomerInfo(Request $request)
    {
        $shippingcharge = 0;
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_company'] = $request->shipping_company;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_state'] = $request->shipping_state;
        $data['shipping_city'] = $request->shipping_city;
        $data['shipping_postalcode'] = $request->customer_postalcode;
        $data['shipping_country'] = $request->shipping_country;

        $data['billing_name'] = $request->billing_name;
        $data['billing_phone'] = $request->billing_phone;
        $data['billing_address'] = $request->billing_address;
        $data['billing_state'] = $request->billing_state;
        $data['billing_city'] = $request->billing_city;
        $data['billing_postalcode'] = $request->billing_postalcode;
        $data['billing_country'] = $request->billing_country;

        $shipmentCharge = shipmentCharge::where('state_id', $request->state_id)->first();
        if (!is_null($shipmentCharge)) {
            $shippingcharge = $shipmentCharge->charge;
        } else {
            $shippingcharge = 0;
        }
        $data['shipment'] = $shippingcharge;
        $request->session()->put('address', $data);
    }
    public function Payment()
    {
        $categories = Category::all();
        return view('frontend.checkout.payment', compact('categories'));
    }
    public function index()
    {
        $pagetitle = "Checkout";
        $shipment = 0;
        $nettotal = 0;
        $brands = Brand::all();
        $categories = Category::all();
        $countrys = Country::orderBy('name', 'asc')->get();
        if (!Session::has('cart')) {
            return view('frontend.checkout.index', ['countrys' => $countrys, 'products' => null, 'pagetitle' => $pagetitle, 'categories' => $categories, 'brands' => $brands]);
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $totalprice = $cart->totalPrice;
        $customer = customer::where('user_id', Auth::id())->first();
        if (!is_null($customer)) {
            $states =  state::where('country_id', $customer->country_id)->get();
            $cities =  city::where('state_id', $customer->state_id)->get();
            $shipmentCharge = shipmentCharge::where('state_id', $customer->state_id)->first();
            if (!is_null($shipmentCharge)) {
                $shipment = $shipmentCharge->charge;
            } else {
                $shipment = 0;
            }
        } else {
            $states = '';
            $cities = '';
            $shipment = 0;
        }
        $netotal = $totalprice + $shipment;
        return view('frontend.checkout.index', [
            'countrys' => $countrys,
            'products' => $cart->items,
            'totalprice' => $cart->totalPrice,
            'customer' => $customer,
            'states' => $states,
            'cities' => $cities,
            'shipment' => $shipment,
            'netotal' => $netotal,
            'pagetitle' => $pagetitle,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }
    function Shipmentcharge(Request $request)
    {
        $charge = 0;
        $stateid = $request->stateid;
        $shipmentCharge = shipmentCharge::where('state_id', $stateid)->first();
        if (!is_null($shipmentCharge)) {
            $charge = $shipmentCharge->charge;
        } else {
            $charge = 0;
        }
        return response()->json($charge);
    }
    public function InvoiceCode()
    {
        $NumberFormat = NumberFormat::select('cashinvoice')->where('id', 1)->first();
        $numb = $NumberFormat->cashinvoice;
        $Invoice = new Order();
        $lastInvoice = $Invoice->pluck('id')->last();
        $InvoiceCode = $lastInvoice + 1;
        $invid = $numb . $InvoiceCode;
        return  $invid;
        //  return response()->json($numb . $InvoiceCode);
    }

    public function StoreCash(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric',
            'country_id' => 'required|numeric',
            'state_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'address' => 'required',
            'nettotal' => 'required',
            'itemtables' => 'required'
        ]);

        //   if ($request->paymenttype_id) {
        $paymentInfo = "Cash";
        $customerid = $this->CustomerStoreOrUpdate($request);
        if ($customerid > 0) {
            $invnum = $this->InvoiceCode();
            $netotal = $request->nettotal;
            //   $paymentype = $request->paymenttype_id;
            $datareponse = "";
            $order = new Order();
            $order->invoice_no = $invnum;
            $order->inputdate = date('Y-m-d');
            $order->ref_no = "";
            $order->type_id = 1;
            $order->customer_id = $customerid;
            $order->amount = $request->nettotal;
            $order->discount = 0.00;
            $order->vat = $request->vat;
            $order->shipment = $request->shipment;
            $order->nettotal = $netotal;
            $order->store_amount = $netotal;
            $order->paymenttype = $paymentInfo;
            $order->status = 0;
            $order->user_id = Auth::id();
            $order->comment = 'Order';
            if ($order->save() == true) {
                //Item Details
                //   $this->StorePaymenInfo($order->id, $paymentInfo);
                $data =  $request->itemtables;
                //$jsonData = json_decode($data, true);
                $this->OrderDetailsStore($data, $order->id, $customerid);

                $this->CustomerDebit($request->discount, $netotal, $customerid, $order->id);
                User::find(Auth::id())->notify(new OrderNotification($order));
                //  event(new RealTimeMessage($order));
                Session::forget('cart');
                $datareponse = $order->id;
            } else {
                $datareponse = 0;
            }
        } else {
            $datareponse = 0;
        }
        ///   }

        // return $order->id;
        return response()->json($datareponse);
    }
    public function Store($request, $paymentInfo)
    {

        /* 
        $request->validate([
            'customername' => 'required',
            'mobile_no' => 'required|numeric',
            'country_id' => 'required|numeric',
            'state_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'address' => 'required',
            'nettotal' => 'required',
            'itemtables' => 'required'
        ]);
 */
        //   if ($request->paymenttype_id) {
        $customerid = $this->CustomerStoreOrUpdate($request);
        if ($customerid > 0) {
            $invnum = $this->InvoiceCode();
            $netotal = $request->amount;
            //   $paymentype = $request->paymenttype_id;
            $datareponse = "";
            $order = new Order();
            $order->invoice_no = $invnum;
            $order->inputdate = date('Y-m-d');
            $order->ref_no = "";
            $order->type_id = 1;
            $order->customer_id = $customerid;
            $order->amount = $request->rate;
            $order->discount = 0.00;
            $order->vat = $request->vat;
            $order->shipment = $request->shipment;
            $order->nettotal = $netotal;
            $order->store_amount = $paymentInfo['store_amount'];
            $order->paymenttype = $paymentInfo['card_type'];
            $order->status = 0;
            $order->user_id = Auth::id();
            $order->comment = 'Order';
            if ($order->save() == true) {
                //Item Details
                $this->StorePaymenInfo($order->id, $paymentInfo);
                $data =  $request->details;
                $jsonData = json_decode($data, true);
                $this->OrderDetailsStore($jsonData, $order->id, $customerid);
                $this->CustomerDebit($request->discount, $netotal, $customerid, $order->id);
                User::find(Auth::id())->notify(new OrderNotification($order));
                //  event(new RealTimeMessage($order));
                Session::forget('cart');
            } else {
                $datareponse = 0;
            }
        } else {
            $datareponse = 0;
        }
        ///   }

        return $order->id;
        //   return response()->json($datareponse);
    }

    public function StorePaymenInfo($invoiceid, $data)
    {
        $PaymentInfo = new PaymentInfo();
        $PaymentInfo->invoice_id = $invoiceid;
        $PaymentInfo->tran_id = $data['tran_id'];
        $PaymentInfo->amount = $data['amount'];
        $PaymentInfo->card_type = $data['card_type'];
        $PaymentInfo->store_amount = $data['store_amount'];
        $PaymentInfo->card_no = $data['card_no'];
        $PaymentInfo->bank_tran_id = $data['bank_tran_id'];
        $PaymentInfo->tran_date = $data['tran_date'];
        $PaymentInfo->card_issuer = $data['card_issuer'];
        $PaymentInfo->card_brand = $data['card_brand'];
        $PaymentInfo->card_issuer_country = $data['card_issuer_country'];
        $PaymentInfo->store_id = $data['store_id'];
        $PaymentInfo->currency_rate = $data['currency_rate'];
        $PaymentInfo->save();
    }

    public function CustomerDebit($discount, $netotal, $customerid, $orderid)
    {
        $payment = 0;
        $creditinvoice = 0;
        $discount =  $discount;
        $cashinvoice = $netotal + $discount;

        $CustomerDebts = new CustomerDebts();
        $CustomerDebts->customer_id = $customerid;
        $CustomerDebts->openingBalance = $cashinvoice;
        $CustomerDebts->cashinvoice = 0;
        $CustomerDebts->creditinvoice = 0;
        $CustomerDebts->order = $netotal;
        $CustomerDebts->totaldiscount = $discount;
        $CustomerDebts->payment = $payment;
        $CustomerDebts->remark = 'Order';
        $CustomerDebts->trn_id = $orderid;
        $CustomerDebts->save();
    }
    public function OrderDetailsStore($tableData, $orderid, $customerid)
    {

        foreach ($tableData as $items) {

            $itemid = $items['item']['id'];
            $orderqty = $items['qty'];
            $orderDetails = new OrderDetails();
            $orderDetails->invoice_id = $orderid;
            $orderDetails->item_id = $itemid;
            $orderDetails->spacification = "";
            $orderDetails->mrp =  $items['unitprice'];
            $orderDetails->unit_id = $items['item']['unit_id'];
            $orderDetails->qty = $orderqty;
            $orderDetails->amount = $items['qty'];
            $orderDetails->vat = 0.0;
            $orderDetails->discount = 0.00;
            $orderDetails->nettotal = $items['price'];
            $orderDetails->customer_id = $customerid;
            $orderDetails->save();
        }
    }

    //sslComerz payment
    public function payViaAjax(Request $request)
    {

        $invnum = $this->InvoiceCode();
        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.
        $requestdata = (array)json_decode($request->cart_json);
        $post_data = array();
        $post_data['total_amount'] = $requestdata['total_amount']; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] =  $requestdata['cus_name'];
        $post_data['cus_email'] = Auth::user()->email;
        $post_data['cus_add1'] = $requestdata['cus_addr1'];
        $post_data['cus_add2'] = $requestdata['cus_addr2'];
        $post_data['cus_city'] = $requestdata['cus_city'];
        $post_data['cus_state'] = $requestdata['cus_state'];
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = $requestdata['cus_country'];
        $post_data['cus_phone'] =  $requestdata['cus_phone'];
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = $requestdata['cus_addr1'];
        /*  $post_data['ship_add2'] = $requestdata['cus_city']; */
        $post_data['ship_city'] = $requestdata['cus_city'];
        $post_data['ship_state'] = $requestdata['cus_state'];
        /*  $post_data['ship_postcode'] = "1000"; */
        $post_data['ship_phone'] =  $requestdata['cus_phone'];
        $post_data['ship_country'] =  $requestdata['cus_country'];

        /*  $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods"; */

        # OPTIONAL PARAMETERS
        /*  $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004"; */
        /*   $post_data['value_a'] = $invnum; */
        $update_product = DB::table('sslorders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([

                /*  'inputdate' => date('Y-m-d'), */
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'country_id' => $requestdata['countryid'],
                'state_id' => $requestdata['stateid'],
                'city_id' => $requestdata['cityid'],
                'rate' => $requestdata['amount'],
                'discount' => $requestdata['discount'],
                'vat' => $requestdata['vat'],
                'shipment' => $requestdata['shipment'],
                'amount' => $post_data['total_amount'],
                'paymentinfo' => "",
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'address_one' => $post_data['cus_add2'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency'],
                'details' => json_encode($requestdata['itemtables']),
            ]);
        Session::save();
        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function success(Request $request)
    {
        //echo "Transaction is Successful";
        //  dd($request->all());
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();
        #Check order status in order tabel against the transaction id or order id.

        $order_detials = DB::table('sslorders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();
        //  dd($order_detials);

        if ($order_detials->status == 'Pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);
            //   dd($validation); 
            if ($validation == true) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */


                $update_product = DB::table('sslorders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Processing']);

                $orders = sslorder::where('transaction_id', $tran_id)->first();
                $orderid = $this->Store($orders, $request->all());
                Session()->flash('success', 'Your Order Successfully Place,Will Recived Your Order And delivery,Thank You');
                //  echo "<br >Transaction is successfully Completed";
                Session::save();
                return redirect()->route('checkout.orderslip', $orderid);
            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                $update_product = DB::table('sslorders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Failed']);
                echo "validation Fail";
            }
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            echo "Transaction is successfully Completed";
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            echo "Invalid Transaction";
        }
        //  return redirect()->route('accounts');
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('sslorders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('sslorders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            echo "Transaction is Falied";
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('sslorders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('sslorders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            echo "Transaction is Cancel";
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }
    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('sslorders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($tran_id, $order_details->amount, $order_details->currency, $request->all());
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('sslorders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $update_product = DB::table('sslorders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Failed']);

                    echo "validation Fail";
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }



    //end ssl Commerz

    protected function  CardTransactionUpdate($token, $netotal, $newbalancecard, $invoiceid)
    {
        $charge = Stripe::charges()->create([
            'amount' => $netotal,
            'description' => 'Order',
            'currency' => 'USD',
            'source' => $token['id'],
        ]);

        $card = $token['card'];
        $CardPayment = new CardPayment();
        $CardPayment->inputdate =  date('Y-m-d');
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



    public function CustomerCode()
    {

        $customer = new customer();
        $lastcustomerID = $customer->orderBy('id', 'desc')->pluck('id')->first();
        $newcustomerID = $lastcustomerID + 1;
        $customerCode = '10' . $newcustomerID;
        return $customerCode;
    }


    public function orderSlip($id)
    {
        $pagetitle = "Invoice";
        $brands = Brand::all();
        $categories = Category::all();
        $order = Order::find($id);
        return view('frontend.checkout.orderSlip', compact('order', 'pagetitle', 'brands', 'brands','categories'));
    }

    public function orderpdf($id)
    {
        $invoice = Order::find($id);
        $title = "Order";
        $ordername = "Order #" . $invoice->invoice_no;
        $pdf = PDF::loadView('frontend.pdf.order', compact('invoice', 'title'));
        return $pdf->stream($ordername . '.pdf');
    }


    public function PlaceOrder()
    {
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $tableData = $cart->items;
        $rate = $cart->totalPrice;
        $customerInfo = Session::get('address');
        $customerid = $this->CustomerStoreOrUpdate($customerInfo);
        $vat = 0;
        $shipment = 0;
        $paymentInfo = "Cash";

        if ($customerid > 0) {
            $invnum = $this->InvoiceCode();
            $netotal = $rate;
            //   $paymentype = $request->paymenttype_id;
            $datareponse = "";
            $order = new Order();
            $order->invoice_no = $invnum;
            $order->inputdate = date('Y-m-d');
            $order->ref_no = "";
            $order->type_id = 1;
            $order->customer_id = $customerid;
            $order->amount = $rate;
            $order->discount = 0.00;
            $order->vat = $vat;
            $order->shipment = $shipment;
            $order->nettotal = $netotal;
            $order->payment_info = $paymentInfo;
            $order->status = 0;
            $order->user_id = Auth::id();
            $order->comment = 'Order';
            if ($order->save() == true) {
                $data =  $tableData;
                $this->OrderDetailsStore($data, $order->id, $customerid);
                // $this->CustomerDebit($request->discount, $netotal, $customerid, $order->id);
                User::find(Auth::id())->notify(new OrderNotification($order));
                //  event(new RealTimeMessage($order));
                Session::forget('cart');
                Session::forget('address');
                $datareponse = $order->id;
            } else {
                $datareponse = 0;
            }
        } else {
            $datareponse = 0;
        }
        ///   }

        // return $order->id;

        return redirect()->route('checkout.complete', $order->id);
        //  return response()->json($datareponse);
    }
    public function CustomerStoreOrUpdate($request)
    {
        // dd($request);
        $customer_id = 0;
        $customer = customer::where('user_id', auth::id())->first();
        if (!is_null($customer)) {
            //Shipping
            $customer->company = $request['shipping_company'];
            $customer->shipping_address = $request['shipping_address'];
            $customer->shipping_country = $request['shipping_country'];
            $customer->shipping_state = $request['shipping_state'];
            $customer->shipping_city = $request['shipping_city'];
            $customer->shipping_postalcode = $request['shipping_postalcode'];
            $customer->mobile_no = $request['shipping_phone'];
            //billing
            $customer->billing_name = $request['billing_name'];
            $customer->billing_address = $request['billing_address'];
            $customer->billing_country = $request['billing_country'];
            $customer->billing_state = $request['billing_state'];
            $customer->billing_city = $request['billing_city'];
            $customer->billing_postalcode = $request['billing_postalcode'];
            $customer->billing_phone = $request['billing_phone'];
            $customer->update();
            $customer_id = $customer->id;
        } else {
            $customerCode = $this->CustomerCode();
            $newcustomer = new customer();
            $newcustomer->name = $request['shipping_name'];
            $newcustomer->customerid = $customerCode;
            //shiiping
            $newcustomer->company = $request['shipping_company'];
            $newcustomer->shipping_address = $request['shipping_address'];
            $newcustomer->shipping_country = $request['shipping_country'];
            $newcustomer->shipping_state = $request['shipping_state'];
            $newcustomer->shipping_city = $request['shipping_city'];
            $newcustomer->shipping_postalcode = $request['shipping_postalcode'];
            $newcustomer->mobile_no = $request['shipping_phone'];
            //billing
            $newcustomer->billing_name = $request['billing_name'];
            $newcustomer->billing_address = $request['billing_address'];
            $newcustomer->billing_country = $request['billing_country'];
            $newcustomer->billing_state = $request['billing_state'];
            $newcustomer->billing_city = $request['billing_city'];
            $newcustomer->billing_postalcode = $request['billing_postalcode'];
            $newcustomer->billing_phone = $request['billing_phone'];
            //other Information
            $newcustomer->mobile_no = $request['shipping_phone'];
            $newcustomer->email = Auth::user()->email;
            $newcustomer->status = 1;
            $newcustomer->openingDate = date('Y-m-d');
            $newcustomer->user_id = Auth::id();
            $newcustomer->save();
            $customer_id = $newcustomer->id;
        }
        return $customer_id;
    }
    public function OrderComplete($id)
    {
        $categories = Category::all();
        $order = Order::find($id);
        return view('frontend.checkout.complete', compact('categories', 'order'));
    }
}
