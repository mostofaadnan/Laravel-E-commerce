<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VatCollection;
use App\Models\Invoice;
use App\Models\VatPayment;
use App\Models\CashDrawer;
use App\Models\Bank;
use DataTables;
use PDF;


class VatCollectionContrller extends Controller
{
    function __construct()
    {
        $this->middleware('permission:vat-list|vat-create|vat-edit|vat-delete', ['only' => ['index', 'show', 'Vatpayment']]);
        $this->middleware('permission:vat-create', ['only' => ['create', 'store', 'paymentcreate', 'storepayment']]);
        $this->middleware('permission:vat-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:vat-delete', ['only' => ['Delete', 'VatPaymentDelete']]);
    }
    public function index()
    {
        return view('vatCollection.index');
    }
    public function LoadAll()
    {

        $VatCollection = VatCollection::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($VatCollection)
            ->addIndexColumn()

            ->addColumn('inputdate', function (VatCollection $VatCollection) {
                return date('m/d/Y', strtotime($VatCollection->created_at));
            })
            ->addColumn('user', function (VatCollection $VatCollection) {
                return $VatCollection->username ? $VatCollection->username->name : 'Deleted User';
            })
            ->addColumn('action', function ($VatCollection) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $VatCollection->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                if ($VatCollection->payment == 0) {
                    $button .= '<a class="dropdown-item" id="makepayment" data-id="' . $VatCollection->id . '">Make Payment</a>';
                    $button .= '<div class="dropdown-divider"></div>';
                    $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $VatCollection->id . '">Delete</a>';
                    $button .= '<div class="dropdown-divider"></div>';
                } else {
                    $button .= '<a class="dropdown-item" id="paymentview" data-id="' . $VatCollection->id . '">Payment View</a>';
                    $button .= '<div class="dropdown-divider"></div>';
                }
                $button .= '<a class="dropdown-item" id="print" data-id="' . $VatCollection->id . '">Print</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="pdfdata" data-id="' . $VatCollection->id . '">Pdf</a>';
                $button .= '</div></div>';
                return $button;
            })

            ->make(true);
    }
    public function create()
    {
        return view('vatCollection.create');
    }

    public function CollectionNo()
    {
        $VatCollection = new VatCollection();
        $lastvatid = $VatCollection->pluck('id')->last();
        $newvatcollectionno = $lastvatid + 1;
        return response()->json('VTC-' . '1000' . $newvatcollectionno);
    }
    public function GetData(Request $request)
    {
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $invoice = Invoice::select('id', 'invoice_no', 'inputdate', 'amount', 'discount', 'vat', 'nettotal')
            ->whereBetween('inputdate', array($fromdate, $todate))
            ->where('cancel', 0)
            ->where('vatcol', '==', 0)
            ->get();
        return response()->json($invoice);
    }
    public function Store(Request $request)
    {

        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $VatCollection = new VatCollection();
        $VatCollection->collection_no = $request->vatcollectiono;
        $VatCollection->fromdate = $fromdate;
        $VatCollection->todate =  $todate;
        $VatCollection->remark = $request->remark;
        $VatCollection->amount = $request->amount;
        $VatCollection->user_id = Auth::id();
        if ($VatCollection->save() == true) {
            $vatcol = 1;
            $tableData = $request->itemtables;
            foreach ($tableData as $items) {
                $invoiceid = $items['id'];
                $invoice = invoice::select('id', 'vatcollection_id', 'vatcol')
                    ->where('id', $invoiceid)
                    ->get();
                //invoice Update
                if (!is_null($invoice)) {
                    $dataupdate = invoice::where(
                        ['id' => $invoiceid]
                    )
                        ->update(
                            [
                                'vatcol' => $vatcol,
                                'vatcollection_id' => $VatCollection->id,
                            ]
                        );
                }
            }
        }
        return response()->json($VatCollection->id);
    }
    public function vatcodeDatalistall(Request $request)
    {
        if ($request->ajax()) {
            $VatCollectionno = VatCollection::select('id', 'collection_no', 'amount')
                ->get();
            return view('datalist.vatcodedatalist', compact('VatCollectionno'))->render();
        }
    }

    public function show($id)
    {
        $this->setVatcollectionId($id);
        return view('vatCollection.view');
    }
    public function setVatcollectionId($id)
    {
        Session::put('vtacollectionid', $id);
    }
    public function getView()
    {
        $id = Session::get('vtacollectionid');
        $VatCollection = VatCollection::with('InvDetails')->find($id);
        return response()->json($VatCollection);
    }
    public function Delete($id)
    {
        $VatCollection = VatCollection::find($id);
        $payment = $VatCollection->payment;
        $invoice = Invoice::select('id', 'vatcollection_id', 'vatcol')
            ->where('vatcollection_id', $VatCollection->id)
            ->get();
        //invoice Update
        if (!is_null($VatCollection) || $payment == 0) {
            if (!is_null($invoice)) {
                $vatcol = 0;
                Invoice::where(
                    ['vatcollection_id' => $VatCollection->id]
                )
                    ->update(
                        [
                            'vatcol' => $vatcol,
                            'vatcollection_id' => 0,
                        ]
                    );
            }
            $VatCollection->delete();
        }
    }

    public function pdf($id)
    {
        $title = "Vat Collection";
        $VatCollection = VatCollection::find($id);
        $pdf = PDF::loadView('pdf.vatcollection', compact('VatCollection', 'title'));
        return $pdf->stream('vatcollection.pdf');
    }
    public function LoadPrintslip($id)
    {
        $title = "Vat Collection";
        $VatCollection = VatCollection::find($id);
        return view('pdf.vatcollection', compact('VatCollection', 'title'));
    }
    //Vat Paymet
    public function Vatpayment()
    {
        return view('vatCollection.vatpayment');
    }
    public function VatpaymentLoad()
    {
        $VatPayment = VatPayment::orderBy('id', 'desc')
            ->latest()
            ->get();
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
            ->addColumn('user', function (VatPayment $VatPayment) {
               
                return $VatPayment->username ? $VatPayment->username->name : 'Deleted User';
           
            })
            ->addColumn('action', function ($VatPayment) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $VatPayment->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $VatPayment->id . '">Delete</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="print" data-id="' . $VatPayment->id . '">Print</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="pdfdata" data-id="' . $VatPayment->id . '">Pdf</a>';
                $button .= '</div></div>';
                return $button;
            })

            ->make(true);
    }
    public function paymentcreate()
    {
        return view('vatCollection.vatpaymentcreate');
    }
    public function vatcodeDatalist(Request $request)
    {
        if ($request->ajax()) {
            $VatCollectionno = VatCollection::select('id', 'collection_no', 'amount')
                ->where('payment', 0)
                ->get();
            return view('datalist.vatcodedatalist', compact('VatCollectionno'))->render();
        }
    }

    public function vatPaymentNo()
    {
        $VatPayment = new VatPayment();
        $lastVatPayment = $VatPayment->pluck('id')->last();
        $VatPaymentCode = $lastVatPayment + 1;
        return response()->json('VTP-100' . $VatPaymentCode);
    }

    public function storepayment(Request $request)
    {
        $respnse = "";
        $amount = $request->amount;
        $paymentype = $request->paymenttype;
        $VatPayment = new VatPayment();
        $VatPayment->vat_id = $request->vatid;
        $VatPayment->vat_payment_no = $request->paymentno;
        $VatPayment->inputdate = $request->inputdate;
        $VatPayment->amount = $amount;
        $VatPayment->payment_type =  $paymentype;
        $VatPayment->paymentdescription = $request->paymentdescription;
        $VatPayment->remark = $request->remark;
        $VatPayment->user_id = Auth::id();
        if ($VatPayment->save()) {

            //balance update
            $cashin = CashDrawer::sum('cashin');
            $cashout = CashDrawer::sum('cashout');
            $balance = $cashin - $cashout;
            $newbalance = $balance - $amount;

            $cashinbank = Bank::sum('cashin');
            $cashoutbank = Bank::sum('cashout');
            $balancebank = $cashinbank - $cashoutbank;
            $newbalancebank =  $balancebank - $amount;

            if ($paymentype == 1) {
                $this->CashDrawerUpdate($request->inputdate, $amount, $newbalance, $VatPayment->id);
            } else {
                $this->BankTransactionUpdate($request->inputdate, $amount, $newbalancebank, $VatPayment->id, $request->bankname, $request->accno, $request->bankdescrip);
            }
            $VatCollection = VatCollection::select('id', 'payment')
                ->where('id', $request->vatid)
                ->first();
            //invoice Update
            if (!is_null($VatCollection)) {

                VatCollection::where(
                    ['id' => $request->vatid]
                )
                    ->update(
                        [
                            'payment' => 1,
                        ]
                    );
            }
            $respnse = $VatPayment->id;
        } else {

            $respnse = 0;
        }
        return response()->json($respnse);
    }
    public function CashDrawerUpdate($openingdate, $netotal, $newbalance, $invoiceid)
    {
        $Drware = new CashDrawer();
        $Drware->inputdate = $openingdate;
        $Drware->cashin = 0;
        $Drware->cashout = $netotal;
        $Drware->balance = $newbalance;
        $Drware->payment_id = $invoiceid;
        $Drware->type = "Vat Payment";
        $Drware->type_id = 6;
        $Drware->user_id = Auth::id();
        $Drware->save();
    }
    public function BankTransactionUpdate($openingdate, $netotal, $newbalance, $invoiceid, $bankname, $accno, $bankdescr)
    {
        $Drware = new Bank();
        $Drware->inputdate = $openingdate;
        $Drware->cashin = 0;
        $Drware->cashout = $netotal;
        $Drware->balance = $newbalance;
        $Drware->payment_id = $invoiceid;
        $Drware->type = "vat Payment";
        $Drware->type_id = 6;
        $Drware->bank = $bankname;
        $Drware->accno = $accno;
        $Drware->description = $bankdescr;
        $Drware->user_id = Auth::id();
        $Drware->save();
    }
    public function vatPaymentCodatalist(Request $request)
    {
        if ($request->ajax()) {
            $VatPayment = VatPayment::select('id', 'vat_payment_no')
                ->get();
            return view('datalist.vatpaymentdatalist', compact('VatPayment'))->render();
        }
    }

    public function paymentshow($id)
    {
        $this->SetPaymentId($id);
        return view('vatCollection.vatpaymentshow');
    }

    public function getPaymentView()
    {
        $id = Session::get('vatpaymentid');
        $VatPayment = VatPayment::with('Vat_Collection')->find($id);
        return response()->json($VatPayment);
    }

    public function SetPaymentId($id)
    {
        Session::put('vatpaymentid', $id);
    }

    public function vatPaymentPdf($id)
    {
        $title = "Vat Payment";
        $VatPayment = VatPayment::find($id);
        $pdf = PDF::loadView('pdf.vatpayment', compact('VatPayment', 'title'));
        return $pdf->stream('VatPayment.pdf');
    }
    public function LoadPrintslipvatPyment($id)
    {
        $title = "Vat Payment";
        $VatPayment = VatPayment::find($id);
        return view('pdf.vatpayment', compact('VatPayment', 'title'));
    }
    public function VatPaymentDelete($id)
    {
        $VatPayment = VatPayment::find($id);

        if (!is_null($VatPayment)) {
            $payment = $VatPayment->payment_type;
            if ($payment == 1) {
                //Cash Drwer Delete
                $Drware = CashDrawer::where('type_id', 6)
                    ->where('type', 'Vat Payment')
                    ->where('payment_id', $VatPayment->id)
                    ->first();
                $Drware->delete();
            } else {
                //Bank Transection
                $Bank = Bank::where('type_id', 6)
                    ->where('type', 'Vat Payment')
                    ->where('payment_id', $VatPayment->id)
                    ->first();
                $Bank->delete();
            }
            $VatCollection = VatCollection::select('id', 'payment')
                ->where('id', $VatPayment->vat_id)
                ->first();
            //invoice Update
            if (!is_null($VatCollection)) {

                VatCollection::where(
                    ['id' =>  $VatPayment->vat_id]
                )
                    ->update(
                        [
                            'payment' => 0,
                        ]
                    );
            }
            $VatPayment->delete();
        }
    }
}
