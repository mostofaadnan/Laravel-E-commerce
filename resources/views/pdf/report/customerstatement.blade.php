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
                            <th>Customer</th>
                            <th>Description</th>
                            <th>Opening</th>
                            <th>Cash Invoice</th>
                            <th>Credit Invoice</th>
                            <th>Discount</th>
                            <th>Return</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($total = 0);
                        @foreach($data['details'] as $key =>$pd)
                        <tr>
                            <td width="5%" align="center">{{ $key+1 }}</td>
                            <td width="10%" align="center"><?php echo date('Y-m-d', strtotime($pd->created_at));  ?></td>
                            <td>{{ $pd->CustomerName->name }}</td>
                            <td width="15%">{{ $pd->remark }}</td>
                            <td width="10%" align="right">{{ $pd->openingBalance==0 ? '':$pd->openingBalance }}</td>
                            <td width="10%" align="right">{{ $pd->cashinvoice==0 ? '':$pd->cashinvoice }}</td>
                            <td width="10%" align="right">{{ $pd->creditinvoice==0 ? '':$pd->creditinvoice }}</td>
                            <td width="10%" align="right">{{ $pd->totaldiscount==0 ? '':$pd->totaldiscount }}</td>
                            <td width="10%" align="right">{{ $pd->salereturn==0?'' :$pd->salereturn }}</td>
                            <td width="10%" align="right">{{ $pd->payment==0?'':$pd->payment   }}</td>


                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <?php
                        $opening = $data['details']->sum('openingBalance');
                        $cashinvoice = $data['details']->sum('cashinvoice');
                        $creditinvoice = $data['details']->sum('creditinvoice');
                        $discount = $data['details']->sum('totaldiscount');
                        $returnamount = $data['details']->sum('salereturn');
                        $payment =  $data['details']->sum('payment');
                        $netConsignment = ($cashinvoice - $discount);
                        $balancedue = $netConsignment - $payment;
                        ?>
                        <tr>
                            <td colspan="4" align="right"><b>Net Total</b></td>
                            <td align="right"><b>{{ $data['details']->sum('openingBalance') }}</b></td>
                            <td align="right"><b>{{ $data['details']->sum('cashinvoice') }}</b></td>
                            <td align="right"><b>{{ $data['details']->sum('creditinvoice') }}</b></td>
                            <td align="right"><b>{{ $data['details']->sum('totaldiscount') }}</b></td>
                            <td align="right"><b>{{ $data['details']->sum('salereturn') }}</b></td>
                            <td align="right"><b>{{ $data['details']->sum('payment') }}</b></td>
                        </tr>
                        <tr>
                            <td colspan="9" align="right"><b>Balance Due</b></td>
                            <td align="right"><b>{{ $balancedue  }}</b></td>
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