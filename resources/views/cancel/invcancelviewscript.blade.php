<script>
  var invoiceid;

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
        url: "{{ url('Session-Id/invid')}}" + '/' + urlid,
        success: function() {
          InvoiceDetails();
        }
      });
    }
  });

  function InvoiceDetails() {
    $.ajax({
      type: "get",
      url: "{{ url('Invoice/getView')}}",
      datatype: ("json"),
      success: function(data) {
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
  $(document).on('click', '#datadelete', function() {
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
            url: "{{ url('Invoice/canceldestroy')}}" + '/' + invoiceid,
            success: function(data) {
              url = "{{ route('invoice.cancels')}}",
                document.location.href = url;

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
  });

  //retrive
  $(document).on('click', '#retrivedata', function() {
    swal({
        title: "Are you sure?",
        text: "If You will Retrive This data,it will cash back",
        icon: "success",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          var id = $(this).data("id");
          $.ajax({
            type: "post",
            url: "{{ url('Admin/Invoice/retrive')}}" + '/' + invoiceid,
            success: function(data) {
              url = "{{ route('invoice.cancels')}}",
                document.location.href = url;
            },
            error: function(data) {
              console.log(data);
              swal("Opps! Faild", "Data Fail to Retribe", "error");
            }
          });
          swal("Ok! Your file has been Retrived!", {
            icon: "success",
          });
        } else {
          swal("Your file is not retrive!");
        }
      });
  });
</script>