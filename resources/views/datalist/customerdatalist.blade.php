
@foreach($customers as $customer)
<option id="{{ $customer->id }}" data-name="{{ $customer->name }}" data-credit="{{ $customer->credit }}" data-consignment="{{ $customer->consignment }}" data-payment="{{ $customer->payment }}" data-discount="{{ $customer->totaldiscount }}" data-balancedue="{{ $customer->balancedue }}" value="{{ $customer->name }}">
@endforeach