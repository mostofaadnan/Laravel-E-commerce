@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-sm-7 form-single-input-section ">
    <div class="card card-design">
      <div class="card-header card-header-section">
        <div class="row mb-3 mt-2">
          <div class="col-sm-6">
            @lang('home.new') @lang('home.credit') @lang('home.payment')
          </div>
          <div class="col-sm-6">
          </div>
        </div>
      </div>
      <div class="card-body form-div">
        <div class="mb-2"></div>
        <div class="container">
          @include('partials.ErrorMessage')
          @include('customerpaymentrecive.partials.customerpaymentform')
        </div>
      </div>
      <div class="card-footer  card-footer-section">
        <div class="pull-right">
          <div class="btn-group button-grp" role="group" aria-label="Basic example">
            <button type="submit" id="datasubmit" class="btn btn-success btn-lg">@lang('home.submit')</button>
            <button id="reset" class="btn btn-light clear_field btn-lg">@lang('home.reset')</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('customerpaymentrecive.partials.customerpcreatescript');
@endsection