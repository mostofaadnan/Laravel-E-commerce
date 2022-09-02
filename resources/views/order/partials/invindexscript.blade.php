<script type="text/javascript">
  $(document).ready(function() {
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
        initComplete: function() {
          this.api().columns().every(function() {
            var column = this;
            var select = $('<br><select><option value=""></option></select>')
              .appendTo($(column.header()))
              .on('change', function() {
                var val = $.fn.dataTable.util.escapeRegex(
                  $(this).val()
                );

                column.search(val ? '^' + val + '$' : '', true, false)
                  .draw();
              });

            console.log(select);

            column.data().unique().sort().each(function(d, j) {
              $(select).append('<option value="' + d + '">' + d + '</option>')
            });
          });
        },
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
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
              page: 'all',
            },
            footer: true,
          },
          {
            extend: 'csv',
            text: '<i class="fa fa-file-text-o"></i>@lang("home.csv")',
            className: 'btn btn-info',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
              modifier: {
                page: 'all',
              }
            },

          },
          {
            extend: 'excel',
            text: '<i class="fa fa-file-excel-o"></i>@lang("home.excel")',
            className: 'btn btn-success',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
              page: 'all',
            },
            footer: true,

          },
          {
            /*  extend: 'pdf', */

            text: '<i class="fa fa-file-pdf-o"></i>@lang("home.pdf")',
            extend: 'pdf',
            className: 'btn btn-light',
            orientation: 'portrait', //portrait',
            pageSize: 'A4',
            title: 'Order List',
            filename: 'Order',
            className: 'btn btn-danger',
            //download: 'open',
            exportOptions: {
              /* modifer: {
                page: 'all',
              }, */
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
              modifier: {
                page: 'all',
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
            text: '<i class="fa fa-print"></i>@lang("home.print")',
            className: 'btn btn-dark',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
              page: 'all',
            },
            footer: true,
          },

        ],

        "ajax": {
          "url": "{{ route('order.loadall') }}",
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
    /* $(document).ready(function() {
    $.fn.dataTable.ext.search.push(
      function(settings, data, dataIndex) {
        var min = $('#min').datepicker("getDate");
        var max = $('#max').datepicker("getDate");
        var startDate = new Date(data[2]);
        if (min == null && max == null) {
          return true;
        }
        if (min == null && startDate <= max) {
          return true;
        }
        if (max == null && startDate >= min) {
          return true;
        }
        if (startDate <= max && startDate >= min) {
          return true;
        }
        return false;
      }
    );


    $("#min").datepicker({
      onSelect: function() {
        table.draw();
      },
      changeMonth: true,
      changeYear: true
    });
    $("#max").datepicker({
      onSelect: function() {
        table.draw();
      },
      changeMonth: true,
      changeYear: true
    });
    var table = $('#example').DataTable();

    // Event listener to the two range filtering inputs to redraw on input
    $('#min, #max').change(function() {
      table.draw();
    });
  });
*/



    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {

      var start = picker.startDate.format('YYYY-MM-DD');
      var end = picker.endDate.format('YYYY-MM-DD');

      $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
          var min = start;
          var max = end;
          var startDate = new Date(data[2]);

          if (min == null && max == null) {
            return true;
          }
          if (min == null && startDate <= max) {
            return true;
          }
          if (max == null && startDate >= min) {
            return true;
          }
          if (startDate <= max && startDate >= min) {
            return true;
          }
          return false;
        }
      );
      table.draw();
      $.fn.dataTable.ext.search.pop();
    });




    window.onload = DataTable();

    $(document).on('click', '#datashow', function() {
      var id = $(this).data("id");
      url = "{{ url('Admin/Order/show')}}" + '/' + id,
        window.location = url;
    });
    $(document).on('click', '#pdf', function() {
      var id = $(this).data("id");
      url = "{{ url('Admin/Order/orderPdf')}}" + '/' + id,
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
    $(document).on('click',"#recieved", function() {
      var id = $(this).data("id");
      url = "{{ url('Admin/Order/orderrecived')}}" + '/' + id,
        window.location = url;
    });
    $(document).on('click',"#delivery",function() {
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