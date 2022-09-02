@foreach($purchasereturns as $purchasereturn)
<option id="{{ $purchasereturn->id }}" value="{{ $purchasereturn->return_code }}">
@endforeach