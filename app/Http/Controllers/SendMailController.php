<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\purchase;
use App\Models\PurchaseRecieved;
use App\Models\SupplierDebt;
use App\Models\SaleReturn;
use App\Models\PurchaseReturn;
use App\Models\SupplierPayment;
use App\Models\CustomerPaymentRecieve;
use App\Models\CustomerDebts;
use JWTException;
use Mail;
use PDF;

class SendMailController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:mail-list', ['only' => [
            'Index',
            'DocumentSend',
            'InvoiceSend',
            'CreditInvoiceSend',
            'PurchaseSend',
            'GrnSend',
            'SaleReturnSend',
            'PurchaseReturnSend',
            'SuppliaerPaymentSend',
            'CustomerPaymentSend',
            'SupplierStatement',
            'CustomerStatement',
        ]]);
    }

    public function Index()
    {
        return view('mails.index');
    }

    public function DocumentSend(Request $request)
    {
        $data["email"] = $request->email;
        $data["client_name"] = $request->client_name;
        $data["subject"] = $request->subject;
        $data["message"] = $request->message;
        $files = $request->file('files');
        /* dd($file); */
        try {
            Mail::send('mails.mail', compact('data'), function ($message) use ($data, $files) {
                $message->to($data["email"], $data["client_name"])
                    ->subject($data["subject"]);
                foreach ($files as $file) {
                    $message->attach($file->getRealPath(), array(
                        'as' => $file->getClientOriginalName(), // If you want you can chnage original name to custom name      
                        'mime' => $file->getMimeType()
                    ));
                }
            });
        } catch (JWTException $exception) {
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {

            Session()->flash('success', 'Error sending mail');
        } else {

            Session()->flash('success', 'Message sent Succesfully');
        }

        return redirect()->Route('sendmails');
    }


    public function InvoiceSend(Request $request)
    {
        $data["email"] = $request->email;
        $data["client_name"] = $request->client_name;
        $data["subject"] = $request->subject;
        $data["message"] = $request->message;
        $title = "Cash Invoice";
        $invoice = Invoice::find($request->invoiceid);
        $pdf = PDF::loadView('pdf.invoice', compact('invoice', 'title'));
        /*   $pdf = PDF::loadView('mails.mail', $data); */

        try {
            Mail::send('mails.mail', compact('data'), function ($message) use ($data, $pdf) {
                $message->to($data["email"], $data["client_name"])
                    ->subject($data["subject"])
                    ->attachData($pdf->output(), "invoice.pdf");
            });
        } catch (JWTException $exception) {
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
            /*   $this->statusdesc  =   "Error sending mail";
            $this->statuscode  =   "0"; */
            Session()->flash('success', 'Error sending mail');
        } else {

            /* $this->statusdesc  =   "Message sent Succesfully";
            $this->statuscode  =   "1"; */
            Session()->flash('success', 'Message sent Succesfully');
        }

        return redirect()->Route('invoice.show', $request->invoiceid);
    }
    public function CreditInvoiceSend(Request $request)
    {
        $data["email"] = $request->email;
        $data["client_name"] = $request->client_name;
        $data["subject"] = $request->subject;
        $data["message"] = $request->message;
        $title = "Cash Invoice";
        $invoice = Invoice::find($request->invoiceid);
        $pdf = PDF::loadView('pdf.creditinvoice', compact('invoice', 'title'));
        /*   $pdf = PDF::loadView('mails.mail', $data); */

        try {
            Mail::send('mails.mail', compact('data'), function ($message) use ($data, $pdf) {
                $message->to($data["email"], $data["client_name"])
                    ->subject($data["subject"])
                    ->attachData($pdf->output(), "invoice.pdf");
            });
        } catch (JWTException $exception) {
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
            /*   $this->statusdesc  =   "Error sending mail";
            $this->statuscode  =   "0"; */
            Session()->flash('success', 'Error sending mail');
        } else {

            /* $this->statusdesc  =   "Message sent Succesfully";
            $this->statuscode  =   "1"; */
            Session()->flash('success', 'Message sent Succesfully');
        }

        return redirect()->Route('creditinvoice.show', $request->invoiceid);
    }

    public function PurchaseSend(Request $request)
    {
        $data["email"] = $request->email;
        $data["client_name"] = $request->client_name;
        $data["subject"] = $request->subject;
        $data["message"] = $request->message;
        $purchase = purchase::find($request->purchaseid);
        $title = "Purchase Order";
        $pdf = PDF::loadView('pdf.purchase', compact('purchase', 'title'));
        try {
            Mail::send('mails.mail', compact('data'), function ($message) use ($data, $pdf) {
                $message->to($data["email"], $data["client_name"])
                    ->subject($data["subject"])
                    ->attachData($pdf->output(), "purchase.pdf");
            });
        } catch (JWTException $exception) {
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {

            Session()->flash('success', 'Error sending mail');
        } else {
            Session()->flash('success', 'Message sent Succesfully');
        }

        return redirect()->Route('purchase.show', $request->purchaseid);
    }
    public function GrnSend(Request $request)
    {
        $data["email"] = $request->email;
        $data["client_name"] = $request->client_name;
        $data["subject"] = $request->subject;
        $data["message"] = $request->message;

        $precieve = PurchaseRecieved::find($request->grnid);
        $supplierDebd = SupplierDebt::where('supplier_id', $precieve->purchaseDetails->supplier_id)
            ->get();
        $consignment = $supplierDebd->sum('consignment');
        $discount = $supplierDebd->sum('totaldiscount');
        $netConsignment = ($consignment - $discount);
        $payments = $supplierDebd->sum('payment');
        $balancedue = $netConsignment - $payments;
        $title = "Goods Recieved Note(GRN)";
        $pdf = PDF::loadView('pdf.purchaseRecived', compact('precieve', 'consignment', 'discount', 'payments', 'balancedue', 'title'));
        try {
            Mail::send('mails.mail', compact('data'), function ($message) use ($data, $pdf) {
                $message->to($data["email"], $data["client_name"])
                    ->subject($data["subject"])
                    ->attachData($pdf->output(), "purchase.pdf");
            });
        } catch (JWTException $exception) {
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
            Session()->flash('success', 'Error sending mail');
        } else {
            Session()->flash('success', 'Message sent Succesfully');
        }

        return redirect()->Route('precieve.show', $request->grnid);
    }
    public function SaleReturnSend(Request $request)
    {
        $data["email"] = $request->email;
        $data["client_name"] = $request->client_name;
        $data["subject"] = $request->subject;
        $data["message"] = $request->message;

        $title = "Sale Return";
        $SaleReturn = SaleReturn::find($request->returnid);
        $pdf = PDF::loadView('pdf.salereturn', compact('SaleReturn', 'title'));
        try {
            Mail::send('mails.mail', compact('data'), function ($message) use ($data, $pdf) {
                $message->to($data["email"], $data["client_name"])
                    ->subject($data["subject"])
                    ->attachData($pdf->output(), "purchase.pdf");
            });
        } catch (JWTException $exception) {
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
            Session()->flash('success', 'Error sending mail');
        } else {
            Session()->flash('success', 'Message sent Succesfully');
        }
        return redirect()->Route('salereturn.show', $request->returnid);
    }
    public function PurchaseReturnSend(Request $request)
    {
        $data["email"] = $request->email;
        $data["client_name"] = $request->client_name;
        $data["subject"] = $request->subject;
        $data["message"] = $request->message;
        $PurchaseReturn = PurchaseReturn::find($request->purchasereturnno);
        $title = "Purchase Return";
        $pdf = PDF::loadView('pdf.purchasereturn', compact('PurchaseReturn', 'title'));
        try {
            Mail::send('mails.mail', compact('data'), function ($message) use ($data, $pdf) {
                $message->to($data["email"], $data["client_name"])
                    ->subject($data["subject"])
                    ->attachData($pdf->output(), "Purcashereturn.pdf");
            });
        } catch (JWTException $exception) {
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
            Session()->flash('success', 'Error sending mail');
        } else {
            Session()->flash('success', 'Message sent Succesfully');
        }

        return redirect()->Route('purchasereturn.show', $request->purchasereturnno);
    }
    public function SuppliaerPaymentSend(Request $request)
    {
        $data["email"] = $request->email;
        $data["client_name"] = $request->client_name;
        $data["subject"] = $request->subject;
        $data["message"] = $request->message;
        $title = "Supplier Payment";
        $supplierpayment = SupplierPayment::find($request->paymentid);
        $supplierDebd = SupplierDebt::where('supplier_id', $supplierpayment->supplier_id)
            ->get();
        $consignment = $supplierDebd->sum('consignment');
        $discount = $supplierDebd->sum('totaldiscount');
        $netConsignment = ($consignment - $discount);
        $payments = $supplierDebd->sum('payment');
        $balancedue = $netConsignment - $payments;
        $pdf = PDF::loadView('pdf.supplierpayment', compact('supplierpayment', 'consignment', 'discount', 'payments', 'balancedue', 'title'));
        try {
            Mail::send('mails.mail', compact('data'), function ($message) use ($data, $pdf) {
                $message->to($data["email"], $data["client_name"])
                    ->subject($data["subject"])
                    ->attachData($pdf->output(), "supplierpayment.pdf");
            });
        } catch (JWTException $exception) {
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
            Session()->flash('success', 'Error sending mail');
        } else {
            Session()->flash('success', 'Message sent Succesfully');
        }

        return redirect()->Route('supplierpayment.show', $request->paymentid);
    }
    public function CustomerPaymentSend(Request $request)
    {
        $data["email"] = $request->email;
        $data["client_name"] = $request->client_name;
        $data["subject"] = $request->subject;
        $data["message"] = $request->message;
        $title = "Credit Payment";
        $customerpayment = CustomerPaymentRecieve::find($request->paymentid);
        $pdf = PDF::loadView('pdf.customerpayment', compact('customerpayment', 'title'));
        try {
            Mail::send('mails.mail', compact('data'), function ($message) use ($data, $pdf) {
                $message->to($data["email"], $data["client_name"])
                    ->subject($data["subject"])
                    ->attachData($pdf->output(), "supplierpayment.pdf");
            });
        } catch (JWTException $exception) {
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
            Session()->flash('success', 'Error sending mail');
        } else {
            Session()->flash('success', 'Message sent Succesfully');
        }

        return redirect()->Route('customerpayment.show', $request->paymentid);
    }

    public function SupplierStatement(Request $request)
    {
        $data["email"] = $request->email;
        $data["client_name"] = $request->client_name;
        $data["subject"] = $request->subject;
        $data["message"] = $request->message;
        $title = "Supplier Statement";
        $supplierid = $request->supplierid;
        $fromdate = $request->from;
        $todate = $request->to;
        $data['supplier'] = $request->suppliername;
        $data['fromdate'] = $fromdate;
        $data['todate'] = $todate;

        $data['details'] = SupplierDebt::orderBy('id', 'desc')
            ->where('supplier_id',   $supplierid)
            ->WhereBetween('created_at', array($fromdate, $todate))
            ->get();
        $pdf = PDF::loadView('pdf.report.supplierstatement', compact('data', 'title'))->setPaper('a4', 'landscape');
        try {
            Mail::send('mails.mail', compact('data'), function ($message) use ($data, $pdf) {
                $message->to($data["email"], $data["client_name"])
                    ->subject($data["subject"])
                    ->attachData($pdf->output(), "SupplierStatement.pdf");
            });
        } catch (JWTException $exception) {
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
            Session()->flash('success', 'Error sending mail');
        } else {
            Session()->flash('success', 'Message sent Succesfully');
        }

        return redirect()->Route('supplier.statement');
    }
    public function CustomerStatement(Request $request)
    {
        $data["email"] = $request->email;
        $data["client_name"] = $request->client_name;
        $data["subject"] = $request->subject;
        $data["message"] = $request->message;
        $title = "Supplier Statement";
        $customerid = $request->customerid;
        $fromdate = $request->from;
        $todate = $request->to;
        $data['customer'] = $request->customername;
        $data['fromdate'] = $fromdate;
        $data['todate'] = $todate;

        $data['details'] = CustomerDebts::orderBy('id', 'desc')
            ->where('customer_id', $customerid)
            ->WhereBetween('created_at', array($fromdate, $todate))
            ->get();
        $pdf = PDF::loadView('pdf.report.customerstatement', compact('data', 'title'))->setPaper('a4', 'landscape');
        try {
            Mail::send('mails.mail', compact('data'), function ($message) use ($data, $pdf) {
                $message->to($data["email"], $data["client_name"])
                    ->subject($data["subject"])
                    ->attachData($pdf->output(), "CustomerStatement.pdf");
            });
        } catch (JWTException $exception) {
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
            Session()->flash('success', 'Error sending mail');
        } else {
            Session()->flash('success', 'Message sent Succesfully');
        }

        return redirect()->Route('customer.statement');
    }
}
