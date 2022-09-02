<script>
    var urlid;

    function ViewPaymentCode() {
        $.ajax({
            type: 'get',
            url: "{{ route('customerpayment.paymentcodedatalist') }}",
            datatype: 'JSON',
            success: function(data) {
                $('#paymentno').html(data);
            },
            error: function(data) {
                console.log(data)

            }
        });
    }

    $("#paymentcode").on('input', function() {
        var val = this.value;
        if ($('#paymentno option').filter(function() {
                return this.value.toUpperCase() === val.toUpperCase();
            }).length) {
            urlid = $('#paymentno').find('option[value="' + val + '"]').attr('id');
            $.ajax({
                type: 'post',
                url: "{{ url('Admin/Session-Id/cpaymentid')}}" + '/' + urlid,
                success: function() {
                    PayMentInfo();
                }
            });
        }
    });
    window.onload = ViewPaymentCode();

    function PayMentInfo() {
        $.ajax({
            type: "get",
            url: "{{ url('Admin/CustomerPayment/getView')}}",
            datatype: ("json"),
            success: function(data) {
                urlid = data.id
                $("#paymentcode").val(data.payment_no);
                lodData(data);
                customerInfo(data.customer_id);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    window.onload = PayMentInfo();

    function lodData(data) {
        var paymenttype = "";
        switch (data.payment_type) {
            case 1:
                paymenttype = 'Cash';
                break;
            case 2:
                paymenttype = 'Card';
                break;
            default:
                paymenttype = 'Bank';
                break;

        }
        $("#supplierpaymentno").html(data.payment_no)
        $("#paymentdate").html(data.inputdate)
        $("#paymenttype").html(paymenttype)
        $("#amount").html(data.amount)
        $("#payment").html(data.recieve)
        $("#balancedue").html(data.balancedue)
        $("#inwords").html(numberToWords(data.recieve) + " Only")
    }

    function customerInfo(cusid) {
        $.ajax({
            type: 'get',
            url: "{{url('Admin/Customer/customerinfo')}}?customerid=" + cusid,
            success: function(data) {
                console.log(data)
                customerInformation(data.customer);
                CustomerinfoDetails(data);
            },
            error: function(data) {
                console.log(data);
            }
        });

    }

    function customerInformation(data) {
        $("#suppliername").html(data.name);
        $("#supplieraddress").html("<p>" + data.address + "," + data.city_name['name'] + "," + data.state_name['name'] + ",</p>");
        $("#suppliercountry").html("<p>" + data.country_name['name'] + ".</p>");
        $("#mobile").html("&nbsp;&nbsp;" + data.mobile_no);
        $("#telno").html("&nbsp;&nbsp;" + data.tell_no);
        $("#email").html("&nbsp;&nbsp;" + data.email);
        $("#website").html("&nbsp;&nbsp;" + data.website);
    }

    function CustomerinfoDetails(data) {
        $("#opening").html('<b>' + parseFloat(data.openingbalance).toFixed(2) + '</b>')
        $("#cashinv").html('<b>' + parseFloat(data.cashinvoice).toFixed(2) + '</b>')
        $("#creditinv").html('<b>' + parseFloat(data.creditinvoice).toFixed(2) + '</b>')
        $("#consignment").html('<b>' + parseFloat(data.consignment).toFixed(2) + '</b>')
        $("#sdiscount").html('<b>' + parseFloat(data.discount).toFixed(2) + '</b>')
        $("#spayment").html('<b>' + parseFloat(data.payment).toFixed(2) + '</b>')
        $("#sbalancedue").html('<b>' + parseFloat(data.balancedue).toFixed(2) + '</b>')
    }


    function numberToWords(number) {
        var digit = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
        var elevenSeries = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
        var countingByTens = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
        var shortScale = ['', 'thousand', 'million', 'billion', 'trillion'];
        number = number.toString();
        number = number.replace(/[\, ]/g, '');
        if (number != parseFloat(number)) return 'not a number';
        var x = number.indexOf('.');
        if (x == -1) x = number.length;
        if (x > 15) return 'too big';
        var n = number.split('');
        var str = '';
        var sk = 0;
        for (var i = 0; i < x; i++) {
            if ((x - i) % 3 == 2) {
                if (n[i] == '1') {
                    str += elevenSeries[Number(n[i + 1])] + ' ';
                    i++;
                    sk = 1;
                } else if (n[i] != 0) {
                    str += countingByTens[n[i] - 2] + ' ';
                    sk = 1;
                }
            } else if (n[i] != 0) {
                str += digit[n[i]] + ' ';
                if ((x - i) % 3 == 0) str += 'hundred ';
                sk = 1;
            }
            if ((x - i) % 3 == 1) {
                if (sk) str += shortScale[(x - i - 1) / 3] + ' ';
                sk = 0;
            }
        }
        if (x != number.length) {
            var y = number.length;
            str += 'point ';
            for (var i = x + 1; i < y; i++) str += digit[n[i]] + ' ';
        }
        str = str.replace(/\number+/g, ' ');
        return str.trim() + ".";

    }
    $(document).on('click', "#pdf", function() {
        url = "{{ url('Admin/CustomerPayment/pdf')}}" + '/' + urlid,
            window.open(url, '_blank');
    })
    $("#mail").on('click', function() {
    if (urlid > 0) {
      url = "{{ url('Admin/CustomerPayment/sendmail')}}" + '/' + urlid,
        window.location = url;
    }
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

                    $.ajax({
                        type: "post",
                        url: "{{ url('Admin/CustomerPayment/delete')}}" + '/' + urlid,
                        success: function(data) {
                            url = "{{ route('customerpayments')}}",
                                window.open(url);
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
</script>