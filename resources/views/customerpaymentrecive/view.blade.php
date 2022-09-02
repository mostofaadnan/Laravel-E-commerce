@extends('layouts.master')
@section('content')


<div class="card">
    <div class="card-header card-header-section">
        <div class="row">
            <div class="col-8 col-sm-4 col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">@lang('home.payment') @lang('home.number')</label>
                    </div>
                    <input type="text" class="form-control" id="paymentcode" list="paymentno" placeholder="@lang('home.search')">
                    <datalist id="paymentno">
                    </datalist>
                </div>
            </div>
            <div class="col-4 col-sm-8">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ route('customerpayments') }}" class="nav-link">@lang('home.payment') @lang('home.list')</a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('customerpayment.create') }}" class="nav-link">@lang('home.new')</a>
                        <div class="dropdown-divider"></div>
                        <a class="nav-link" id="datadelete">@lang('home.delete')</a>
                        <div class="dropdown-divider"></div>
                        <a id="pdf" class="nav-link">@lang('home.pdf')</a>
                        <div class="dropdown-divider"></div>
                        <a id="mail" class="nav-link"> @lang('home.mail') @lang('home.send')</a>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="card-body">
        <div class="inv-title">
            <h4 class="no-margin">@lang('home.credit') @lang('home.payment')</h4>
        </div>
        @include('partials.ErrorMessage')   
        <div class="row">
            <div class="col-sm-4">
                <h4 id="suppliername"></h4>
                <address>
                    <i class="" id="supplieraddress"></i>
                    <i class="" id="suppliercountry"></i>
                    <i id="mobile" class="fa fa-mobile " aria-hidden="true"></i><br>
                    <i id="telno" class="fa fa-phone" aria-hidden="true"></i><br>
                    <i id="email" class="fa fa-envelope-o" aria-hidden="true"></i><br>
                    <i id="website" class="fa fa-address-book-o" aria-hidden="true"></i>
                </address>
            </div>
            <div class="col-sm-4 hidden-xs"></div>
            <div class="col-sm-4">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>@lang('home.payment') @lang('home.number')</th>
                        <td id="supplierpaymentno"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.date')</th>
                        <td id="paymentdate"></td>
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
                <table class="table table-bordered table-striped table-responsive-sm table-sm" width="100%">
                    <thead>
                        <th>@lang('home.description')</th>
                        <th>@lang('home.amount')</th>
                        <th>@lang('home.payment')</th>
                        <th>@lang('home.balancedue')</th>
                        <th>@lang('home.remark')</th>
                    </thead>
                    <tbody id="tablebody">
                        <tr>
                            <td width="20%">@lang('home.credit') @lang('home.payment')</td>
                            <td width="10%" id="amount" align="right"></td>
                            <td width="10%" id="payment" align="right"></td>
                            <td width="10%" id="balancedue" align="right"></td>
                            <td width="60%" id="remark"></td>
                        </tr>
                        <tr>
                            <th id="inwordsht">In words:</th>
                            <td id="inwords" colspan="4"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <table class="table table-bordered table-striped mt-2">
                    <tr>
                        <th colspan="2" class="text-center">@lang('home.customer') @lang('home.balance')</th>
                    </tr>
                    <tr>
                        <th>@lang('home.opening') @lang('home.balance')</th>
                        <td id="opening" align="right"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.cash') @lang('home.invice')</th>
                        <td id="cashinv" align="right"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.credit') @lang('home.invoice')</th>
                        <td id="creditinv" align="right"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.consignment')</th>
                        <td id="consignment" align="right"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.discount')</th>
                        <td id="sdiscount" align="right"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.payment')</th>
                        <td id="spayment" align="right"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.balancedue')</th>
                        <td id="sbalancedue" align="right"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@include('customerpaymentrecive.partials.customerpviewscript')
@endsection