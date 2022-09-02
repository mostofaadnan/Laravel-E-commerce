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
            @lang('home.product') @lang('home.slider') @lang('home.management')
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header card-header-section">
                            <div class="pull-left">
                                @lang('home.new') @lang('home.entry')
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputPassword2" class="col-form-label">@lang('home.type')</label>
                                <select id="typeid" class="form-control">
                                    <option value="">Select Types</option>
                                    @foreach($types as $type)
                                    <option value="{{$type->id}}">{{ $type->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword2" class="col-form-label">@lang('home.item')</label>
                                <input type="text" class="form-control" id="search" placeholder="@lang('home.search')" list="product" autocomplete="off">
                                <datalist id="product">
                                </datalist>
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
                            @lang('home.item') @lang('home.slider') @lang('home.list')
                        </div>
                        <div class="card-body">
                            <table id="mytable" class="table table-bordered" style="width:100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th> #@lang('home.sl') </th>
                                        <th> @lang('home.type') </th>
                                        <th> @lang('home.item')</th>
                                        <th>@lang('home.action')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th> #@lang('home.sl') </th>
                                        <th> @lang('home.type') </th>
                                        <th> @lang('home.item')</th>
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
    var sliderid = 0;
    var productid = 0;

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
                "url": "{{ route('productslide.loadall') }}",
                "type": "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: "text-center"
                },
                {
                    data: 'type',
                    name: 'type',

                },
                {
                    data: 'product',
                    name: 'product',

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

    function ItemDatalist() {
        $.ajax({
            type: 'get',
            url: "{{ route('product.itemdatalist') }}",
            datatype: 'JSON',
            success: function(data) {
                $('#product').html(data);
            },
            error: function(data) {}
        });
    }
    window.onload = ItemDatalist();
    $("#search").on('input', function() {
        var val = this.value;
        var mrp = 0;
        if ($('#product option').filter(function() {
                return this.value.toUpperCase() === val.toUpperCase();
            }).length) {
            productid = $('#product').find('option[value="' + val + '"]').attr('id');
        }
    });


    $("#datainsert").on("click", function(e) {
     
        var typeid = $("#typeid").val();
        if (typeid == "" || productid == 0) {
            swal("Opps! Faild", "Title Value Requird", "error");
        } else {
            $("#overlay").fadeIn();
            if (sliderid == 0) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('productslide.store') }}",
                    data: {

                        typeid: typeid,
                        productid: productid,

                    },
                    datatype: ("json"),
                    success: function() {
                        $("#overlay").fadeOut();
                        swal("Data Inserted Successfully", "Form Submited", "success");
                        clear();
                        table.ajax.reload();
                    },
                    error: function(data) {
                        console.log(data);
                        $("#overlay").fadeOut();
                        swal("Opps! Faild", "Form Submited Faild", "error");
                    }

                });
            } else {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('productslide.update') }}",
                    data: {
                        id: sliderid,
                        typeid: typeid,
                        productid: productid,
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
       $("#search").val("");
        $("#typeid").val("");
        $("#productud").val("");
        sliderid = 0;
        productid = 0;
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
                        url: "{{ url('Admin/Product-Sliders/delete')}}" + '/' + dataid,
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
            url: "{{ route('productslide.show') }}",
            data: {
                dataid: id,
            },
            datatype: 'JSON',
            success: function(data) {
                productid = data.product_id;
                slideid = data.id;
                $("#typeid option[value='" + data.type_id + "']").attr('selected', 'selected');
                $("#search").val(data.product_name['name']);
            },
            error: function(data) {

            }
        });
    })
</script>
@endsection