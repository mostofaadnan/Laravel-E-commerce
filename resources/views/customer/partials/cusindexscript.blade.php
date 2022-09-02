<script>
  var table;
  var customerid;

  function RetriveData() {
    $.ajax({
      type: 'get',
      url: "{{ route('saleconfig.view') }}",
      datatype: 'JSON',
      success: function(data) {
        customerid = data.customer_id;
      },
    });
  }
window.onload=RetriveData();
  function DataTable() {
    table = $('#mytable').DataTable({
      responsive: true,
      paging: true,
      scrollY: 400,
      scrollCollapse: false,
      ordering: true,
      searching: true,
      colReorder: true,
      keys: true,
      processing: true,
      serverSide: true,
      footerCallback: function() {
        var sum = 0;
        var column = 0;
        this.api().columns('4,5,6,7,8,9,10', {
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
          /*  if (!sum.includes('tk'))
             sum += ' &euro;';  */
          $(column.footer()).html(sum);

        });
      },

      dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>" +
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
            columns: [0, 2, 4, 5, 6, 7, 8, 9, 10]
          }
        },
        {
          extend: 'csv',
          text: '<i class="fa fa-file-text-o"></i>@lang("home.csv")',
          className: 'btn btn-info',
          exportOptions: {
            columns: [0, 2, 4, 5, 6, 7, 8, 9, 10]
          }
        },
        {
          extend: 'excel',
          text: '<i class="fa fa-file-excel-o"></i>@lang("home.excel")',
          className: 'btn btn-success',
          exportOptions: {
            columns: [0, 2, 4, 5, 6, 7, 8, 9, 10]
          },
          footer: true,
        },
        {
          text: '<i class="fa fa-file-pdf-o"></i>@lang("home.pdf")',
          extend: 'pdfHtml5',
          className: 'btn btn-light',
          orientation: 'landscape', //portrait',
          pageSize: 'A4',
          title: 'Customer List(Cash)',
          filename: 'Customer',
          className: 'btn btn-danger',

          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
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
          orientation: 'landscape',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
          },
          footer: true,
        },

      ],
      "ajax": {
        "url": "{{ route('customer.loadall') }}",
        "type": "GET",
      },
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          className: "text-center"
        },
        {
          data: 'customerid',
          name: 'customerid',
          className: "text-center"
        },
        {
          data: 'name',
          name: 'name',
        },
        {
          data: 'mobile_no',
          name: 'mobile_no',
          className: "text-center"
        },
        {
          data: 'cashinvoice',
          name: 'cashinvoice',
          className: "text-right"
        },
        {
          data: 'creditinvoice',
          name: 'creditinvoice',
          className: "text-right"
        },
        {
          data: 'consignment',
          name: 'consignment',
          className: "text-right"
        },
        {
          data: 'totaldiscount',
          name: 'totaldiscount',
          className: "text-right"

        },
        {
          data: 'payment',
          name: 'payment',
          className: "text-right"
        },
        {
          data: 'netpayment',
          name: 'netpayment',
          className: "text-right"
        },
        {
          data: 'balancedue',
          name: 'balancedue',
          className: "text-right"
        },
        {
          data: 'status',
          name: 'status',
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
    /*   $('.dataTables_length').addClass('bs-select'); */
  }
  $(document).on('click', "#loadall", function() {
    DataTable();
  })
  window.onload = DataTable();

  //data show
  $(document).on('click', "#datashow", function() {

    var dataid = $(this).data("id");
    url = "{{ url('Admin/Customer/show')}}" + '/' + dataid,
      window.location = url;
  });
  //data edit
  $(document).on('click', "#dataedit", function() {

    var dataid = $(this).data("id");
    url = "{{ url('Admin/Customer/edit')}}" + '/' + dataid,
      window.location = url;
  });

  //Documetn Upload
  $(document).on('click', "#documentup", function() {

    var dataid = $(this).data("id");
    url = "{{ url('Admin/Customer/document')}}" + '/' + dataid,
      window.location = url;
  });

  //Balance Upload
  $(document).on('click', "#openingbalance", function() {

    var dataid = $(this).data("id");
    url = "{{ url('Admin/Customer/openingbalance')}}" + '/' + dataid,
      window.location = url;
  });
  // data Delete
  $(document).on('click', '#deletedata', function() {
    var dataid = $(this).data("id");
    RetriveData();
    console.log(customerid)
    if (customerid == dataid) {
      swal("Opps! Faild", "This is Default Customer, You Cant Delete it, Better change Default Customer And Try Again", "error");
    } else {
      swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this  data!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              type: "post",
              url: "{{ url('Admin/Customer/delete')}}" + '/' + dataid,
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
    }
  });
  $(document).on("click", "#active", function(event) {
    var dataid = $(this).data("id");
    $.ajax({
      type: "post",
      url: "{{ url('Admin/Customer/Active')}}" + '/' + dataid,
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
      url: "{{ url('Admin/Customer/Inactive')}}" + '/' + dataid,
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
</script>