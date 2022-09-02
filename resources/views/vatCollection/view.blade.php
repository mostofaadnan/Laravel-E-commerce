@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header card-header-section">
        <div class="row">
            <div class="col-8 col-sm-4 col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">@lang('home.vat') @lang('home.number')</label>
                    </div>
                    <input type="text" class="form-control" id="vatcollection" list="vatno" placeholder="@lang('home.search')">
                    <datalist id="vatno">
                    </datalist>
                </div>
            </div>
            <div class="col-4 col-sm-8">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @lang('home.action')
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ route('vatcollections') }}" class="nav-link">@lang('home.vat') @lang('home.collection')</a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('vatcollection.create') }}" class="nav-link">New</a>
                        <div class="dropdown-divider"></div>
                        <a id="deletedata" class="nav-link">@lang('home.delete')</a>
                        <div class="dropdown-divider"></div>
                        <a id="print" class="nav-link">@lang('home.print')</a>
                        <div class="dropdown-divider"></div>
                        <a id="pdfdata" class="nav-link">@lang('home.pdf')</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="inv-title">
            <h4 class="no-margin" style="color:blue"><b>@lang('home.vat') @lang('home.collection')</b></h4>
        </div>
        <div class="row">
            <div class="col-sm-8">
            </div>
            <div class="col-12 col-sm-4">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>@lang('home.vat') @lang('home.number')</th>
                        <td id="vatcollectiono"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.from') @lang('home.date')</th>
                        <td id="fromdate"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.to') @lang('home.date')</th>
                        <td id="todate"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.remark')</th>
                        <td id="remark"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.status')</th>
                        <td id="status"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped table-responsive-sm table-sm  data-table mt-2" width="100%">
                    <thead>
                        <th>@lang('home.sl')</th>
                        <th>@lang('home.invoice') @lang('home.number')</th>
                        <th>@lang('home.invoice') @lang('home.date')</th>
                        <th>@lang('home.vat')</th>
                    </thead>
                    <tbody id="tablebody">

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" align="right"><b> @lang('home.nettotal')</b></td>
                            <td id="nettotal" align="right"></td>
                        </tr>
                    </tfoot>
                </table>

            </div>

        </div>

    </div>

</div>
<script>
    var vatid = 0;
    var payment = 0;

    function ViewVatNo() {
        $.ajax({
            type: 'get',
            url: "{{ route('vatcollection.vatcodedatalistall') }}",
            datatype: 'JSON',
            success: function(data) {
                $('#vatno').html(data);

            },
            error: function(data) {
                console.log(data)
            }
        });
    }
    window.onload = ViewVatNo();
    $("#vatcollection").on('input', function() {
        var val = this.value;
        if ($('#vatno option').filter(function() {
                return this.value.toUpperCase() === val.toUpperCase();
            }).length) {
            var id = $('#vatno').find('option[value="' + val + '"]').attr('id');
            $.ajax({
                type: "post",
                url: "{{ url('Admin/Vat-Collections/setVatcollectionId')}}" + '/' + id,
                datatype: ("json"),
                success: function(data) {
                    VatPaymentDetails();
                },
                error: function(data) {}

            });
        }
    });

    function VatPaymentDetails() {
        $.ajax({
            type: "get",
            url: "{{ url('Admin/Vat-Collections/getView')}}",
            datatype: ("json"),
            success: function(data) {
                vatid = data.id;
                payment = data.payment;
                lodData(data);
                loadTableDetails(data);
                DeletebtnshowHide();
            },
            error: function(data) {

            }

        });
    }

    function DeletebtnshowHide() {
        if (payment == 1) {
            $(".delete").hide();
        } else {
            $(".delete").show();
        }
    }
    window.onload = VatPaymentDetails();

    function lodData(data) {

        $("#vatcollectiono").html(data.collection_no)
        $("#todate").html(data.todate)
        $("#fromdate").html(data.fromdate)
        $("#nettotal").html("<b>" + data.amount + "</b>")
        $("#remark").html(data.remark)
        $("#status").html(data.payment == 1 ? 'Paid' : 'Due')
    }

    function loadTableDetails(data) {
        $("#tablebody").empty();
        var sl = 1;
        data.inv_details.forEach(function(value) {
            $(".data-table tbody").append("<tr>" +
                "<td>" + sl + "</td>" +
                "<td>" + value.invoice_no + "</td>" +
                "<td>" + value.inputdate + "</td>" +
                "<td align='right'>" + value.vat + "</td>" +
                "</tr>"
            );
            sl++;
        })

    }
    $(document).on('click', '#pdfdata', function() {
        url = "{{ url('Admin/Vat-Collections/pdf')}}" + '/' + vatid,
            window.open(url, '_blank');
    });
    $(document).on('click', '#print', function() {
        url = "{{ url('Admin/Vat-Collections/LoadPrintslip')}}" + '/' + vatid,
            window.open(url, '_blank');
    });

    $(document).on('click', "#deletedata", function() {

        if (payment == 0) {
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this  data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var id = $(this).data("id");
                        $.ajax({
                            type: "post",
                            url: "{{ url('Admin/Vat-Collections/delete')}}" + '/' + vatid,
                            success: function() {
                                url = "{{ route('vatcollections')}}"
                                window.location = url;
                            },
                            error: function(data) {
                                console.log(data)
                                swal("Opps! Faild", "Data Fail to Delete", "error");
                            }
                        });
                        swal("Ok! Your file has been deleted!", {
                            icon: "success",
                        });
                    } else {
                        swal("Your file is safe!");
                    }
                });
        }

    });
</script>
@endsection