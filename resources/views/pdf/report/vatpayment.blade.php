@extends('pdf.partials.reportmaster')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 ">
                <table width="100%">
                    <tr>
                        <td width="55%"></td>
                        <td>
                            <table class="table table-striped">
                                <tr>
                                    <th align="right">Type</th>
                                    <td>{{ $data['type'] }}</td>
                                </tr>
                                <tr>
                                    <th align="right">From</th>
                                    <td>{{ $data['fromdate'] }}</td>
                                </tr>
                                <tr>
                                    <th align="right">To</th>
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
                            <th>Vat No</th>
                            <th>payment No</th>
                            <th>Payment</th>
                            <th>Description</th>
                            <th>Amount</th>


                        </tr>
                    </thead>
                    <tbody>
                        @php($total = 0);
                        @foreach($data['details'] as $key =>$pd)
                        <tr>
                            <td align="center" width="10%">{{ $key+1 }}</td>
                            <td align="center" width="10%">{{ $pd->inputdate}}</td>
                            <td width="15%">{{ $pd['vatno'] }}</td>
                            <td width="15%">{{ $pd->vat_payment_no }}</td>
                            <td width="10%">{{ $pd->Vat_Collection->collection_no  }}</td>
                            <td>{{ $pd->remark  }}</td>
                            <td align="right">{{ $pd->amount  }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" align="right"><b>Net Total</b></td>
                            <td align="right"><b>{{ $data['details']->sum('amount') }}</b></td>

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