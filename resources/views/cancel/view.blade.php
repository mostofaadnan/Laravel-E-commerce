@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header card-header-section">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @lang('home.action')
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ route('invoices') }}" class="nav-link">@lang('home.invoice') @lang('home.list')</a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('invoice.create') }}" class="nav-link">@lang('home.new')</a>
                        <div class="dropdown-divider"></div>
                        <a id="datadelete" class="nav-link">@lang('home.delete')</a>
                        <div class="dropdown-divider"></div>
                        <a id="retrivedata" class="nav-link">@lang('home.retrive')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="inv-title">
            <h4 class="no-margin"><b>@lang('home.invoice') @lang('home.cancel')</b></h4>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <h5 id="customername"></h5>
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
                        <td>@lang('home.invoice') @lang('home.type')</th>
                        <td id="type"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.invoice') @lang('home.no')</th>
                        <td id="invoiceno"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.date')</th>
                        <td id="invoicedate"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.reference')</th>
                        <td id="refno"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.payment') @lang('home.type')</th>
                        <td id="paymenttype"></td>
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
        </div>
        <div class="row">
            <div class="col-sm-8"></div>
            <div class="col-sm-4">
                <table class="table table-bordered table-striped mt-2">
                    <tr>
                        <td align="right"><b>@lang('home.subtotal')</b></td>
                        <td id="subtotal" align="right"></td>
                    </tr>
                    <tr>
                        <td align="right"><b>@lang('home.discount')</b></td>
                        <td id="discount" align="right"></td>
                    </tr>
                    <tr>
                        <td align="right"><b>@lang('home.sales') @lang('home.tax')</b></td>
                        <td id="vat" align="right"></td>
                    </tr>
                    <tr>
                        <td align="right"><b>@lang('home.nettotal')</b></td>
                        <td id="nettotal" align="right"></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
</div>

@include('cancel.invcancelviewscript')
@endsection