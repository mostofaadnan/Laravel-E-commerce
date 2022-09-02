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
                            <th>From</th>
                            <th>To</th>
                            <th>Amount</th>
                            <th>Status</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach($data['details'] as $key =>$pd)
                        <tr>
                            <td align="center">{{ $key+1 }}</td>
                            <td align="center"><?php echo date('Y-m-d', strtotime($pd->created_at));  ?></td>
                            <td>{{ $pd->collection_no }}</td>
                            <td>{{ $pd->fromdate }}</td>
                            <td>{{ $pd->todate  }}</td>
                            <td align="right">{{ $pd->amount  }}</td>
                            <td>{{ $pd->payment==1?'Paid':'Due'  }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" align="right"><b>Net Total</b></td>
                            <td align="right"><b>{{ $data['details']->sum('amount') }}</b></td>
                            <td></td>
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