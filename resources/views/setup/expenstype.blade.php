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
                @lang('home.expenses')  @lang('home.type') @lang('home.management')
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header card-header-section">
                            @lang('home.expenses') @lang('home.type')
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputPassword2" class="col-form-label">@lang('home.name')</label>
                                <input type="text" class="form-control" id="name" placeholder="@lang('home.name')" autocomplete="off">
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
                                <div class="btn-group button-grp" role="group" aria-label="Basic example">
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
                                @lang('home.expenses') @lang('home.type') @lang('home.list')
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="mytable" class="table table-bordered" style="width:100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th> #@lang('home.sl') </th>
                                        <th> @lang('home.name') </th>
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
    var store = 0;
    var typeid = 0

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
                "url": "{{ route('expensestype.loadall') }}",
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
    $("#datainsert").on("click", function() {

        var name = $("#name").val();
        var remark = $("#description").val();
        var status = $("#status").val();
        if (name == "") {
            swal("Opps! Faild", "Title Value Requird", "error");
        } else {
            $("#overlay").fadeIn();
            if (typeid == 0) {
                $.ajax({
                    type: 'post',
                    url: "{{ route('expensestype.store') }}",
                    data: {
                        name: name,
                        remark: remark,
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
                    url: "{{route('expensestype.update') }}",
                    data: {
                        id: typeid,
                        name: name,
                        remark: remark,
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
        typeid = 0;
        $("#name").val("");
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
                        url: "{{ url('Admin/ExpensesType/delete')}}" + '/' + id,
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
            url: "{{ route('expensestype.show') }}",
            data: {
                id: id,
            },
            datatype: 'JSON',
            success: function(data) {
                var status = data.status
                typeid = data.id
                var message = ((status == 0 ? " Deactive " : " Active "));
                $("#name").val(data.name);
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