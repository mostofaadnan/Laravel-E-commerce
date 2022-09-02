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
            autoWidth:true,
            keys: true,
            processing: true,
            serverSide: true,
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
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
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'csv',
                    text: '<i class="fa fa-file-text-o"></i>@lang("home.csv")',
                    className: 'btn btn-info',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i>@lang("home.excel")',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    footer: false,
                },
                {
                    text: '<i class="fa fa-file-pdf-o"></i>@lang("home.pdf")',
                    extend: 'pdf',
                    className: 'btn btn-light',
                    orientation: 'portrait', //portrait',
                    pageSize: 'A4',
                    title: 'Product List',
                    filename: 'itemlist',
                    className: 'btn btn-danger',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    footer: false,
                    customize: function(doc) {

                        var tblBody = doc.content[1].table.body;
                        doc.content[1].layout = {
                            hLineWidth: function(i, node) {
                                return (i === 0 || i === node.table.body.length) ? 2 : 1;
                            },
                            vLineWidth: function(i, node) {
                                return (i === 0 || i === node.table.widths.length) ? 2 : 1;
                            },
                            hLineColor: function(i, node) {
                                return (i === 0 || i === node.table.body.length) ? 'black' : 'gray';
                            },
                            vLineColor: function(i, node) {
                                return (i === 0 || i === node.table.widths.length) ? 'black' : 'gray';
                            }
                        };
                        $('#gridID').find('tr').each(function(ix, row) {
                            var index = ix;
                            var rowElt = row;
                            $(row).find('td').each(function(ind, elt) {
                                tblBody[index][ind].border
                                if (tblBody[index][1].text == '' && tblBody[index][2].text == '') {
                                    delete tblBody[index][ind].style;
                                    tblBody[index][ind].fillColor = '#FFF9C4';
                                } else {
                                    if (tblBody[index][2].text == '') {
                                        delete tblBody[index][ind].style;
                                        tblBody[index][ind].fillColor = '#FFFDE7';
                                    }
                                }
                            });
                        });
                    }

                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> @lang("home.print")',
                    className: 'btn btn-dark',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                    footer: false,
                },


            ],

            "ajax": {
                "url": "{{ route('product.loadall') }}",
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
                    data: 'category',
                    name: 'category'
                },
                {
                    data: 'unit',
                    name: 'unit',

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
    $('#loadall').on('click', function() {
        DataTable();
    });
    window.onload = DataTable();

    function readAllData() {
        var url = "{{ route('product.productgetlist') }}";
        $.get(url, function(data) {
            LoadTableData(data);

        })

    }
    //data view
    $(document).on('click', "#dataedit", function() {
        var dataid = $(this).data("id");
        url = "{{ url('Admin/Product/edit')}}" + '/' + dataid,
            window.location = url;
    });
    //data view
    $(document).on('click', "#datashow", function() {
            var dataid = $(this).data("id");
            url = "{{ url('Admin/Product/productDetails')}}" + '/' + dataid,
                window.location = url;
        });
    //stock summerise
    $(document).on('click', "#stocksum", function() {
        var dataid = $(this).data("id");
        url = "{{ url('Admin/Product/openstock')}}" + '/' + dataid,
            window.location = url;
    });
    // data Delete
    $(document).on('click', '#datadelete', function() {
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
                        url: "{{ url('Admin/Product/delete')}}" + '/' + dataid,
                        success: function(data) {
                            table.ajax.reload();
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


    });


    $(document).on("click", "#active", function(event) {
        var dataid = $(this).data("id");
        $.ajax({
            type: "post",
            url: "{{ url('Admin/Product/Active')}}" + '/' + dataid,
            data: {
                id: dataid,
            },
            datatype: ("json"),
            success: function() {

                table.ajax.reload();
            },
            error: function() {
                swal("Opps! Faild", "Form Submited Faild", "error");

            }

        });
    });
    $(document).on("click", "#inactive", function(event) {
        var dataid = $(this).data("id");
        $.ajax({
            type: "post",
            url: "{{ url('Admin/Product/Inactive')}}" + '/' + dataid,
            data: {
                id: dataid,
            },
            datatype: ("json"),
            success: function() {
                table.ajax.reload();
            },
            error: function() {
                swal("Opps! Faild", "Form Submited Faild", "error");

            }

        });



    });
    $(document).on('click', '#dataarcive', function() {
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
                        url: "{{ url('Admin/Product/makeArchive')}}" + '/' + dataid,
                        success: function(data) {
                            table.ajax.reload();
                        },
                        error: function() {
                            swal("Opps! Faild", "Form Submited Faild", "error");

                        }
                    });

                    swal("Poof! Your imaginary file has been Archived!", {
                        icon: "success",
                    });
                } else {
                    swal("Your imaginary file is safe!");
                }
            });


    });
</script>