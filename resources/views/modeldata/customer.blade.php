<div class="form-group mb-2">
    <input type="text" class="form-control" id="customersearchmodel" placeholder="Customer" list="customermodel" required>
    <datalist id="customermodel">
    </datalist>
</div>
<div class="row">
    <div class="col-sm-12">
        <h5 id="customername" style="color:red;"></h5>
    </div>
    <div class="col-sm-12" id="addressinfo">
        <h5>@lang('home.address')</h5>
        <address>
            <i class="" id="customeraddress"></i>
            <i class="" id="customercountry"></i>
            <i id="mobile" class="fa fa-mobile " aria-hidden="true"></i><br>
        </address>
    </div>
</div>
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="basicInfo-tab" data-toggle="tab" href="#basicInfo" role="tab" aria-controls="basicInfo" aria-selected="true">@lang('home.general') @lang('home.information')</a>
    </li>
</ul>
<div class="tab-content ml-1">
    <div class="tab-pane fade show active" id="basicInfo" role="tabpanel" aria-labelledby="basicInfo-tab">
        <table class="table-infodetails table table-borderd table-sm">
            <thead>
                <tr>
                    <th>@lang('home.field')</th>
                    <th>@lang('home.description')</th>
                </tr>
            </thead>
            <tbody id="customerinfodetails">
            </tbody>
        </table>
    </div>
</div>
<script>
    function CustomerDataList() {
        $('#customermodel').html("");
        $.ajax({
            type: 'get',
            url: "{{ route('customer.customerdatalist') }}",
            datatype: 'JSON',
            success: function(data) {
                $('#customermodel').html(data);
            },
            error: function(data) {}
        });
    }
    window.onload = CustomerDataList();
    $("#customersearchmodel").on('input', function() {
        var val = this.value;
        if (val == "") {
            //clear();
        } else {
            if ($('#customermodel option').filter(function() {
                    return this.value.toUpperCase() === val.toUpperCase();
                }).length) {
                var customerid = $('#customermodel').find('option[value="' + val + '"]').attr('id');
                customerinfo(customerid);
            }
        }

    });

    function customerinfo(customerid) {
        $.ajax({
            type: 'get',
            url: "{{url('Admin/Customer/customerinfo')}}?customerid=" + customerid,
            success: function(data) {
                CustomerBasicInfo(data);
                Customeraddress(data.customer);
                CustomerinfoDetails(data);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    function CustomerBasicInfo(data) {
        $('#imgProfilev').attr('src', '');
        var customername = data.customer.name.toUpperCase();
        $("#customername").text(customername);
        if (data.customer.image !== null) {
            var imagesrc = "{{ asset('images/Customer') }}/" + data.customer.image;
            $('#imgProfile').attr('src', imagesrc);
        }
        $("#basicinfo").html(
            '<h5>Details</h5>' +
            '<hr>' +
            'TIN:' + data.customer.TIN + '<br>' +
            'Oppening Date:' + data.customer.openingDate + '<br>' +
            /*   data.category.forEach(function(value) {
                value.cate_name['name']
              }) */
            +'<br>' +
            'Status: <span class="span-info"> </span>'
        );
    }

    function Customeraddress(data) {
        $("#customeraddress").html("<p>" + data.address + "," + data.city_name['name'] + "," + data.state_name['name'] + ",</p>");
        $("#customercountry").html("<p>" + data.country_name['name'] + ".</p>");
        $("#mobile").html("&nbsp;&nbsp;" + data.mobile_no);
       
    }

    function CustomerinfoDetails(data) {
        $("#supplierinfodetails").empty();
        $(".table-infodetails tbody").append(
            '<tr>' +
            '<th>Opening Balance</th>' +
            '<td>' + data.openingbalance + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th>Cash Invoice</th>' +
            '<td>' + data.cashinvoice + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th>Cash Invoice</th>' +
            '<td>' + data.creditinvoice + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th>Consignment</th>' +
            '<td>' + data.consignment + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th>Payment Recieved</th>' +
            '<td>' + data.payment + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th>Discount</th>' +
            '<td>' + data.discount + '</td>' +
            '</tr>' +
            '<tr>' +
            '<th>Balance Due</th>' +
            '<td>' + data.balancedue + '</td>' +
            '</tr>'
        );
    }

    function CustomerClear() {
        $('#imgProfilev').removeAttr("src");
        $(".table-infodetails tbody").empty();
        $("#customername").text("");
        $("#basicinfo").html("");
        $("#customeraddress").html("");
        $("#customercountry").html("");
        $("#mobile").html("");
        $("#telno").html("");
        $("#email").html("");
        $("#website").html("");
        $("#customersearchmodel").val("");
    }
</script>