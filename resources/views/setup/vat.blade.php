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
                @lang('home.vat') @lang('home.setting')
            </div>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">

                    <div class="card">
                        <div class="card-header card-header-section">
                            @lang('home.new') @lang('home.type')
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="exampleInputPassword2" class="col-form-label">@lang('home.default') @lang('home.name')</label>
                                <input type="text" class="form-control" id="name" placeholder="@lang('home.default') @lang('home.name')">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2" class="col-form-label">@lang('home.value')</label>
                                <input type="number" class="form-control" id="value" placeholder="@lang('home.value')">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2" class="col-form-label">@lang('home.remark')</label>
                                <textarea class="form-control" id="remark" cols="30" rows="5" placeholder="@lang('home.remark')"></textarea>
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
                                    <button class="btn btn-success btn-lg" id="reset">@lang('home.reset')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-header card-header-section">
                            <div class="pull-left">
                                @lang('home.vat') @lang('home.setting') @lang('home.list')
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="mytable" class="table table-bordered" style="width:100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th> #@lang('home.sl') </th>
                                        <th> @lang('home.name') </th>
                                        <th> @lang('home.value') </th>
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
                                        <th> @lang('home.value') </th>
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
    var vatid = 0;

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

            //dom: 'lBfrtip',
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
                "url": "{{ route('vatsetting.loadall') }}",
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
                    data: 'value',
                    name: 'value',

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
        $('.dataTables_length').addClass('bs-select');
    }
    window.onload = DataTable();

    $(document).on("click", "#datainsert", function() {
       
        var name = $("#name").val();
        var value = $("#value").val();
        var remark = $("#remark").val();
        var status = $("#status").val();
        if (name == "" || value == "" ) {
            swal("Opps! Faild", "Title Value Requird", "error");
        } else {
            $("#overlay").fadeIn();
            if (vatid == 0) {
                $.ajax({
                    url: "{{ route('vatsetting.store') }}",
                    type: 'post',
                    data: {
                        name: name,
                        value: value,
                        remark: remark,
                        status: status
                    },
                    datatype: ("json"),
                    success: function() {
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
                    type: "POST",
                    url: "{{ route('vatsetting.update') }}",
                    data: {
                        id: vatid,
                        name: name,
                        value: value,
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
                    error: function(data) {
                        $("#overlay").fadeOut();
                        swal("Opps! Faild", "Form Submited Faild", "error");
                        console.log(data);
                    }

                });
            }
        }
    });

    function clear() {
        vatid=0;
        $("#name").val("");
        $("#value").val("");
        $("#remark").val("");
        $("#status").val(1);
    }


    $(document).on('click', '#datashow', function() {
        dataid = $(this).data("id");
        $.ajax({
            type: "get",
            url: "{{url('Admin/Vatsetting/Show')}}?dataid=" + dataid,
            datatype: 'JSON',
            success: function(data) {
                vatid = data.id;
                $("#name").val(data.name);
                $("#value").val(data.value);
                $("#remark").val(data.remark);
                $("#statusid option[value='" + data.status + "']").attr('selected', 'selected');
            },
            error: function(data) {

            }
        });

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
                    $.ajax({
                        type: "post",
                        url: "{{ url('Vatsetting/delete')}}" + '/' + id,
                        success: function(data) {
                            table.ajax.reload();
                            clear();

                        },
                        error: function(data) {
                            swal("Opps! Faild", "Form Submited Faild", "error");
                            console.log(data);
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


    $("#reset").on('click', function() {
        clear();

    });
</script>

@endsection