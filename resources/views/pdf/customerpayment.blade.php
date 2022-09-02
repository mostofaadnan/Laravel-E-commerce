@extends('pdf.partials.reportmaster')
@section('content')
<div class="card">
    <div class="card-body">
        <table class="table Info-Table" style="width:100%" cellspacing="0">
            <tr>
                <td>
                    <h5>{{ $customerpayment->CustomerName->name }}</h5>
                    <address>
                        <i class="" id="customeraddress">{{ $customerpayment->CustomerName->address }},{{ $customerpayment->CustomerName->CityName->name }} , {{ $customerpayment->CustomerName->StateName->name }} </i><br>
                        <i class="" id="customercountry">{{ $customerpayment->CustomerName->CountryName->name }}.</i><br>
                        @if(($customerpayment->CustomerName->mobile_no)!==null) <i id="mobile" class="fa fa-mobile " aria-hidden="true">Mobile:{{ $customerpayment->CustomerName->mobile_no }}</i><br>@endif
                        @if(($customerpayment->CustomerName->tell_no)!==null)<i id="telno" class="fa fa-phone" aria-hidden="true">Phone:{{ $customerpayment->CustomerName->tell_no }}</i><br>@endif
                        @if(($customerpayment->CustomerName->email)!==null)<i id="email" class="fa fa-envelope-o" aria-hidden="true">Email:{{ $customerpayment->CustomerName->email }}</i><br>@endif
                        @if(($customerpayment->CustomerName->website)!==null)<i id="website" class="fa fa-address-book-o" aria-hidden="true">Website:{{ $customerpayment->CustomerName->website }}</i>@endif
                    </address>
                </td>
                <td></td>
                <td>
                    <table class="table table-striped" style="width:100%" cellspacing="0">
                        <tr>
                            <th align="right">Payment No</th>
                            <td>{{ $customerpayment->payment_no }}</td>
                        </tr>
                        <tr>
                            <th align="right">Payment Date</th>
                            <td>{{ $customerpayment->inputdate }}</td>
                        </tr>
                        <tr>
                            <th align="right">Payment Type</th>
                            <td>
                                <?php
                                $payment = $customerpayment->payment_id;
                                if ($payment == 1) {
                                    echo 'Cash';
                                } elseif ($payment == 2) {
                                    echo 'Bank';
                                } elseif ($payment == 3) {
                                    echo 'Card';
                                }
                                else{
                                    echo 'Paypal';
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
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Credit Payment</td>
                    <td align="right">{{ $customerpayment->amount }}</td>
                    <td align="right">{{ $customerpayment->recieve }}</td>
                    <td align="right">{{ $customerpayment->balancedue }}</td>
                    <td align="right">{{ $customerpayment->remark }}</td>
                </tr>
            </tbody>
        </table>

        <?php
        $cashinvoice = $customerpayment->CustomerBalance->sum('cashinvoice');
        $creditinvoice = $customerpayment->CustomerBalance->sum('creditinvoice');
        $discount = $customerpayment->CustomerBalance->sum('totaldiscount');
        $consignment =  round(($cashinvoice + $creditinvoice), 2);
        $netconsignment =  round(($consignment - $discount), 2);
        $payment = $customerpayment->CustomerBalance->sum('payment');
        $netpayment =  round(($payment + $cashinvoice), 2);
        $balancedue = round(($netconsignment - $netpayment), 2);
        ?>
        <table class="table table-striped mt-2" style="width:40%" cellspacing="0">
            <tr>
                <td colspan="2" align="center"><b>Customer Balance</b></th>
            </tr>
            <tr>
                <th>Description</th>
                <th>Amount</th>
            </tr>
            <tr>
                <th align="right">Opening Balance</th>
                <td align="right">{{ $customerpayment->CustomerBalance->sum('openingBalance') }}</td>
            </tr>
            <tr>
                <th align="right">Cash Invoice</th>
                <td align="right">{{ $cashinvoice }}</td>
            </tr>
            <tr>
                <th align="right">Credit Invoice</th>
                <td align="right">{{ $creditinvoice }}</td>
            </tr>
            <tr>
                <th align="right">Total Consignment</th>
                <td align="right">{{ $consignment }}</td>
            </tr>
            <tr>
                <th align="right">Total Discount</th>
                <td align="right">{{ $discount }}</td>
            </tr>
            <tr>
                <th align="right">Payment</th>
                <td align="right">{{ $netpayment }}</td>
            </tr>
            <tr>
                <th align="right">Balancedue</th>
                <td align="right"> {{$balancedue}}</td>
            </tr>
        </table>
        <table class="footer-table" style="margin-top: 120px;" width="100%">
            <tr>
                <td class="border-top">
                   
                    <p align="center">Customer Sign</p>
                </td>
                <td></td>
                <td class="border-top">
                   
                    <p align="center">Prepaid By</p>
                </td>
                <td></td>
                <td class="border-top">
                   
                    <p align="center">Director Sign</p>
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection