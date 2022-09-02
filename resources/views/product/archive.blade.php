@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header card-header-section" style="background-color:red;">
        <div class="pull-left">
            @lang('home.archive') @lang('home.item')
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="mytable" style="width:100%" cellspacing="0">

            <thead>
                <tr>
                    <th> #@lang('home.sl') </th>
                    <th> @lang('home.barcode')</th>
                    <th> @lang('home.name') </th>
                    <th> @lang('home.category') </th>
                    <th> @lang('home.stock') @lang('home.unit')</th>
                    <th> @lang('home.tp')</th>
                    <th> @lang('home.mrp')</th>
                    <th> @lang('home.discount')</th>
                    <th> @lang('home.status')</th>
                    <th> @lang('home.action')</th>
                </tr>

            </thead>
            <tbody id="tablebody">

            </tbody>
            <tfoot>
                <tr>
                    <th> #@lang('home.sl') </th>
                    <th> @lang('home.barcode')</th>
                    <th> @lang('home.name') </th>
                    <th> @lang('home.category') </th>
                    <th> @lang('home.stock') @lang('home.unit')</th>
                    <th> @lang('home.tp')</th>
                    <th> @lang('home.mrp')</th>
                    <th> @lang('home.discount')</th>
                    <th> @lang('home.status')</th>
                    <th> @lang('home.action')</th>
                </tr>
            </tfoot>

        </table>
    </div>
</div>
<script>
    var table;

    function DataTable() {
        table = $('#mytable').DataTable({
            responsive: true,
            paging: true,
            scrollY: 400,
            ordering: true,
            searching: true,
            colReorder: true,
            keys: true,
            processing: true,
            serverSide: true,
            iDisplayLength: 100,

            dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-2'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [{

                    text: '<i class="fa fa-refresh"></i>@lang("home.refresh")',
                    action: function() {
                        table.ajax.reload();
                    },
                    className: 'btn btn-info',
                },

                {
                    extend: 'copy',

                    className: 'btn btn-secondary',
                    text: '<i class="fa fa-files-o"></i>@lang("home.export")',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'csv',
                    text: '<i class="fa fa-file-text-o"></i>@lang("home.csv")',
                    className: 'btn btn-info',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i>@lang("home.excel")',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                    footer: false,
                },
            ],

            "ajax": {
                "url": "{{ route('product.loadallarchive') }}",
                "type": "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: "text-center"
                },
                {
                    data: 'barcode',
                    name: 'barcode',


                },
                {
                    data: 'name',
                    name: 'name',

                },

                {
                    data: 'category',
                    name: 'category'
                },
                {
                    data: 'unit',
                    name: 'unit',

                },
                {
                    data: 'tp',
                    name: 'tp',
                    className: "text-right"
                },
                {
                    data: 'mrp',
                    name: 'mrp',
                    className: "text-right"
                },
                {
                    data: 'discount',
                    name: 'discount',
                    className: "text-right"
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
                }
            ],
            /* columnDefs: [{
                targets: [7],
                render: function(data, type, row) {
                    return data > 0  ?  $(row).addClass( 'red' ) :  $(row).addClass( 'black' )
                }
            }] */
        });
        $('.dataTables_length').addClass('bs-select');
        table.buttons().container()
            .appendTo('#example_wrapper .col-md-6:eq(0)');
    }
    window.onload = DataTable();


    $(document).on('click', '#dataretrived', function() {
        swal({
                title: "Are you sure?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var dataid = $(this).data("id");
                    $.ajax({
                        type: "post",
                        url: "{{ url('Admin/Product/makeRetrive')}}" + '/' + dataid,
                        success: function(data) {
                            table.ajax.reload();
                        },
                        error: function() {
                            swal("Opps! Faild", "Form Submited Faild", "error");

                        }
                    });

                    swal("Poof! Your has been Retrived!", {
                        icon: "success",
                    });
                } else {
                    swal("Your Data Remain Archived");
                }
            });


    });
</script>

@endsection