<script>
    var customerid = 0;
    var balancedue = 0;
    var newbalancedue = 0;
    var oldrecieve = 0;
    var recieve = 0;


    function purchaseCode() {
        $.ajax({
            type: 'get',
            url: "{{ route('customerpayment.paymentno') }}",
            datatype: 'JSON',
            success: function(data) {
                $("#paymentno").val(data);
            },
            error: function(data) {}
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
            error: function(data) {
                console.log(data);
            }
        });
    }
    window.onload = CustomerDataList();
    window.onload = purchaseCode();

    function clear() {
        customerid = 0;
        balancedue = 0;
        newbalancedue = 0;
        $("#cashinvoice").val("");
        $("#creditinvoice").val("");
        $("#discount").val("");
        $("#consignment").val("");
        $("#paidamount").val("");
        $("#balancedue").val("");
        $("#payment").val("");
        $("#newbalancedue").val("");
        $("#cashamount").val("");
        $("#cardamount").val("");
        $("#bankamount").val("");
        $("#paypalamount").val("");
        $("#banknamesearch").val("");
        $("#accno").val("");
        $("#bankdescrp").val("");
        $("#card-element").val("");
    }
    $("#customersearch").on('input', function() {
        var val = this.value;
        if (val == "") {
            clear();
        } else {
            if ($('#customer option').filter(function() {
                    return this.value.toUpperCase() === val.toUpperCase();
                }).length) {
                customerid = $('#customer').find('option[value="' + val + '"]').attr('id');
                $.ajax({
                    type: "get",
                    url: "{{ url('Admin/Customer/getAmounthistory')}}" + '/' + customerid,
                    datatype: ("json"),
                    success: function(data) {
                        loadData(data);
                    },
                    error: function() {}
                });
            }
        }

    });

    function loadData(data) {


        $("#cashinvoice").val(parseFloat(data.cashinvoice).toFixed(2));
        $("#creditinvoice").val(parseFloat(data.creditinvoice).toFixed(2));
        $("#consignment").val(parseFloat(data.consignment).toFixed(2));
        $("#discount").val(parseFloat(data.discount).toFixed(2));
        $("#paidamount").val(parseFloat(data.payment).toFixed(2));
        oldrecieve = parseFloat(data.payment).toFixed(2);
        $("#balancedue").val(parseFloat(data.balancedue).toFixed(2));
        balancedue = parseFloat(data.balancedue).toFixed(2);
    }
    $("#payment").on('keyup', function() {
        if (balancedue == 0) {} else {
            recieve = $(this).val();
            newbalancedue = balancedue - recieve;
            $("#newbalancedue").val(newbalancedue.toFixed(2));
            if (newbalancedue > 0) {
                $("#cashamount").val(recieve);
                $("#cardamount").val(recieve);
                $("#bankamount").val(recieve);
                $("#paypalamount").val(recieve);
            } else {
                $("#cashamount").val("");
                $("#cardamount").val("");
                $("#bankamount").val("");
                $("#paypalamount").val("");
            }

        }
    });



    function ExecuteClear() {
        $("#customersearch").val("");
        purchaseCode();
        clear();
    }
    //inset Data
    function DataInsert(paymentdescription, bankname, accno, bankdescrip, token) {
        $("#overlay").fadeIn();
        var paymentno = $("#paymentno").val();
        var inputdate = $("#inputdate").val();
        var amount = $("#balancedue").val();
        var newbalancedue = $("#newbalancedue").val();
        var paymenttype = $("#paymenttype").val();

        var remark = $("#remark").val();
        $.ajax({
            type: "POST",
            url: "{{ route('customerpayment.store') }}",
            //data: JSON.stringify(itemtables),
            data: {
                paymentno: paymentno,
                inputdate: inputdate,
                customer_id: customerid,
                amount: amount,
                recieve: recieve,
                oldrecieve: oldrecieve,
                newbalancedue: newbalancedue,
                paymenttype: paymenttype,
                bankname: bankname,
                accno: accno,
                bankdescrip: bankdescrip,
                remark: remark,
                paymentdescription: paymentdescription,
                token: token
            },
            datatype: ("json"),
            success: function(data) {
                $("#overlay").fadeOut();
                Confirmation(data);
            },
            error: function(data) {
                $("#overlay").fadeOut();
                swal("Ops! Fail To submit", "Data Submit", "error");
                console.log(data);
            }
        });
    }
    $("#datasubmit").on('click', function() {
        var nbalancedue = $("#newbalancedue").val();
        if (recieve == 0 || customerid == 0 || nbalancedue == "" || nbalancedue < 0) {
            swal("Requirement Field", "Please Select Requirement fields to fillup", "error");
        } else {
            PaymentPermission();
        }

    });
    bankid = 0;

    function PaymentPermission() {
        var type = $("#paymenttype").val();
        if (type == 1) {
            //cash payment
            var paymentdescription = "Cash Payment"
            DataInsert(paymentdescription);
        } else if (type == 2) {
            //bank payment
            var bankname = $("#banknamesearch").val();
            bankid = $('#banknames').find('option[value="' + bankname + '"]').attr('id');
            var accno = $("#accno").val();
            var bankdescrip = $("#bankdescrp").val();
            var paymentype = 2;
            var bankamount = $("#bankamount").val();
            var paymentdescription = "Bank:" + bankname + "\n" + "Acc No:" + accno;
            if (bankid == 0 || accno == "" || bankamount == 0 || bankamount == "") {
                swal("Please Select Bank Requirment Fields", "Requirment Field Empty", "error");
            } else {
                DataInsert(paymentdescription, bankname, accno, bankdescrip);
            }
        } else if (type == 3) {
            var bankname = "";
            var accno = "";
            var bankdescrip = "";
            var cardamount = $("#cardamount").val();
            var option = {
                amount: cardamount,
                name: document.getElementById('name_on_card').value
            }
            if (cardamount == 0 || cardamount == "") {
                swal("Please Select Requirment Fields", "Requirment Field Empty", "error");
            } else {
                stripe.createToken(card, option).then(function(result) {
                    if (result.error) {
                        // Inform the user if there was an error.
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                     
                        var card = result.token['card'];
                        var card_id = card['id'];
                        var brand = card['brand'];
                        var stripe_id = result.token['id'];
                        var name_on_card = card['name'];
                        var paymentdescription = 'Name On Card:' + name_on_card + "\n" + "Card:" + brand + "\n" + "Card Id:" + card_id + "\n" + "Stripe Id:" + stripe_id
                        DataInsert(paymentdescription, bankname, accno, bankdescrip, result.token);
                        
                    }


                });
            }
        } else {
            //paypal
            var nbalancedue = $("#newbalancedue").val();
            if (recieve == 0 || customerid == 0 || nbalancedue == "" || nbalancedue < 0) {
                swal("Requirement Field", "Please Select Requirement fields to fillup", "error");
            } else {
                $("#overlay").fadeIn();
                var paymentno = $("#paymentno").val();
                var inputdate = $("#inputdate").val();
                var amount = $("#balancedue").val();
                var newbalancedue = $("#newbalancedue").val();
                var paymenttype = $("#paymenttype").val();
                var remark = $("#remark").val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('customerpayment.paypalstore') }}",
                    //data: JSON.stringify(itemtables),
                    data: {
                        paymentno: paymentno,
                        inputdate: inputdate,
                        customer_id: customerid,
                        amount: amount,
                        recieve: recieve,
                        oldrecieve: oldrecieve,
                        newbalancedue: newbalancedue,
                        remark: remark,
                    },
                    datatype: ("json"),
                    success: function(data) {
                        $("#overlay").fadeOut();
                        url = "{{ url('Admin/CustomerPayment/paypalprocess')}}" + '/' + data,
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
        }
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
                        url = "{{ url('Admin/CustomerPayment/show')}}" + '/' + data,
                            window.location = url;
                        break;
                    case "catch":
                        //PurchasePrint();
                        break;
                    case "datapdf":
                        url = "{{ url('Admin/CustomerPayment/pdf')}}" + '/' + data,
                            window.open(url, '_blank');
                        break;

                    default:
                        //swal("Thank You For Your Choice");
                }
            });
        ExecuteClear();
    }
</script>