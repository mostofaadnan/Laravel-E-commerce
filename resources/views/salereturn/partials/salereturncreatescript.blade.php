<script type="text/javascript">
    var invoiceno = 0;
    var sl = 1;
    var netallTotal = 0;
    var customerid = 0;
    var shipment = 0;
    var vats = 0;
    var totaldiscounts = 0;
    var autometic_store = 0;
    var vat_applicable = 0;
    var credit = 0;
    var payment = 0;
    var dicount = 0;
    var balancedue = 0;
    var itemids = 0;

    function RetriveData() {
        $.ajax({
            type: 'get',
            url: "{{ route('saleconfig.view') }}",
            datatype: 'JSON',
            success: function(data) {
                
                autometic_store = data.autometic_store;
                vat_applicable = data.vat_applicable;
                $("#customer option[value='" + customerid + "']").attr('selected', 'selected');

            },
        });

    }

    function ViewInvoiceCode() {
        $.ajax({
            type: 'get',
            url: "{{ route('salereturn.invoicecodedatalist') }}",
            datatype: 'JSON',
            success: function(data) {
                $('#invoicenumber').html(data);
            },
            error: function(data) {}
        });
    }

    function SaleReturnCode() {
        $.ajax({
            type: 'get',
            url: "{{ route('salereturn.returncode') }}",
            datatype: 'JSON',
            success: function(data) {
                invoiceno = data;
                $("#returncode").val(invoiceno);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    /*  /*  setInterval("InvoiceCode()", 1000); */

    function ItemDatalist() {
        $.ajax({
            type: 'get',
            url: "{{ route('product.itemdatalist') }}",
            datatype: 'JSON',
            success: function(data) {
                $('#product').html(data);
            },
            error: function(data) {
                console.log(data)
            }
        });
    }

    function CustomerDataList() {
        $.ajax({
            type: 'get',
            url: "{{ route('customer.customerdatalist') }}",
            datatype: 'JSON',
            success: function(data) {
                $('#customer').html(data);
            },
            error: function(data) {}
        });
    }
    window.onload = ViewInvoiceCode();
    window.onload = SaleReturnCode();
    window.onload = ItemDatalist();
    window.onload = CustomerDataList();
    $("#search").on('input', function() {
        var val = this.value;
        if ($('#product option').filter(function() {
                return this.value.toUpperCase() === val.toUpperCase();
            }).length) {
            itemids = $('#product').find('option[value="' + val + '"]').attr('id');
            var mrp = $('#product').find('option[value="' + val + '"]').attr('data-mrp');
            if (mrp) {
                $("#mrp").val(mrp)
                if (autometic_store == 1) {
                    $('#qty').val("1");
                    var rowCount = $('.data-table tr').length;
                    if (rowCount == 1) {
                        addRowData();
                    } else {
                        CheckEntry();
                    }
                } else {
                    $('#qty').focus();
                }
            } else {
                $("#mrp").val("")
            }

        }
    });

    $('#search').keypress(function(e) {
        var key = e.which;
        if (key == 13) {
            if ($("#mrp").val() !== "") {
                $('#qty').focus();
            }
        }
    });
    $("#clear").on('click', function() {
        clear();
    })


    $("#customersearch").on('input', function() {
        var val = this.value;
        if (val == "") {
            clear();
        } else {

            if ($('#customer option').filter(function() {
                    return this.value.toUpperCase() === val.toUpperCase();
                }).length) {
                customerid = $('#customer').find('option[value="' + val + '"]').attr('id');
                console.log(customerid)
                $.ajax({
                    type: "get",
                    data: {
                        customerid: customerid
                    },
                    url: "{{ route('customer.info')}}",
                    datatype: ("json"),
                    success: function(data) {

                        credit = (data.creditinvoice).toFixed(2);
                        balancedue = (data.balancedue).toFixed(2);

                    },
                    error: function(data) {
                        console.log(data)
                    }
                });
            }
        }

    });



    //Add rows
    $("#addrows").on('click', function(e) {
        var product = $("#search").val();
        var code = $('#product').find('option[value="' + product + '"]').attr('id');
        var qty = $("#qty").val();
        if (product == "" || qty == "" || code == 0) {
            swal("Please Select Requrie Field", "Require Field", "error");
        } else {
            var rowCount = $('.data-table tr').length;
            if (rowCount == 1) {
                addRowData();
            } else {
                CheckEntry();
            }
        }
    });

    $('#qty').keypress(function(e) {
        var key = e.which;
        if (key == 13) // the enter key code
        {
            var mrp = $("#mrp").val();
            var productname = $("#search").val();
            var itemcode = $('#product').find('option[value="' + productname + '"]').attr('id');
            var qty = $("#qty").val();
            if (productname == "" || qty == "" || itemcode == 0 || mrp == "" || mrp == 0 || qty == 0) {
                swal("Please Select Requrie Field", "Require Field", "error");

            } else {

                var rowCount = $('.data-table tr').length;
                if (rowCount == 1) {
                    addRowData();
                } else {

                    CheckEntry();
                }

            }

        }
    });

    function CheckEntry() {
        /*   var name = $("#search").val();
          var item = $('#product').find('option[value="' + name + '"]').attr('id'); */
        var qty = $("#qty").val();
        var isvalid = true;
        $("#table tr").each(function() {
            var row = $(this);
            var tableitemcode = row.data('itemcode');
            // var tableitemcode = row.parent("tr").attr('data-itemcode');
            //  console.log(tableitemcode)
            if (itemids == tableitemcode) {
                isvalid = false;
                var findrow = $(this);
                // console.log(findrow)
                AutoQuantityUpdate(findrow, qty)
                /*   break; */
                /*   swal("Ops! This Data Already Exists", "input Data", "error");
                  clear(); */
            }
        });
        if (isvalid == true) {
            addRowData();
        }
    }

    function AutoQuantityUpdate(row, qty) {
        var vat = 0;

        /*  var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
         var qty = $(this).parent("tr").find("td").eq(2).text();
         if (qty == "" || !numberRegex.test(qty)) {
             qty = 0;
         } */
        var itemname = row.data('searchname');
        var rowqty = row.find("td").eq(2).text();
        var totalqty = parseFloat(rowqty) + parseFloat(qty);
        var unitprice = row.find("td").eq(3).text();
        var discount = row.data('discount');
        var amount = parseFloat(totalqty * unitprice).toFixed(2);
        var totaldiscount = parseFloat(discount * totalqty).toFixed(2);
        if (vat_applicable == 1) {
            var vatvalue = $('#product').find('option[value="' + itemname + '"]').attr('data-vat');
            vat = vatvalue / 100;
        } else {
            vat = 0;
        }
        row.find("td:eq(2)").text(totalqty);
        var productvat = parseFloat(unitprice * vat).toFixed(2);
        var totalvat = parseFloat(totalqty * productvat).toFixed(2);
        var total = parseFloat(amount - totaldiscount);
        var nettotal = (parseFloat(totalvat) + parseFloat(total)).toFixed(2);
        row.find("td:eq(4)").text(amount);
        row.data('totaldiscount', totaldiscount);
        row.data('totalvat', totalvat);
        row.data('nettotal', nettotal);
        TablelSummation();
        clear();
    }

    function addRowData() {
        RetriveData();
        if (customerid > 0) {
            var vat = 0;
            var search = $("#search").val();
            var itemcode = $('#product').find('option[value="' + search + '"]').attr('id');
            var barcode = $('#product').find('option[value="' + search + '"]').attr('data-barcode');
            var unitname = $('#product').find('option[value="' + search + '"]').attr('data-unitname');
            productname = $('#product').find('option[value="' + search + '"]').attr('data-name');
            var qty = $("#qty").val();
            var unitprice = $("#mrp").val();
            var amount = parseFloat(qty * unitprice).toFixed(2);
            var discount = $("#discount").val();
            var totaldiscount = parseFloat(discount * qty).toFixed(2);
            if (vat_applicable == 1) {
                var vatvalue = $('#product').find('option[value="' + search + '"]').attr('data-vat');
                vat = vatvalue / 100;
            } else {
                vat = 0;
            }
            var productvat = parseFloat(unitprice * vat).toFixed(2);
            var totalvat = parseFloat(qty * productvat).toFixed(2);
            var total = parseFloat(amount - totaldiscount).toFixed(2);
            var nettotal = (parseFloat(totalvat) + parseFloat(total)).toFixed(2);
            $(".data-table tbody").append("<tr class='i'  data-id='items-" + sl + "' data-searchname='" + search + "' data-itemcode='" + itemcode + "' data-barcd='" + barcode + "' data-unitn='" + unitname + "'  data-discount='" + discount + "' data-totaldiscount='" + totaldiscount + "' data-totalvat='" + totalvat + "' data-nettotal='" + nettotal + "' >" +
                "<td align='center'>" + sl + "</td>" +
                /*  "<td id='itemcode'>" + itemcode + "</td>" + */
                "<td class='itemname'>" + productname + "</td>" +
                "<td class='qty' contenteditable='true' text-align='right'>" + qty + "</td>" +
                "<td align='right'>" + unitprice + "</td>" +
                "<td class='amount' align='right'>" + amount + "</td>" +
                /* "<td class='discount' id='" + discount + "' align='right'>" + totaldiscount + "</td>" +
                "<td class='vat' align='right'>" + totalvat + "</td>" +
                "<td class='nettotal' align='right'>" + nettotal + "</td>" + */
                "<td>" +
                " <div class='btn-group' role='group' aria-label='Basic example'>" +
                "<button class='btn btn-secondary btn-sm btn-iniview' id='invviewitem data-id='" + itemcode + "' data-toggle='modal' data-target='#invmodelviewitems'><i class='fa fa-eye'></i></button>" +
                "<button class='btn btn-danger btn-sm btn-delete'>X</button>" +
                "<div>" +
                "</td>" +
                "</tr>");
            sl++;
            TablelSummation();
            clear();
        } else {
            clear();
            swal("Ops! Please Select Customer", "Customer Confirmation", "error");

        }
    }
    $("body").on("click", ".btn-delete", function() {
        swal({
                title: "Are you sure?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $(this).parents("tr").remove();
                    TablelSummation();
                } else {
                    //swal("Your imaginary file is safe!");
                }
            });
    });
    //qty update
    $("body").on("keyup", '.qty', function() {
        var vat = 0;
        var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
        var qty = $(this).parent("tr").find("td").eq(2).text();
        if (qty == "" || !numberRegex.test(qty)) {
            qty = 0;
        }
        var getDiscount = $(this).parent("tr").attr('data-totaldiscount');
        var unitprice = $(this).parent("tr").find("td").eq(3).text();
        var discount = $(this).parent("tr").attr('data-discount');
        var amount = parseFloat(qty * unitprice).toFixed(2);
        var totaldiscount = parseFloat(discount * qty).toFixed(2);
        if (vat_applicable == 1) {
            var vatvalue = $('#product').find('option[value="' + search + '"]').attr('data-vat');
            vat = vatvalue / 100;

        } else {
            vat = 0;
        }
        var productvat = parseFloat(unitprice * vat).toFixed(2);
        var totalvat = parseFloat(qty * productvat).toFixed(2);
        var total = parseFloat(amount - totaldiscount);
        var nettotal = (parseFloat(totalvat) + parseFloat(total)).toFixed(2);
        $(this).parents("tr").find("td:eq(4)").text(amount);

        /*  $(this).parents("tr").find("td:eq(6)").text(totaldiscount);
         $(this).parents("tr").find("td:eq(7)").text(totalvat);
         $(this).parents("tr").find("td:eq(8)").text(nettotal); */
        $(this).parents("tr").data('totaldiscount', totaldiscount);
        $(this).parents("tr").data('totalvat', totalvat);
        $(this).parents("tr").data('nettotal', nettotal);
        TablelSummation();
    });
    var invid;
    $("body").on('click', '.btn-iniview', function() {
        invid = $(this).closest("tr").data('id');
        var itemcode = $(this).closest("tr").data('itemcode');
        $("#invproductid").val(itemcode);
        var barcode = $(this).closest("tr").data('barcd');
        $("#invbarcode").val(barcode);
        console.log(itemcode)
        var itemname = $(this).closest("tr").find("td").eq(1).text();
        $("#invname").val(itemname);
        var qty = $(this).closest("tr").find("td").eq(2).text();
        $("#invqty").val(qty);
        var unitname = $(this).closest("tr").data('unitn');
        $("#invunit").val(unitname);
        var mrp = $(this).closest("tr").find("td").eq(3).text();
        $("#invdatamrp").val(mrp);
        var amount = $(this).closest("tr").find("td").eq(4).text();
        $("#invamount").val(amount);
        var totaldiscount = $(this).closest("tr").data('totaldiscount');
        $("#invdiscount").val(totaldiscount);
        var totalvat = $(this).closest("tr").data('totalvat');
        $("#invvat").val(totalvat);
        var nettotal = $(this).closest("tr").data('nettotal');
        $("#invnettotal").val(nettotal);

    })
    /*   $("body").on("keyup", '.discount', function() {
        var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
        var discount = $(this).parent("tr").find("td").eq(6).text();
        
        if (discount == "" || !numberRegex.test(discount)) {
          discount = 0;
        }
        var unitprice = $(this).parent("tr").find("td").eq(4).text();
        var qty = $(this).parent("tr").find("td").eq(3).text();
        var amount = parseFloat(qty * unitprice).toFixed(2);
        var totaldiscount = parseFloat(discount * qty).toFixed(2);
        var vat = 0.05;
        var productvat = parseFloat(unitprice * vat).toFixed(2);
        var totalvat = parseFloat(qty * productvat).toFixed(2);
        var total = parseFloat(amount - totaldiscount);
        var nettotal=(parseFloat(totalvat)+parseFloat(total)).toFixed(2);
        $(this).parents("tr").find("td:eq(5)").text(amount);
        $(this).parents("tr").find("td:eq(7)").text(totalvat);
        $(this).parents("tr").find("td:eq(8)").text(nettotal);
        TablelSummation();

      }); */
    function clear() {
        $("#search").val("");
        $("#qty").val("");
        $("#mrp").val("");
        $("#discount").val("");

        $('#search').focus();
        itemids = 0;
    }

    function TablelSummation() {
        // netamount();
        // netamount();
        var cusnettotal = 0;
        var cusbalancedue = 0;
        netamount();
        totaldiscount();
        totalvat();
        Nettotal();

        /* $("#amount").val(netamounts);
        $("#totaldiscount").val(netdiscount);
        $("#vat").val(netvat);
        $("#nettotal").val(netallTotal); */
        //customer section
        $("#currentsale").val(netallTotal);
        cusnettotal = parseFloat(netallTotal) + parseFloat(credit);
        cusbalancedue = parseFloat(netallTotal) + parseFloat(balancedue);
        if (!$("#customer option:selected").length) {
            $("#cusnettoal").val(cusnettotal.toFixed(2));
            $("#balancedue").val(cusbalancedue.toFixed(2));
        } else {
            customerPanelClear();
        }

    }

    function customerPanelClear() {
        $("#creditinv").val("0");
        $("#currentsale").val("0");
        $("#cusnettoal").val("0");
        $("#cuspayment").val("0");
        $("#balancedue").val("0");
    }

    function netamount() {
        var sum = 0;
        $(".amount").each(function() {
            var value = $(this).text();
            if (!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });
        $("#amount").val(sum.toFixed(2));

    }

    function totaldiscount() {
        var sum = 0;
        $('.i').each(function() {
            var value = $(this).data('totaldiscount');

            if (!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });
        $("#totaldiscount").val(sum.toFixed(2));

    }

    function totalvat() {
        var sum = 0;
        $('.i').each(function() {
            var value = $(this).data('totalvat');
            if (!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });
        $("#vat").val(sum.toFixed(2));
    }

    function Nettotal() {
        var sum = 0;
        $('.i').each(function() {
            var value = $(this).data('nettotal');
            if (!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });
        /*   if ($("#shipment").val() == "") {
              shipment = 0;
          } else {
              shipment = parseFloat($("#shipment").val());
          } */
        if ($("#vat").val() == "") {
            vats = 0;
        } else {
            vats = parseFloat($("#vat").val());
        }
        if ($("#totaldiscount").val() == "") {
            totaldiscounts = 0;
        } else {
            totaldiscounts = parseFloat($("#totaldiscount").val());
        }
        netallTotal = (shipment + sum + vats + totaldiscounts).toFixed(2);
        $("#nettotal").val(netallTotal);
    }
    $("#totaldiscount").on('click', function() {
        $("#totaldiscount").val("");
    })
    $("#totaldiscount").on('keyup', function() {
        if (netallTotal > 0) {
            Nettotal();
        }
    })
    $("#vat").on('click', function() {
        $("#vat").val("");
    })
    $("#vat").on('keyup', function() {
        if (netallTotal > 0) {
            Nettotal();
        }
    })
    $("#shipment").on('click', function() {
        $("#shipment").val("");
    })
    $("#shipment").on('keyup', function() {
        if (netallTotal > 0) {
            Nettotal();
        }

    })
    //inset Data
    function DataInsert() {
        $("#overlay").fadeIn();
        var returncode = $("#returncode").val();
        var invoicecode = $("#invoicecode").val();
        console.log(invoicecode);
        var type = $("#type").val();
        var openingdate = $("#dateinput").val();
        var customername = $("#customersearch").val();
        customerid = $('#customer').find('option[value="' + customername + '"]').attr('id');
        var refno = $("#refno").val();
        var amount = $("#amount").val();
        var totaldiscount = $("#totaldiscount").val();
        var vat = $("#vat").val();
        var nettotal = $("#nettotal").val();
        var itemtables = new Array();
        $("#table TBODY TR").each(function() {
            var row = $(this);
            var item = {};
            item.code = row.data('itemcode');
            item.Name = row.find("TD").eq(1).html();
            item.qty = row.find("TD").eq(2).html();
            item.unitprice = row.find("TD").eq(3).html();
            item.amount = row.find("TD").eq(4).html();
            /*  item.discount = row.find("TD").eq(6).html(); */
            item.discount = row.data('totaldiscount');
            item.vat = row.data('totalvat');
            item.nettotal = row.data('nettotal');
            if (item.nettotal > 0) {
                itemtables.push(item);
            }
        });
        //  console.log(itemtables);
        $.ajax({
            type: "POST",
            url: "{{ route('salereturn.store') }}",
            data: {
                itemtables: itemtables,
                invoicecode: invoicecode,
                returncode: returncode,
                type: type,
                openingdate: openingdate,
                customer_id: customerid,
                refno: refno,
                amount: amount,
                discount: totaldiscount,
                vat: vat,
                nettotal: nettotal,
                shipment: shipment
            },
            datatype: ("json"),
            success: function(data) {
                $("#overlay").fadeOut();
                if (data > 0) {
                    Confirmation(data);
                } else {
                    swal("Ops! Something Wrong", "Data Submit Fail", "error");
                }

            },
            error: function(data) {
                $("#overlay").fadeOut();
                swal("Ops! Fail To submit", "Data Submit", "error");
                console.log(data);
            }
        });

    }
    $("#submittData").click(function() {
        var tbody = $(".data-table tbody");

        if (netallTotal == 0 || tbody.children().length == 0 || customerid < 0) {
            swal("Please Select Requirment Fields", "Requirment Field Empty", "error");
        } else {
            DataInsert();
        }
    });


    function ExecuteClear() {
        SaleReturnCode();
        $("#datatablebody").empty();
        $("#amount").val(0);
        $("#totaldiscount").val(0);
        $("#vat").val(0);
        $("#nettotal").val(0);
        $("#suppliersearch").val("");
        $("#refno").val("");
        $("#customersearch").val("");
        netallTotal = 0;
        sl = 1;
        netallTotal = 0;
        customerid = 0;
        credit = 0;
        payment = 0;
        dicount = 0;
        balancedue = 0;
        shipment = 0;
        customerPanelClear();

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
                        url = "{{ url('Admin/Sale-Return/show')}}" + '/' + data,
                            window.location = url;
                        break;
                    case "catch":

                        url = "{{ url('Admin/Sale-Return/LoadPrintslip')}}" + '/' + data,
                            window.open(url, '_blank');

                        break;
                    case "datapdf":
                        url = "{{ url('Admin/Sale-Return/returnpdf')}}" + '/' + id,
                            window.open(url, '_blank');
                        break;

                    default:
                        //swal("Thank You For Your Choice");
                }
            });
        ExecuteClear();
    }
    $("#resteBtn").click(function() {
        if ($("#datatablebody").is(':empty')) {
            ExecuteClear();
        } else {
            swal({
                    title: "Are you sure?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        ExecuteClear();
                    } else {
                        //swal("Your imaginary file is safe!");
                    }
                });
        }
    });
</script>