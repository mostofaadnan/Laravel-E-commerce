@foreach($VatCollectionno as $vatno)
<option id="{{ $vatno->id }}" data-amount="{{ $vatno->amount  }}" value="{{ $vatno->collection_no }}">
@endforeach