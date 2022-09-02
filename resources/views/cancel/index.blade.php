@extends('layouts.master')
@section('content')

<div class="card">
    <style .input-group-text{width:auto;}></style>
    <div class="card-header card-header-section">
        <div class="pull-left">
            @lang('home.invoice') @lang('home.cancel')
        </div>
    </div>
    <div class="card-body">
        <div class="row  mt-2">
            <div class="col-sm-3  mb-2">
            </div>
            <div class="col-sm-9 mb-2">
                @include('section.dateBetween')
            </div>
            <div class="divider"></div>
        </div>
     
        <table id="mytable" class="table table-bordered select" style="width:100%" cellspacing="0">
            <thead>
                <tr>
                    <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                    <!-- <th> #@lang('home.sl') </th> -->
                    <th> @lang('home.invoice') @lang('home.no') </th>
                    <th> @lang('home.date') </th>
                    <th> @lang('home.customer') </th>
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
                    <th> </th>
                    <th> @lang('home.invoice') @lang('home.no') </th>
                    <th> @lang('home.date') </th>
                    <th> @lang('home.customer') </th>
                    <th> @lang('home.nettotal')</th>
                    <th> @lang('home.payment') @lang('home.type')</th>
                    <th> @lang('home.user')</th>
                    <th> @lang('home.action')</th>
                </tr>
            </tfoot>
        </table>
     

    </div>
</div>

@include('cancel.invcancelindexscript')
@endsection