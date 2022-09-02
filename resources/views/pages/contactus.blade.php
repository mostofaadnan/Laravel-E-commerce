@extends('layouts.master')
@section('content')

<div class="card">
    <style .input-group-text{width:auto;}></style>
    <div class="card-header card-header-section">
        <div class="pull-left">
            @lang('home.sector') @lang('home.expenditure')
        </div>
    </div>
    <div class="card-body">
        @include('partials.ErrorMessage')
        <table class="table table-bordered" id="mytable" style="width:100%" cellspacing="0">
            <thead>
                <tr>
                    <th> #@lang('home.sl') </th>
                    <th> @lang('home.date') </th>
                    <th> @lang('home.name') </th>
                    <th> @lang('home.email') </th>
                    <th> @lang('home.subject') </th>
                    <th> @lang('home.action') </th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr>
                    <th> #@lang('home.sl') </th>
                    <th> @lang('home.date') </th>
                    <th> @lang('home.name') </th>
                    <th> @lang('home.email') </th>
                    <th> @lang('home.subject') </th>
                    <th> @lang('home.action') </th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
    var tabledata;

    function DataTable() {
        tabledata = $('#mytable').DataTable({

            paging: true,
            scrollY: 400,
            ordering: true,
            searching: true,
            colReorder: true,
            keys: true,
            processing: true,
            serverSide: true,
            dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",

            "ajax": {
                "url": "{{ route('page.contactloadall') }}",
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
                    data: 'name',
                    name: 'name',

                },

                {
                    data: 'email',
                    name: 'email',


                },
                {
                    data: 'subject',
                    name: 'subject',
                 

                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: "text-center"
                }
            ],
        });

    }
    window.onload = DataTable();

    $(document).on('click', '#datashow', function() {
        var id = $(this).data("id");
        url = "{{ url('Admin/contactusview')}}" + '/' + id,
            window.location = url;

    });

    $(document).on('click', '#deletedata', function() {
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
            url: "{{ url('Admin/contactusdelete')}}" + '/' + id,
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
</script>
@endsection