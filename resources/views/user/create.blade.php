@extends('layouts.master')
@section('content')
<style>
    .user-panel {
        box-shadow: none;
    }
</style>
<div class="row">
    <div class="col-sm-8 form-single-input-section">
        <div class="card user-panel">
            <div class="card-header card-header-section">@lang('home.new') @lang('home.user')</div>
            <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @include('user.partials.userform')
                </div>
                <div class="card-footer">

                    <button type="submit" class="btn btn-success">
                        @lang('home.submit')
                    </button>
            </form>
            <button class="btn btn-info" id="reset">
                @lang('home.reset')
            </button>

        </div>

    </div>
</div>
@endsection