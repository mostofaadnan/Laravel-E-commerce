@extends('layouts.master')
@section('content')
<style>
    .nav>li>a {

        padding: 13px 10px;
    }

    .nav-item a {
        color: #fff;
    }
    .searchnuv a {
        color:#000 !important;
    }
 
</style>
<div class="col-lg-12">
    <ul class="nav nav-tabs mb-2" id="myTabs" role="tablist">
        <li class="nav-item waves-effect waves-light searchnuv">
            <a class="nav-link navsearch active" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="true">@lang('home.invoice')</a>
        </li>
        <li class="nav-item waves-effect waves-light searchnuv">
            <a class="nav-link navsearch" id="card-tab" data-toggle="tab" href="#card" role="tab" aria-controls="card" aria-selected="false">@lang('home.item') @lang('home.search')</a>
        </li>
    </ul>
    <div class="tab-content" id="searchTabcontent">
        <div class="tab-pane fade active show" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            @include('invoice.partials.invoicefield')
        </div>
        <div class="tab-pane fade" id="card" role="tabpanel" aria-labelledby="card-tab">
            @include('section.itemsearch')
        </div>
    </div>
</div>


@include('invoice.partials.invcreatescript')
@include('section.modelsection')

@endsection