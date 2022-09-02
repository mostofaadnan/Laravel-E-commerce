@extends('layouts.master')
@section('content')
<style>
    .table td {
        padding: 1px !important;
        padding-bottom: 1px !important;
    }
</style>
<div class="card">
    <style .input-group-text{width:auto;}></style>
    <div class="card-header card-header-section">
        <div class="pull-left">
            @lang('home.order') @lang('home.management')
        </div>
    </div>
    <div class="card-body">
        <div class="row  mt-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                @include('section.dateBetween')
            </div>
            <div class="divider"></div>
        </div>
        <table id="mytable" class="table table-bordered" style="width:100%" cellspacing="0">
            <thead>
                <tr>

                    <th> #@lang('home.sl') </th>
                    <th> @lang('home.invoice') @lang('home.no') </th>
                    <th> @lang('home.date') </th>
                    <th> @lang('home.customer') </th>
                    <th> @lang('home.nettotal')</th>
                    <th> @lang('home.payment') @lang('home.type')</th>
                    <th> @lang('home.status')</th>
                    <th> @lang('home.action')</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
   <th> #@lang('home.sl') </th>
                    <th> @lang('home.invoice') @lang('home.no') </th>
                    <th> @lang('home.date') </th>
                    <th> @lang('home.customer') </th>
                    <th> @lang('home.nettotal')</th>
                    <th> @lang('home.payment') @lang('home.type')</th>
                    <th> @lang('home.status')</th>
                    <th> @lang('home.action')</th>
                </tr>
            </tfoot>
        </table>


    </div>
</div>

@include('order.partials.invindexscript')
@endsection