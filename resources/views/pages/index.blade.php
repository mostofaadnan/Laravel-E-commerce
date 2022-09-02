@extends('layouts.master')
@section('content')
<style>
  .inside-card {
    box-shadow: none;
  }

  .label-chart {
    border: 1px #ccc solid;
  }
</style>
<div class="card">
  <div class="card-header">
    <div class="pull-right">
      <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" id="today" class="btn btn-dark active">@lang('home.today')</button>
        <button type="button" id="sevenday" class="btn btn-dark">@lang('home.last') @lang('home.7') @lang('home.days')</button>
        <button type="button" id="thismonth" class="btn btn-dark">@lang('home.this') @lang('home.month')</button>
        <button type="button" id="thisyear" class="btn btn-dark">@lang('home.this') @lang('home.year')</button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-sm-2  tile_stats_count">
        <div class="card">
          <div class="card-header card-header-section">
            <span class="count_top"> @lang('home.order')</span>
          </div>
          <div class="card-body count-box">
            <div class="count red" id="order"></div>
          </div>
        </div>
      </div>
      <div class="col-sm-2  tile_stats_count">
        <div class="card">
          <div class="card-header card-header-section">
            <span class="count_top"> @lang('home.cash') @lang('home.invoice')</span>
          </div>
          <div class="card-body count-box">
            <div class="count red" id="invoice"></div>
          </div>
        </div>
      </div>
      <div class="col-sm-2 tile_stats_count">
        <div class="card">
          <div class="card-header card-header-section">
            <span class="count_top">@lang('home.purchase')</span>
          </div>
          <div class="card-body count-box">
            <div class="count green" id="purchase"></div>
          </div>
        </div>
      </div>
      <div class="col-sm-2  tile_stats_count">
        <div class="card">
          <div class="card-header card-header-section">
            <span class="count_top"> @lang('home.payment')</span>
          </div>
          <div class="card-body count-box">
            <div class="count green" id="ppayment"></div>
          </div>
        </div>
      </div>

      <div class=" col-sm-2  tile_stats_count">
        <div class="card">
          <div class="card-header card-header-section">
            <span class="count_top"> @lang('home.credit') @lang('home.payment')</span>
          </div>
          <div class="card-body count-box">
            <div class="count red" id="cpayment"></div>
          </div>
        </div>
      </div>

      <div class=" col-sm-2  tile_stats_count">
        <div class="card">
          <div class="card-header card-header-section">
            <span class="count_top"> @lang('home.cash') @lang('home.drawer')</span>
          </div>
          <div class="card-body count-box">
            <div class="count green" id="cdrawer"></div>
          </div>
        </div>
      </div>

      <div class=" col-sm-2  tile_stats_count">
        <div class="card">
          <div class="card-header card-header-section">
            <span class="count_top"> @lang('home.expenses')</span>
          </div>
          <div class="card-body count-box">
            <div class="count red" id="expencess"></div>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-sm-12">

        <div class="card">
          <div class="card-header">
            <h4>Recent New Order</h4>
          </div>
          <div class="card-body">
            <table id="orderTable" class="table table-bordered" style="width:100%" cellspacing="0">
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
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="card label-chart">
          <div class="card-header">
            <div class="pull-left">
              @lang('home.order')
            </div>
            <div class="pull-right">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <select class="form-control charttype4">
                    <option value="1">Bar</option>
                    <option value="2">Line</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <select class="form-control orderyear">
                    <?php
                    $currently_selected = date('Y');
                    for ($i = 2020; $i <= 2050; $i++) {
                      echo '<option value=' . $i . ' ' . ($i === $currently_selected ? ' selected="selected"' : '') . '>' . $i . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            {!! $orderchart->container() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{!! $orderchart->script() !!}
@include('pages.partials.homescript')
@include('pages.partials.chartscript')
@endsection