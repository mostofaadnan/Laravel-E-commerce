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
                                    <th align="right">Supplier</th>
                                    <td>{{ $data['supplier'] }}</td>
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
                            <th>Payment No</th>
                            <th>Supplier</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Balance Due</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($total = 0);
                        @foreach($data['details'] as $key =>$pd)
                        <tr>
                            <td width="5%" align="center">{{ $key+1 }}</td>
                            <td width="10%" lign="center">{{ $pd->inputdate }}</td>
                            <td width="15%">{{ $pd->payment_no }}</td>
                            <td>{{ $pd->SupplierName->name }}</td>
                            <td align="right" width="14%">{{ $pd->amount  }}</td>
                            <td align="right" width="14%">{{ $pd->payment  }}</td>
                            <td align="right" width="14%">{{ $pd->balancedue }}</td>
                            <td align="right" width="8%">{{ $pd->payment_id==1?'Cash':'Bank'  }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" align="right"><b>Net Total</b></td>
                            <td align="right"><b>{{ $data['details']->sum('amount') }}</b></td>
                            <td align="right"><b>{{ $data['details']->sum('payment') }}</b></td>
                            <td align="right"><b>{{ $data['details']->sum('balancedue') }}</b></td>
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