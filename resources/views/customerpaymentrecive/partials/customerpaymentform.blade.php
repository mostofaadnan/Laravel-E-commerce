<style>
    .paymentbox {
        display: none;

    }
    #cashamount{
        text-align: right;
        font-style: bold;
        color: #ff3547;
        font-size: 16px;
    }
    #cardamount{
        text-align: right;
        font-style: bold;
        color: #ff3547;
        font-size: 16px;
    }
    #bankamount{
        text-align: right;
        font-style: bold;
        color: #ff3547;
        font-size: 16px;
    }
    #paypalamount{
        text-align: right;
        font-style: bold;
        color: #ff3547;
        font-size: 16px;
    }
    #payment{
        text-align: right;
        font-style: bold;
        color: #ff3547;
        
    }
</style>
<div class="row">
    <div class="input-group  col-sm-6 mb-1">
        <div class="input-group-prepend">
            <span class="input-group-text">@lang('home.payment') @lang('home.no')</span>
        </div>
        <input type="text" class="form-control" id="paymentno" placeholder="@lang('home.payment') @lang('home.no')" readonly>
    </div>
    <div class="input-group  col-sm-6 mb-1">
        <div class="input-group date" data-provide="datepicker" id="datetimepicker2">
            <div class="input-group-prepend">
                <span class="input-group-text" id="">@lang('home.date')</span>
            </div>
            <input type="text" id="inputdate" class="form-control" data-date="">
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
        </div>
    </div>
</div>
<div class="input-group  mb-1">
    <div class="input-group-prepend">
        <span class="input-group-text" id="">@lang('home.customer')</span>
    </div>
    <input type="text" class="form-control" id="customersearch" placeholder="@lang('home.customer')" list="customer" required>
    <datalist id="customer">
    </datalist>
</div>
<div class="row">
    <div class="input-group  col-sm-6 mb-1">
        <div class="input-group-prepend">
            <span class="input-group-text">@lang('home.cash') @lang('home.invoice')</span>
        </div>
        <input type="text" class="form-control" id="cashinvoice" placeholder="@lang('home.cash') @lang('home.invoice')" readonly>
    </div>
    <div class="input-group col-sm-6 mb-1">
        <div class="input-group-prepend">
            <span class="input-group-text" id="">@lang('home.credit') @lang('home.invoice')</span>
        </div>
        <input type="text" id="creditinvoice" class="form-control" placeholder="@lang('home.credit') @lang('home.invoice')" readonly>
    </div>
</div>
<div class="row">
    <div class="input-group col-sm-6 mb-1">
        <div class="input-group-prepend">
            <span class="input-group-text" id="">@lang('home.consignment')</span>
        </div>
        <input type="text" id="consignment" class="form-control" placeholder="@lang('home.consignment')" readonly>
    </div>
    <div class="input-group  col-sm-6 mb-1">
        <div class="input-group-prepend">
            <span class="input-group-text">@lang('home.discount')</span>
        </div>
        <input type="text" class="form-control" id="discount" placeholder="@lang('home.discount')" readonly>
    </div>
</div>
<div class="row">
    <div class="input-group  col-sm-6 mb-1">
        <div class="input-group-prepend">
            <span class="input-group-text">@lang('home.paid') @lang('home.amount')</span>
        </div>
        <input type="text" class="form-control" id="paidamount" placeholder="@lang('home.paid') @lang('home.amount')" readonly>
    </div>
    <div class="input-group col-sm-6 mb-1">
        <div class="input-group-prepend">
            <span class="input-group-text" id="">@lang('home.balancedue')</span>
        </div>
        <input type="text" id="balancedue" class="form-control" placeholder="@lang('home.balancedue')" readonly>
    </div>
</div>
<hr>
<div class="row">
    <div class="input-group  col-sm-6 mb-1">
        <div class="input-group-prepend">
            <span class="input-group-text">@lang('home.payment')</span>
        </div>
        <input type="number" class="form-control" id="payment" placeholder="@lang('home.payment')">
    </div>
    <div class="input-group col-sm-6 mb-1">
        <div class="input-group-prepend">
            <span class="input-group-text" id=""> @lang('home.new') @lang('home.balancedue')</span>
        </div>
        <input type="text" name="barcode" id="newbalancedue" class="form-control" placeholder="@lang('home.new') @lang('home.balancedue')" readonly>
    </div>
</div>
<div class="row">
    <div class="input-group mb-1 col-sm-6">
        <div class="input-group-prepend">
            <span class="input-group-text">@lang('home.payment') @lang('home.type')</span>
        </div>
        <select name="" id="paymenttype" class="form-control">
            <option value="1">Cash</option>
            <option value="2">Bank</option>
            <option value="3">Card</option>
            <option value="4">Paypal</option>

        </select>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-12">
        <div id="cashpanel">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">@lang('home.amount')</span>
                </div>
                <input type="text" class="form-control" id="cashamount" placeholder="@lang('home.amount')" readonly>
            </div>
        </div>
        <div class="paymentbox" id="bankpanel">
            @include('customerpaymentrecive.partials.bankpayment')
        </div>
        <div class="paymentbox" id="cardpanel">
            @include('customerpaymentrecive.partials.cardpayment')
        </div>
        
        <div class="paymentbox" id="paypalpanel">
            @include('customerpaymentrecive.partials.paypalpayment')
        </div>
    </div>
</div>
<hr>
<div class="input-group mb-1">
    <div class="input-group-prepend">
        <span class="input-group-text" id="">@lang('home.remark')</span>
    </div>
    <textarea name="" class="form-control" id="remark" cols="5" rows="5" placeholder="@lang('home.remark')"></textarea>
</div>

<script>
    $('#paymenttype').change(function() {
        var type = $(this).val();
        console.log(type)
        if (type == 1) {
            $("#cashpanel").show();
            $("#bankpanel").hide();
            $("#cardpanel").hide();
            $("#paypalpanel").hide();
        } else if (type == 2) {
            $("#cashpanel").hide();
            $("#bankpanel").show();
            $("#cardpanel").hide();
            $("#paypalpanel").hide();
        } else if (type == 3) {
            $("#cashpanel").hide();
            $("#bankpanel").hide();
            $("#cardpanel").show();
            $("#paypalpanel").hide();
        } else {
            $("#cashpanel").hide();
            $("#bankpanel").hide();
            $("#cardpanel").hide();
            $("#paypalpanel").show();
        }

    });

    $(function() {
        var myDate = $("#inputdate").attr('data-date');
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        var currentmonth = new Date(date.getFullYear(), date.getMonth());
        $('#inputdate').datepicker({
            dateFormat: 'yyyy/mm/dd',
            todayHighlight: true,
            startDate: today,
            endDate: end,
            autoclose: true
        });
        $('#inputdate').datepicker('setDate', myDate);
        $('#inputdate').datepicker('setDate', today);
    });
</script>