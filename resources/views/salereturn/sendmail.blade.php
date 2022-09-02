@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-sm-8 form-single-input-section">
        <div class="card">
            <div class="card-header card-header-section">
                <div class="pull-left">
                    @lang('home.send') @lang('home.mail')
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('sendmail.salereturnsend') }}" method="post">
                    <input type="hidden" name="returnid" value="{{ $SaleReturn->id }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Return No</label>
                        <input type="text" class="form-control" aria-describedby="emailHelp" value="{{ $SaleReturn->return_no }}" placeholder="return no" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Customer</label>
                        <input type="text" class="form-control" name="client_name" aria-describedby="emailHelp" value="{{ $SaleReturn->CustomerName->name }}" placeholder="Customer">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $SaleReturn->CustomerName->email }}" placeholder="Recipients">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Subject</label>
                        <input type="text" class="form-control" name="subject" aria-describedby="emailHelp" value="Sale Return" placeholder="Subject">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Message</label>
                        <textarea name="message" rows="5" cols="40" class="form-control"></textarea>
                    </div>
            </div>
            <div class="card-footer">
                <div class="pull-right">
                    <button type="submit" class="btn btn-lg btn-primary btn-block">@lang('home.submit')</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection