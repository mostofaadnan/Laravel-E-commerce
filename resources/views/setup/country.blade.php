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
                @lang('home.country') @lang('home.management')
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">

                    <div class="card">
                        <div class="card-header card-header-section">
                            @lang('home.new') @lang('home.country')
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="exampleInputPassword2" class=" col-form-label">@lang('home.short') @lang('home.name')</label>
                                <input type="text" class="form-control" id="shortname" placeholder="@lang('home.short') @lang('home.name')">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2" class=" col-form-label">@lang('home.name')</label>
                                <input type="text" class="form-control" id="name" placeholder="@lang('home.name')">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2" class=" col-form-label">@lang('home.phone') @lang('home.phone')</label>
                                <input type="text" class="form-control" id="phonecode" placeholder="@lang('home.phone') @lang('home.phone')">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2" class="col-form-label">@lang('home.status')</label>
                                <select name="status" class="form-control" id="status">
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                            </div>
                            <div class="card-footer card-footer-section">
                            <div class="btn-group button-grp" role="group" aria-label="Basic example">
                                    <button id="datainsert" class="btn btn-danger btn-lg">@lang('home.submit')</button>
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
                                @lang('home.country') @lang('home.list')
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="mytable" class="table table-bordered" style="width:100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th> #@lang('home.sl') </th>
                                        <th> @lang('home.short') @lang('home.name') </th>
                                        <th> @lang('home.name') </th>
                                        <th> @lang('home.phone') @lang('home.code')</th>
                                        <th> @lang('home.status')</th>
                                        <th>@lang('home.action')</th>
                                    </tr>
                                </thead>
                                <tbody id="showalldata">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th> #@lang('home.sl') </th>
                                        <th> @lang('home.short') @lang('home.name') </th>
                                        <th> @lang('home.name') </th>
                                        <th> @lang('home.phone') @lang('home.code')</th>
                                        <th> @lang('home.status')</th>
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
    var countryid = 0;



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
            dom: "<'row'<'col-sm-3'l><'col-sm-2 text-center'B><'col-sm-7'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [{
                    text: '<i class="fa fa-refresh"></i>@lang("home.refresh")',
                    action: function() {
                        table.ajax.reload();
                    },
                    className: 'btn btn-info',
                },



            ],
            "ajax": {
                "url": "{{ route('country.loadall') }}",
                "type": "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: "text-center"
                },
                {
                    data: 'sortname',
                    name: 'sortname',

                },
                {
                    data: 'name',
                    name: 'name',

                },
                {
                    data: 'phonecode',
                    name: 'phonecode',

                },
                {
                    data: 'status',
                    name: 'status',

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
        var shortname = $("#shortname").val();
        var name = $("#name").val();
        var phonecode = $("#phonecode").val();
        var status = $("#status").val();

        if (name == "") {
            swal("Opps! Faild", "Country Value Requird", "error");
        } else {
            if (countryid == 0) {
                $.ajax({
                    type: 'post',
                    url: "{{ route('country.store') }}",
                    data: {
                        shortname: shortname,
                        name: name,
                        phonecode: phonecode,
                        status: status
                    },
                    datatype: ("json"),
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
                    url: "{{ route('country.update') }}",
                    data: {
                        id: countryid,
                        shortname: shortname,
                        name: name,
                        phonecode: phonecode,
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
        countryid = 0;
        $("#shortname").val("");
        $("#name").val("");
        $("#phonecode").val("");
        $("#status").val("1");
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
                        url: "{{ url('Admin/Country/delete')}}" + '/' + dataid,
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
            url: "{{ route('country.show') }}",
            data: {
                dataid: id,
            },
            datatype: 'JSON',
            success: function(data) {
                clear();
                countryid = data.id;
                var status = data.status
                var message = ((status == 0 ? " Deactive " : " Active "));
                $("#shortname").val(data.sortname);
                $("#name").val(data.name);
                $("#phonecode").val(data.phonecode);
                $("#status option[value='" + status + "']").attr('selected', 'selected');
            },
            error: function(data) {

            }
        });
    })
</script>

@endsection