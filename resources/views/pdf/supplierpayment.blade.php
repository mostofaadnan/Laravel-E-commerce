@extends('pdf.partials.reportmaster')
@section('content')

<div class="card">
    <div class="card-body">
        <table class="table Info-Table" style="width:100%" cellspacing="0">
            <tr>
                <td>
                    <h5>{{ $supplierpayment->SupplierName->name }}</h5>

                    <address>
                        <i class="" id="customeraddress">{{ $supplierpayment->SupplierName->address }},{{ $supplierpayment->SupplierName->CityName->name }} , {{ $supplierpayment->SupplierName->StateName->name }} </i><br>
                        <i class="" id="customercountry">{{ $supplierpayment->SupplierName->CountryName->name }}.</i><br>
                        @if(($supplierpayment->SupplierName->mobile_no)!==null) <i id="mobile" class="fa fa-mobile " aria-hidden="true">Mobile:{{ $supplierpayment->SupplierName->mobile_no }}</i><br>@endif
                        @if(($supplierpayment->SupplierName->tell_no)!==null)<i id="telno" class="fa fa-phone" aria-hidden="true">Phone:{{ $supplierpayment->SupplierName->tell_no }}</i><br>@endif
                        @if(($supplierpayment->SupplierName->email)!==null)<i id="email" class="fa fa-envelope-o" aria-hidden="true">Email:{{ $supplierpayment->SupplierName->email }}</i><br>@endif
                        @if(($supplierpayment->SupplierName->website)!==null)<i id="website" class="fa fa-address-book-o" aria-hidden="true">Website:{{ $supplierpayment->SupplierName->website }}</i>@endif
                    </address>

                </td>
                <td></td>
                <td>
                    <table class="table table-striped" style="width:100%" cellspacing="0">
                        <tr>
                            <th align="right">Payment No</th>
                            <td>{{ $supplierpayment->payment_no }}</td>
                        </tr>
                        <tr>
                            <th align="right">Payment Date</th>
                            <td>{{ $supplierpayment->inputdate }}</td>
                        </tr>
                        <tr>
                            <th align="right">Payment Type</th>
                            <td>
                                <?php
                                $payment = $supplierpayment->payment_id;
                                if ($payment == 1) {
                                    echo 'Cash';
                                } elseif ($payment == 2) {
                                    echo 'Card';
                                } else {
                                    echo 'Bank';
                                }
                                ?>
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>
        <table class="table table-striped" style="width:100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Description</th>
                    <th width="10%">Amount</th>
                    <th width="10%">Payment</th>
                    <th width="15%">Balance Due</th>
                    <th width="15%">Remark</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Supplier Payment</td>
                    <td align="right">{{ $supplierpayment->amount }}</td>
                    <td align="right">{{ $supplierpayment->payment }}</td>
                    <td align="right">{{ $supplierpayment->balancedue }}</td>
                    <td align="right">{{ $supplierpayment->remark }}</td>
                </tr>

            </tbody>
        </table>
        <table class="table table-striped mt-2" style="width:40%" cellspacing="0">
            <tbody>
                <tr>
                    <td colspan="2" align="center"><b>Supplier Balance</b></td>
                </tr>
                <tr>
                    <th align="right">Consignment</th>
                    <td align="right">{{ $consignment }}</td>
                </tr>
                <tr>
                    <th align="right"><b>Total Discount</b></th>
                    <td align="right">{{ $discount }}</td>
                </tr>
                <tr>
                    <th align="right">Payment</th>
                    <td align="right"> {{ $payments }} </td>
                </tr>
                <tr>
                    <th align="right">Balance Due</th>
                    <td align="right"> {{ $balancedue }} </td>
                </tr>
            </tbody>
        </table>

        <table class="footer-table" style="margin-top: 60px;" width="100%">
            <tr>
                <td>
                    <hr style="border:1px solid #ccc">
                    <p align="center">Supplier Sign</p>
                </td>
                <td>
                    <hr style="border:1px solid #ccc">
                    <p align="center">Prepaid By</p>
                </td>
                <td>
                    <hr style="border:1px solid #ccc">
                    <p align="center">Director Sign</p>
                </td>
            </tr>
        </table>
    </div>

    @endsection