@extends('layouts.master')
@section('content')
<style>
    .image-container {
        position: relative;
    }

    .image {
        opacity: 1;
        display: block;
        width: 100%;
        height: auto;
        transition: .5s ease;
        backface-visibility: hidden;
    }

    .middle {
        transition: .5s ease;
        opacity: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        text-align: center;
    }

    .image-container:hover .image {
        opacity: 0.3;
    }

    .image-container:hover .middle {
        opacity: 1;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header profile-view">
                <div class="row">
                    <div class=" col-sm-8">
                        <h3 id="customername" style="color:red;"></h3>
                    </div>
                    <div class="form-group col-sm-4">
                        <input type="text" class="form-control" id="customersearch" placeholder="Customer" list="customer" required>
                        <datalist id="customer">
                        </datalist>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('customer.partials.customerinfo')
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="basicInfo-tab" data-toggle="tab" href="#basicInfo" role="tab" aria-controls="basicInfo" aria-selected="true">@lang('home.account') @lang('home.summery')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="invoicehistorycash-tab" data-toggle="tab" href="#invoicehistorycash" role="tab" aria-controls="invoicehistorycash" aria-selected="false">@lang('home.invoice') @lang('home.history')(@lang('home.cash'))</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="invoicehistorycredit-tab" data-toggle="tab" href="#invoicehistorycredit" role="tab" aria-controls="invoicehistorycredit" aria-selected="false">@lang('home.invoice') @lang('home.history')(@lang('home.credit'))</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="paymenthistory-tab" data-toggle="tab" href="#paymenthistory" role="tab" aria-controls="paymenthistory" aria-selected="false">@lang('home.payment') @lang('home.recieved') @lang('home.history')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="connectedServices-tab" data-toggle="tab" href="#connectedServices" role="tab" aria-controls="connectedServices" aria-selected="false">@lang('home.document')</a>
                            </li>

                        </ul>
                        <div class="tab-content ml-1" id="myTabContent">
                            <div class="tab-pane fade show active" id="basicInfo" role="tabpanel" aria-labelledby="basicInfo-tab">
                                <div class="container">
                                    <table class="table-infodetails table table-hover">
                                        <thead>
                                            <tr>
                                                <th>@lang('home.field')</th>
                                                <th>@lang('home.description')</th>
                                            </tr>
                                        </thead>
                                        <tbody id="customerinfodetails">
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="invoicehistorycash" role="tabpanel" aria-labelledby="invoicehistorycash-tab">
                                <div class="pull-left mt-2 mb-2 mr-2">
                                    <h4 style='color:red;margin-left:10px;'>@lang('home.invoice') @lang('home.history')(@lang('home.cash'))</h4>
                                </div>
                                <div class="container">
                                    <table id="tablebodycash" class="table table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> #@lang('home.sl') </th>
                                                <th> @lang('home.invoice') @lang('home.no') </th>
                                                <th> @lang('home.date') </th>
                                                <th> @lang('home.nettotal')</th>
                                                <th> @lang('home.payment') @lang('home.type')</th>
                                                <th> @lang('home.user')</th>
                                                <th> @lang('home.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                            <tr>
                                                <th> #@lang('home.sl') </th>
                                                <th> @lang('home.invoice') @lang('home.no') </th>
                                                <th> @lang('home.date') </th>
                                                <th> @lang('home.nettotal')</th>
                                                <th> @lang('home.payment') @lang('home.type')</th>
                                                <th> @lang('home.user')</th>
                                                <th> @lang('home.action')</th>
                                            </tr>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="invoicehistorycredit" role="tabpanel" aria-labelledby="invoicehistorycredit-tab">
                                <div class="pull-left mt-2 mb-2 mr-2">
                                    <h4 style='color:red;margin-left:10px;'>Invoice History(credit)</h4>
                                </div>
                                <div class="container">
                                    <table id="tablebodycredit" class="table table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> #Sl </th>
                                                <th> Invoice No </th>
                                                <th> Invoice Date </th>
                                                <th> Total Amount</th>
                                                <th> Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                            <tr>
                                                <th> #Sl </th>
                                                <th> Invoice No </th>
                                                <th> Invoice Date </th>
                                                <th> Total Amount</th>
                                                <th> Action</th>
                                            </tr>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>


                            </div>


                            <div class="tab-pane fade" id="paymenthistory" role="tabpanel" aria-labelledby="paymenthistory-tab">
                                <div class="pull-left mt-2 mb-2 mr-2">
                                    <h4 style='color:red;margin-left:10px;'>Payment Recieve History</h4>
                                </div>
                                <div class="pull-right mt-2 mb-2 mr-2">
                                    <input type="text" class="form-control" id="search" placeholder="Search" list="product" required>
                                </div>
                                <table id="tableypayment" class="table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th> #Sl </th>
                                            <th> Payment No </th>
                                            <th> Date </th>
                                            <th> Amount</th>
                                            <th> Recieve </th>
                                            <th> Balance Due </th>
                                            <th> Payment type </th>
                                            <th> User</th>
                                            <th> Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th> #Sl </th>
                                            <th> Payment No </th>
                                            <th> Payment Date </th>
                                            <th> Amount</th>
                                            <th> Recieve </th>
                                            <th> Balance Due </th>
                                            <th> Payment type </th>
                                            <th> User</th>
                                            <th> Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="connectedServices" role="tabpanel" aria-labelledby="ConnectedServices-tab">
                                <div class="container">
                                    <table class="data-table-document" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Type</th>
                                                <th>Remark</th>
                                                <th>Image</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabledocument">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="card-header">


            </div>
        </div>
    </div>
</div>


@include('customer.partials.cusviewscript')

@endsection