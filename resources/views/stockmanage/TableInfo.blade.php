<table class="table table-striped" id="mytable">
    <thead>
        <tr>
            <th> #@lang('home.sl') </th>
            <th> @lang('home.barcode')</th>
            <th> @lang('home.name') </th>
            <th>@lang('home.stock')</th>
            <th>@lang('home.stock') @lang('home.unit')</th>
            <th>@lang('home.tp')</th>
            <th>@lang('home.mrp')</th>
            <th>@lang('home.stock') @lang('home.amount')</th>

        </tr>
    </thead>
    <tbody id="tablebody">
    </tbody>
    <tfoot>
        <tr>
            <th> #@lang('home.sl') </th>
            <th> @lang('home.barcode')</th>
            <th> @lang('home.name') </th>
            <th>@lang('home.stock')</th>
            <th>@lang('home.stock') @lang('home.unit')</th>
            <th>@lang('home.tp')</th>
            <th>@lang('home.mrp')</th>
            <th>@lang('home.stock') @lang('home.amount')</th>
        </tr>
    </tfoot>
</table>
@include('stockmanage.qtyindexscripts')