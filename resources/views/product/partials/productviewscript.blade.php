<script>
  var productid = 0;
  var table;
  var invoicetable;

  function ItemDatalist() {
    $.ajax({
      type: 'get',
      url: "{{ route('product.itemdatalist') }}",
      datatype: 'JSON',
      success: function(data) {
        $('#product').html(data);
      },
      error: function(data) {}
    });
  }
  window.onload = ItemDatalist();

  function ItemInformation() {
    $.ajax({
      type: 'get',
      url: "{{ route('product.getDataById') }}",
      datatype: 'JSON',
      success: function(data) {
        productid = data.id;
        LoadData(data);
        CurrentStock();
        getOpening();
        itemPurchaseView();
        LoadTableDataInvoice()

      },
      error: function(data) {
        console.log(data);
      }
    });
  }
  window.onload = ItemInformation();

  function LoadData(data) {
    $("#productname").html(data.name);
    $("#productid").html(data.id);
    $("#barcode").html(data.barcode);
    $("#category").html(data.category_name['title']);
    data.subcategory_id > 0 ? $("#subcategory").html(data.subcategory_name['title']) : '';
    data.brand_id > 0 ? $("#brand").html(data.brand_name['title']) : '';
    $("#unit").html(data.unit_name['Shortcut']);
    $("#openingdate").html(data.openingDate);
    $("#tp").html(data.tp);
    $("#mrp").html(data.mrp);
    $("#vatvalue").html(data.vat_name['value'] + '%')
    $("#remark").html(data.remark);
    $("#status").html(data.status == 1 ? 'Active' : 'Inactive');
    $("#user").html(data.username['name']);
  }
  //purchase History

  function itemPurchaseView() {
    table = $('#purchasetable').DataTable({
      responsive: true,
      paging: true,
      scrollY: 400,
      ordering: true,
      searching: true,
      colReorder: true,
      keys: true,
      processing: true,
      serverSide: true,
      /* autoFill: false, */
      footerCallback: function() {
        var sum = 0;
        var column = 0;
        this.api().columns('8,9,10,11', {
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
      //dom: 'lBfrtip',
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
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
          }
        },
        {
          extend: 'csv',
          text: '<i class="fa fa-file-text-o"></i>@lang("home.csv")',
          className: 'btn btn-info',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
          }
        },
        {
          extend: 'excel',
          text: '<i class="fa fa-file-excel-o"></i>@lang("home.excel")',
          className: 'btn btn-success',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
          },
          footer: true,
        },
      ],
      "ajax": {
        "url": "{{ route('purchase.purchaseitem') }}",
        "data": {
          productid: productid,
        },
        "type": "GET",
      },
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          className: "text-center"
        },
        {
          data: 'purchasecode',
          name: 'purchasecode',
          className: "text-center"
        },
        {
          data: 'inputdate',
          name: 'inputdate',
          className: "text-center"
        },
        {
          data: 'supplier',
          name: 'supplier',
        },
        {
          data: 'tp',
          name: 'tp',
          className: "text-right"
        },
        {
          data: 'mrp',
          name: 'mrp',
          className: "text-right"
        },
        {
          data: 'qty',
          name: 'qty',
          className: "text-right"
        },
        {
          data: 'unit',
          name: 'unit',

        },
        {
          data: 'amount',
          name: 'amount',
          className: "text-right"

        },
        {
          data: 'discount',
          name: 'discount',
          className: "text-right"

        },
        {
          data: 'vat',
          name: 'vat',
          className: "text-right"

        },
        {
          data: 'nettotal',
          name: 'nettotal',
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
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
      $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust()
        .responsive.recalc();
    });
  }
  //window.onload = itemPurchaseView();



  function clear() {
    table.ajax.reload();
  }
  $(document).on('click', '#datashow', function() {
    var id = $(this).data("id");
    url = "{{ url('Admin/Purchase/show')}}" + '/' + id,
      window.location = url;
  });

  //Invoice Histpry
  function LoadTableDataInvoice() {
    invoicetable = $('#invoicetable').DataTable({
      responsive: true,
      paging: true,
      scrollY: 400,
      ordering: true,
      searching: true,
      colReorder: true,
      keys: true,
      processing: true,
      serverSide: true,
      autoFill: false,

      footerCallback: function() {
        var sum = 0;
        var column = 0;
        this.api().columns('8,9,10,11', {
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
      //dom: 'lBfrtip',
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
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
          }
        },
        {
          extend: 'csv',
          text: '<i class="fa fa-file-text-o"></i>@lang("home.csv")',
          className: 'btn btn-info',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
          }
        },
        {
          extend: 'excel',
          text: '<i class="fa fa-file-excel-o"></i>@lang("home.excel")',
          className: 'btn btn-success',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
          },
          footer: true,
        },

      ],
      "ajax": {
        "url": "{{ route('invoce.invoiceitem') }}",
        "data": {
          productid: productid,
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
          data: 'invoiceno',
          name: 'invoiceno',
          className: "text-center"
        },
        {
          data: 'customer',
          name: 'customer',
        },

        {
          data: 'tp',
          name: 'tp',
          className: "text-right"
        },
        {
          data: 'mrp',
          name: 'mrp',
          className: "text-right"
        },
        {
          data: 'qty',
          name: 'qty',
          className: "text-right"
        },
        {
          data: 'unit',
          name: 'unit',

        },
        {
          data: 'amount',
          name: 'amount',
          className: "text-right"

        },
        {
          data: 'discount',
          name: 'discount',
          className: "text-right"

        },
        {
          data: 'vat',
          name: 'vat',
          className: "text-right"

        },
        {
          data: 'nettotal',
          name: 'nettotal',
          className: "text-right"
        },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: false
        }
      ],
    });
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
      $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust()
        .responsive.recalc();
    });
  }
  $("#search").on('input', function() {
    var val = this.value;
    if ($('#product option').filter(function() {
        return this.value.toUpperCase() === val.toUpperCase();
      }).length) {
      productid = $('#product').find('option[value="' + val + '"]').attr('id');
      $.ajax({
        type: 'post',
        url: "{{ url('Admin/Session-Id/productId')}}" + '/' + productid,
        success: function() {
          table.destroy();
          invoicetable.destroy();
          ItemInformation();
        }
      });

    }
  });

  function CurrentStock() {
    $.ajax({
      type: 'get',
      data: {
        id: productid
      },
      url: "{{ route('product.currentstock') }}",
      datatype: 'JSON',
      success: function(data) {
        data > 0 ? $("#currentqty").html('<span>' + data + '</span>') : $("#currentqty").html('<span style="color:red"><b>' + data + '</b></span>')
      },
      error: function(data) {}
    });
  }

  function getOpening() {
    $.ajax({
      type: 'get',
      url: "{{ url('Admin/Product/getopening')}}" + '/' + productid,
      datatype: 'JSON',
      success: function(data) {
        $('#qty').html(data);

      },
      error: function(data) {}
    });
  }
  /*   $("#connectedServices").on('click', function() {
      table.destroy();
      itemPurchaseView();
    })
    $("#InvoiceHistory").on('click', function() {
      invoicetable.destroy();
      LoadTableDataInvoice();
    }) */
  $(document).on('click', '#datashowinvoice', function() {
    var id = $(this).data("id");
    url = "{{ url('Admin/Invoice/show')}}" + '/' + id,
      window.location = url;
  });

  // window.onload = LoadTableDataInvoice();
  //end invoice history
</script>