@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header card-header-section">
        <div class="row">
            <div class="col-8 col-sm-4 col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">@lang('home.order') @lang('home.number')</label>
                    </div>
                    <input type="text" class="form-control" id="invoicecode" list="invoicenumber" placeholder="@lang('home.search')">
                    <datalist id="invoicenumber">
                    </datalist>
                </div>
            </div>
            <div class="col-4 col-sm-8">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @lang('home.action')
                    </button>
                    <div class="dropdown-menu" id="dropDown">
                        <a href="{{ route('orders') }}" class="nav-link">@lang('home.order') @lang('home.list')</a>
                        <div class="dropdown-divider"></div>
                        <a id="recieved" class="nav-link delete">@lang('home.recieved')</a>
                        <div class="dropdown-divider" id="recieved-dev"></div>
                        <a id="delivary" class="nav-link delete">@lang('home.delivery')</a>
                        <div class="dropdown-divider" id="delivary-dev"></div>
                        <a id="canceldata" class="nav-link delete">@lang('home.cancel')</a>
                        <div class="dropdown-divider"></div>
                        <a id="orderpdf" class="nav-link">@lang('home.pdf')</a>
                        <div class="dropdown-divider"></div>
                        <a id="mail" class="nav-link">@lang('home.send') @lang('home.mail')</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="card-body">
        @include('partials.ErrorMessage')

        <nav>
            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><b>Order</b></a>
                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><b>Payment Information</b></a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="inv-title mt-2">
                    <h4><b>@lang('home.order')</b></h4>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <h4>Shipment Address</h4>
                        <h5 id="customername"></h5>
                        <address>
                            <i class="" id="customeraddress"></i>
                            <i class="" id="customercountry"></i>
                            <i id="mobile" class="fa fa-mobile " aria-hidden="true"></i><br>
                            <i id="email" class="fa fa-envelope-o" aria-hidden="true"></i><br>

                        </address>
                    </div>
                    <div class="col-sm-4 hidden-xs"></div>
                    <div class="col-12 col-sm-4">
                        <table class="table table-bordered table-striped">

                            <tr>
                                <th>@lang('home.order') @lang('home.no')</th>
                                <td id="invoiceno"></td>
                            </tr>
                            <tr>
                                <th>@lang('home.date')</th>
                                <td id="invoicedate"></td>
                            </tr>
                            <tr>
                                <th>@lang('home.delivery') @lang('home.date')</th>
                                <td id="delvarydate"></td>
                            </tr>
                            <tr>
                                <th>@lang('home.payment') @lang('home.type')</th>
                                <td id="paymenttype"></td>
                            </tr>
                            <tr>
                                <th>@lang('home.status')</th>
                                <td id="status"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-10">
                        <table class="table table-bordered table-responsive-sm table-sm  data-table">
                            <thead>
                                <th align="center" width='5%'>#@lang("home.sl")</th>
                                <th>@lang("home.description")</th>
                                <th width='5%'>@lang("home.quantity")</th>
                                <th width='5%'>@lang("home.unit")</th>
                                <th width='10%'>@lang("home.unit") @lang("home.price")</th>
                                <th width='10%'>@lang("home.total")</th>
                            </thead>
                            <tbody id="tablebody">
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-8 "></div>
                    <div class="col-sm-4">
                        <table class="table table-bordered table-striped mt-2">
                            <tr>
                                <th>@lang("home.subtotal")</th>
                                <td id="subtotal" align="right"></td>
                            </tr>
                            <!--
                    <tr>
                        <th>@lang("home.discount")</th>
                        <td id="discount" align="right"></td>
                    </tr>

                    -->
                            <tr>
                                <th>@lang("home.sales") @lang("home.tax")</th>
                                <td id="vat" align="right"></td>
                            </tr>
                            <tr>
                                <th>@lang("home.shipment")</th>
                                <td id="shipment" align="right"></td>
                            </tr>
                            <tr>
                                <th>@lang("home.nettotal")</th>
                                <td id="nettotal" align="right"></td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="inv-title mt-2">
                    <h4><b>@lang('home.payment') @lang('home.information')</b></h4>
                    <div class="row">
                        <div class="col-sm-12 mt-10">
                            <table class="table table-bordered table-responsive-sm table-sm">
                                <thead>
                                    <th align="left" width='20%'>#@lang("home.field")</th>
                                    <th>@lang("home.description")</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td align="left"><b>Invoice No</b></td>
                                        <td align="left" id="cardinvno"></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><b>Transection No</b></td>
                                        <td align="left" id="cardtrn"></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><b>Transection Date</b></td>
                                        <td align="left" id="carddate"></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><b>Card Type</b></td>
                                        <td align="left" id="cardtype"></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><b>Card No</b></td>
                                        <td align="left" id="cardno"></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><b>Bank Transection ID</b></td>
                                        <td align="left" id="cardbanktrn"></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><b>Card Issue</b></td>
                                        <td align="left" id="cardissue"></td>
                                    </tr>
                                 
                                    <tr>
                                        <td align="left"><b>Card Brand</b></td>
                                        <td align="left" id="cardbank"></td>
                                    </tr>
                                  
                                    <tr>
                                        <td align="left"><b>Card Issue Country</b></td>
                                        <td align="left" id="cardcountry"></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><b>Store Id</b></td>
                                        <td align="left" id="storeid"></td>
                                    </tr>
                                  
                                    <tr>
                                        <td align="left"><b>Amount</b></td>
                                        <td align="left" id="cardamt"></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><b>Store Amount</b></td>
                                        <td align="left" id="storeamt"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@include('order.partials.invviewscript')
@endsection