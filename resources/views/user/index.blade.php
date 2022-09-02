@extends('layouts.master')
@section('content')

<div class="card">
    <style .input-group-text{width:auto;}></style>
    <div class="card-header card-header-section">
        <div class="pull-left">
            @lang('home.user') @lang('home.management')
        </div>
        <div class="pull-right">
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group" role="group" aria-label="First group">
                    <a type="button" class="btn btn-outline-danger" href="{{Route('user.create')}}">@lang('home.new') @lang('home.user')</i>
                    </a>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('user.partials.userTable')
    </div>
</div>
@include('user.partials.userregisterscript')
@endsection