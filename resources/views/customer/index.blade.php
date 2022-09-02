@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header card-header-section">
        <div class="pull-left">
            @lang('home.customer') @lang('home.management')
        </div>
        <!--
        <div class="pull-right">
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group" role="group" aria-label="First group">
                    <a type="button" class="btn btn-outline-danger" href="{{Route('customer.create')}}"><i class="fa fa-plus" aria-hidden="true">@lang('home.new') @lang('home.customer')</i>
                    </a>
                </div>
            </div>
        </div>
        -->
    </div>
    <div class="card-body">
        @include('partials.ErrorMessage')
        <table class="table table-bordered" cellspacing="0" id="mytable" width="100%">
            <thead>
                <tr>
                    <th> #@lang('home.sl') </th>
                    <th> @lang('home.id') </th>
                    <th> @lang('home.name') </th>
                    <th> @lang('home.mobile') @lang('home.no')</th>
                    <th> @lang('home.cash') @lang('home.invoice') </th>
                    <th> @lang('home.credit') @lang('home.invoice') </th>
                    <th> @lang('home.consignment') </th>
                    <th> @lang('home.discount') </th>
                    <th> @lang('home.credit') @lang('home.payment')</th>
                    <th> @lang('home.netpayment')</th>
                    <th> @lang('home.balancedue')</th>
                    <th> @lang('home.status')</th>
                    <th> @lang('home.action')</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th> #@lang('home.sl') </th>
                    <th> @lang('home.id') </th>
                    <th> @lang('home.name') </th>
                    <th> @lang('home.mobile') @lang('home.no')</th>
                    <th> @lang('home.cash') @lang('home.invoice') </th>
                    <th> @lang('home.credit') @lang('home.invoice') </th>
                    <th> @lang('home.consignment') </th>
                    <th> @lang('home.discount') </th>
                    <th> @lang('home.credit') @lang('home.payment')</th>
                    <th> @lang('home.netpayment')</th>
                    <th> @lang('home.balancedue')</th>
                    <th> @lang('home.status')</th>
                    <th> @lang('home.action')</th>
                </tr>
            </tfoot>
        </table>

    </div>
</div>
@include('customer.partials.cusindexscript')
@endsection