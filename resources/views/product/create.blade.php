@extends('layouts.master')
@section('content')
<style>
  .btn-group {
    border: none;
  }
</style>
<div class="row">
  <div class="col-sm-10 form-single-input-section">
    <div class="card card-design">
      <div class="card-header card-header-section">
        <div class="row mb-3 mt-2">
          <div class="col-sm-8">
            @lang('home.new') @lang('home.item')
          </div>
          <div class="col-sm-4">
           <!--
            <input type="text" class="form-control" id="search" placeholder=" @lang('home.search')" list="product" autocomplete="off">
            <datalist id="product">
            </datalist>
            -->
          </div>
        </div>
      </div>
      <div class="card-body form-div">
        <div class="container">
          @include('partials.ErrorMessage')
          <div class="row">
            <div class="col-sm-8">
              <div class="tab-pane fade active show" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                @include('product.partials.inputForm')
              </div>
            </div>
            <div class="col-md-4" style="margin-left: auto;margin-right: auto;">
              @include('product.partials.profilePicture')
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              @include('product.partials.texteditor')
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-12">
              @include('product.partials.multipleImageUpload')
            </div>
          </div>
        </div>
      </div>

      <div class="card-footer  card-footer-section">
        <div class="pull-right">
          <div class="btn-group" role="group" aria-label="Basic example">
            <button type="submit" id="datainsert" class="btn btn-success btn-lg"> @lang('home.submit')</button>
            <button id="reset" class="btn btn-light clear_field btn-lg"> @lang('home.reset')</button>
            <button id="deletedata" class="btn btn-danger btn-lg"> @lang('home.delete')</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@include('product.partials.productcreatescripts');


@endsection