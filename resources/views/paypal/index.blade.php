@extends('layouts.master')
@section('content')

<div class="card">
    <style .input-group-text{width:auto;}></style>
    <div class="card-header card-header-section">
        <div class="pull-left">
            @lang('home.paypal') @lang('home.description')
        </div>
        <div class="pull-right">
            <label id="balance"></label>
            <!--  <div class="input-group">
                <div class="input-group-prepend" style="background-color: transparent !important;">
                    <span class="input-group-text">Prasent Balance</span>
                </div>
                <input type="text" class="form-control sum-section" id="balance" placeholder="nettotal" value="0" readonly>
            </div> -->

        </div>
    </div>
    <div class="card-body">
        <div class="row ">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-9">
                @include('section.dateBetween')
                <!-- https://w3alert.com/laravel-tutorial/laravel-datatables-custom-search-filter-example-tutorial -->
            </div>

            <div class="divider"></div>
        </div>
        <table id="mytable" class="table table-bordered" style="width:100%" cellspacing="0">
            <thead>
                <tr>
                    <th> #@lang('home.sl') </th>
                    <th> @lang('home.date') </th>
                    <th> @lang('home.description') </th>
                    <th> @lang('home.amount') </th>
                    <th> @lang('home.token') </th>
                    <th> @lang('home.payerid') </th>
                    <th> @lang('home.currency')</th>
               
                    <th> @lang('home.user')</th>
                    <th> @lang('home.action')</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th> #@lang('home.sl') </th>
                    <th> @lang('home.date') </th>
                    <th> @lang('home.description') </th>
                    <th> @lang('home.amount') </th>
                    <th> @lang('home.token') </th>
                    <th> @lang('home.payerid') </th>
                    <th> @lang('home.currency')</th>
                  
                    <th> @lang('home.user')</th>
                    <th> @lang('home.action')</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@include('paypal.partials.paypalindexscript')
@endsection