@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-sm-10 form-single-input-section ">
        <div class="card card-design">
            <div class="card-header card-header-section">
                <h5 align="center"> @lang('home.company') @lang('home.information')</h5>
            </div>
            <div class="card-body form-div">
            @include('partials.ErrorMessage')
            <form action="{{ route('company.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="container">
                    @include('company.companyform')
                </div>
            </div>

            <div class="card-footer  card-footer-section">
                <div class="pull-right">
                
                    <button type="submit" id="" class="btn btn-success btn-lg">@lang('home.save')</button>
                </div>
               

            </div>
            </form>
        </div>

    </div>

</div>

@include('company.companyscript');

</script>

@endsection