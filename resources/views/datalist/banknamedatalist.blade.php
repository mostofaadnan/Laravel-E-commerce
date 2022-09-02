@foreach($BankName as $bank)
<option id="{{ $bank->id }}" value="{{ $bank->name }}">
    @endforeach