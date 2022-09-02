<div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested dropdown" style="padding-top:0;">
    <div class="btn-group mt-1" role="group">
        <button id="btnGroupDrop1" type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @lang('home.check')
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item" href="{{ route('saleconfig') }}">@lang('home.configuration')</a>
            <div class="dropdown-divider"></div>
            <a id="vatshow" data-toggle="modal" data-target="#vatsetting" class="dropdown-item" href="#">@lang('home.vat') @lang('home.setting')</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" id="customerinformation" onclick=CustomerClear() data-toggle="modal" data-target="#customerinfo" href="#">@lang('home.customer')</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" id="itemcheck" data-toggle="modal" data-target="#modelitemview" href="#">@lang('home.item') @lang('home.check')</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{Route('invoice.profile')}}" target="_blank">@lang('home.invoice') @lang('home.check')</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('invoices') }}" target="_blank">@lang('home.sale') @lang('home.details')</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('salereturn.create')}}" target="_blank">@lang('home.sale') @lang('home.return')</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('invoice.create') }}" target="_blank">@lang('home.new') @lang('home.invoice')</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{Route('invoice.profile')}}" target="_blank">@lang('home.cancel')</a>
        </div>
    </div>
    <button type="button" id="resteBtn" class="btn btn-dark ">@lang('home.reset')</button>

</div>

