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
            @lang('home.subcategory') @lang('home.management')
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header card-header-section">
                            <div class="pull-left">
                                @lang('home.new') @lang('home.subcategory')
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="exampleInputPassword2" class="col-form-label">@lang('home.name')</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="@lang('home.name')">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2" class="col-form-label">@lang('home.category')</label>
                                <select id="categoryid" name="categoryid" class="form-control">
                                    <option value="0">Select Category</option>
                                    @foreach($category as $cat)
                                    <option value="{{$cat->id}}">{{ $cat->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2" class="col-form-label">@lang('home.description')</label>

                                <textarea name="description" class="form-control" id="description" cols="30" rows="6" placeholder="@lang('home.description')"> </textarea>

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


<script type='text/javascript'>
    var table;
    var subcategoryid = 0;

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
                "url": "{{ route('subcategory.loadall') }}",
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
                    data: 'description',
                    name: 'description',

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

    $("#datainsert").on("click", function(e) {
        $("#overlay").fadeIn();
        var title = $("#title").val();
        var categoryid = $("#categoryid").val();
        var description = $("#description").val();
        var status = $("#status").val();
        if (title == "" ||categoryid=="0") {
            swal("Opps! Faild", "Title Value Requird", "error");
        } else {
            if (subcategoryid == 0) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('subcategory.store') }}",
                    data: {
                        title: title,
                        categoryid: categoryid,
                        description: description,
                        status: status
                    },
                    datatype: ("json"),
                    success: function() {
                        $("#overlay").fadeOut();
                        swal("Data Inserted Successfully", "Form Submited", "success");
                        clear();
                        table.ajax.reload();
                    },
                    error: function() {
                        $("#overlay").fadeOut();
                        swal("Opps! Faild", "Form Submited Faild", "error");

                    }

                });
            } else {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('subcategorys.update') }}",
                    data: {
                        id: subcategoryid,
                        title: title,
                        categoryid: categoryid,
                        description: description,
                        status: status
                    },
                    datatype: ("json"),
                    success: function() {
                        $("#overlay").fadeOut();
                        swal("Data Inserted Successfully", "Form Submited", "success");
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

    function clear() {
        $("#title").val("");
        $("#categoryid").val("0");
        $("#description").val("");
        $("#status").val("1");
        subcategoryid = 0;
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
                        url: "{{ url('Admin/Sub-Category/delete')}}" + '/' + dataid,
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
            url: "{{ route('subcategory.show') }}",
            data: {
                dataid: id,
            },
            datatype: 'JSON',
            success: function(data) {
                subcategoryid = data.id;
                console.log(data.category_id);
                var status = data.status
                var message = ((status == 0 ? " Deactive " : " Active "));
                $("#title").val(data.title);
              //  $("#categoryid option[value='" + data.category_id + "']").attr('selected', 'selected');
              $("#categoryid").val(data.category_id);
                if (data.description) {
                    $("#description").val(data.description);
                } else {
                    $("#description").val("");
                }
                $("#status option[value='" + status + "']").attr('selected', 'selected');
            },
            error: function(data) {

            } 
        });
    })
</script>
@endsection