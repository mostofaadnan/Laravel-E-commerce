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
                <form action="{{ route('sendmail.customerpaymentsend') }}" method="post">
                    <input type="hidden" name="paymentid" value="{{ $customerpayment->id }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">@lang('home.payment') @lang('home.number')</label>
                        <input type="text" class="form-control"  value="{{ $customerpayment->payment_no }}" placeholder="@lang('home.payment') @lang('home.number')" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">@lang('home.customer')</label>
                        <input type="text" class="form-control" name="client_name"  value="{{ $customerpayment->CustomerName->name }}" placeholder="@lang('home.customer')">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">@lang('home.email')</label>
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $customerpayment->CustomerName->email }}" placeholder="@lang('home.reciepents')">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">@lang('home.subject')</label>
                        <input type="text" class="form-control" name="subject"  value="Credit Payment" placeholder="@lang('home.subject')">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">@lang('home.message')</label>
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