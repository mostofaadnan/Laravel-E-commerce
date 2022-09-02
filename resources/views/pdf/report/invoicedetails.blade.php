@extends('pdf.partials.reportmaster')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 ">
                <table width="100%">
                    <tr>
                        <td width="70%"></td>
                        <td>
                            <table class="table table-striped">
                                <tr>
                                    <th align="right">Customer:</th>
                                    <td>{{ $data['customer'] }}</td>
                                </tr>
                                <tr>
                                    <th align="right">From:</th>
                                    <td>{{ $data['fromdate'] }}</td>
                                </tr>
                                <tr>
                                    <th align="right">To:</th>
                                    <td>
                                        {{ $data['todate'] }}
                                    </td>
                                </tr>
                            </table>
                        </td>

                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped" style="width:100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Date</th>
                            <th>Invoice No</th>
                            <th>Customer</th>
                            <th>Item</th>
                            <th>MRP</th>
                            <th>Qty</th>
                            <th>Amount</th>
                            <th>Discount</th>
                            <th>Vat</th>
                            <th>Net total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($total = 0);
                        @foreach($data['details'] as $key =>$pd)
                        <tr>
                            <td width="5%" align="center">{{ $key+1 }}</td>
                            <td width="10%" align="center">{{ $pd->invoicename->inputdate }}</td>
                            <td width="10%" align="center">{{ $pd->invoicename->invoice_no }}</td>
                            <td>{{ $pd->invoicename->customerName->name }}</td>
                            <td>{{ $pd->productName->name }}</td>
                            <td width="5%" align="right">{{ $pd->mrp }}</td>
                            <td width="5%" align="right">{{ $pd->qty }}</td>
                            <td width="10%" align="right">{{ $pd->amount }}</td>
                            <td width="7%" align="right">{{ $pd->discount }}</td>
                            <td width="5%" align="right">{{ $pd->vat }}</td>
                            <td width="10%" align="right">{{ $pd->nettotal }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" align="right"><b>Net Total</b></td>
                            <td align="right"><b>{{ $data['details']->sum('amount') }}</b></td>
                            <td align="right"><b>{{ $data['details']->sum('discount') }}</b></td>
                            <td align="right"><b>{{ $data['details']->sum('vat') }}</b></td>
                            <td align="right"><b>{{ $data['details']->sum('nettotal') }}</b></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="col-sm-12">
            <table class="footer-table" style="margin-top: 60px;" width="100%">
                <tr>
                    <td width="20%">
                        <hr style="border:1px solid #ccc">
                        <p align="center">Prepaid By</p>
                    </td>
                    <td width="60%">
                    </td>
                    <td width="20%">
                        <hr style="border:1px solid #ccc">
                        <p align="center">Director Sign</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection