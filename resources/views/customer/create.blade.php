@extends('layouts.master')
@section('content')
<style>
    .multi-select {
        height: 56px !important;
    }
</style>
<div class="col-lg-12">
    <div class="card">
    <div class="card-header card-header-section">
            @lang('home.new') @lang('home.customer') 
        </div>
        <div class="card-body">
            @include('customer.partials.customercreateform')
        </div>
        <div class="card-footer card-footer-section">
            <div class="pull-right">
                <button type="submit" class="btn btn-lg btn-primary btn-block">Save</button>
            </div>
            <div class="pull-right">
                <button class="btn btn-lg btn-secondary btn-block">Reset</button>
            </div>

        </div>
        </form>
    </div>
</div>


@include('customer.partials.cuscreatescript')
@endsection