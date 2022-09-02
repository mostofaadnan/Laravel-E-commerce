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
            <div class="card-header card-header-section">Edit User</div>
            <form method="POST" action="{{ route('user.update',$user->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @include('user.partials.userformedit')
                </div>
                <div class="card-footer">

                    <button type="submit" class="btn btn-success">
                        Submit
                    </button>
            </form>
            <button class="btn btn-info" id="reset">
                Reset
            </button>

        </div>

    </div>
</div>
@endsection