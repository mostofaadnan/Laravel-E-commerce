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
                            <th>@lang('home.payment') @lang('home.number')</th>
                            <td>{{ $VatPayment->vat_payment_no }}</td>
                        </tr>
                        <tr>
                            <th>@lang('home.vat') @lang('home.number')</th>
                            <td>{{ $VatPayment->Vat_Collection->collection_no }}</td>
                        </tr>
                        <tr>
                            <th>@lang('home.date')</th>
                            <td>{{ $VatPayment->inputdate }}</td>
                        </tr>
                        <tr>
                            <th>@lang('home.payment') @lang('home.type')</th>
                            <td>
                                <?php
                                echo $VatPayment->payment_type == 1 ? 'Cash' : 'Bank';
                                ?>

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="table table-striped" style="width:100%" cellspacing="0">
            <thead>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Payment Description</th>
                        <th>Amount</th>
                        <th>Remark</th>
                    </tr>
                </thead>
            </thead>
            <tbody>
                <tr>
                    <td>Vat Payment</td>
                    <td>{{ $VatPayment->paymentdescription }}</td>
                    <td align="right">{{ $VatPayment->amount }}</td>
                    <td>{{ $VatPayment->remark }}</td>
                </tr>
            </tbody>

        </table>

        <table class="footer-table" style="margin-top: 60px;" width="100%">
            <tr>
                <td class="border-top" width="20%">
                    <p align="center">Prepaid By</p>
                </td>
                <td width="60%">
                </td>
                <td class="border-top" width="20%">
                    <p align="center">Director Sign</p>
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection