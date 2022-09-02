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
                @lang('home.state') @lang('home.management')
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">

                    <div class="card">
                        <div class="card-header card-header-section">
                            @lang('home.new') @lang('home.state')
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="exampleInputPassword2" class=" col-form-label">@lang('home.country')</label>
                                <select id="country_id" class="form-control">
                                    @foreach($Countrys as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2" class=" col-form-label">@lang('home.name')</label>
                                <input type="text" class="form-control" id="name" placeholder="@lang('home.name')">
                            </div>
                            <div class="card-footer card-footer-section">
                                <div class="btn-group" role="group" aria-label="Basic example">
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
                                        <th> @lang('home.name') </th>
                                        <th> @lang('home.country')</th>
                                        <th>@lang('home.action')</th>
                                    </tr>
                                </thead>
                                <tbody id="showalldata">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th> #@lang('home.sl') </th>
                                        <th> @lang('home.name') </th>
                                        <th> @lang('home.country')</th>
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
    var stateid = 0;



    function DataTable() {

        table = $('#mytable').DataTable({
            responsive: true,
            paging: true,
            scrollY: 223,
            ordering: true,
            searching: true,
            colReorder: true,
            keys: true,
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            iDisplayLength: 100,
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
                "url": "{{ route('state.loadall') }}",
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
                    data: 'country',
                    name: 'country',

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
        var country_id = $("#country_id").val();
        if (name == "") {
            swal("Opps! Faild", "Country Value Requird", "error");
        } else {
            if (stateid == 0) {
                $.ajax({
                    type: 'post',
                    url: "{{ route('state.store') }}",
                    data: {

                        name: name,
                        country_id: country_id,

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
                    url: "{{ route('state.update') }}",
                    data: {
                        id: stateid,
                        name: name,
                        country_id: country_id,

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
        stateid = 0;
        $("#country_id").val($("#country_id option:first").val());
        $("#name").val("");
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
                        type: "POST",
                        url: "{{ url('Admin/State/delete')}}" + '/' + dataid,
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
            url: "{{ route('state.show') }}",
            data: {
                dataid: id,
            },
            datatype: 'JSON',
            success: function(data) {
                clear();
                stateid = data.id;
                $("#name").val(data.name);

                $("#country_id option[value='" + data.country_id + "']").attr('selected', 'selected');
            },
            error: function(data) {

            }
        });
    })
</script>

@endsection