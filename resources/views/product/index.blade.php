@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header card-header-section">
        <div class="pull-left">
            @lang('home.item') @lang('home.management')
        </div>
        <div class="pull-right">
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group" role="group" aria-label="First group">
                    <a type="button" class="btn btn-outline-success" href="{{Route('product.create')}}"><i class="fa fa-plus" aria-hidden="true"> @lang('home.new') @lang('home.item')</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs mt-2" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="basicInfo-tab" data-toggle="tab" href="#basicInfo" role="tab" aria-controls="basicInfo" aria-selected="true">@lang('home.list')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="connectedServices-tab" data-toggle="tab" href="#connectedServices" role="tab" aria-controls="connectedServices" aria-selected="false">@lang('home.Gird')</a>
            </li>
            </li>
        </ul>
        <div class="tab-content ml-1" id="myTabContent">
            <div class="tab-pane fade show active" id="basicInfo" role="tabpanel" aria-labelledby="basicInfo-tab" style="padding-top:10px;">
                @include('product.partials.productTable')
            </div>
            <div class="tab-pane fade" id="connectedServices" role="tabpanel" aria-labelledby="ConnectedServices-tab">
                @include('product.partials.productGirdView')
            </div>
        </div>
    </div>
</div>
@include('product.partials.productindexscript')

@endsection