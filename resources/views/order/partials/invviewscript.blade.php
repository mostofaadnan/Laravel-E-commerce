<script type="text/javascript">
  $(document).ready(function() {
    var invoiceid = 0;

    function ViewInvoiceCode() {
      $.ajax({
        type: 'get',
        url: "{{ route('order.invoicecodedatalist') }}",
        datatype: 'JSON',
        success: function(data) {
          $('#invoicenumber').html(data);
        },
        error: function(data) {}
      });
    }
    window.onload = ViewInvoiceCode();

    $("#invoicecode").on('input', function() {
      var val = this.value;
      if ($('#invoicenumber option').filter(function() {
          return this.value.toUpperCase() === val.toUpperCase();
        }).length) {
        invoiceid = $('#invoicenumber').find('option[value="' + val + '"]').attr('id');
        InvoiceDetails(invoiceid);
      }
    });

    function InvoiceDetails(id) {
      $.ajax({
        type: "get",
        data: {
          id: id
        },
        url: "{{ route('order.getView')}}",
        datatype: ("json"),
        success: function(data) {
          invoiceid = data.id
          $("#invoicecode").val(data.invoice_no);
          lodData(data);
    
        },
        error: function(data) {

        }

      });
    }
    window.onload = InvoiceDetails("{{ $id }}");

    function lodData(data) {
      var status = "";
      var sts = data.status;

      switch (sts) {
        case '0':
          status = 'New Order';
          break;
        case '1':
          status = 'Recieved';
          break;
        case '3':
          status = 'Delivired';
          break;
        default:
          break;
      }
      $("#invoiceno").html(data.invoice_no)
      $("#cardinvno").html(data.invoice_no)
      $("#invoicedate").html(data.inputdate)
      $("#delvarydate").html(data.delivery_date)
      $("#subtotal").html(data.amount)
      // $("#discount").html(data.discount)
      $("#vat").html(data.vat)
      $("#shipment").html(data.shipment)
      $("#nettotal").html(data.nettotal)
      $("#paymenttype").html(data.paymenttype)
      $("#status").html(status);
      loadTableDetails(data);
      showHideBtn(data);
      customerInformation(data);
      PaymentInfo(data.payment);
    }

    function customerInformation(data) {
      $("#customername").html(data.customer_name['name']);
      $("#customeraddress").html("<p>" + data.customer_name['address'] + "," + data.customer_name.city_name['name'] + "," + data.customer_name.state_name['name'] + ",</p>");
      $("#customercountry").html("<p>" + data.customer_name.country_name['name'] + ".</p>");
      $("#mobile").html("&nbsp;&nbsp;" + data.customer_name['mobile_no']);
      $("#email").html("&nbsp;&nbsp;" + data.customer_name['email']);
    }

    function loadTableDetails(data) {
      $("#tablebody").empty();
      var sl = 1;
      data.inv_details.forEach(function(value) {
        $(".data-table tbody").append("<tr>" +
          "<td>" + sl + "</td>" +
          "<td class='itemname'>" + value.product_name['name'] + "</td>" +
          "<td align='right'>" + value.qty + "</td>" +
          "<td>" + value.unit_name['Shortcut'] + "</td>" +
          "<td align='right'>" + value.mrp + "</td>" +
          "<td align='right' class='vat'>" + value.amount + "</td>" +
          "</tr>");
        sl++;
      })
    }

    function showHideBtn(data) {
      console.log(data.status);
      switch (data.status) {
        case '0':
          $("#recieved").show();
          $("#recieved-dev").show();
          $("#delivary").hide();
          $("#delivary-dev").hide();
          break;
        case '1':
          $("#recieved").hide();
          $("#recieved-dev").hide();
          $("#delivary").show();
          $("#delivary-dev").show();
          break;
        default:
          $("#recieved").hide();
          $("#recieved-dev").hide();
          $("#delivary").hide();
          $("#delivary-dev").hide();
          break;
      }

    }

    function PaymentInfo(data) {
      /* $("#cardinvno").html(data.) */
      $("#cardtrn").html(data.tran_id)
      $("#carddate").html(data.tran_date)
      $("#cardtype").html(data.card_type)
      $("#cardno").html(data.card_no)
      $("#cardbanktrn").html(data.bank_tran_id)
      $("#cardissue").html(data.card_issuer)
      $("#cardbank").html(data.card_brand)
      $("#cardcountry").html(data.card_issuer_country	)
      $("#storeid").html(data.store_id)
      $("#cardamt").html(data.amount)
      $("#storeamt").html(data.store_amount)

    }
    $("#orderpdf").on('click', function() {
      if (invoiceid > 0) {
        url = "{{ url('Admin/Order/orderPdf')}}" + '/' + invoiceid,
          window.open(url, '_blank');
      }
    });
    $("#printslip").on('click', function() {
      if (invoiceid > 0) {
        url = "{{ url('Admin/Order/LoadPrintslip')}}" + '/' + invoiceid,
          window.open(url, '_blank');
      }

    });
    $("#mail").on('click', function() {
      if (invoiceid > 0) {
        url = "{{ url('Admin/Order/sendmail')}}" + '/' + invoiceid,
          window.location = url;
      }

    });
    $("#recieved").on('click', function() {
      if (invoiceid > 0) {
        url = "{{ url('Admin/Order/orderrecived')}}" + '/' + invoiceid,
          window.location = url;
      }
    });
    $("#delivary").on('click', function() {
      if (invoiceid > 0) {
        url = "{{ url('Admin/Order/OrderDelivery')}}" + '/' + invoiceid,
          window.location = url;
      }
    });

    $(document).on('click', '#recievedOrder', function() {
      if (invoiceid > 0) {
        swal({
            title: "Are you sure?",
            text: "If you recieved This Order,Customer Has send A notification",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              var id = $(this).data("id");
              var delivarydate = $("#startDate").val();
              $.ajax({
                type: "post",

                url: "{{ url('Admin/Order/recived')}}" + '/' + invoiceid,
                data: {
                  delivarydate: delivarydate
                },
                success: function(data) {
                  url = "{{ url('Admin/Order/show')}}" + '/' + invoiceid,
                    window.location = url;
                },
                error: function(data) {
                  console.log(data);
                  swal("Opps! Faild", "Data Fail to Cancel", "error");
                }
              });
              swal("Ok! This Order has been Recieved!", {
                icon: "success",
              });
            } else {
              swal("Your file is become new Order!");
            }
          });
      }
    });
    $(document).on('click', '#deliverorder', function() {
      if (invoiceid > 0) {
        swal({
            title: "Are you sure?",
            text: "If you recieved This Order,Customer Has send A notification",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {

              var delivarydate = $("#dateinput").val();
              var empid = $("#employee_id").val();
              var exp = $("#shipment").val();
              var remark = $("#remark").val();
              $.ajax({
                type: "post",
                url: "{{ url('Admin/Order/delivery')}}" + '/' + invoiceid,
                data: {
                  delivarydate: delivarydate,
                  empid: empid,
                  exp: exp,
                  remark: remark
                },
                success: function(data) {

                  pdfurl = "{{ url('Admin/Order/deliverypdf')}}" + '/' + invoiceid,
                    window.open(pdfurl, '_blank');
                  url = "{{ url('Admin/Order/show')}}" + '/' + invoiceid,
                    window.location = url;
                },
                error: function(data) {
                  console.log(data);
                  swal("Opps! Faild", "Data Fail to Cancel", "error");
                }
              });
              swal("Ok! This Order has been Recieved!", {
                icon: "success",
              });
            } else {
              swal("Your file is become new Order!");
            }
          });
      }
    });
    $(document).on('click', '#canceldata', function() {
      if (invoiceid > 0) {
        swal({
            title: "Are you sure?",
            text: "Once Cancel, you will not be able to recover this  data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              var id = $(this).data("id");
              $.ajax({
                type: "post",
                url: "{{ url('Admin/Invoice/cancel')}}" + '/' + invoiceid,
                success: function(data) {
                  url = "{{ route('invoices')}}",
                    window.location = url;
                },
                error: function(data) {
                  console.log(data);
                  swal("Opps! Faild", "Data Fail to Cancel", "error");
                }
              });
              swal("Ok! Your file has been cancelled!", {
                icon: "success",
              });
            } else {
              swal("Your file is safe!");
            }
          });
      }
    });
    $("#dataprint").on("click", function(e) {
      var sTable = $("#DivIdToPrint").html();
      var style = "<style>";
      style = style + "table {width: 100%;font: 17px Calibri;}";
      style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
      style = style + "padding: 2px 3px;text-align: center;}";
      style = style + "</style>";

      // CREATE A WINDOW OBJECT.
      var win = window.open('', '', 'height=700,width=700');
      win.document.write('<html><head>');
      win.document.write('<title>Profile</title>'); // <title> FOR PDF HEADER.
      win.document.write(style); // ADD STYLE INSIDE THE HEAD TAG.
      win.document.write('</head>');
      win.document.write('<body>');
      win.document.write(sTable); // THE TABLE CONTENTS INSIDE THE BODY TAG.
      win.document.write('</body></html>');

      win.document.close(); // CLOSE THE CURRENT WINDOW.

      win.print(); // PRINT THE CONTENTS.

    });


  });
</script>