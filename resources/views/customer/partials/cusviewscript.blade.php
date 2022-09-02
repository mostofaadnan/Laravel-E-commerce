<script>
    var customerid = 0;
    var invoicetable;
    var invoicetablecredit;
    var tablepayment;

    function getUrl() {
        var url = $(location).attr('href')
        customerid = url.substring(url.lastIndexOf('/') + 1);
        customerinfo(customerid);


    }
    window.onload = getUrl();

    function CustomerDataList() {
        $.ajax({
            type: 'get',
            url: "{{ route('customer.customerdatalist') }}",
            datatype: 'JSON',
            success: function(data) {
                $('#customer').html(data);
            },
            error: function(data) {

            }
        });
    }
    window.onload = CustomerDataList();
    $("#customersearch").on('input', function() {
        var val = this.value;
        if (val == "") {
            //clear();
        } else {
            if ($('#customer option').filter(function() {
                    return this.value.toUpperCase() === val.toUpperCase();
                }).length) {
                customerid = $('#customer').find('option[value="' + val + '"]').attr('id');
                invoicetable.destroy();
                invoicetablecredit.destroy();
                tablepayment.destroy();
                customerinfo(customerid);
            }
        }

    });

    function convertToSlug(Text) {
        return Text
            .toLowerCase()
            .replace(/ /g, '-')
            .replace(/[^\w-]+/g, '');
    }

    function changeUrl() {
        var url = $(location).attr('href')
        var i = url.lastIndexOf('/');
        if (i != -1) {
            newurl = url.substr(0, i) + "/" + customerid;
            history.pushState({}, null, newurl);
        }
    }



    function CustomerBasicInfo(data) {
        $('#imgProfile').attr('src', '');
        var customername = data.name.toUpperCase();
        $("#customername").text(customername);
        if (data.image !== null) {
            var imagesrc = "{{ asset('storage/app/public/Customer') }}/" + data.image;
            $('#imgProfile').attr('src', imagesrc);
        }
        var status = data.status == 1 ? 'Active' : 'Inactive';
        $("#basicinfo").html(
            '<h5>Details</h5>' +
            '<hr>' +
            'TIN:' + data.TIN + '<br>' +
            'Oppening Date:' + data.openingDate + '<br>' +
            'Status: <span class="span-info">'+status+'</span>'
        );
    }

    function Customeraddress(data) {
        $("#customeraddress").html("<p>" + data.address + "," + data.city_name['name'] + "," + data.state_name['name'] + ",</p>");
        $("#customercountry").html("<p>" + data.country_name['name'] + ".</p>");
        $("#mobile").html("&nbsp;&nbsp;" + data.mobile_no);
        $("#telno").html("&nbsp;&nbsp;" + data.tell_no);
        $("#email").html("&nbsp;&nbsp;" + data.email);
        $("#website").html("&nbsp;&nbsp;" + data.website);
    }

    function CustomerinfoDetails(data) {
        $("#supplierinfodetails").empty();
        $(".table-infodetails tbody").append(
            '<tr>' +
            '<th width="20%">Opening Balance</th>' +
            '<td>' + data.openingbalance + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th>Cash Invoice</th>' +
            '<td>' + data.cashinvoice + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th>Credit Invoice</th>' +
            '<td>' + data.creditinvoice + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th>Consignment</th>' +
            '<td>' + data.consignment + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th>Payment Recieved</th>' +
            '<td>' + data.payment + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th>Discount</th>' +
            '<td>' + data.discount + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th>Balance Due</th>' +
            '<td>' + data.balancedue + '</td>' +
            '</tr>'
        );
    }


    function customerDocument(data) {
        console.log(data)
        $("#tabledocument").empty();
        var sl = 1;
        data.forEach(function(value) {
            var imagesrc = "{{ asset('images/Customer/customerDocument') }}/" + value.image;
            //var remark = value.remark.replace(/<br> ?/g, '&#013;&#010;');
            $(".data-table-document tbody").append("<tr>" +
                "<td>" + sl + "</td>" +
                "<td>" + value.type + "</td>" +
                "<td><p class='text-justify'>" + value.remark + "</p></td>" +
                "<td><img src=" + imagesrc + " id='imgProfile' width='150px' height='100px'></td>" +
                "<td>" +
                '<div class="btn-group" role="group" aria-label="Basic example">' +
                '<a type="button" id="datashowcash" class="btn btn-danger btn-sm" data-id="' + value.id + '">Delete</a>' +
                '</div>' +
                "</td>" +
                "</tr>");
            sl++;
        })
    }
    //Cash Invoice

    function LoadTableDataCash() {
        invoicetable = $('#tablebodycash').DataTable({
            paging: true,
            scrollX: true,
            scrollY: 300,
            ordering: true,
            searching: true,
            select: true,
            autoFill: true,
            colReorder: true,
            keys: true,
            processing: true,
            serverSide: true,
            iDisplayLength: 50,

            footerCallback: function() {
                var sum = 0;
                var column = 0;
                this.api().columns('3', {
                    page: 'current'
                }).every(function() {
                    column = this;
                    sum = column
                        .data()
                        .reduce(function(a, b) {
                            a = parseFloat(a, 10);
                            if (isNaN(a)) {
                                a = 0;
                            }
                            b = parseFloat(b, 10);
                            if (isNaN(b)) {
                                b = 0;
                            }
                            return (a + b).toFixed(2);
                        }, 0);
                    /* if (!sum.includes('€'))
                      sum += ' &euro;'; */
                    $(column.footer()).html(sum);

                });
            },

            dom: "<'row'<'col-sm-4'l><'col-sm-5 text-center'B><'col-sm-3'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [{
                    text: '<i class="fa fa-refresh"></i>Refresh',
                    action: function() {
                        invoicetable.ajax.reload();
                    },
                    className: 'btn btn-info',
                },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i>Excel',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                    footer: true,
                },
                {
                    /*  extend: 'pdf', */

                    text: '<i class="fa fa-file-pdf-o"></i>PDF',
                    extend: 'pdf',
                    className: 'btn btn-light',
                    orientation: 'portrait', //portrait',
                    pageSize: 'A4',
                    title: 'Invoice List(Cash)',
                    filename: 'invoice',
                    className: 'btn btn-danger',
                    //download: 'open',
                    exportOptions: {
                        /* modifer: {
                          page: 'all',
                        }, */
                        columns: [0, 1, 2, 3, 4],
                        modifier: {
                            page: 'all',
                            search: 'none'
                        }
                    },
                    footer: true,
                    customize: function(doc) {
                        doc.styles.title = {
                            color: 'red',
                            fontSize: '20',
                            // background: 'blue',
                            alignment: 'center'
                        }
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>Print',
                    className: 'btn btn-dark',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                    footer: true,
                },
            ],

            "ajax": {
                "url": "{{ route('invoice.getlistcustomercash') }}",
                "data": {
                    customerid: customerid,
                },
                "type": "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: "text-center"
                },
                {
                    data: 'invoice_no',
                    name: 'invoice_no',
                    className: "text-center"
                },
                {
                    data: 'inputdate',
                    name: 'inputdate',
                    className: "text-center"
                },
                {
                    data: 'nettotal',
                    name: 'nettotal',
                    className: "text-right"
                },
                {
                    data: 'paymenttype',
                    name: 'paymenttype',
                    orderable: false,
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
    }
    $(document).on('click', '#datashowcash', function() {
        var id = $(this).data("id");
        url = "{{ url('Admin/Invoice/show')}}" + '/' + id,
            window.location = url;

    });
    //end cash invoice History
    //Credit Invoice

    var invoicetablecredit;

    function LoadTableDataCredit() {
        invoicetablecredit = $('#tablebodycredit').DataTable({
            paging: true,
            scrollX: true,
            scrollY: 300,
            ordering: true,
            searching: true,
            select: true,
            autoFill: true,
            colReorder: true,
            keys: true,
            processing: true,
            serverSide: true,
            iDisplayLength: 50,

            footerCallback: function() {
                var sum = 0;
                var column = 0;
                this.api().columns('3', {
                    page: 'current'
                }).every(function() {
                    column = this;
                    sum = column
                        .data()
                        .reduce(function(a, b) {
                            a = parseFloat(a, 10);
                            if (isNaN(a)) {
                                a = 0;
                            }
                            b = parseFloat(b, 10);
                            if (isNaN(b)) {
                                b = 0;
                            }
                            return (a + b).toFixed(2);
                        }, 0);
                    /*   if (!sum.includes('€'))
                        sum += ' &euro;'; */
                    $(column.footer()).html(sum);

                });
            },

            dom: "<'row'<'col-sm-4'l><'col-sm-5 text-center'B><'col-sm-3'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [{
                    text: '<i class="fa fa-refresh"></i>Refresh',
                    action: function() {
                        invoicetablecredit.ajax.reload();
                    },
                    className: 'btn btn-info',
                },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i>Excel',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                    footer: true,
                },
                {
                    /*  extend: 'pdf', */

                    text: '<i class="fa fa-file-pdf-o"></i>PDF',
                    extend: 'pdf',
                    className: 'btn btn-light',
                    orientation: 'portrait', //portrait',
                    pageSize: 'A4',
                    title: 'Invoice List(Cash)',
                    filename: 'invoice',
                    className: 'btn btn-danger',
                    //download: 'open',
                    exportOptions: {
                        /* modifer: {
                          page: 'all',
                        }, */
                        columns: [0, 1, 2, 3, 4],
                        modifier: {
                            page: 'all',
                            search: 'none'
                        }
                    },
                    footer: true,
                    customize: function(doc) {
                        doc.styles.title = {
                            color: 'red',
                            fontSize: '20',
                            // background: 'blue',
                            alignment: 'center'
                        }
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>Print',
                    className: 'btn btn-dark',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                    footer: true,
                },
            ],

            "ajax": {
                "url": "{{ route('creditinvoice.getlistcustomercredit') }}",
                "data": {
                    customerid: customerid,
                },
                "type": "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: "text-center"
                },
                {
                    data: 'invoice_no',
                    name: 'invoice_no',
                    className: "text-center"
                },
                {
                    data: 'inputdate',
                    name: 'inputdate',
                    className: "text-center"
                },
                {
                    data: 'nettotal',
                    name: 'nettotal',
                    className: "text-right"
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        });
    }
    $(document).on('click', '#datashowcredit', function() {
        var id = $(this).data("id");
        url = "{{ url('Admin/Invoice/show')}}" + '/' + id,
            window.location = url;

    });

    //end credit invoice History
    var tablepayment;

    function LoadTableDatapayment() {

        tablepayment = $('#tableypayment').DataTable({
            paging: true,
            scrollY: 300,
            ordering: true,
            searching: true,
            select: true,
            autoFill: true,
            colReorder: true,
            keys: true,
            fixedHeader: false,
            processing: true,
            serverSide: true,
            footerCallback: function() {
                var sum = 0;
                var column = 0;
                this.api().columns('4,5', {
                    page: 'current'
                }).every(function() {
                    column = this;
                    sum = column
                        .data()
                        .reduce(function(a, b) {
                            a = parseFloat(a, 10);
                            if (isNaN(a)) {
                                a = 0;
                            }
                            b = parseFloat(b, 10);
                            if (isNaN(b)) {
                                b = 0;
                            }
                            return (a + b).toFixed(2);
                        }, 0);

                    $(column.footer()).html(sum);

                });
            },
            dom: "<'row'<'col-sm-4'l><'col-sm-5 text-center'B><'col-sm-3'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",

            buttons: [{
                    text: '<i class="fa fa-refresh"></i>Refresh',
                    action: function() {
                        tablepayment.ajax.reload();
                    },
                    className: 'btn btn-info',
                },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i>Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                    footer: true,
                },
                {
                    text: '<i class="fa fa-file-pdf-o"></i>PDF',
                    extend: 'pdf',
                    className: 'btn btn-light',
                    orientation: 'portrait', //portrait',
                    pageSize: 'A4',
                    title: 'Credit Payment List',
                    filename: 'CreditPayment',
                    className: 'btn btn-danger',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
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
                    text: '<i class="fa fa-print"></i>Print',
                    className: 'btn btn-dark',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                    footer: true,
                },
            ],
            "ajax": {
                "url": "{{ route('customerpayment.getlistcustomer') }}",
                "data": {
                    customerid: customerid,
                },
                "type": "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: "text-center"
                },
                {
                    data: 'payment_no',
                    name: 'payment_no',
                    className: "text-center"
                },
                {
                    data: 'inputdate',
                    name: 'inputdate',
                    className: "text-center"
                },
                {
                    data: 'amount',
                    name: 'amount',
                    className: "text-right"

                },
                {
                    data: 'recieve',
                    name: 'recieve',
                    className: "text-right"

                },
                {
                    data: 'balancedue',
                    name: 'balancedue',
                    className: "text-right"

                },
                {
                    data: 'paymenttype',
                    name: 'paymenttype',
                    className: "text-center"
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
    }
    $(document).on('click', '#datashowpayment', function() {
        var id = $(this).data("id");
        url = "{{ url('Admin/CustomerPayment/show')}}" + '/' + id,
            window.location = url;
    });

    function totalpayment() {
        var sum = 0;
        $(".payment").each(function() {
            var value = $(this).text();
            if (!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });
        $("#payment").html('<b style="color:red">' + sum + '</b>');
    }

    function customerinfo(customerid) {
        $.ajax({
            type: 'get',
            url: "{{url('Admin/Customer/customerinfo')}}?customerid=" + customerid,
            success: function(data) {
                /*  console.log(data); */
                CustomerBasicInfo(data.customer);
                Customeraddress(data.customer);
                customerDocument(data.customer.customer_document)
                CustomerinfoDetails(data);
                LoadTableDataCash();
                LoadTableDataCredit();
                LoadTableDatapayment();
                changeUrl();
            },
            error: function(data) {
                console.log(data);
            }
        });
    }


    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust()

    });


    $imgSrc = $('#imgProfile').attr('src');

    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#imgProfile').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    $('#btnChangePicture').on('click', function() {
        // document.getElementById('profilePicture').click();
        if (!$('#btnChangePicture').hasClass('changing')) {
            $('#profilePicture').click();
        } else {
            var name = document.getElementById("profilePicture").files[0].name;
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                alert("Invalid Image File");
            }
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("profilePicture").files[0]);
            var f = document.getElementById("profilePicture").files[0];
            var fsize = f.size || f.fileSize;
            if (fsize > 2000000) {
                alert("Image File Size is very big");
            } else {

                form_data.append("file", document.getElementById('profilePicture').files[0]);
                form_data.append("id", customerid);
                $.ajax({
                    type: 'post',
                    url: "{{ url('Admin/Customer/ImageChange')}}",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        location.reload(true);
                        // console.log(data)
                    },
                    error: function(data) {
                        console.log(data)
                    }
                });
            }
        }
    });
    $('#profilePicture').on('change', function() {
        readURL(this);
        $('#btnChangePicture').addClass('changing');
        $('#btnChangePicture').attr('value', 'Confirm');
        $('#btnDiscard').removeClass('d-none');
        // $('#imgProfile').attr('src', '');
    });
    $('#btnDiscard').on('click', function() {
        // if ($('#btnDiscard').hasClass('d-none')) {
        $('#btnChangePicture').removeClass('changing');
        $('#btnChangePicture').attr('value', 'Change');
        $('#btnDiscard').addClass('d-none');
        $('#imgProfile').attr('src', $imgSrc);
        $('#profilePicture').val('');
        // }
    });
</script>