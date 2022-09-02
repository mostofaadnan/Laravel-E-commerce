@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header card-header-section">
        <div class="pull-left">
        @lang('home.stock') @lang('home.management')
        </div>
     
    </div>
    <div class="card-body">
        @include('stockmanage.TableInfo')
    </div>
    <!--    <div class="card-footer">

    </div> -->

</div>
@endsection