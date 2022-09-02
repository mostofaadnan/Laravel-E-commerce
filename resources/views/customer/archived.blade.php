@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header card-header-section">
        <div class="pull-left">
            @lang('home.customer') @lang('home.archive')
        </div>
       
    </div>
    <div class="card-body">
        @include('partials.ErrorMessage')
        <table class="table table-bordered" cellspacing="0" id="mytable" width="100%">
            <thead>
                <tr>
                    <th> #@lang('home.sl') </th>
                    <th> @lang('home.id') </th>
                    <th> @lang('home.name') </th>
                    <th> @lang('home.mobile') @lang('home.no')</th>
                    <th> @lang('home.cash') @lang('home.invoice') </th>
                    <th> @lang('home.credit') @lang('home.invoice') </th>
                    <th> @lang('home.consignment') </th>
                    <th> @lang('home.discount') </th>
                    <th> @lang('home.credit') @lang('home.payment')</th>
                    <th> @lang('home.netpayment')</th>
                    <th> @lang('home.balancedue')</th>
                    <th> @lang('home.status')</th>
                    <th> @lang('home.action')</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th> #@lang('home.sl') </th>
                    <th> @lang('home.id') </th>
                    <th> @lang('home.name') </th>
                    <th> @lang('home.mobile') @lang('home.no')</th>
                    <th> @lang('home.cash') @lang('home.invoice') </th>
                    <th> @lang('home.credit') @lang('home.invoice') </th>
                    <th> @lang('home.consignment') </th>
                    <th> @lang('home.discount') </th>
                    <th> @lang('home.credit') @lang('home.payment')</th>
                    <th> @lang('home.netpayment')</th>
                    <th> @lang('home.balancedue')</th>
                    <th> @lang('home.status')</th>
                    <th> @lang('home.action')</th>
                </tr>
            </tfoot>
        </table>

    </div>
</div>
<script>
    var table;
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

            dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
         
            "ajax": {
                "url": "{{ route('customer.LoadAllArchived') }}",
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
        url = "{{ url('Customer/show')}}" + '/' + dataid,
            window.location = url;
    });
    //data edit
    $(document).on('click', "#dataedit", function() {

        var dataid = $(this).data("id");
        url = "{{ url('Customer/edit')}}" + '/' + dataid,
            window.location = url;
    });
    //Balance Upload
    $(document).on('click', "#openingbalance", function() {
        var dataid = $(this).data("id");
        url = "{{ url('Customer/openingbalance')}}" + '/' + dataid,
            window.location = url;
    });
    // data Delete
    $(document).on('click', '#deletedata', function() {
        swal({
                title: "Are you sure?",
                text: "Once deleted!, All Important Data like Invoice,Invoice Return, credit payment will be lost, Better skip this step",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var dataid = $(this).data("id");
                    $.ajax({
                        type: "post",
                        url: "{{ url('Customer/permanentdelete')}}" + '/' + dataid,
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
    $(document).on("click", "#retrive", function(event) {
        var dataid = $(this).data("id");
        $.ajax({
            type: "post",
            url: "{{ url('Customer/retrive')}}" + '/' + dataid,
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
            url: "{{ url('Customer/Inactive')}}" + '/' + dataid,
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
@endsection