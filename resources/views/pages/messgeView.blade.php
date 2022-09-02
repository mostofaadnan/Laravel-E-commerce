@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header card-header-section">
        <div class="row">
            <div class="col-8 col-sm-4 col-md-4">
                <h5>Message</h5>
            </div>
            <div class="col-4 col-sm-8">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @lang('home.action')
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ route('page.contactus') }}" class="nav-link">@lang('home.message') @lang('home.list')</a>
                        <div class="dropdown-divider"></div>
                        <a id="deletedata" class="nav-link">@lang("home.delete")</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-sm-4">
                <ul>
                    <li>
                        <p><b>Name:</b>{{ $message->name }}</p>
                    </li>
                    <li>
                        <p><b>Email:</b>{{ $message->email }}</p>
                    </li>
                    <li>
                        <p><b>Subject:</b>{{ $message->subject }}</p>
                    </li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-12">
                {{ $message->message }}
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="exampleInputPassword2" class="col-form-label"><b>@lang('home.reply')</b></label>
                    <textarea name="description" class="form-control" id="description" name="categorydescription" cols="30" rows="8" placeholder="@lang('home.description')"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer card-footer-section">
        <div class="pull-right">
            <div class="btn-group button-grp" role="group" aria-label="Basic example">
                <button type="submit" id="recievedOrder" class="btn btn-success btn-lg">@lang('home.submit')</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '#deletedata', function() {
        swal({
                title: "Are you sure?",
                text: "Once Cancel, you will not be able to recover this  data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var id = "{{ $message->id }}";
                    $.ajax({
                        type: "post",
                        url: "{{ url('Admin/contactusdelete')}}" + '/' + id,
                        success: function(data) {
                            url = "{{ route('page.contactus')}}",
                                window.location = url;
                        },
                        error: function(data) {
                            console.log(data);
                            swal("Opps! Faild", "Data Fail to Cancel", "error");
                        }
                    });
                    swal("Ok! Your file has been cancelled!", {
                        icon: "success",
                    });
                } else {
                    swal("Your file is safe!");
                }
            });
    });
</script>
@endsection