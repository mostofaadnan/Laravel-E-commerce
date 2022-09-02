@extends('pdf.partials.reportmaster')
@section('content')
<div class="card">
  <div class="card-body">
    <table class="table Info-Table" style="width:100%" cellspacing="0">
      <tr>
        <td>
          <h5>{{ $SaleReturn->Customername->name }}</h5>
          <address>
            <i class="" id="customeraddress">{{ $SaleReturn->CustomerName->address }},{{$SaleReturn->CustomerName->cityname->name }} , {{ $SaleReturn->CustomerName->statename->name }} </i><br>
            <i class="" id="customercountry">{{ $SaleReturn->CustomerName->countryname->name }}.</i><br>
            @if(($SaleReturn->CustomerName->mobile_no)!==null) <i id="mobile" class="fa fa-mobile " aria-hidden="true">Mobile:{{ $SaleReturn->CustomerName->mobile_no }}</i><br>@endif
            @if(($SaleReturn->CustomerName->tell_no)!==null)<i id="telno" class="fa fa-phone" aria-hidden="true">Phone:{{ $SaleReturn->CustomerName->tell_no }}</i><br>@endif
            @if(($SaleReturn->CustomerName->email)!==null)<i id="email" class="fa fa-envelope-o" aria-hidden="true">Email:{{ $SaleReturn->CustomerName->email }}</i><br>@endif
            @if(($SaleReturn->CustomerName->website)!==null)<i id="website" class="fa fa-address-book-o" aria-hidden="true">Website:{{ $SaleReturn->CustomerName->website }}</i>@endif
          </address>
        </td>
        <td></td>
        <td>
          <table class="table table-striped" style="width:100%" cellspacing="0">
            <tr>
              <th align="right">Invoice Type</th>
              <td>{{ $SaleReturn->type_id==1? 'Cash SaleReturn':'Credit Invoice' }}</td>
            </tr>
            <tr>
              <th align="right">Return No</th>
              <td>{{ $SaleReturn->return_no }}</td>
            </tr>
            <tr>
              <th align="right">Invoice No</th>
              <td>{{ $SaleReturn->	invoice_id }}</td>
            </tr>
            <tr>
              <th align="right">Return Date</th>
              <td>{{ $SaleReturn->inputdate }}</td>
            </tr>
            <tr>
              <th align="right">Ref. No</th>
              <td>{{ $SaleReturn->ref_no }}</td>
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
      @foreach($SaleReturn->returnDetails as $key => $details)
      <tr>
        <td> {{ $key+1 }}</td>
        <td>{{ $details->productName->name }}</td>
        <td align="right">{{ $details->qty }}</td>
        <td>{{ $details->ProductName->UnitName->Shortcut }}</td>
        <td align="right">{{ $details->mrp }}</td>
        <td align="right"> {{ $details->amount }} </td>
      </tr>
      @endforeach
      <tr>
        <td colspan="5" align="right"><b>Sub Total</b></td>
        <td align="right">{{ $SaleReturn->amount }}</td>
      </tr>
      <tr>
        <td colspan="5" align="right"><b>Discount</b></td>
        <td align="right">{{ $SaleReturn->discount }}</td>
      </tr>
      <tr>
        <td colspan="5" align="right"><b>Vat</b></td>
        <td align="right">{{ $SaleReturn->vat }}</td>
      </tr>
      <tr>
        <td colspan="5" align="right"><b>Return Amount</b></td>
        <td align="right"> {{ $SaleReturn->nettotal }} </td>
      </tr>
    </tbody>
  </table>

<table class="footer-table" style="margin-top: 60px;" width="100%">
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