@extends('layouts.master')
@section('content')

<div class="card">
    <style .input-group-text{width:auto;}></style>
    <div class="card-header card-header-section">
        <div class="pull-left">
            @lang('home.bank') @lang('home.transection')
        </div>
        <div class="pull-right">
            <label id="balance"></label>
        </div>
    </div>
    <div class="card-body">
        <div class="row ">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-9">
                @include('section.dateBetween')
            </div>
            <div class="divider"></div>
        </div>
        <table id="mytable" class="table table-bordered" style="width:100%" cellspacing="0">
            <thead>
                <tr>
                    <th> #@lang('home.sl') </th>
                    <th> @lang('home.date') </th>
                    <th> @lang('home.description')</th>
                    <th> @lang('home.cashin') </th>
                    <th> @lang('home.cashout') </th>
                    <th> @lang('home.balance')</th>
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
                    <th> @lang('home.cashin') </th>
                    <th> @lang('home.cashout') </th>
                    <th> @lang('home.balance')</th>
                    <th> @lang('home.user')</th>
                    <th> @lang('home.action')</th>
                </tr>
            </tfoot>
        </table>

    </div>


</div>
@include('bank.partials.bankindexscripts')
@endsection