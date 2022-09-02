@extends('pdf.partials.reportmaster')
@section('content')
<div class="card">
  <div class="card-body">
    <table class="table Info-Table" style="width:100%" cellspacing="0">
      <tr>
        <td>
          <h5>{{ $PurchaseReturn->SupplierName->name }}</h5>
          <address>
            <i class="" id="customeraddress">{{ $PurchaseReturn->SupplierName->address }},{{ $PurchaseReturn->SupplierName->CityName->name }} , {{ $PurchaseReturn->SupplierName->StateName->name }} </i><br>
            <i class="" id="customercountry">{{ $PurchaseReturn->SupplierName->CountryName->name }}.</i><br>
            @if(($PurchaseReturn->SupplierName->mobile_no)!==null) <i id="mobile" class="fa fa-mobile " aria-hidden="true">Mobile:{{ $PurchaseReturn->SupplierName->mobile_no }}</i><br>@endif
            @if(($PurchaseReturn->SupplierName->tell_no)!==null)<i id="telno" class="fa fa-phone" aria-hidden="true">Phone:{{ $PurchaseReturn->SupplierName->tell_no }}</i><br>@endif
            @if(($PurchaseReturn->SupplierName->email)!==null)<i id="email" class="fa fa-envelope-o" aria-hidden="true">Email:{{ $PurchaseReturn->SupplierName->email }}</i><br>@endif
            @if(($PurchaseReturn->SupplierName->website)!==null)<i id="website" class="fa fa-address-book-o" aria-hidden="true">Website:{{ $PurchaseReturn->SupplierName->website }}</i>@endif
          </address>
        </td>
        <td></td>
        <td>
          <table class="table table-striped">
            <tr>
              <th align="right">Return No</th>
              <td>{{ $PurchaseReturn->return_code }}</td>
            </tr>
            <tr>
              <th align="right">Return Date</th>
              <td>{{ $PurchaseReturn->inputdate }}</td>
            </tr>
            <tr>
              <th align="right">Reference No</th>
              <td>{{ $PurchaseReturn->ref_no }}</td>
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
          <th width="8%">Quantity</th>
          <th width="5%">Unit</th>
          <th width="15%">Unit Price</th>
          <th width="15%">Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach($PurchaseReturn->PDetails as $key => $details)
        <tr>
          <td> {{ $key+1 }}</td>
          <td>{{ $details->productName->name }}</td>
          <td align="right">{{ $details->qty }}</td>
          <td>{{ $details->productName->UnitName->Shortcut }}</td>
          <td align="right">{{ $details->mrp }}</td>
          <td align="right"> {{ $details->amount }} </td>
        </tr>
        @endforeach
        <tr>
          <th colspan="5" align="right">Sub Total</th>
          <td align="right">{{ $PurchaseReturn->amount }}</td>
        </tr>
        <tr>
          <th colspan="5" align="right">Discount</th>
          <td align="right">{{ $PurchaseReturn->discount }}</td>
        </tr>
        <tr>
          <td colspan="5" align="right"><b>Vat</b></tdh>
          <td align="right">{{ $PurchaseReturn->vat }}</td>
        </tr>
        <tr>
          <td colspan="5" align="right">Return Amount(Total)</td>
          <td align="right"> {{ $PurchaseReturn->nettotal }} </td>
        </tr>
      </tbody>
    </table>

    <table style="margin-top: 60px;" width="100%">
      <tr>
        <td class="border-top">
          <p align="center">Supplier Sign</p>
        </td>
        <td class="border-top">
          <p align="center">Prepaid By</p>
        </td>
        <td class="border-top">
          <p align="center">Director Sign</p>
        </td>
      </tr>

    </table>
  </div>
</div>

@endsection