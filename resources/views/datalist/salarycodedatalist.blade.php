@foreach($salarys as $salary)
<option id="{{ $salary->id }}" data-netsalary="{{ $salary->netsalary }}" value="{{ $salary->payment_no }}">
@endforeach