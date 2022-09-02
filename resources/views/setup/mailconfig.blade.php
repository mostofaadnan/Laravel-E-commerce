@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-sm-8 form-single-input-section">
        <div class="card card-design">
            <div class="card-header card-header-section">
                @lang('home.mail') @lang('home.configuration')
            </div>
            <div class="card-body">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-4">
                        <label for="inputGroupSelect01">@lang('home.name') </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="name" placeholder="@lang('home.name')" require>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-4">
                        <label for="inputGroupSelect01">@lang('home.driver') </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="driver" placeholder="@lang('home.driver')" require>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-4">
                        <label for="inputGroupSelect01">@lang('home.host') </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="host" placeholder="@lang('home.host')" require>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-4">
                        <label for="inputGroupSelect01">@lang('home.port') </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="port" placeholder="@lang('home.port')" require>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-4">
                        <label for="inputGroupSelect01">@lang('home.username') </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="username" placeholder="@lang('home.username')" require>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-4">
                        <label for="inputGroupSelect01">@lang('home.password') </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="password" placeholder="@lang('home.password')" require>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-4">
                        <label for="inputGroupSelect01">@lang('home.encryption') </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="encryption" placeholder="@lang('home.encryption')" require>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-4">
                        <label for="inputGroupSelect01">@lang('home.email') @lang('home.address') </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="email" class="form-control" id="dataemail" placeholder="@lang('home.email') @lang('home.address')" require>
                    </div>
                </div>

            </div>

            <div class="card-footer  card-footer-section">
                <div class="pull-right">
                    <button type="submit" id="datainsert" class="btn btn-danger"> @lang('home.save') @lang('home.change')</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function loadData() {
        $.ajax({
            type: 'GET',
            url: "{{ route('mailconfig.getdata') }}",
            success: function(data) {
                $("#name").val(data.name);
                $("#driver").val(data.driver);
                $("#host").val(data.host);
                $("#port").val(data.port);
                $("#username").val(data.username);
                $("#password").val(data.password);
                $("#encryption").val(data.encryption);
                $("#dataemail").val(data.email)
            }

        });
    }
    window.onload = loadData();

    $("#datainsert").on('click', function() {
        $("#overlay").fadeIn();
        var name = $("#name").val();
        var driver = $("#driver").val();
        var host = $("#host").val();
        var port = $("#port").val();
        var username = $("#username").val();
        var password = $("#password").val();
        var encryption = $("#encryption").val();
        var dataemail = $("#dataemail").val();
        $.ajax({
            type: 'POST',
            url: "{{ route('mailconfig.store') }}",
            data: {
                name: name,
                driver: driver,
                host: host,
                port: port,
                username: username,
                password: password,
                encryption: encryption,
                email: dataemail
            },
            success: function(data) {
                $("#overlay").fadeOut();
                if ($.isEmptyObject(data.error)) {
                    swal("Data Submit", "Data successfully Submited", "success");
                    loadData();
                } 

            },
            error: function(data) {
                $("#overlay").fadeOut();
                swal("Data Submit Fail", "Data Submited Fail Due to form Validation", "error");
            }

        });
    });

    function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $.each(msg, function(key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
        });
    }
</script>
@endsection