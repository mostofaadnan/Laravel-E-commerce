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

    .profile-description-section {
        margin: auto;
    }

    .mark {
        color: #DC143C;
    }

    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:before {
        bottom: .5em;
    }
</style>

<div class="row">
    <div class="col-12 profile-description-section">
        <div class="card">
            <div class="card-header profile-view">
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <h3 id="productname"></h3>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="input-group  mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="">@lang('home.search')</span>
                            </div>
                            <input type="text" class="form-control" id="search" placeholder="Search" list="product" required>
                            <datalist id="product">
                            </datalist>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs mt-2" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="basicInfo-tab" data-toggle="tab" href="#basicInfo" role="tab" aria-controls="basicInfo" aria-selected="true">@lang('home.item') @lang('home.details')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="connectedServices-tab" data-toggle="tab" href="#connectedServices" role="tab" aria-controls="connectedServices" aria-selected="false">@lang('home.purchase') @lang('home.history')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="InvoiceHistory-tab" data-toggle="tab" href="#InvoiceHistory" role="tab" aria-controls="InvoiceHistory" aria-selected="false">@lang('home.invoice') @lang('home.history')</a>
                            </li>
                        </ul>
                        <div class="tab-content ml-1" id="myTabContent">
                            <div class="tab-pane fade show active" id="basicInfo" role="tabpanel" aria-labelledby="basicInfo-tab">
                                <div class="mt-2 my-custom-scrollbar my-custom-scrollbar-primary scrollbar-morpheus-den">
                                    <table class="table table-striped table-bordered table-sm">

                                        <thead>
                                            <tr>
                                                <th style="width:30%;">@lang('home.field')</th>
                                                <th>@lang('home.description')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>@lang('home.id')</th>
                                                <td id="productid"></td>
                                            </tr>
                                            <tr>
                                                <th>@lang('home.baroce')</th>
                                                <td id="barcode"></td>
                                            </tr>
                                            <tr>
                                                <th>@lang('home.category')</th>
                                                <td id="category"></td>
                                            </tr>
                                            <tr>
                                                <th>@lang('home.subcategory')</th>
                                                <td id="subcategory"></td>
                                            </tr>
                                            <tr>
                                                <th>@lang('home.brand')</th>
                                                <td id="brand"></td>
                                            </tr>

                                            <tr>
                                                <th>@lang('home.opening') @lang('home.date')</th>
                                                <td id="openingdate"></td>
                                            </tr>
                                            <tr>
                                                <th class="th-mark">@lang('home.tp') ( @lang('home.trade') @lang('home.price') )</th>
                                                <td class="th-mark" id="tp"></td>
                                            </tr>
                                            <tr>
                                                <th>@lang('home.mrp') ( @lang('home.market') @lang('home.price') )</th>
                                                <td id="mrp"></td>
                                            </tr>
                                            <tr>
                                                <th>@lang('home.vat')</th>
                                                <td id="vatname"></td>
                                            </tr>
                                            <tr>
                                                <th>@lang('home.vat') @lang('home.value')</th>
                                                <td id="vatvalue">%/td>
                                            </tr>
                                            <tr>
                                                <th>@lang('home.opening') @lang('home.stock')</th>
                                                <td id="qty"> </td>
                                            </tr>
                                            <tr>
                                                <th>@lang('home.current') @lang('home.stock')</th>
                                                <td id="currentqty"> </td>
                                            </tr>
                                            <tr>
                                                <th>@lang('home.stock') @lang('home.unit')</th>
                                                <td id="unit"></td>
                                            </tr>
                                            <tr>
                                                <th>@lang('home.remark')</th>
                                                <td id="remark"></td>
                                            </tr>
                                            <tr>
                                                <th>@lang('home.status')</th>
                                                <td id="status"></td>
                                            </tr>
                                            <tr>
                                                <th>@lang('home.user')</th>
                                                <td id="user"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                            <!-- Start 2nd Tabs -->
                            <div class="tab-pane fade" id="connectedServices" role="tabpanel" aria-labelledby="ConnectedServices-tab">
                                <div class="container">
                                    <table class="table table-bordered" cellspacing="0" width="100%" id="purchasetable">
                                        <thead>
                                            <tr>
                                                <th> #Sl </th>
                                                <th> Purchase Code</th>
                                                <th> Date </th>
                                                <th> Supplier</th>
                                                <th> TP </th>
                                                <th> MRP </th>
                                                <th> Qty </th>
                                                <th> unit </th>
                                                <th> Amount </th>
                                                <th> Vat</th>
                                                <th> Discount</th>
                                                <th> Net Total</th>
                                                <th> Status</th>
                                                <th> Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th> #Sl </th>
                                                <th> Purchase Code</th>
                                                <th> Date </th>
                                                <th> Supplier</th>
                                                <th> TP </th>
                                                <th> MRP </th>
                                                <th> Qty </th>
                                                <th> unit </th>
                                                <th> Amount </th>
                                                <th> Vat</th>
                                                <th> Discount</th>
                                                <th> Net Total</th>
                                                <th> Status</th>
                                                <th> Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!-- end second tabs -->

                            <!-- Start 3rd Tabs -->
                            <div class="tab-pane fade" id="InvoiceHistory" role="tabpanel" aria-labelledby="InvoiceHistory-tab">
                                <div class="container">
                                    <table class="table table-bordered" cellspacing="0" width="100%" id="invoicetable">
                                        <thead>
                                            <tr>
                                                <th align="center"> #Sl </th>
                                                <th align="center"> Input Date </th>
                                                <th align="center">Invoice Code</th>
                                                <th align="center"> Customer </th>
                                                <th align="center"> TP </th>
                                                <th align="center"> MRP </th>
                                                <th align="center"> Qty </th>
                                                <th align="center"> unit </th>
                                                <th align="center"> Amount </th>
                                                <th align="center">Vat</th>
                                                <th align="center">Discount</th>
                                                <th align="center">Net Total</th>
                                                <th align="center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th align="center"> #Sl </th>
                                                <th align="center"> Input Date </th>
                                                <th align="center">Invoice Code</th>
                                                <th align="center"> Customer </th>
                                                <th align="center"> TP </th>
                                                <th align="center"> MRP </th>
                                                <th align="center"> Qty </th>
                                                <th align="center"> unit </th>
                                                <th align="center"> Amount </th>
                                                <th align="center">Vat</th>
                                                <th align="center">Discount</th>
                                                <th align="center">Net Total</th>
                                                <th align="center">Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>


                            </div>

                            <!-- end third tabs -->


                        </div>
                    </div>




                </div>



                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>


    @include('product.partials.productviewscript')

    @endsection