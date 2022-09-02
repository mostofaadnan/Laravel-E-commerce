<script type="text/javascript">
  var table;

  function DataTable() {
    var fromdate = $("#min").val();
    var todate = $("#max").val();
    table = $('#mytable').DataTable({
      paging: true,
      scrollY: 400,
      scrollCollapse: true,
      ordering: true,
      searching: true,
      select: true,
      autoFill: true,
      colReorder: true,
      keys: true,
      iDisplayLength: 50,
      processing: true,
      serverSide: true,
      footerCallback: function() {
        var sum = 0;
        var column = 0;
        this.api().columns('2,3', {
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
            Prasentbalance();
            //table.ajax.reload();
          },
          className: 'btn btn-info',
        },

        {
          extend: 'copy',
          text: '<i class="fa fa-files-o"></i>@lang("home.export")',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5]
          }
        },
        {
          extend: 'csv',
          text: '<i class="fa fa-file-text-o"></i>@lang("home.csv")',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5]
          }
        },
        {
          extend: 'excel',
          text: '<i class="fa fa-file-excel-o"></i>@lang("home.excel")',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5]
          },
          footer: true,
        },
        {
          text: '<i class="fa fa-file-pdf-o"></i>@lang("home.pdf")',
          extend: 'pdf',
          className: 'btn btn-light',
          orientation: 'portrait', //portrait',
          pageSize: 'A4',
          title: 'Cash Drawer List(Cash)',
          filename: 'Cashdrawer',
          className: 'btn btn-danger',

          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5]
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
            columns: [0, 1, 2, 3, 4, 5]
          },
          footer: true,
        },

      ],
      "ajax": {
        "url": "{{ route('banks.loadall') }}",
        "data": {
          fromdate: fromdate,
          todate: todate,
        },
        "type": "GET",
      },
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          className: "text-center"
        },
        {
          data: 'inputdate',
          name: 'inputdate',
          className: "text-center"
        },
        {
          data: 'type',
          name: 'type',
        },
        {
          data: 'cashin',
          name: 'cashin',
          className: "text-right"

        },
        {
          data: 'cashout',
          name: 'cashout',
          className: "text-right"
        },
        {
          data: 'balance',
          name: 'balance',
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
  window.onload = DataTable();
  $("#submitdate").on('click', function() {
    if ($("#max").val() == "" || $("#min").val() == "") {
      swal("Opps! Faild", "Please Select Between Date", "error");
    } else {
      table.destroy();
      DataTable();
    }

  });

  function Prasentbalance() {
    var url = "{{ route('banks.prasentbalance') }}";
    $.get(url, function(data) {
      $("#balance").html('<p style="padding:2px;color:#fff">Prasent Balance:<b style="color:red">&nbsp;' + data.toFixed(2) + '</b></p>');

    })

  }
  window.onload = Prasentbalance();

  $(document).on('click', '#datashow', function() {
    var id = $(this).data("id");
    var type = $(this).data("type");

    switch (type) {
      case 1:
        url = "{{ url('Admin/Invoice/show')}}" + '/' + id,
          window.location = url;
        break;
      case 2:
        url = "{{ url('Admin/SupplierPayment/show')}}" + '/' + id,
          window.location = url;
        break;
      case 3:
        url = "{{ url('Admin/CustomerPayment/show')}}" + '/' + id,
          window.location = url;
        break;
      case 4:
        url = "{{ url('Admin/Sale-Return/show')}}" + '/' + id,
          window.location = url;
        break;
      case 5:
        url = "{{ url('Admin/Vat-Collections/paymentshow')}}" + '/' + id,
          window.location = url;
        break;
      case 6:
        url = "{{ url('Admin/Expenses/paymentshow')}}" + '/' + id,
          window.location = url;
        break;
      case 7:
        url = "{{ url('Admin/Salary/salarypaymentshow')}}" + '/' + id,
          window.location = url;
        break;
      default:
    }
    // window.location = url;

  });
</script>