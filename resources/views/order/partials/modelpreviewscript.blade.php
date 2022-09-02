<script>
 

  //invoice view
  function ViewInvoiceCode() {
    $.ajax({
      type: 'get',
      url: "{{ route('invoice.invoicecodedatalist') }}",
      datatype: 'JSON',
      success: function(data) {
        $('#invoicenumbercheck').html(data);
      },
      error: function(data) {}
    });
  }
  window.onload = ViewInvoiceCode();
  setInterval("ViewInvoiceCode()", 1000);
  $("#invoicecodecheck").on('input', function() {
    var val = this.value;
    if ($('#invoicenumbercheck option').filter(function() {
        return this.value.toUpperCase() === val.toUpperCase();
      }).length) {
      var productid = $('#invoicenumbercheck').find('option[value="' + val + '"]').attr('id');
      $.ajax({
        type: "get",
        url: "{{ url('Admin/Invoice/getView')}}" + '/' + productid,
        datatype: ("json"),
        success: function(data) {
          if (data) {
            lodData(data);
          } else {
            invoiceClear();
          }

        },
        error: function(data) {
          console.log(data)
        }
      });
    }
  });

  function lodData(data) {
    var paymenttype = data.paymenttype_id = 1 ? 'Cash' : 'Card';
    var type = data.type_id = 1 ? 'Cash Invoice' : 'Credit';
    $("#invoicenoc").html(data.invoice_no)
    $("#invoicedatec").html(data.inputdate)
    $("#refnoc").html(data.ref_no)
    $("#typec").html(type)
    $("#paymenttypec").html(paymenttype)
    loadTableDetails(data);
    customerInformation(data);
  }

  function customerInformation(data) {
    $("#customernamec").html(data.customer_name['name']);
    $("#customeraddressc").html("<p>" + data.customer_name['address'] + "," + data.customer_name.city_name['name'] + "," + data.customer_name.state_name['name'] + ",</p>");
    $("#customercountryc").html("<p>" + data.customer_name.country_name['name'] + ".</p>");
    $("#mobilec").html("&nbsp;&nbsp;" + data.customer_name['mobile_no']);
    $("#telnoc").html("&nbsp;&nbsp;" + data.customer_name['tell_no']);
    $("#emailc").html("&nbsp;&nbsp;" + data.customer_name['email']);
    $("#websitec").html("&nbsp;&nbsp;" + data.customer_name['website']);
  }

  function loadTableDetails(data) {
    $("#tablebodyc").empty();
    var sl = 1;
    data.inv_details.forEach(function(value) {
      $(".data-tablec tbody").append("<tr>" +
        "<td>" + sl + "</td>" +
        "<td>" + value.product_name['name'] + "</td>" +
        "<td>" + value.qty + "</td>" +
        "<td>" + value.unit_name['Shortcut'] + "</td>" +
        "<td>" + value.mrp + "</td>" +
        "<td>" + value.amount + "</td>" +
        "</tr>");
      sl++;
    })
    $(".data-tablec tbody").append(
      "<tr>" +
      "<td colspan='5' align='right'><b>Groce Total</b></td>" +
      "<td align='right'>" + data.amount + "</td>" +
      "</tr>" +
      "<tr>" +
      "<td colspan='5' align='right'><b>Discount</b></td>" +
      "<td align='right'>" + data.discount + "</td>" +
      "</tr>" +
      "<tr>" +
      "<td colspan='5' align='right'><b>Vat</b></td>" +
      "<td align='right'>" + data.vat + "</td>" +
      "</tr>" +
      "<tr>" +
      "<td colspan='5' align='right'><b>Net Total</b></td>" +
      "<td align='right'>" + data.nettotal + "</td>" +
      "</tr>"
    );
  }
  $("#invoicecheck").on('click', function() {
    invoiceClear();
  });

  function invoiceClear() {
    $("#invoicecodecheck").val("");
    $("#invoicenumbercheck").val("");
    $("#invoicenoc").html("")
    $("#invoicedatec").html("")
    $("#refnoc").html("")
    $("#typec").html("")
    $("#subtotalc").html("")
    $("#discountc").html("")
    $("#vatc").html("")
    $("#nettotalc").html("")
    $("#paymenttypec").html("")
    $("#customernamec").html("")
    $("#customeraddressc").html("")
    $("#customercountryc").html("")
    $("#mobilec").html("")
    $("#telnoc").html("")
    $("#emailc").html("")
    $("#websitec").html("")
    $(".data-tablec tbody").empty();
  }




</script>