@extends('layouts.master')
@section('content')
<style>
    .image-container {
        position: relative;
    }

    .image {
        opacity: 1;
        display: block;
        width: 100%;
        height: auto;
        transition: .5s ease;
        backface-visibility: hidden;
    }

    .middle {
        transition: .5s ease;
        opacity: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        text-align: center;
    }

    .image-container:hover .image {
        opacity: 0.3;
    }

    .image-container:hover .middle {
        opacity: 1;
    }

    .my-custom-scrollbar {
        position: relative;
        height: 200px;
        overflow: auto;
    }

    .table-wrapper-scroll-y {
        display: block;
    }
</style>

<div class="row">
    <div class="col-sm-8 form-single-input-section">
        <div class="card">
            <div class="card-header card-header-section">
                <div class="row mb-3 mt-2">
                    <div class="col-sm-6">
                        @lang('home.user') @lang('home.profile')
                        <input type="hidden" id="userid" value="{{ Auth::user()->id }}">
                    </div>

                </div>
            </div>
            <div class="card-body">
                <div class="card-title mb-4">
                    <div class="d-flex justify-content-start">
                        <div class="image-container">
                            <img src="{{asset('storage/app/public/user/'.Auth::user()->image)}}" id="imgProfile" style="width: 150px; height: 150px" class="img-thumbnail" />
                            <div class="middle">
                                <input type="button" class="btn btn-secondary" id="btnChangePicture" value="Change" />
                                <input type="file" style="display: none;" id="profilePicture" name="file" />
                            </div>
                        </div>
                        <div class="ml-auto">
                            <input type="button" class="btn btn-primary d-none" id="btnDiscard" value="Discard Changes" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="basicInfo-tab" data-toggle="tab" href="#basicInfo" role="tab" aria-controls="basicInfo" aria-selected="true">Basic Info</a>
                            </li>

                        </ul>
                        <div class="tab-content ml-1" id="myTabContent">
                            <div class="tab-pane fade show active" id="basicInfo" role="tabpanel" aria-labelledby="basicInfo-tab">


                                <div class="row">
                                    <div class="col-sm-3 col-md-2 col-5">
                                        <label style="font-weight:bold;">Full Name</label>
                                    </div>
                                    <div class="col-md-8 col-6">
                                        {{ Auth::user()->name }}
                                    </div>
                                </div>
                                <hr />

                                <div class="row">
                                    <div class="col-sm-3 col-md-2 col-5">
                                        <label style="font-weight:bold;">Email</label>
                                    </div>
                                    <div class="col-md-8 col-6">
                                        {{ Auth::user()->email }}
                                    </div>
                                </div>
                                <hr />
                                <hr />
                                <div class="row">
                                    <div class="col-sm-3 col-md-2 col-5">
                                        <label style="font-weight:bold;">User Role</label>
                                    </div>
                                    <div class="col-md-8 col-6">

                                        {{ Auth::user()->roles()->pluck('name')->implode(' ') }}

                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-sm-3 col-md-2 col-5">
                                        <label style="font-weight:bold;">Permissions</label>
                                    </div>
                                    <div class="col-md-10 col-10">
                                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                            <table class="table table-bordered table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#SL</th>
                                                        <th>Description</th>
                                                    </tr>
                                                    <?php
                                                    $user = Auth::user();
                                                    foreach ($user->getAllPermissions() as $key => $permision) {
                                                    ?>
                                                        <tr>
                                                            <td>{{ $key+1 }}</td>
                                                            <td>{{ $permision->name }}</td>
                                                        </tr>
                                                    <?php } ?>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <hr />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $imgSrc = $('#imgProfile').attr('src');

        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#imgProfile').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        $('#btnChangePicture').on('click', function() {
            // document.getElementById('profilePicture').click();
            if (!$('#btnChangePicture').hasClass('changing')) {
                $('#profilePicture').click();
            } else {
                var name = document.getElementById("profilePicture").files[0].name;
                var form_data = new FormData();
                var ext = name.split('.').pop().toLowerCase();
                if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                    alert("Invalid Image File");
                }
                var oFReader = new FileReader();
                oFReader.readAsDataURL(document.getElementById("profilePicture").files[0]);
                var f = document.getElementById("profilePicture").files[0];
                var fsize = f.size || f.fileSize;
                if (fsize > 2000000) {
                    alert("Image File Size is very big");
                } else {
                    form_data.append("file", document.getElementById('profilePicture').files[0]);
                    $.ajax({
                        type: 'post',
                        url: "{{ url('Admin/UserProfile/ImageChange')}}",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(data) {
                            location.reload(true);
                            // console.log(data)
                        },
                        error: function(data) {
                            console.log(data)
                        }
                    });
                }
            }
        });
        $('#profilePicture').on('change', function() {
            readURL(this);
            $('#btnChangePicture').addClass('changing');
            $('#btnChangePicture').attr('value', 'Confirm');
            $('#btnDiscard').removeClass('d-none');
            // $('#imgProfile').attr('src', '');
        });
        $('#btnDiscard').on('click', function() {
            // if ($('#btnDiscard').hasClass('d-none')) {
            $('#btnChangePicture').removeClass('changing');
            $('#btnChangePicture').attr('value', 'Change');
            $('#btnDiscard').addClass('d-none');
            $('#imgProfile').attr('src', $imgSrc);
            $('#profilePicture').val('');
            // }
        });
    });


</script>
@endsection