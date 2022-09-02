@extends('pdf.partials.reportmaster')
@section('content')
<div class="card">
    <div class="card-body">
        <table class="table Info-Table" style="width:100%" cellspacing="0">
            <tr>
                <td width="50%"> </td>
                <td width="50%">
                    <table class="table table-striped" style="width:100%" cellspacing="0">

                        <tr>
                            <th>Date</th>
                            <td>{{ $wastage->inputdate }}</td>
                        </tr>
                        <tr>
                            <th>Remark</th>
                            <td>{{ $wastage->remark }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="table table-striped" style="width:100%" cellspacing="0">
            <thead>
                <tr>
                    <th align="center" width="7%">#sl</th>
                    <th>Description</th>
                    <th width="8%">Qty</th>
                    <th width="5%">Unit</th>
                    <th width="15%">Unit Price</th>
                    <th width="15%">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($wastage->WDatils as $key => $details)
                <tr>
                    <td align="center"> {{ $key+1 }}</td>
                    <td>{{ $details->productName->name }}</td>
                    <td align="right">{{ $details->qty }}</td>
                    <td>{{ $details->productName->UnitName->Shortcut }}</td>
                    <td align="right">{{ $details->tp }}</td>
                    <td align="right"> {{ $details->amount }} </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5" align="right"><b>Net Total</b></td>
                    <td align="right"><b>{{ $wastage->nettotal }}</b></td>
                </tr>
            </tbody>
        </table>
        <table class="footer-table" style="margin-top: 80px;" width="100%">
            <tr>
                <td class="border-top">
                    <p align="center">Prepaid By</p>
                </td>
                <td width="40%"></td>
                <td class="border-top">
                    <p align="center">Director Sighn</p>
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection