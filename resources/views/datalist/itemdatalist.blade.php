@foreach($products as $product)

<option id="{{ $product->id }}" data-name="{{ $product->name }}" data-barcode="{{ $product->barcode }}" data-mrp="{{ $product->mrp }}" data-unitid="{{ $product->unit_id }}" data-tp="{{ $product->tp }}" data-mrp="{{ $product->mrp }}" data-discount="{{ $product->discount }}"  data-unitname="{{ $product->UnitName->Shortcut }}" value="{{ $product->name }}({{  $product->CategoryName->title}})">

    @endforeach