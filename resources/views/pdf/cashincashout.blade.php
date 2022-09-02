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
                            <th align="right">Payment No</th>
                            <td>{{ $CashInCashOut->payment_no }}</td>
                        </tr>
                        <tr>
                            <th align="right">Payment Date</th>
                            <td>{{ $CashInCashOut->inputdate }}</td>
                        </tr>
                        <tr>
                            <th align="right">Payment Type</th>
                            <td>
                                <?php
                                $payment = $CashInCashOut->source;
                                if ($payment == 1) {
                                    echo 'Cash';
                                } elseif ($payment == 2) {
                                    echo 'Bank';
                                } else {
                                }
                                ?>
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>
        <table class="table table-striped mt-2" style="width:100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount Description</th>
                    <th>Remark</th>
                    <th>Amount</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Cashin/Cash out</td>
                    <td>{{ $CashInCashOut->payment_description }}</td>
                    <td>{{ $CashInCashOut->remark }}</td>
                    <td align="right"><b>{{ $CashInCashOut->amount }}</b></td>

                </tr>

            </tbody>
        </table>


        <table class="footer-table" style="margin-top: 60px;" width="100%">
            <tr>
                <td width="25%">
                    <hr style="border:1px solid #ccc">
                    <p align="center">Prepaid By</p>
                </td>
                <td></td>
                <td width="25%">
                    <hr style="border:1px solid #ccc">
                    <p align="center">Director Sign</p>
                </td>
            </tr>
        </table>
    </div>

    @endsection