@extends('layouts.master')
@section('content')

<div class="card">
    <style .input-group-text{width:auto;}></style>
    <div class="card-header card-header-section">
        <div class="pull-left">
            @lang('home.bank') @lang('home.desctiption')
        </div>
        <div class="pull-right">
         
        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
        <div class="btn-group" role="group" aria-label="First group">
          <a type="button" class="btn btn-outline-danger" href="{{Route('cards.StripeBalancseHistry')}}">@lang('home.stripe') @lang('home.history')</i>
          </a>
       
        </div>
      </div>

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
                    <th> @lang('home.cashin') </th>
                    <th> @lang('home.cashout') </th>
                    <th> @lang('home.balance')</th>
                    <th> @lang('home.description') </th>
                    <th> @lang('home.stripe') @lang('home.id')</th>
                    <th> @lang('home.card') @lang('home.on') @lang('home.name')</th>
                    <th> @lang('home.brand')</th>
                    <th> @lang('home.country')</th>
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
                    <th> @lang('home.cashin') </th>
                    <th> @lang('home.cashout') </th>
                    <th> @lang('home.balance')</th>
                    <th> @lang('home.description') </th>
                    <th> @lang('home.stripe') @lang('home.id')</th>
                    <th> @lang('home.card') @lang('home.on') @lang('home.name')</th>
                    <th> @lang('home.brand')</th>
                    <th> @lang('home.country')</th>
                    <th> @lang('home.user')</th>
                    <th> @lang('home.action')</th>
                </tr>
            </tfoot>
        </table>

    </div>


</div>
@include('card.partials.cardindexscript')
@endsection