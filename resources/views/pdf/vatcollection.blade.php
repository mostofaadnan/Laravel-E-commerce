@extends('pdf.partials.reportmaster')
@section('content')
<div class="card">
    <div class="card-body">
        <table class="table Info-Table" style="width:100%" cellspacing="0">
            <tr>
                <td width="50%"></td>
                <td>
                    <table class="table table-striped" style="width:100%" cellspacing="0">
                        <tr>
                            <th align="right">Vat No:</th>
                            <td>{{ $VatCollection->collection_no }}</td>
                        </tr>
                        <tr>
                            <th align="right">From:</th>
                            <td>{{ $VatCollection->fromdate }}</td>
                        </tr>
                        <tr>
                            <th align="right">To:</th>
                            <td>{{ $VatCollection->todate }}</td>
                        </tr>
                        <tr>
                            <th align="right">Remark:</th>
                            <td>{{ $VatCollection->remark }}</td>
                        </tr>
                        <tr>
                            <th align="right">Status</th>
                            <td><?php echo $VatCollection->payment == 1 ? 'Paid' : 'Due' ?></td>
                        </tr>
                    </table>
                </td>

            </tr>
        </table>
        <table class="table table-striped" style="width:100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Sl</th>
                    <th>Invoice Date</th>
                    <th>Invoice No</th>
                    <th>Vat</th>
                </tr>
            </thead>
            <tbody>

                @foreach($VatCollection->InvDetails as $key =>$vd)
                <tr>
                    <td align="center">{{ $key+1 }}</td>
                    <td>{{ $vd->invoice_no}}</td>
                    <td>{{ $vd->inputdate }}</td>
                    <td align="right">{{ $vd->vat}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" align="right"><b>Net Total</b></td>
                    <td align="right"><b>{{ $VatCollection->amount }}</b></td>

                </tr>
            </tfoot>
        </table>

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
@endsection