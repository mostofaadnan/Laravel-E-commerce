@extends('layouts.master')
@section('content')
<style>
    .card {
        border: 1px #ccc solid;

    }

    .mainpanel {
        border: none;
    }
</style>

<div class="col-lg-12">
    <div class="card mainpanel">
        <div class="card-header card-header-section">
            @lang('home.slider') @lang('home.management')
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header card-header-section">
                            <div class="pull-left">
                                @lang('home.new') @lang('home.slider')
                            </div>
                        </div>
                        <div class="card-body">
                            @include('slider.sliderPicture')
                            <div class="form-group">
                                <label for="exampleInputPassword2" class="col-form-label">@lang('home.title')</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="@lang('home.title')">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2" class="col-form-label">@lang('home.category')</label>
                                <select id="categoryid" name="categoryid" class="form-control">
                                    <option value="0">Select Category</option>
                                    @foreach($category as $cat)
                                    <option value="{{$cat->title}}">{{ $cat->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2" class="col-form-label">@lang('home.name')</label>
                                <textarea name="description" class="form-control" id="description" cols="30" rows="2" placeholder="@lang('home.description')"> </textarea>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2" class="col-form-label">@lang('home.status')</label>
                                <select name="status" class="form-control" id="status">
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                            </div>
                            <div class="card-footer card-footer-section">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="submit" id="datainsert" class="btn btn-danger btn-lg">@lang('home.submit')</button>
                                    <button id="reset" class="btn btn-success">@lang('home.reset')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-header card-header-section">
                            @lang('home.subcategory') @lang('home.list')
                        </div>
                        <div class="card-body">
                            <table id="mytable" class="table table-bordered" style="width:100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th> #@lang('home.sl') </th>
                                        <th> @lang('home.name') </th>
                                        <th> @lang('home.category') </th>
                                        <th> @lang('home.status')</th>
                                        <th> @lang('home.description') </th>
                                        <th>@lang('home.action')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th> #@lang('home.sl') </th>
                                        <th> @lang('home.name') </th>
                                        <th> @lang('home.category') </th>
                                        <th> @lang('home.status')</th>
                                        <th> @lang('home.description') </th>
                                        <th>@lang('home.action')</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Image Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" id="imagepreview" style="width: 100%;">
            </div>
        </div>
    </div>
</div>
<script type='text/javascript'>
    var table;
    var sliderid = 0;

    function DataTable() {
        table = $('#mytable').DataTable({
            responsive: true,
            paging: true,
            scrollY: 295,
            ordering: true,
            searching: true,
            colReorder: true,
            keys: true,
            processing: true,
            serverSide: true,

            dom: "<'row'<'col-sm-3'l><'col-sm-2 text-center'B><'col-sm-7'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [{
                text: '<i class="fa fa-refresh"></i>@lang("home.refresh")',
                action: function() {
                    table.ajax.reload();
                },
                className: 'btn btn-info',
            }, ],
            "ajax": {
                "url": "{{ route('slider.loadall') }}",
                "type": "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: "text-center"
                },
                {
                    data: 'title',
                    name: 'title',

                },
                {
                    data: 'category',
                    name: 'category',

                },
                {
                    data: 'status',
                    name: 'status',

                },
                {
                    data: 'remark',
                    name: 'remark',

                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },

            ],
        });
    }
    window.onload = DataTable();

    $('#datainsert').on('click', function() {

        //$("#profilePicture").html('<span class="spinner-border spinner-border-sm"></span>');

        var title = $("#title").val();
        var category = $("#categoryid").val();
        var description = $("#description").val();
        var status = $("#status").val();
        var form_data = new FormData();
        //var ext = name.split('.').pop().toLowerCase();
        /*
         if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'jfif']) == -1) {
             alert("Invalid Image File");
         }

         */


        if (title == "" || category == "0" || description == "" || $(".imagename").val() == "") {

            swal("Fill the All Information", "Form Submited", "error");

        } else {
            var ImageURL = document.getElementById("img-upload").src;
            var block = ImageURL.split(";");
            var contentType = block[0].split(":")[1]; // In this case "image/gif"
            var realData = block[1].split(",")[1]; // In this case "R0lGODlhPQBEAPeoAJosM...."
            var blob = b64toBlob(realData, contentType);
            form_data.append("id", sliderid);
            form_data.append("file", blob);
            form_data.append("title", title);
            form_data.append("category", category);
            form_data.append("description", description);
            form_data.append("status", status);
            $("#overlay").fadeIn();
            if (sliderid > 0) {
                //update
                $.ajax({
                    type: 'post',
                    url: "{{ route('slider.update')}}",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        $("#overlay").fadeOut();
                        swal("Data Update Successfully", "Form Submited", "success");
                        clear();
                        table.ajax.reload();

                    },
                    error: function(data) {
                        $("#overlay").fadeOut();
                        console.log(data)
                    }
                });
            } else {
                $.ajax({
                    type: 'post',
                    url: "{{ route('slider.store')}}",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        $("#overlay").fadeOut();
                        swal("Data Inserted Successfully", "Form Submited", "success");
                        clear();
                        table.ajax.reload();

                    },
                    error: function(data) {
                        $("#overlay").fadeOut();
                        console.log(data)
                    }
                });

            }
        }




    });

    function b64toBlob(b64Data, contentType, sliceSize) {
        contentType = contentType || '';
        sliceSize = sliceSize || 512;

        var byteCharacters = atob(b64Data);
        var byteArrays = [];

        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);

            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            var byteArray = new Uint8Array(byteNumbers);

            byteArrays.push(byteArray);
        }

        var blob = new Blob(byteArrays, {
            type: contentType
        });
        return blob;
    }

    function clear() {
        $("#title").val("");
        $("#categoryid").val("0");
        $("#description").val("");
        $("#status").val("1");
        $('#img-upload').attr('src', '');
        $(".imagename").val("");
        sliderid = 0;

    }
    $(document).on('click', "#reset", function() {
        clear();
    })
    $(document).on('click', '#deletedata', function() {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this  data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var dataid = $(this).data("id");
                    $.ajax({
                        type: "post",
                        url: "{{ url('Admin/Slider/delete')}}" + '/' + dataid,
                        success: function(data) {
                            table.ajax.reload();
                            clear();
                        },
                        error: function() {
                            swal("Opps! Faild", "Form Submited Faild", "error");
                        }
                    });
                    swal("Poof! Your imaginary file has been deleted!", {
                        icon: "success",
                    });
                } else {
                    swal("Your imaginary file is safe!");
                }
            });
    })
    //show Data by id


    $(document).on('click', '#datashow', function() {
        var id = $(this).data("id");
        $.ajax({
            type: 'get',
            url: "{{ route('slider.show') }}",
            data: {
                dataid: id,
            },
            datatype: 'JSON',
            success: function(data) {
                sliderid = data.id;
                var imagesrc;
                $('#img-upload').attr('src', '');
                if (data.image !== null) {
                    imagesrc = "{{ asset('storage/app/public/slider') }}/" + data.image;
                    convertImgToBase64(imagesrc, function(base64Img) {
                        $('#img-upload').attr('src', base64Img);
                    });
                }
                var status = data.status
                var message = ((status == 0 ? " Deactive " : " Active "));
                $("#title").val(data.title);
                //  $("#categoryid option[value='" + data.category + "']").attr('selected', 'selected');
                $("#categoryid").val(data.category);
                $("#description").val(data.remark);
                $("#status option[value='" + status + "']").attr('selected', 'selected');
                $(".imagename").val(data.image)
            },
            error: function(data) {
                console.log(data)
            }
        });
    })

    function convertImgToBase64(url, callback, outputFormat) {
        var canvas = document.createElement('CANVAS');
        var ctx = canvas.getContext('2d');
        var img = new Image;
        img.crossOrigin = 'Anonymous';
        img.onload = function() {
            canvas.height = img.height;
            canvas.width = img.width;
            ctx.drawImage(img, 0, 0);
            var dataURL = canvas.toDataURL(outputFormat || 'image/png');
            callback.call(this, dataURL);
            // Clean up
            canvas = null;
        };
        img.src = url;
    }

    $("#img-upload").on("click", function() {
        $('#imagepreview').attr('src', $('#img-upload').attr('src')); // here asign the image to the modal when the user click the enlarge link
        $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
    });
</script>
@endsection