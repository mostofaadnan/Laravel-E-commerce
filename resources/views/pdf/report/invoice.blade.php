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
                                    <td><?php if ($data['type'] == 1) {
                                            echo 'Cash Invoice';
                                        } elseif ($data['type'] == 2) {
                                            echo 'Credit Invoice';
                                        } else {
                                            echo 'All';
                                        } ?></td>
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
                            <th>Type</th>
                            <th>Invoice No</th>
                            <th>Customer</th>
                            <th>Payment</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($total = 0);
                        @foreach($data['details'] as $key =>$pd)
                        <tr>
                            <?php
                            switch ($pd->paymenttype_id) {
                                case 1:
                                    $payment = 'Cash';
                                    break;
                                case 2:
                                    $payment = 'Bank';
                                    break;
                                case 3:
                                    $payment = 'Card';
                                    break;
                                case 4:
                                    $payment = 'Paypal';
                                    break;
                                default:
                                    $payment = 'Credit';
                                    break;
                            }
                            ?>
                            <td width="6%" align="center">{{ $key+1 }}</td>
                            <td width="15%" lign="center">{{ $pd->inputdate }}</td>
                            <td width="15%" lign="center">{{ $pd->type_id==1?'Cash Invoice':'Credit Invoice' }}</td>
                            <td width="15%">{{ $pd->invoice_no }}</td>
                            <td>{{ $pd->CustomerName->name }}</td>
                            <td width="12%">{{ $payment }}</td>
                            <td align="right" width="12%">{{ $pd->nettotal  }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" align="right"><b>Net Total</b></td>
                            <td align="right"><b>{{ $data['details']->sum('nettotal') }}</b></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="col-sm-12">
            <table class="footer-table" style="margin-top: 80px;" width="100%">
                <tr>
                    <td width="20%" class="border-top">
                        <p align="center"><i>Prepaid By</i></p>
                        <p align="center">({{ Auth::user()->name }})</p>
                    </td>
                    <td width="60%">
                    </td>
                    <td width="20%" class="border-top">
                        <p align="center">Director Sign</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection