@extends('pdf.partials.reportmaster')
@section('content')
<div class="card">
  <div class="card-body">
    <table width=100%>
      <tr>
        <td>
          <h5>{{ $purchase->SupplierName->name }}</h3>
            <address>
              <i class="" id="customeraddress">{{ $purchase->SupplierName->address }},{{ $purchase->SupplierName->CityName->name }} , {{ $purchase->SupplierName->StateName->name }} </i><br>
              <i class="" id="customercountry">{{ $purchase->SupplierName->CountryName->name }}.</i><br>
              @if(($purchase->SupplierName->mobile_no)!==null) <i id="mobile" class="fa fa-mobile " aria-hidden="true">Mobile:{{ $purchase->SupplierName->mobile_no }}</i><br>@endif
              @if(($purchase->SupplierName->tell_no)!==null)<i id="telno" class="fa fa-phone" aria-hidden="true">Phone:{{ $purchase->SupplierName->tell_no }}</i><br>@endif
              @if(($purchase->SupplierName->email)!==null)<i id="email" class="fa fa-envelope-o" aria-hidden="true">Email:{{ $purchase->SupplierName->email }}</i><br>@endif
              @if(($purchase->SupplierName->website)!==null)<i id="website" class="fa fa-address-book-o" aria-hidden="true">Website:{{ $purchase->SupplierName->website }}</i>@endif
            </address>

        </td>
        <td></td>
        <td>
          <table class="table table-striped" style="width:100%" cellspacing="0">
            <tr>
              <th align="right">Purchase No</th>
              <td>{{ $purchase->purchasecode }}</td>
            </tr>
            <tr>
              <th align="right">Date</th>
              <td>{{ $purchase->inputdate }}</td>
            </tr>
            <tr>
              <th align="right">Reference No</th>
              <td>{{ $purchase->ref_no }}</td>
            </tr>
            <tr>
              <th align="right">GRN</th>
              <td>
                <?php
                if ($purchase->status == 1) {
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

        @foreach($purchase->PDetails as $key => $details)
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
          <td colspan="5" align="right"><b>Sub Total</b></td>
          <td align="right"><b>{{ $purchase->amount }}</b></td>
        </tr>
        <tr>
          <td colspan="5" align="right"><b>Discount</b></td>
          <td align="right"><b>{{ $purchase->discount }}</b></td>
        </tr>
        <tr>
          <td colspan="5" align="right"><b>Vat</b></tdh>
          <td align="right"><b>{{ $purchase->vat }}</b></td>
        </tr>
        <tr>
          <td colspan="5" align="right"><b>Shipment Cost</b></tdh>
          <td align="right"><b>{{ $purchase->shipment }}</b></td>
        </tr>
        <tr>
          <td colspan="5" align="right"><b>Net Total</b></td>
          <td align="right"><b>{{ $purchase->nettotal }}</b></td>
        </tr>
      </tbody>
    </table>
    <table style="margin-top: 60px;" width="100%">
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