<script>
    var table;

    function DataTable() {
        var fromdate = $("#min").val();
        var todate = $("#max").val();
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
            //dom: 'lBfrtip',
            dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [{

                    text: '<i class="fa fa-refresh"></i> @lang("home.refresh")',
                    action: function() {
                        $("#min").val("");
                        $("#max").val("");
                        table.destroy();
                        DataTable();
                        //table.ajax.reload();
                    },
                    className: 'btn btn-info',
                },
                {
                    extend: 'copy',
                    className: 'btn btn-secondary',
                    text: '<i class="fa fa-files-o"></i> @lang("home.export")',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'csv',
                    text: '<i class="fa fa-file-text-o"></i> @lang("home.csv")',
                    className: 'btn btn-info',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i> @lang("home.excel")',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                    footer: true,
                },
                {
                    text: '<i class="fa fa-file-pdf-o"></i> @lang("home.pdf")',
                    extend: 'pdf',
                    className: 'btn btn-light',
                    orientation: 'portrait', //portrait',
                    pageSize: 'A4',
                    title: 'Purchase Order List',
                    filename: 'purchaseorder',
                    className: 'btn btn-danger',

                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                    footer: true,
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
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                    footer: true,
                },

            ],
            "ajax": {
                "url": "{{ route('vatcollection.loadall') }}",
                "data": {
                    fromdate: fromdate,
                    todate: todate
                },
                "type": "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: "text-center"
                },
                {
                    data: 'collection_no',
                    name: 'collection_no',
                    className: "text-center"
                },
                {
                    data: 'inputdate',
                    name: 'inputdate',
                },
                {
                    data: 'fromdate',
                    name: 'fromdate',
                    className: "text-center"
                },

                {
                    data: 'todate',
                    name: 'todate',

                },
                {
                    data: 'remark',
                    name: 'remark',
                    orderable: false,
                },
                {
                    data: 'amount',
                    name: 'amount',
                    orderable: false,
                    className: "text-right"
                },
                {
                    data: 'user',
                    name: 'user',
                    orderable: false,
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        });
        $('.dataTables_length').addClass('bs-select');
    }
    $("#submitdate").on('click', function() {
        if ($("#max").val() == "" || $("#min").val() == "") {
            swal("Opps! Faild", "Please Select Between Date", "error");
        } else {
            table.destroy();
            DataTable();
        }

    });
    //setInterval("$('#mytable').DataTable().ajax.reload()", 10000);

    window.onload = DataTable();
    $(document).on('click', '#datashow', function() {
        var id = $(this).data("id");
        url = "{{ url('Admin/Vat-Collections/show')}}" + '/' + id,
            window.location = url;
    });

    $(document).on('click', '#makepayment', function() {
        url = "{{ url('Admin/Vat-Collections/paymentcreate')}}",
            window.location = url;
    });
    $(document).on('click', '#print', function() {
        var id = $(this).data("id");
        url = "{{ url('Admin/Vat-Collections/LoadPrintslip')}}" + '/' + id,
            window.open(url, '_blank');
    });
    $(document).on('click', "#deletedata", function() {

        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this  data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var id = $(this).data("id");
                    $.ajax({
                        type: "post",
                        url: "{{ url('Admin/Vat-Collections/delete')}}" + '/' + id,
                        success: function() {
                            $('#mytable').DataTable().ajax.reload()
                        },
                        error: function(data) {
                            console.log(data)
                            swal("Opps! Faild", "Data Fail to Delete", "error");
                        }
                    });
                    swal("Ok! Your file has been deleted!", {
                        icon: "success",
                    });
                } else {
                    swal("Your file is safe!");
                }
            });



    });
    //pdf data
    $(document).on('click', '#pdfdata', function() {
        var id = $(this).data("id");
        url = "{{ url('Admin/Vat-Collections/pdf')}}" + '/' + id,
            window.open(url, '_blank');
    });
</script>