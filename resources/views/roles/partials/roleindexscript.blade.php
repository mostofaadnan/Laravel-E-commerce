<script>
  function DataTable() {
    var tabledata = $('#mytable').DataTable({
      responsive: true,
      paging: true,
      scrollY: 400,
      ordering: true,
      searching: true,
      colReorder: true,
      keys: true,
      aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
      ],
      iDisplayLength: 100,
      processing: true,
      serverSide: true,
      // dom: 'Bfrtip',
      dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      "ajax": {
        "url": "{{ route('role.loadall') }}",
        "type": "GET",
      },
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          className: "text-center"
        },
        {
          data: 'id',
          name: 'id',
          className: "text-center"
        },
        {
          data: 'name',
          name: 'name',
        },
        {
          data: 'permistions',
          name: 'permistions',
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
  $(document).on('click', '#datashow', function() {
    var id = $(this).data("id");
    url = "{{ url('Admin/UserRole/show')}}" + '/' + id,
      window.location = url;
  });
  $(document).on('click', '#dataedit', function() {
    var id = $(this).data("id");
    url = "{{ url('Admin/UserRole/edit')}}" + '/' + id,
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
            url: "{{ url('Admin/UserRole/delete')}}" + '/' + dataid,
            success: function(data) {
              location.reload();
            },
            error: function(data) {
              swal("Opps! Faild", "Form Submited Faild", "error");
              console.log(data);
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
</script>