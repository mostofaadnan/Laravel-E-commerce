@foreach($invoices as $invoice)
<option id="{{ $invoice->id }}" value="{{ $invoice->invoice_no }}">
@endforeach