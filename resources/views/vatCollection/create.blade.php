@extends('layouts.master')
@section('content')
<style>
    .full-height {
        height: 100%;
    }

    .footer {
        margin: auto;
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: #001f3f !important;
        color: white;
        /* text-align: center; */
        z-index: 9999;
    }

    .section-card-body {
        margin-top: 40px;
    }

    .sum-section {

        font-style: bold;
        color: #fff;

    }

    .btn-rounded {
        border-radius: 10em;
    }

    .btn-danger {
        background-color: #ff3547;
        color: #fff;
    }

    .btn-light {
        color: #000 !important;

    }

    .btn-submit {

        margin: .375rem;
        color: inherit;
        text-transform: uppercase;
        word-wrap: break-word;
        white-space: normal;
        cursor: pointer;
        border: 0;
        border-radius: .125rem;
        -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        -webkit-transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        padding: .84rem 2.14rem;
        font-size: .81rem;

    }
</style>
<div class="col-lg-12">
    <div class="card card-design">
        <div class="card-header card-header-section">
            <div class="card-title">
                <h5 style="color:#fff;">@lang('home.new') @lang('home.vat')/@lang('home.tax') @lang('home.collection')</h5>
            </div>
            @include('section.vatcollectionsection')
        </div>
        <div class="card-body fixed_header">
            <table class="data-table table table-striped table-bordered table-sm table-responsive" style="height:400px;" id="invoicetable">
                <thead>
                    <tr>
                        <th classalign='center' width="5%"> #@lang('home.sl') </th>
                        <th align='center' width="10%"> @lang('home.invoice') @lang('home.no') </th>
                        <th align='center' width="10%">@lang('home.date')</th>
                        <th align='center' width="10%"> @lang('home.amount') </th>
                        <th align='center' width="10%"> @lang('home.discount')</th>
                        <th align='center' width="10%"> @lang('home.vat')</th>
                        <th align='center' width="10%"> @lang('home.nettotal') </th>
                    </tr>
                </thead>

                <tbody id="datatablebody">
                </tbody>

                <tfoot>
                    <tr>
                        <th class="text-right" colspan="5"> @lang('home.netvat')</th>
                        <th class="text-right" id="vat"> 0 </th>
                        <th align='center'></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footer sum-section">
            <div class="pull-right button-section">
                <button type="button" id="submittData" class="btn btn-lg btn-submit btn-rounded btn-danger" name="button">@lang('home.submit')</button>
                <button type="button" id="resteBtn" class="btn btn-lg btn-light btn-submit btn-rounded" name="button">@lang('home.reset')</button>
            </div>
        </div>
    </div>
</div>

<!-- @include('purchase.partials.sumfootersection') -->

@include('vatCollection.partials.VatcolleCtioncreateScript')
@endsection