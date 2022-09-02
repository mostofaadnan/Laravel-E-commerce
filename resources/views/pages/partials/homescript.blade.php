<script>
  $(document).ready(function() {


    var type = 1;
    var data;


    $(".btn-group > .btn").click(function() {
      $(".btn-group > .btn").removeClass("active");
      $(this).addClass("active");
    });

    function GetData() {
      if ($("#today").on('click')) {
        type = 1;
      } else if ($("#sevenday").on('click')) {
        type = 2;
      } else if ($("#thismonth").on('click')) {
        type = 3;
      } else if ($("#thisyear").on('click')) {
        type = 4;
      }

    }
    $("#today").on('click', function() {
      type = 1;
      accountSummerise();

      console.log(type)
    })
    $("#sevenday").on('click', function() {
      type = 2;
      accountSummerise();
      console.log(type)
    })
    $("#thismonth").on('click', function() {
      type = 3;
      accountSummerise();
      console.log(type)
    })
    $("#thisyear").on('click', function() {
      type = 4;
      accountSummerise();
      console.log(type)
    })

    function accountSummerise() {
      $.ajax({
        type: 'get',
        data: {
          type: type
        },
        url: "{{ route('accountsummery') }}",
        datatype: 'JSON',
        success: function(data) {

          $("#invoice").html(parseFloat(data.invoice).toFixed(2))
          $("#order").html(parseFloat(data.order).toFixed(2))
          $("#purchase").html(parseFloat(data.purchase).toFixed(2))
          $("#ppayment").html(parseFloat(data.SupplierPayment).toFixed(2))
          $("#cpayment").html(parseFloat(data.CustomerRecieved).toFixed(2))
          $("#cdrawer").html(parseFloat(data.balance).toFixed(2))
          $("#expencess").html(parseFloat(data.Expenses).toFixed(2))
        },
        error: function(data) {
          console.log(data);
        }
      });
    }

    function TableDetails() {
  
    }
    $("#loadall").on('click', function() {
      tabledataone.reload();
    });
 
    var ordertable;

    function OrderDataTable() {
      var fromdate = $("#min").val();
      var todate = $("#max").val();

      table = $('#orderTable').DataTable({
        responsive: true,
        paging: true,
        scrollY: 300,
        ordering: true,
        searching: true,
        colReorder: true,
        keys: true,
        processing: true,
        serverSide: true,
        AutoWidth: false,
        aLengthMenu: [
          [25, 50, 100, 200, -1],
          [25, 50, 100, 200, "All"]
        ],
        iDisplayLength: 100,
        footerCallback: function() {
          var sum = 0;
          var column = 0;
          this.api().columns('4', {
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

        dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",


        "ajax": {
          "url": "{{ route('order.recent') }}",
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
            data: 'customer',
            name: 'customer',
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
            data: 'status',
            name: 'status',
            className: "status",
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
    window.onload = OrderDataTable();

    window.onload = accountSummerise();
    $(document).on('click', '#datashow', function() {
      var id = $(this).data("id");
      url = "{{ url('Admin/Order/show')}}" + '/' + id,
        window.location = url;
    });
    $(document).on('click', '#pdf', function() {
      var id = $(this).data("id");
      url = "{{ url('Admin/Order/invoicepdf')}}" + '/' + id,
        window.open(url, '_blank');
    });
    $(document).on('click', '#printslip', function() {
      var id = $(this).data("id");
      url = "{{ url('Admin/Order/LoadPrintslip')}}" + '/' + id,
        window.open(url, '_blank');
    });
    $(document).on('click', '#mail', function() {
      var id = $(this).data("id");
      url = "{{ url('Admin/Order/sendmail')}}" + '/' + id,
        window.location = url;
    });
    $(document).on('click', "#recieved", function() {
      var id = $(this).data("id");
      url = "{{ url('Admin/Order/orderrecived')}}" + '/' + id,
        window.location = url;
    });
    $(document).on('click', "#delivery", function() {
      var id = $(this).data("id");
      url = "{{ url('Admin/Order/OrderDelivery')}}" + '/' + id,
        window.location = url;

    });
    $(document).on('click', '#canceldata', function() {
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
              url: "{{ url('Admin/Order/cancel')}}" + '/' + id,
              success: function(data) {
                $('#mytable').DataTable().ajax.reload()
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
  });
</script>