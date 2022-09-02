@extends('layouts.master')
@section('content')


<div class="col-lg-12">
    <div class="card mainpanel">
        <div class="card-header card-header-section">
            <div class="pull-left">
                Store Management
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-10 form-single-input-section">
                    <div class="card">
                        <div class="card-header card-header-section">
                            New
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-8">

                                    <div class="form-group">
                                        <label for="exampleInputPassword2" class=" col-form-label">Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword2" class="col-form-label">Address</label>
                                        <textarea name="description" class="form-control" id="address" name="Description" cols="30" rows="2" placeholder="Description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword2" class=" col-form-label">Mobile</label>
                                        <input type="tel" class="form-control" id="mobile" placeholder="Order">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword2" class=" col-form-label">Email</label>
                                        <input type="email" class="form-control" id="email" placeholder="Order">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword2" class="col-form-label">Description</label>
                                        <textarea name="description" class="form-control" id="description" name="Description" cols="30" rows="6" placeholder="Description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword2" class="col-form-label">Google Map</label>
                                        <textarea name="description" class="form-control" id="googleMap" name="Description" cols="30" rows="2" placeholder="Description"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="exampleInputPassword2" class="col-form-label">Status</label>
                                                <select name="status" class="form-control" id="status">
                                                    <option value="1">Active</option>
                                                    <option value="0">Deactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    @include('Store.Picture')
                                </div>
                            </div>
                            <div class="card-footer card-footer-section">
                                <div class="btn-group button-grp" role="group" aria-label="Basic example">
                                    <button id="datainsert" class="btn btn-danger btn-lg">Submit</button>
                                    <button id="reset" class="btn btn-success btn-lg">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 mt-4">
                    <div class="card">
                        <div class="card-header card-header-section">
                            <div class="pull-left">
                                List
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="mytable" class="table table-bordered" style="width:100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th> #SL </th>
                                        <th> Name</th>
                                        <th> Address</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th> Action</th>
                                    </tr>
                                </thead>
                                <tbody id="showalldata">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th> #SL </th>
                                        <th> Name</th>
                                        <th> Address</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th> Action</th>
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

<script type='text/javascript'>
    var table;
    var storeid = 0;



    function DataTable() {

        table = $('#mytable').DataTable({
            responsive: true,
            paging: true,
            scrollY: 223,
            ordering: true,
            searching: true,
            colReorder: true,
            keys: true,
            processing: true,
            serverSide: true,

            //dom: 'lBfrtip',
            dom: "<'row'<'col-sm-2'l><'col-sm-2 text-center'B><'col-sm-8'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [{
                text: '<i class="fa fa-refresh"></i>Refresh',
                action: function() {
                    table.ajax.reload();
                },
                className: 'btn btn-info',
            }, ],
            "ajax": {
                "url": "{{ route('CompanyStore.loadall') }}",
                "type": "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: "text-center"
                },

                {
                    data: 'name',
                    name: 'name',

                },
                {
                    data: 'address',
                    name: 'address',

                },
                {
                    data: 'mobile',
                    name: 'mobile',

                },
                {
                    data: 'email',
                    name: 'email',

                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },

            ],
        });
        $('.dataTables_length').addClass('bs-select');
    }
    window.onload = DataTable();

    $("#datainsert").on("click", function(e) {
        $("#overlay").fadeIn();
        var name = $("#name").val();
        var address = $("#address").val();
        var mobile = $("#mobile").val();
        var email = $("#email").val();
        var description = $("#description").val();
        var googleMap = $("#googleMap").val();
        var status = $("#status").val();
        var form_data = new FormData();
        if (name == ""||address=="" ||mobile==""|| email=="") {
            swal("Opps! Faild", "Title Value Requird", "error");
            $("#overlay").fadeOut();
        } else {
            var ImageURL = document.getElementById("img-upload").src;
            var block = ImageURL.split(";");
            var contentType = block[0].split(":")[1]; // In this case "image/gif"
            var realData = block[1].split(",")[1]; // In this case "R0lGODlhPQBEAPeoAJosM...."
            var blob = b64toBlob(realData, contentType);
            form_data.append("id", courseid);
            form_data.append("file", blob);
            form_data.append("name", name);
            form_data.append("address", address);
            form_data.append("mobile", mobile);
            form_data.append("email", email);
            form_data.append("description", description);
            form_data.append("googleMap", googleMap);
            form_data.append("status", status);
            if (storeid == 0) {
                $.ajax({
                    type: 'post',
                    url: "{{ route('CompanyStore.store') }}",
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
                        swal("Opps! Faild", "Form Submited Faild", "error");
                        console.log(data);
                    }
                });
            } else {
                $.ajax({
                    type: 'post',
                    url: "{{ route('CompanyStore.update') }}",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function() {
                        $("#overlay").fadeOut();
                        swal("Data Update Successfully", "Form Submited", "success");
                        clear();
                        table.ajax.reload();
                    },
                    error: function() {
                        $("#overlay").fadeOut();
                        swal("Opps! Faild", "Form Submited Faild", "error");

                    }

                });

            }
        }
    })



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
        storeid = 0;

        $("#name").val("");
        $("#address").val("");
        $("#mobile").val("");
        $("#email").val("");
        $("#description").val("");
        $("#achivment").val("");
        $("#googleMap").val("");
        $("#status").val("1");
        $('#img-upload').attr('src', '');
        $(".imagename").val("");
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
                        url: "{{ url('Admin/CompanyStore/delete')}}" + '/' + dataid,
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
            url: "{{ route('CompanyStore.show') }}",
            data: {
                dataid: id,
            },
            datatype: 'JSON',
            success: function(data) {
                storeid = data.id;
                var imagesrc;
                $('#img-upload').attr('src', '');
                if (data.image !== null) {
                    imagesrc = "{{ asset('storage/app/public/CompanyStore') }}/" + data.image;
                    convertImgToBase64(imagesrc, function(base64Img) {
                        $('#img-upload').attr('src', base64Img);
                    });
                }
                var status = data.status
                var message = ((status == 0 ? " Deactive " : " Active "));
                $("#name").val(data.name);
                $("#address").val(data.address);
                $("#mobile").val(data.mobile);
                $("#email").val(data.email);
                $("#description").val(data.description);
                $("#googleMap").val(data.googleMap);
                $("#status option[value='" + status + "']").attr('selected', 'selected');
                $(".imagename").val(data.image)
            },
            error: function(data) {

            }
        });
    });

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
</script>

@endsection