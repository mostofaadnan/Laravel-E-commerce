@foreach($payments as $payment)
<option id="{{ $payment->id }}" value="{{ $payment->payment_no }}">
@endforeach