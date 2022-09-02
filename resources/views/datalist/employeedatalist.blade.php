@foreach($Emplyers as $Emplyer)
<option id="{{ $Emplyer->id }}" data-employeid="{{ $Emplyer->employer_id }}" data-name="{{ $Emplyer->name }}" data-salary="{{ $Emplyer->salary }}" value="{{ $Emplyer->employer_id }}-{{ $Emplyer->name }}">
    @endforeach