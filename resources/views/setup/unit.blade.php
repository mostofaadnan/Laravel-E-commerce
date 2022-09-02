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
            <div class="pull-left">
                @lang('home.unit') @lang('home.management')
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header card-header-section">
                            @lang('home.new') @lang('home.unit')
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputPassword2" class="col-form-label">@lang('home.name')</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="@lang('home.name')">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2" class="col-form-label">@lang('home.short') @lang('home.name')</label>
                                <input type="text" class="form-control" id="short" name="short" style="color:red; font-style:itelic bold" placeholder="@lang('home.short')  @lang('home.name')">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2" class="col-form-label">@lang('home.description')</label>
                                <textarea name="description" class="form-control" id="description" name="description" cols="30" rows="5" placeholder="@lang('home.description')"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2" class=" col-form-label">@lang('home.status')</label>
                                <select name="status" class="form-control" id="status">
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                            </div>
                            <div class="card-footer card-footer-section">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="submit" id="datainsert" class="btn btn-danger btn-lg">@lang('home.submit')</button>
                                    <button id="reset" class="btn btn-success btn-lg">@lang('home.reset')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-header card-header-section">
                            <div class="pull-left">
                                @lang('home.unit') @lang('home.list')
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="mytable" class="table table-bordered" style="width:100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th> #@lang('home.sl') </th>
                                        <th> @lang('home.name') </th>
                                        <th> @lang('home.short') @lang('home.name') </th>
                                        <th> @lang('home.status')</th>
                                        <th> @lang('home.description') </th>
                                        <th> @lang('home.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th> #@lang('home.sl') </th>
                                        <th> @lang('home.name') </th>
                                        <th> @lang('home.short') @lang('home.name') </th>
                                        <th> @lang('home.status')</th>
                                        <th> @lang('home.description') </th>
                                        <th> @lang('home.action')</th>
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
    var unitid = 0;

    function DataTable() {
        table = $('#mytable').DataTable({
            responsive: true,
            paging: true,
            scrollY: 275,
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
                "url": "{{ route('unit.loadall') }}",
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
                    data: 'Shortcut',
                    name: 'Shortcut',

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
    $("#datainsert").on("click", function() {
        $("#overlay").fadeIn();
        var title = $("#title").val();
        var short = $("#short").val();
        var description = $("#description").val();
        var status = $("#status").val();
        if (title == "" && short == " ") {
            swal("Opps! Faild", "Title Value Requird", "error");
        } else {
            if (unitid == 0) {
                $.ajax({
                    type: 'post',
                    url: "{{ route('unit.store') }}",
                    data: {
                        title: title,
                        short: short,
                        description: description,
                        status: status
                    },
                    datatype: ("json"),
                    success: function() {
                        $("#overlay").fadeOut();
                        swal("Data Inserted Successfully", "Form Submited", "success"),
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
                    type: 'Post',
                    url: "{{route('units.update') }}",
                    data: {
                        id: unitid,
                        title: title,
                        short: short,
                        description: description,
                        status: status
                    },
                    datatype: ("json"),
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

    function clear() {
        unitid = 0;
        $("#title").val("");
        $("#short").val("");
        $("#description").val("");
    }
    $(document).on('click', "#reset", function() {
        clear();
    });

    $(document).on('click', '#deletedata', function() {
        var id = $(this).data("id");
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
                    console.log(dataid);
                    $.ajax({
                        type: "post",
                        url: "{{ url('Admin/Unit/delete')}}" + '/' + id,
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
        console.log("data")
        var id = $(this).data("id");
        $.ajax({
            type: 'get',
            url: "{{ route('unit.show') }}",
            data: {
                dataid: id,
            },
            datatype: 'JSON',
            success: function(data) {

                var status = data.status
                unitid = data.id
                var message = ((status == 0 ? " Deactive " : " Active "));
                $("#title").val(data.title);
                $("#short").val(data.Shortcut);
                $("#description").val(data.description);
                $("#statusid option[value='" + status + "']").attr('selected', 'selected');
            },
            error: function(data) {
                console.log(data);
            }
        });

    })
</script>


@endsection