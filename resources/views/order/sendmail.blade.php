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
                <form action="{{ route('sendmail.invoicesend') }}" method="post">
                    <input type="hidden" name="invoiceid" value="{{ $invoice->id }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">@lang('home.invoice') @lang('home.number')</label>
                        <input type="text" class="form-control" aria-describedby="emailHelp" value="{{ $invoice->invoice_no }}" placeholder="@lang('home.invoice') @lang('home.number')" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">@lang('home.customer')</label>
                        <input type="text" class="form-control" name="client_name" aria-describedby="emailHelp" value="{{ $invoice->CustomerName->name }}" placeholder="@lang('home.customer')">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">@lang('home.email')</label>
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $invoice->CustomerName->email }}" placeholder="@lang('home.recipient')">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">@lang('home.subject')</label>
                        <input type="text" class="form-control" name="subject" aria-describedby="emailHelp" value="Invoice" placeholder="@lang('home.subject')">
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
<!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript">
    tinymce.init({
        selector: 'textarea.tinymce-editor',
        height: 300,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
        content_css: '//www.tiny.cloud/css/codepen.min.css'
    });
</script> -->
@endsection