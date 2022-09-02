<script type="text/javascript">
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
      autoFill: true,
      colReorder: true,
      keys: true,
      fixedHeader: false,
      processing: true,
      serverSide: true,
      footerCallback: function() {
        var sum = 0;
        var column = 0;
        this.api().columns('5', {
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
      dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",

      buttons: [{
          text: '<i class="fa fa-refresh"></i>@lang("home.refresh")',
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
          text: '<i class="fa fa-files-o"></i>@lang("home.export")',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7]
          },
          footer: true,
        },
        {
          extend: 'csv',
          text: '<i class="fa fa-file-text-o"></i>@lang("home.csv")',
          className: 'btn btn-info',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7]
          },
          footer: true,
        },
        {

          extend: 'excel',
          text: '<i class="fa fa-file-excel-o"></i>@lang("home.excel")',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7]
          },
          footer: true,
        },
        {
          text: '<i class="fa fa-file-pdf-o"></i>@lang("home.pdf")',
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
          text: '<i class="fa fa-print"></i>@lang("home.print")',
          className: 'btn btn-dark',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7]
          },
          footer: true,
        },

      ],
      "ajax": {
        "url": "{{ route('customerpayment.loadall') }}",
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
          data: 'customer',
          name: 'customer',
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
          data: 'paymentdescription',
          name: 'paymentdescription',
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
  window.onload = DataTable();
  $("#submitdate").on('click', function() {
    if ($("#max").val() == "" || $("#min").val() == "") {
      swal("Opps! Faild", "Please Select Between Date", "error");
    } else {
      table.destroy();
      DataTable();
    }

  });


  function SupplierDataList() {
    $.ajax({
      type: 'get',
      url: "{{ route('customer.customerdatalist') }}",
      datatype: 'JSON',
      success: function(data) {
        $('#customer').html(data);
      },
      error: function(data) {}
    })
  }



  $(document).on('click', '#datashow', function() {
    var id = $(this).data("id");
    url = "{{ url('Admin/CustomerPayment/show')}}" + '/' + id,
      window.location = url;
  });
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
            url: "{{ url('Admin/CustomerPayment/delete')}}" + '/' + dataid,
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
  $(document).on('click', "#pdf", function() {
    var id = $(this).data("id");
    url = "{{ url('Admin/CustomerPayment/pdf')}}" + '/' + id,
      window.open(url, '_blank');
  })
  $(document).on('click', "#mail", function() {
    var id = $(this).data("id");
    url = "{{ url('Admin/CustomerPayment/sendmail')}}" + '/' + id,
      window.location = url;
  });
  //supplier text search
  $("#suppliersearch").on('input', function() {
    var val = this.value;
    if (val == "") {
      readAllData();
    } else {

      if ($('#supplier option').filter(function() {
          return this.value.toUpperCase() === val.toUpperCase();
        }).length) {
        var dataid = $('#supplier').find('option[value="' + val + '"]').attr('id');

        $.ajax({
          type: 'post',
          url: "{{ route('purchase.getsupplierbyid') }}",
          //data: data,
          data: {
            dataid: dataid,
          },
          datatype: 'JSON',
          success: function(data) {
            LoadTableData(data);
          },
          error: function(data) {
            //console.log(data);
          }
        });

      }
    }

  });
</script>