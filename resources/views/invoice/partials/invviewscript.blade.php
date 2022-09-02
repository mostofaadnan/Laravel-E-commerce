<script>
  var invoiceid = 0;
  /* 
    function getUrl() {
      var url = $(location).attr('href')
      var segment = url.split("/").length - 1 - (url.indexOf("http://") == -1 ? 0 : 2);
      if (segment == 3) {
        invoiceid = url.substring(url.lastIndexOf('/') + 1);
        InvoiceDetails();
      } else {
        invoiceid = 0;
      }
    } */

  function ViewInvoiceCode() {
    $.ajax({
      type: 'get',
      url: "{{ route('invoice.invoicecodedatalist') }}",
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
      $.ajax({
        type: 'post',
        url: "{{ url('Session-Id/invid')}}" + '/' + invoiceid,
        success: function() {
          InvoiceDetails();
        }
      });
    }
  });

  function InvoiceDetails() {
    $.ajax({
      type: "get",
      url: "{{ url('Admin/Invoice/getView')}}",
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
  window.onload = InvoiceDetails();

  function lodData(data) {
    var paymenttype = data.paymenttype_id = 1 ? 'Cash' : 'Card';
    var type = data.type_id = 1 ? 'Cash Invoice' : 'Credit';
    $("#invoiceno").html(data.invoice_no)
    $("#invoicedate").html(data.inputdate)
    $("#refno").html(data.ref_no)
    $("#type").html(type)
    $("#subtotal").html(data.amount)
    $("#discount").html(data.discount)
    $("#vat").html(data.vat)
    $("#shipment").html(data.shipment)
    $("#nettotal").html(data.nettotal)
    $("#paymenttype").html(paymenttype)
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
  $("#invoicepdf").on('click', function() {
    if (invoiceid > 0) {
      url = "{{ url('Admin/Invoice/invoicepdf')}}" + '/' + invoiceid,
        window.open(url, '_blank');
    }
  });
  $("#printslip").on('click', function() {
    if (invoiceid > 0) {
      url = "{{ url('Admin/Invoice/LoadPrintslip')}}" + '/' + invoiceid,
        window.open(url, '_blank');
    }

  });
  $("#mail").on('click', function() {
    if (invoiceid > 0) {
      url = "{{ url('Admin/Invoice/sendmail')}}" + '/' + invoiceid,
        window.location = url;
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
</script>

<script>
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
</script>