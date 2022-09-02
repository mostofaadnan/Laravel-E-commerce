@extends('pdf.partials.reportmaster')
@section('content')
<div class="card">
    <div class="card-body">
        <table class="table Info-Table" style="width:100%" cellspacing="0">
            <tr>
                <td>
                    <h5>{{ $invoice->Customername->name }}</h5>
                    <address>
                        <i class="" id="customeraddress">{{ $invoice->CustomerName->address }},{{$invoice->CustomerName->cityname->name }} , {{ $invoice->CustomerName->statename->name }} </i><br>
                        <i class="" id="customercountry">{{ $invoice->CustomerName->countryname->name }}.</i><br>
                        @if(($invoice->CustomerName->mobile_no)!==null) <i id="mobile" class="fa fa-mobile " aria-hidden="true">Mobile:{{ $invoice->CustomerName->mobile_no }}</i><br>@endif
                        @if(($invoice->CustomerName->email)!==null)<i id="email" class="fa fa-envelope-o" aria-hidden="true">Email:{{ $invoice->CustomerName->email }}</i><br>@endif
                        @if(($invoice->CustomerName->website)!==null)<i id="website" class="fa fa-address-book-o" aria-hidden="true">Website:{{ $invoice->CustomerName->website }}</i>@endif
                    </address>
                </td>
                <td></td>
                <td>
                    <table class="table table-striped">

                        <tr>
                            <th align="right">Invoice No</th>
                            <td>#{{ $invoice->invoice_no }}</td>
                        </tr>
                        <tr>
                            <th align="right">Invoice Date</th>
                            <td>{{ $invoice->inputdate }}</td>
                        </tr>
                        <tr>
                            <th align="right">Payment Type</th>
                            <td>
                              {{ $invoice->paymenttype }}
                            </td>
                        </tr>
                        <tr>
                            <th align="right">Delivery Date</th>
                            <td>{{ $invoice->inputdate }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>


        <table class="table table-striped" style="width:100%" cellspacing="0">
            <thead>
                <tr>
                    <th width="7%">#sl</th>
                    <th>Description</th>
                    <th width="8%">Qty</th>
                    <th width="5%">Unit</th>
                    <th width="15%">Unit Price</th>
                    <th width="15%">Total</th>
                </tr>
            </thead>
            <tbody>

                @foreach($invoice->InvDetails as $key => $details)
                <tr>
                    <td> {{ $key+1 }}</td>
                    <td>{{ $details->productName->name }}</td>
                    <td align="right">{{ $details->qty }}</td>
                    <td>{{ $details->UnitName->Shortcut }}</td>
                    <td align="right">{{ $details->mrp }}</td>
                    <td align="right"> {{ $details->amount }} </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5" align="right"><b>Sub Total</b></th>
                    <td align="right"><b>{{ $invoice->amount }}</b></td>
                </tr>
               
                <tr>
                    <td colspan="5" align="right"><b>Vat</b></th>
                    <td align="right"><b>{{ $invoice->vat }}</b></td>
                </tr>
                <tr>
                    <td colspan="5" align="right"><b>Shipment Charge</b></th>
                    <td align="right"><b>{{ $invoice->shipment }}</b></td>
                </tr>
                <tr>
                    <td colspan="5" align="right"><b>Net Total</b></th>
                    <td align="right"><b> {{ $invoice->nettotal }}</b></td>
                </tr>
            </tbody>
        </table>
    </div>
    @endsection