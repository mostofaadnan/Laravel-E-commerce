<script type="text/javascript">
  var table;
  var selected = [];

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
      iDisplayLength: 50,
      rowCallback: function(row, data) {
        if ($.inArray(data.DT_RowId, selected) !== -1) {
          $(row).addClass('selected');
        }
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
            //table.ajax.reload();
          },
          className: 'btn btn-info',
        },

        {
          extend: 'excel',
          text: '<i class="fa fa-file-excel-o"></i>@lang("home.excel")',
          className: 'btn btn-success',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
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
          title: 'Invoice List(Cash)',
          filename: 'invoice',
          className: 'btn btn-danger',
          //download: 'open',
          exportOptions: {
            /* modifer: {
              page: 'all',
            }, */
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
            modifier: {
              page: 'all',
              search: 'none'
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
            columns: [0, 1, 2, 3, 4, 5, 6, 7]
          },
          footer: true,
        },
        {
          text: '<i class="fa fa-trush"></i>@lang("home.delete")',
          action: function() {
            DeleteSelected();
          },
          className: 'btn btn-danger',

        }

      ],

      "ajax": {
        "url": "{{ route('invoice.cancelload') }}",
        "data": {
          fromdate: fromdate,
          todate: todate
        },
        "type": "GET",
      },

      columns: [{
          'targets': 0,
          data: 'DT_RowIndex',
          //  name: 'DT_RowIndex',
          'searchable': false,
          'orderable': false,
          'className': 'dt-body-center',
          'render': function(data, type, full, meta) {
            return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
          }
        },
        /*   {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            className: "text-center"
          }, */
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
      select: {
        style: 'os',
        selector: 'td:first-child'
      },
      order: [
        [1, 'asc']
      ]
      /*   columnDefs: [{
          orderable: false,
          className: 'select-checkbox',
          targets: 0
        }],
        select: {
          style: 'os',
          selector: 'td:first-child'
        }, */
    });

  }
  $('#example-select-all').on('click', function() {
    // Get all rows with search applied
    var rows = table.rows({
      'search': 'applied'
    }).nodes();
    // Check/uncheck checkboxes for all rows in the table
    $('input[type="checkbox"]', rows).prop('checked', this.checked);
  });


  $(document).ready(function() {
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
  //Interval("$('#mytable').DataTable().ajax.reload()", 10000);
  $("#submitdate").on('click', function() {
    if ($("#max").val() == "" || $("#min").val() == "") {
      swal("Opps! Faild", "Please Select Between Date", "error");
    } else {
      table.destroy();
      DataTable();
    }

  });
  window.onload = DataTable();

  $(document).on('click', '#datashow', function() {
    var id = $(this).data("id");
    url = "{{ url('Admin/Invoice/cancelview')}}" + '/' + id,
      window.location = url;
  });

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
            url: "{{ url('Admin/Invoice/canceldestroy')}}" + '/' + id,
            success: function(data) {
              table.ajax.reload();
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
            url: "{{ url('Admin/Invoice/retrive')}}" + '/' + id,
            success: function(data) {
              table.ajax.reload();
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