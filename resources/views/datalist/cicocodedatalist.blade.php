@foreach($CashInCashOuts as $CashInCashOut)
<option id="{{ $CashInCashOut->id }}" value="{{ $CashInCashOut->payment_no }}">
@endforeach