@extends('layouts.master')
@section('content')

<div class="card">
    <style .input-group-text{width:auto;}></style>
    <div class="card-header card-header-section">
        <div class="pull-left">
            @lang('home.vat')/@lang('home.tax') @lang('home.collection')
        </div>
        <div class="pull-right">
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group" role="group" aria-label="First group">
                    <a type="button" class="btn btn-outline-danger" href="{{Route('vatcollection.create')}}"> @lang('home.new')  @lang('home.collection')</i>
                    </a>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="divider"></div>
        <table id="mytable" class="table table-bordered" width="100%">
            <thead>
                <tr>
                    <th>#@lang('home.sl') </th>
                    <th>@lang('home.collection') @lang('home.no') </th>
                    <th>@lang('home.date')</th>
                    <th>@lang('home.from')</th>
                    <th>@lang('home.to')</th>
                    <th>@lang('home.description')</th>
                    <th>@lang('home.amount')</th>
                    <th>@lang('home.user')</th>
                    <th>@lang('home.action')</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr>
                    <th>#@lang('home.sl') </th>
                    <th>@lang('home.collection') @lang('home.no') </th>
                    <th>@lang('home.date')</th>
                    <th>@lang('home.from')</th>
                    <th>@lang('home.to')</th>
                    <th>@lang('home.description')</th>
                    <th>@lang('home.amount')</th>
                    <th>@lang('home.user')</th>
                    <th>@lang('home.action')</th>
                </tr>
            </tfoot>
        </table>

    </div>


</div>

@include('vatCollection.partials.vatcollectionindexscript')
@endsection