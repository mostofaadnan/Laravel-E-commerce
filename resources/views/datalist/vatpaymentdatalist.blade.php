@foreach($VatPayment as $vatpaymentno)
<option id="{{ $vatpaymentno->id }}" value="{{ $vatpaymentno->vat_payment_no }}">
@endforeach