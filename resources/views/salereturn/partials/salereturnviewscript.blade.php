<script>
    var returnid;

    function ViewReturnCode() {
        $.ajax({
            type: 'get',
            url: "{{ route('salereturn.salereturncodedatalist') }}",
            datatype: 'JSON',
            success: function(data) {
                $('#returnnumber').html(data);
            },
            error: function(data) {
                console.log(data)
            }
        });
    }

    window.onload = ViewReturnCode();

    $("#returncode").on('input', function() {
        var val = this.value;
        if ($('#returnnumber option').filter(function() {
                return this.value.toUpperCase() === val.toUpperCase();
            }).length) {
            returnid = $('#returnnumber').find('option[value="' + val + '"]').attr('id');

            $.ajax({
                type: 'post',
                url: "{{ url('Admin/Session-Id/salereturnid')}}" + '/' + returnid,
                success: function() {
                    returnDetails();
                }
            });

        }
    });

    function returnDetails() {
        $.ajax({
            type: "get",
            url: "{{ url('Admin/Sale-Return/getview')}}",
            datatype: ("json"),
            success: function(data) {
                returnid = data.id;
                $("#returncode").val(data.return_no);
                lodData(data);
            },
            error: function(data) {
                console.log(data)
            }

        });
    }
    window.onload = returnDetails();

    function lodData(data) {
        ;
        var type = data.type_id = 1 ? 'Cash Invoice' : 'Credit';
        $("#returnno").html(data.return_no)
        $("#invoiceno").html(data.invoice_id)
        $("#invoicedate").html(data.inputdate)
        $("#refno").html(data.ref_no)
        $("#type").html(type)
        $("#subtotal").html(data.amount)
        $("#discount").html(data.discount)
        $("#vat").html(data.vat)
        $("#nettotal").html(data.nettotal)
        loadTableDetails(data);
        customerInformation(data);
    }

    function customerInformation(data) {
        $("#customername").html(data.customer_name['name']);
        $("#customeraddress").html("<p>" + data.customer_name['address'] + "," + data.customer_name.city_name['name'] + "," + data.customer_name.state_name['name'] + ",</p>");
        $("#customercountry").html("<p>" + data.customer_name.country_name['name'] + ".</p>");
        $("#mobile").html("&nbsp;&nbsp;" + data.customer_name['mobile_no']);
        $("#telno").html("&nbsp;&nbsp;" + data.customer_name['tell_no']);
        $("#email").html("&nbsp;&nbsp;" + data.customer_name['email']);
        $("#website").html("&nbsp;&nbsp;" + data.customer_name['website']);
    }

    function loadTableDetails(data) {
        $("#tablebody").empty();
        var sl = 1;
        data.return_details.forEach(function(value) {
            $(".data-table tbody").append("<tr>" +
                "<td>" + sl + "</td>" +
                "<td class='itemname'>" + value.product_name['name'] + "</td>" +
                "<td align='right'>" + value.qty + "</td>" +
                "<td>" + value.product_name.unit_name['Shortcut'] + "</td>" +
                "<td align='right'>" + value.mrp + "</td>" +
                "<td align='right' class='vat'>" + value.amount + "</td>" +
                "</tr>");
            sl++;
        })
    }
    $("#returnpdf").on('click', function() {
        url = "{{ url('Admin/Sale-Return/returnpdf')}}" + '/' + returnid,
            window.open(url, '_blank');

    });
    $(document).on('click', '#printslip', function() {

        url = "{{ url('Admin/Sale-Return/LoadPrintslip')}}" + '/' + returnid,
            window.open(url, '_blank');
    });
    $("#mail").on('click', function() {
        if (returnid > 0) {
            url = "{{ url('Admin/Sale-Return/sendmail')}}" + '/' + returnid,
                window.location = url;
        }

    });
    $(document).on('click', "#deletedata", function() {
        if (returnid > 0) {
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
                            url: "{{ url('Admin/Sale-Return/delete')}}" + '/' + returnid,
                            success: function() {
                                url = "{{ route('salereturns')}}",
                                    window.location = url;
                            },
                            error: function(data) {

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
        }


    });
</script>