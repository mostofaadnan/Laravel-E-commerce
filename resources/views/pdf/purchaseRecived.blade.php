@extends('pdf.partials.reportmaster')
@section('content')
<div class="card">
  <div class="card-body">
    <table width=100%>
      <tr>
        <td>
          <h5>{{ $precieve->purchaseDetails->SupplierName->name }}</h5>
            <address>
              <i class="" id="customeraddress">{{ $precieve->purchaseDetails->SupplierName->address }},{{ $precieve->purchaseDetails->SupplierName->CityName->name }} , {{ $precieve->purchaseDetails->SupplierName->StateName->name }} </i><br>
              <i class="" id="customercountry">{{ $precieve->purchaseDetails->SupplierName->CountryName->name }}.</i><br>
              @if(($precieve->purchaseDetails->SupplierName->mobile_no)!==null) <i id="mobile" class="fa fa-mobile " aria-hidden="true">Mobile:{{ $precieve->purchaseDetails->SupplierName->mobile_no }}</i><br>@endif
              @if(($precieve->purchaseDetails->SupplierName->tell_no)!==null)<i id="telno" class="fa fa-phone" aria-hidden="true">Phone:{{ $precieve->purchaseDetails->SupplierName->tell_no }}</i><br>@endif
              @if(($precieve->purchaseDetails->SupplierName->email)!==null)<i id="email" class="fa fa-envelope-o" aria-hidden="true">Email:{{ $precieve->purchaseDetails->SupplierName->email }}</i><br>@endif
              @if(($precieve->purchaseDetails->SupplierName->website)!==null)<i id="website" class="fa fa-address-book-o" aria-hidden="true">Website:{{ $precieve->purchaseDetails->SupplierName->website }}</i>@endif
            </address>
          
        </td>
        <td></td>
        <td>
          <table class="table table-striped" style="width:100%" cellspacing="0">
            <tr>
              <th align="right">GRN No</th>
              <td>{{ $precieve->purchaseRecievdNo }}</td>
            </tr>
            <tr>
              <th align="right">Purchase No</th>
              <td>{{ $precieve->purchaseDetails->purchasecode }}</td>
            </tr>
            <tr>
              <th align="right">Recieve Date</th>
              <td>{{ $precieve->inputdate }}</td>
            </tr>
            <tr>
              <th align="right">Reference No</th>
              <td>{{ $precieve->purchaseDetails->ref_no }}</td>
            </tr>
            <tr>
              <th align="right">Purchase Recieved</th>
              <td>
                <?php
                if ($precieve->purchaseDetails->status == 1) {
                  echo 'Active';
                } else {
                  echo 'Inactive';
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
          <th width="7%">#sl</th>
          <th>Description</th>
          <th width="8%">Qty</th>
          <th width="5%">Unit</th>
          <th width="15%">Unit Price</th>
          <th width="15%">Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach($precieve->purchaseDetails->PDetails as $key => $details)
        <tr>
          <td> {{ $key+1 }}</td>
          <td>{{ $details->productName->name }}</td>
          <td align="right">{{ $details->qty }}</td>
          <td>{{ $details->UnitName->Shortcut }}</td>
          <td align="right">{{ $details->mrp }}</td>
          <td align="right"> {{ $details->amount }} </td>
        </tr>
        @endforeach
        <tr>
          <td align="right" colspan="5"><b>Sub Total</b></td>
          <td align="right">{{ $precieve->purchaseDetails->amount }}</td>
        </tr>
        <tr>
          <td align="right" colspan="5"><b>Discount</b></th>
          <td align="right">{{ $precieve->purchaseDetails->discount }}</td>
        </tr>
        <tr>
          <td align="right" colspan="5"><b>Vat</b></td>
          <td align="right">{{ $precieve->purchaseDetails->vat }}</td>
        </tr>
        <tr>
          <td align="right" colspan="5"><b>Shipment Cost</b></td>
          <td align="right">{{ $precieve->purchaseDetails->shipment }}</td>
        </tr>
        <tr>
          <td align="right" colspan="5"><b>Net Total</b></td>
          <td align="right"> {{ $precieve->purchaseDetails->nettotal }} </td>
        </tr>
      </tbody>
    </table>

    <table class="table table-striped" style="width:40%" cellspacing="0">
      <tbody>
        <tr>
          <td colspan="2" align="center"><b>Supplier Balance</b></td>
        </tr>
        <tr>
          <th>Consignment</th>
          <td align="right"><b>{{ $consignment }}</b></td>
        </tr>
        <tr>
          <th>Total Discount</th>
          <td align="right"><b>{{ $discount }}</b></td>
        </tr>
        <tr>
          <th>Payment</th>
          <td align="right"><b>{{ $payments }}</b></td>
        </tr>
        <tr>
          <th align="right">Balance Due</th>
          <td align="right"><b> {{ $balancedue }}</b> </td>
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
          <p align="center">Director Sighn</p>
        </td>
      </tr>
    </table>
  </div>
  @endsection