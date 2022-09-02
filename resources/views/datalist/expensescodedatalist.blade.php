@foreach($ExpensesCodes as $ExpensesCode)
<option id="{{ $ExpensesCode->id }}" value="{{ $ExpensesCode->expenses_no }}">
@endforeach