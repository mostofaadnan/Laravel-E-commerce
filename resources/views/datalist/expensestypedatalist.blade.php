
@foreach($ExpensesTypes as $ExpensesType)
<option id="{{ $ExpensesType->id }}" value="{{ $ExpensesType->name }}">
@endforeach