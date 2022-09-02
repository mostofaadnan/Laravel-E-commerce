@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header card-header-section">
        <div class="row">
            <div class="col-8 col-sm-4 col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">@lang('home.return') @lang('home.no')</label>
                    </div>
                    <input type="text" class="form-control" id="returncode" list="returnnumber" placeholder="@lang('home.search')">
                    <datalist id="returnnumber">
                    </datalist>
                </div>
            </div>
            <div class="col-4 col-sm-8">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @lang('home.action')
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ route('salereturns') }}" class="nav-link">@lang('home.return') @lang('home.list')</a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('salereturn.create') }}" class="nav-link">@lang('home.new')</a>
                        <div class="dropdown-divider"></div>
                        <a class="nav-link" id="deletedata">@lang('home.delete')</a>
                        <div class="dropdown-divider"></div>
                        <a id="printslip" class="nav-link">@lang('home.print')</a>
                        <div class="dropdown-divider"></div>
                        <a id="returnpdf" class="nav-link">@lang('home.pdf')</a>
                        <div class="dropdown-divider"></div>
                        <a id="mail" class="nav-link">@lang('home.mail') @lang('home.send')</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="card-body">
        @include('partials.ErrorMessage')
        <div class="inv-title">
            <h4 class="no-margin" style="color:blue"><b>@lang('home.sale') @lang('home.return')</b></h4>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <h4 id="customername"></h4>
                <address>
                    <i class="" id="customeraddress"></i>
                    <i class="" id="customercountry"></i>
                    <i id="mobile" class="fa fa-mobile " aria-hidden="true"></i><br>
                    <i id="telno" class="fa fa-phone" aria-hidden="true"></i><br>
                    <i id="email" class="fa fa-envelope-o" aria-hidden="true"></i><br>
                    <i id="website" class="fa fa-address-book-o" aria-hidden="true"></i>
                </address>
            </div>
            <div class="col-sm-4 hidden-xs"></div>
            <div class="col-12 col-sm-4">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>@lang('home.invoice') @lang('home.type')</th>
                        <td id="type"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.return') @lang('home.number')</th>
                        <td id="returnno"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.invoice') @lang('home.number')</th>
                        <td id="invoiceno"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.return') @lang('home.date')</th>
                        <td id="invoicedate"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.reference') @lang('home.number')</th>
                        <td id="refno"></td>
                    </tr>


                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped table-responsive-sm table-sm  data-table" width="100%">
                    <thead>
                        <th align="center">#@lang('home.sl')</th>
                        <th>@lang('home.description')</th>
                        <th>@lang('home.quantity')</th>
                        <th>@lang('home.unit')</th>
                        <th>@lang('home.unit') @lang('home.price')</th>
                        <th>@lang('home.total')</th>
                    </thead>
                    <tbody id="tablebody">
                    </tbody>
                </table>
            </div>
            <div class="col-sm-8 "></div>
            <div class="col-sm-4">
                <table class="table table-bordered table-striped mt-2">
                    <tr>
                        <th>@lang('home.subtotal')</th>
                        <td id="subtotal"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.discount')</th>
                        <td id="discount"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.sale') @lang('home.tax')</th>
                        <td id="vat"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.return') @lang('home.amount')</th>
                        <td id="nettotal"></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
</div>
@include('salereturn.partials.salereturnviewscript')
@endsection