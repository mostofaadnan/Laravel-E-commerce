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
                                <label for="exampleInputPassword2" class=" col-form-label">@lang('home.state')</label>
                                <select class="form-control" name="state_id" id="state">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2" class=" col-form-label">@lang('home.shipment') @lang('home.charge')</label>
                                <input type="number" class="form-control" id="charge" placeholder="@lang('home.shipment') @lang('home.charge')">
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
                                        <th> @lang('home.country')</th>
                                        <th> @lang('home.state')</th>
                                        <th> @lang('home.charge')</th>
                                        <th>@lang('home.action')</th>
                                    </tr>
                                </thead>
                                <tbody id="showalldata">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th> #@lang('home.sl') </th>
                                        <th> @lang('home.country')</th>
                                        <th> @lang('home.state')</th>
                                        <th> @lang('home.charge')</th>
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
    $(document).ready(function() {
        var table;
        var chargeid = 0;

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
                    "url": "{{ route('shipment.loadall') }}",
                    "type": "GET",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: "text-center"
                    },
                    {
                        data: 'country',
                        name: 'country',

                    },
                    {
                        data: 'state',
                        name: 'state',

                    },
                    {
                        data: 'charge',
                        name: 'charge',

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

        $('#country_id').change(function() {
            var countryID = $(this).val();
            State(countryID);

        });

        function State(countryID) {
            if (countryID) {
                $.ajax({
                    type: "GET",
                    url: "{{url('Admin/State/get-state-list')}}?country_id=" + countryID,
                    success: function(res) {
                        if (res) {
                            $("#state").empty();
                            $("#state").append('<option>Select</option>');
                            $.each(res, function(key, value) {
                                $("#state").append('<option value="' + key + '">' + value + '</option>');
                            });


                        } else {
                            $("#state").empty();
                        }
                    }
                });
            } else {
                $("#state").empty();

            }
        }


        $("#datainsert").on("click", function(e) {
            $("#overlay").fadeIn();

            var charge = $("#charge").val();
            var country_id = $("#country_id").val();
            var stateid = $("#state").val();
            if (charge == "" || country_id == "" || stateid == "") {
                swal("Opps! Faild", "Country Value Requird", "error");
            } else {
                if (chargeid == 0) {
                    $.ajax({
                        type: 'post',
                        url: "{{ route('shipment.store') }}",
                        data: {


                            categoryid: country_id,
                            stateid: stateid,
                            charge: charge

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
                        url: "{{ route('shipment.update') }}",
                        data: {
                            id: chargeid,
                            categoryid: country_id,
                            stateid: stateid,
                            charge: charge

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
            $("#state").empty();
            $("#charge").val("");
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
                            url: "{{ url('Admin/Shipment/delete')}}" + '/' + dataid,
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
            console.log(id);
            $.ajax({
                type: 'get',
                url: "{{ route('shipment.show') }}",
                data: {
                    dataid: id,
                },
                datatype: 'JSON',
                success: function(data) {
                    clear();
                    chargeid = data.id;
                    var countryid = data.country_id;
                    var stateid = data.state_id;
                    $("#charge").val(data.charge);
                    $("#country_id option[value='" + data.country_id + "']").attr('selected', 'selected');
                    FindState(countryid, stateid);
                },
                error: function(data) {

                }
            });
        });
    });

    function FindState(countryID, stateid) {
        if (countryID) {
            $.ajax({
                type: "GET",
                url: "{{url('Admin/State/get-state-list')}}?country_id=" + countryID,
                success: function(res) {
                    if (res) {
                        $("#state").empty();
                        $("#state").append('<option>Select</option>');
                        $.each(res, function(key, value) {
                            $("#state").append('<option value="' + key + '">' + value + '</option>');
                        });

                        $("#state option[value='" + stateid + "']").attr('selected', 'selected');
                    } else {
                        $("#state").empty();
                    }
                }
            });
        } else {
            $("#state").empty();

        }
    }
</script>

@endsection