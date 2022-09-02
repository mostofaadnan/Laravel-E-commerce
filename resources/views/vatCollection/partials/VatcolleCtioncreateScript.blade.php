<script>
    var vatid;

    function CollectionNo() {

        $.ajax({
            type: 'get',
            url: "{{ route('vatcollection.collectionno') }}",
            datatype: 'JSON',
            success: function(data) {
                $("#colloctionno").val(data);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    window.onload = CollectionNo();

    function getData() {
        var fromdate = $("#inputdate").val();
        var todate = $("#inputdateto").val();
        $.ajax({
            type: 'get',
            data: {
                fromdate: fromdate,
                todate: todate,
            },
            url: "{{ route('vatcollection.getdata') }}",
            datatype: 'JSON',
            success: function(data) {
                LoadTableData(data);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    $("#vatcollect").on('click', function() {
        getData()
    })

    function LoadTableData(data) {
        $(".data-table tbody").empty();
        var sl = 1;
        data.forEach(function(value) {

            $(".data-table tbody").append("<tr data-id='" + value.id + "'>" +
                "<td>" + sl + "</td>" +
                "<td>" + value.invoice_no + "</td>" +
                "<td>" + value.inputdate + "</td>" +
                "<td align='right'>" + value.amount + "</td>" +
                "<td  align='right'>" + value.discount + "</td>" +
                "<td class='vat' align='right'>" + value.vat + "</td>" +
                "<td align='right'>" + value.nettotal + "</td>" +
                "</tr>");
            sl++;
        })
        totalvat();
    }

    function totalvat() {
        var sum = 0;
        $(".vat").each(function() {
            var value = $(this).text();
            if (!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });
        $("#vat").html(sum.toFixed(2));
    }
    //inset Data
    function DataInsert() {
        $("#overlay").fadeIn();
        var vatcollectiono = $("#colloctionno").val();
        var fromdate = $("#inputdate").val();
        var todate = $("#inputdateto").val();
        var amount = $("#vat").html();
        var remark = $("#remark").val();
        var itemtables = new Array();
        $("#invoicetable TBODY TR").each(function() {
            var row = $(this);
            var item = {};
            item.id = row.attr('data-id');
            itemtables.push(item);
        });
        // console.log(itemtables)
        $.ajax({
            type: "POST",
            url: "{{ route('vatcollection.store') }}",
            //data: JSON.stringify(itemtables),
            data: {
                itemtables: itemtables,
                vatcollectiono: vatcollectiono,
                fromdate: fromdate,
                todate: todate,
                amount: amount,
                remark: remark,
            },
            datatype: ("json"),
            success: function(data) {
                $("#overlay").fadeOut();
                console.log(data);
                if (data > 0) {
                    Confirmation(data);
                } else {
                    swal("Ops! Something Wrong", "Data Submit Fail121", "error");
                }
            },
            error: function(data) {
                $("#overlay").fadeOut();
                swal("Ops! Fail To submit", "Data Submit", "error");
                console.log(data);
            }
        });

    }
    $("#submittData").on('click', function() {
        if ($("#vat").html() == "0") {

        } else {
            DataInsert();
        }
    })

    function ExecuteClear() {
        CollectionNo();
        $(".data-table tbody").empty();
        $("#remark").val("");
        $("#vat").html("");
    }

    function Confirmation(data) {
        swal("Successfully Data Save", "Data Submit", "success", {
                buttons: {
                    cancel: "Cancel",
                    Show: "Show",
                    catch: {
                        text: "Print",
                        value: "catch",
                    },
                    datapdf: {
                        text: "Pdf",
                        value: "datapdf",
                        background: "#endregion",
                    },
                    Cancel: false,
                },
            })
            .then((value) => {
                switch (value) {

                    case "Show":
                        url = "{{ url('Admin/Vat-Collections/show')}}" + '/' + data,
                            window.location = url;
                        break;
                    case "catch":
                        url = "{{ url('Admin/Vat-Collections/LoadPrintslip')}}" + '/' + data,
                        window.open(url, '_blank');
                        break;
                    case "datapdf":
                        url = "{{ url('Admin/Vat-Collections/pdf')}}" + '/' + data,
                            window.open(url, '_blank');
                        break;

                    default:
                        //swal("Thank You For Your Choice");
                }
            });
        ExecuteClear();
    }
</script>