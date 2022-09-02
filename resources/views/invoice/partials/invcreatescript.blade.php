<script type="text/javascript">
    var invoiceno = 0;
    var sl = 1;
    var netallTotal = 0;
    var pay = 0;
    var change = 0;
    var customerid = 0;
    var shipment = 0;
    var vats = 0;
    var totaldiscounts = 0;
    var autometic_store = 0;
    var vat_applicable = 0;
    var itemids = 0;

    function RetriveData() {
        $.ajax({
            type: 'get',
            url: "{{ route('saleconfig.view') }}",
            datatype: 'JSON',
            success: function(data) {
                customerid = data.customer_id;
                autometic_store = data.autometic_store;
                vat_applicable = data.vat_applicable;
                $("#customer option[id='" + customerid + "']").attr('selected', 'selected');
            },
        });

    }
    window.onload = RetriveData();

    function InvoiceCode() {
        $.ajax({
            type: 'get',
            url: "{{ route('invoice.invoicecode') }}",
            datatype: 'JSON',
            success: function(data) {
                invoiceno = data;
                $("#invoicecode").val(invoiceno);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

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
    $("#search").on('input', function() {
        var val = this.value;
        var mrp = 0;
        if ($('#product option').filter(function() {
                return this.value.toUpperCase() === val.toUpperCase();
            }).length) {
            itemids = $('#product').find('option[value="' + val + '"]').attr('id');
            var itemprice = $('#product').find('option[value="' + val + '"]').attr('data-mrp');
            var discount = $('#product').find('option[value="' + val + '"]').attr('data-discount');

            if (discount > 0) {
                mrp = discount;
            } else {
                mrp = itemprice;
            }

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

    window.onload = CustomerDataList();
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
            if (itemids == tableitemcode) {
                isvalid = false;
                var findrow = $(this);
                AutoQuantityUpdate(findrow, qty)

            }
        });
        if (isvalid == true) {
            addRowData();
        }
    }

    function AutoQuantityUpdate(row, qty) {
        var vat = 0;
        var itemname = row.data('searchname');
        var rowqty = row.find("td").eq(2).text();
        var totalqty = parseFloat(rowqty) + parseFloat(qty);
        var unitprice = row.find("td").eq(3).text();
        var discount = row.data('discount');
        var amount = parseFloat(totalqty * unitprice).toFixed(2);
        var totaldiscount = parseFloat(discount * totalqty).toFixed(2);
        if (vat_applicable == 1) {
            //var vatvalue = $('#product').find('option[value="' + itemname + '"]').attr('data-vat');
            vatvalue=0;
            vat = vatvalue / 100;
        } else {
            vat = 0;
        }
        row.find("td:eq(2)").text(totalqty);
        var productvat = parseFloat(unitprice * vat).toFixed(2);
        var totalvat = parseFloat(totalqty * productvat).toFixed(2);
        var total = parseFloat(amount - totaldiscount);
        var nettotal = (parseFloat(totalvat) + parseFloat(total)).toFixed(2);

        console.log(productvat)
        row.find("td:eq(4)").text(amount);
        row.data('totaldiscount', totaldiscount);
        row.data('totalvat', totalvat);
        row.data('nettotal', nettotal);
        TablelSummation();
        clear();
    }

    function addRowData() {
        RetriveData();
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
         //   var vatvalue = $('#product').find('option[value="' + search + '"]').attr('data-vat');
         var vatvalue=0;
         vat = vatvalue / 100;
            console.log(vatvalue)

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
            "<button class='btn btn-secondary btn-sm btn-iniview' id='invviewitem' data-id='" + itemcode + "' data-toggle='modal' data-target='#invmodelviewitems'><i class='fa fa-eye'></i></button>" +
            "<button class='btn btn-danger btn-sm btn-delete'>X</button>" +
            "<div>" +
            "</td>" +
            "</tr>");
        sl++;
        TablelSummation();
        clear();
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
        var vat = 0.05;
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
    /*    $(".modal").on("hidden.bs.modal", function(){
    $(".modal-body").html("");
}); */
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
        itemids = 0;
        $('#search').focus();

    }

    function TablelSummation() {
        netamount();
        totaldiscount();
        totalvat();
        Nettotal();
        $("#pay").val("0");
        $("#change").val("0");
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
        if ($("#shipment").val() == "") {
            shipment = 0;
        } else {
            shipment = parseFloat($("#shipment").val());
        }
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
        $("#bankamount").val(netallTotal);
        $("#cardamount").val(netallTotal);
        $("#paypalamount").val(netallTotal);

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
    //pay clear

    $("#pay").on('click', function() {

        $("#pay").val("");
        $("#change").val("");

    })

    $("#pay").on('keyup', function() {
        pay = 0;
        change = 0;
        var value = $(this).val();
        if (value == "" || netallTotal == 0) {
            var pay = 0;
            var change = 0;
        } else {
            pay = value;
            change = value - netallTotal;
        }
        $("#change").val(change.toFixed(2));

    })
    //inset Data
    var invid;

    function DataInsert(paymenttype_id, bankname, accno, bankdescrip, token) {

        $("#overlay").fadeIn();

        var invoicecode = $("#invoicecode").val();
        var openingdate = $("#dateinput").val();
        var customername = $("#customersearch").val();
        if (customername == "") {
            customerid = 1;
        } else {
            customerid = $('#customer').find('option[value="' + customername + '"]').attr('id');
        }
        var refno = $("#refno").val();
        var amount = $("#amount").val();
        var discount = $("#totaldiscount").val();
        var vat = $("#vat").val();
        var nettotal = $("#nettotal").val();
        var pay = $("#pay").val();
        var change = $("#change").val();
        var itemtables = new Array();
        // console.log(token)
        $("#table TBODY TR").each(function() {
            var row = $(this);
            var item = {};
            item.code = row.data('itemcode');
            item.name = row.find("TD").eq(1).html();
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
        InvoiceCode();
        $.ajax({
            type: "POST",
            url: "{{ route('invoice.store') }}",
            //data: JSON.stringify(itemtables),
            data: {
                itemtables: itemtables,
                invoicecode: invoicecode,
                openingdate: openingdate,
                customer_id: customerid,
                refno: refno,
                amount: amount,
                discount: discount,
                vat: vat,
                shipment: shipment,
                nettotal: nettotal,
                pay: pay,
                change: change,
                paymenttype_id: paymenttype_id,
                bankname: bankname,
                accno: accno,
                bankdescrip: bankdescrip,
                token: token


            },
            datatype: ("json"),
            success: function(data) {
                $("#overlay").fadeOut();

                if (data > 0) {
                    Confirmation(data);
                    invid = data;
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
        var pay = parseFloat($("#pay").val());
        var change = $("#change").val();
        var bankname = "";
        var accno = "";
        var bankdescrip = "";
        var paymentype = 1;
        if (netallTotal > pay || pay == 0 || pay == "" || netallTotal == 0 || change < 0 || pay < 0) {
            swal("Please Select Requirment Fields", "Requirment Field Empty", "error");
        } else {
            DataInsert(paymentype, bankname, accno, bankdescrip);
        }
    });
    bankid = 0;
    $("#banksubmittData").click(function() {
        var bankname = $("#banknamesearch").val();
        bankid = $('#banknames').find('option[value="' + bankname + '"]').attr('id');
        var accno = $("#accno").val();
        var bankdescrip = $("#bankdescrp").val();
        var paymentype = 2;

        if (bankid == 0 || accno == "" || netallTotal == 0) {
            swal("Please Select Requirment Fields", "Requirment Field Empty", "error");
        } else {
            DataInsert(paymentype, bankname, accno, bankdescrip);
        }
    });


    $("#cardsubmitData").click(function() {
        var paymentype = 3;
        var bankname = "";
        var accno = "";
        var bankdescrip = "";
        var option = {
            amount: netallTotal,
            name: document.getElementById('name_on_card').value
        }
        if (netallTotal == 0) {
            swal("Please Select Requirment Fields", "Requirment Field Empty", "error");
        } else {
            stripe.createToken(card, option).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    console.log(result.token);
                    DataInsert(paymentype, bankname, accno, bankdescrip, result.token);
                }


            });
        }
    });
    $("#paypalpayment").on('click', function() {
        if (netallTotal == 0) {
            swal("Please Select Requirment Fields", "Requirment Field Empty", "error");
        } else {
            $("#overlay").fadeIn();
            var paymenttype_id = 4;
            var invoicecode = $("#invoicecode").val();
            var openingdate = $("#dateinput").val();
            var customername = $("#customersearch").val();
            if (customername == "") {
                customerid = 1;
            } else {
                customerid = $('#customer').find('option[value="' + customername + '"]').attr('id');
            }
            var refno = $("#refno").val();
            var amount = $("#amount").val();
            var discount = $("#totaldiscount").val();
            var vat = $("#vat").val();
            var nettotal = $("#nettotal").val();
            var pay = $("#pay").val();
            var change = $("#change").val();
            var itemtables = new Array();
            // console.log(token)
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

            $.ajax({
                type: "POST",
                url: "{{ route('invoice.paypalcartstore') }}",
                //data: JSON.stringify(itemtables),
                data: {
                    itemtables: itemtables,
                    invoicecode: invoicecode,
                    openingdate: openingdate,
                    customer_id: customerid,
                    refno: refno,
                    amount: amount,
                    discount: discount,
                    vat: vat,
                    nettotal: nettotal,
                    paymenttype_id: paymenttype_id,
                },
                datatype: ("json"),
                success: function(data) {
                    $("#overlay").fadeOut();
                    url = "{{ url('Invoice/paypalprocess')}}" + '/' + data,
                        window.open(url);
                    ExecuteClear();
                },

                error: function(data) {
                    $("#overlay").fadeOut();
                    swal("Ops! Fail To submit", "Data Submit", "error");
                    console.log(data);
                }
            });
        }
    });


    $('#pay').keypress(function(e) {
        var key = e.which;
        if (key == 13) // the enter key code
        {
            var pay = parseFloat($("#pay").val());
            var change = $("#change").val();
            var bankname = "";
            var accno = "";
            var bankdescrip = "";
            var paymentype = 1;
            if (netallTotal > pay || pay == 0 || pay == "" || netallTotal == 0 || change < 0 || pay < 0) {
                swal("Please Select Requirment Fields", "Requirment Field Empty", "error");
            } else {
                DataInsert(paymentype, bankname, accno, bankdescrip);
            }
        }
    });



    function ExecuteClear() {
        InvoiceCode();

        $("#datatablebody").empty();
        $("#amount").val(0);
        $("#totaldiscount").val(0);
        $("#vat").val(0);
        $("#shipment").val(0);
        $("#nettotal").val(0);
        $("#suppliersearch").val("");
        $("#refno").val("");
        $("#pay").val(0);
        $("#change").val(0);
        $("#banknamesearch").val("");
        $("#accno").val("");
        $("#bankdescrp").val("");
        $("#bankamount").val(0);
        netallTotal = 0;
        sl = 1;
        $("#name_on_card").val("");
        $("#cardamount").val("")
        shipment = 0;
        vats = 0;
        totaldiscounts = 0;
        customerid = 0;
        RetriveData();



    }

    function Confirmation(data) {
        swal("Successfully Data Save", "Data Submit", "success", {
                buttons: {
                    cancel: "Close",
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
                        url = "{{ url('Admin/Invoice/show')}}" + '/' + data,
                            window.open(url, '_blank');
                        break;
                    case "catch":

                        url = "{{ url('Admin/Invoice/LoadPrintslip')}}" + '/' + data,
                            window.open(url, '_blank');
                        break;
                    case "datapdf":
                        url = "{{ url('Admin/Invoice/invoicepdf')}}" + '/' + data,
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
    window.onload = InvoiceCode();

    function InvSlip() {
        $.ajax({
            type: "get",
            url: "{{ url('Admin/Invoice/getView')}}" + '/' + invid,
            datatype: ("json"),
            success: function(data) {
                lodDatainv(data);
                printSlip();
            },
            error: function(data) {
                console.log(data)
            }
        });
    }

    function lodDatainv(data) {
        $("#invno").html(data.invoice_no);
        $("#indate").html(data.created_at);
        $("#invcustomer").html(data.customer_name['name']);
        $("#tablebodyc").empty();
        var sl = 1;
        data.inv_details.forEach(function(value) {
            $("#invtabledetails tbody").append("<tr>" +
                "<td>" + sl + "." + value.product_name['name'] + "</td>" +
                "<td align='right'>" + (value.qty).toFixed(2) + "</td>" +
                /*  "<td>" + value.unit_name['Shortcut'] + "</td>" + */
                "<td align='right'>" + (value.mrp).toFixed(2) + "</td>" +
                "<td align='right'>" + (value.discount).toFixed(2) + "</td>" +
                "<td align='right'>" + (value.amount).toFixed(2) + "</td>" +
                "</tr>");
            sl++;
        })
        $("#invtabledetails tbody").append(
            "<tr>" +
            "<td colspan='4' align='right'><b>Groce Total</b></td>" +
            "<td align='right'>" + data.amount + "</td>" +
            "</tr>" +
            "<tr>" +
            "<td colspan='4' align='right'><b>Discount</b></td>" +
            "<td align='right'>" + data.discount + "</td>" +
            "</tr>" +
            "<tr>" +
            "<td colspan='4' align='right'><b>Vat</b></td>" +
            "<td align='right'>" + data.vat + "</td>" +
            "</tr>" +
            "<tr>" +
            "<td colspan='4' align='right'><b>Net Total</b></td>" +
            "<td align='right'>" + data.nettotal + "</td>" +
            "</tr>"
        );
    }
</script>