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
                @include('partials.ErrorMessage')
                <form action="{{ route('sendmail.documentsend') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">@lang("home.name")</label>
                        <input type="text" class="form-control" name="client_name" placeholder="@lang('home.reciepients') @lang('home.name')">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">@lang('home.email')</label>
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="@lang('home.email')" require>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">@lang('home.subject')</label>
                        <input type="text" class="form-control" name="subject" value="Credit Payment" placeholder="@lang('home.subject')">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">@lang('home.message')</label>
                        <textarea name="message" rows="5" cols="40" class="form-control" placeholder="@lang('home.message')"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">@lang('home.document')</label>
                        <input type="file" name="files[]" accept="file_extension|image/*|media_type" multiple>
                    </div>
            </div>
            <div class="card-footer">
                <div class="pull-right">
                    <button type="submit" class="btn btn-lg btn-primary btn-block">@lang('home.send')</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection