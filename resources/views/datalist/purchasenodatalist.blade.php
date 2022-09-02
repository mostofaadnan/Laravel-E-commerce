@foreach($purchases as $purchase)
<option id="{{ $purchase->id }}" value="{{ $purchase->purchasecode }}">
@endforeach