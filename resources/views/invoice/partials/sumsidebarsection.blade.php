<style>
    .footer {
        padding: 0px !important;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: #001f3f !important;
        color: white;
        /*  z-index: 9999; */
        /* height: 400px; */
        padding-left: 0px !important;
        padding-right: 0px !important;
    }



    .sum-section {
        text-align: right;
        font-style: bold;
        color: #ff3547;
        font-size: 16px;

    }

    .payment-type {
        background-color: #001f3f !important;
        color: white;
    }

    #payment-option {
        color: #fff;
    }

    .btn-rounded {
        border-radius: 10em;
    }

    .btn-danger {
        background-color: #ff3547;
        color: #fff;
    }

    .btn-light {
        color: #000 !important;

    }

    .btn-submit {

        margin: .375rem;
        color: inherit;
        text-transform: uppercase;
        word-wrap: break-word;
        white-space: normal;
        cursor: pointer;
        border: 0;
        border-radius: .125rem;
        -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        -webkit-transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        padding: .84rem 2.14rem;
        font-size: .81rem;
    }

    #pay {
        color: red;

    }

    #vat {
        color: red;

    }

    #totaldiscount {
        color: red;
    }

    .sumsection-input {
        background-color: #001f3f !important;
        font-size: 20px;
        width: 60px;

    }

    .sumsection-input-text {
        background-color: #001f3f !important;
        color: #fff !important;
        font-style: bold;
        font-size: 15px;
    }

    .nav-link.active {
        color: #f8f9fb !important;
        background-color: #001f3f !important;
        border-color: #dee2e6 #dee2e6 #fff;
    }

   

    #card-element {
        border: 1px #fff solid;
        background-color: transparent;
    }
   
</style>

<div class="card footer">
    <div class="card-body">
        <div class="tab-content mt-2" id="myTabContent">
            <div class="tab-pane fade show active" id="basicInfo" role="tabpanel" aria-labelledby="basicInfo-tab">
                <div class="from-group">
                    <label class="sumsection-input-text" for="inputGroupSelect01"> @lang('home.amount')</label>
                    <input type="text" class="form-control sum-section" id="amount" placeholder=" @lang('home.amount')" value="0" readonly>
                </div>

                <div class="from-group">
                    <label class="sumsection-input-text" for="inputGroupSelect01"> @lang('home.discount')</label>
                    <input type="text" class="form-control sum-section" id="totaldiscount" placeholder=" @lang('home.discount')" value="0">
                </div>
                <div class="from-group">
                    <label class="sumsection-input-text" for="inputGroupSelect01"> @lang('home.vat')</label>
                    <input type="text" class="form-control sum-section" id="vat" value="0" placeholder=" @lang('home.vat')">
                </div>
                <div class="from-group">
                    <label class="sumsection-input-text" for="inputGroupSelect01"> @lang('home.nettotal')</label>
                    <input type="text" class="form-control sum-section" id="nettotal" placeholder=" @lang('home.nettotal')" value="0" readonly>
                </div>
                <div class="from-group">
                    <label class="sumsection-input-text" for="inputGroupSelect01"> @lang('home.pay')</label>
                    <input type="text" class="form-control sum-section" id="pay" value="0" placeholder=" @lang('home.pay')">
                </div>
                <div class="from-group">
                    <label class=" sumsection-input-text" for="inputGroupSelect01"> @lang('home.change')</label>
                    <input type="text" class="form-control sum-section" id="change" value="0" placeholder=" @lang('home.change')" readonly>
                </div>
                <button style="width:100%;" type="button" id="submittData" class="btn btn-danger btn-lg mt-1" name="button"> @lang('home.submit')<small><i>(cntl+s)</i></small></button>
            </div>
            <div class="tab-pane fade show" id="banksection" role="tabpanel" aria-labelledby="banksection-tab">
                @include('section.bankpaymentsection')
            </div>
            <div class="tab-pane fade show" id="cardsection" role="tabpanel" aria-labelledby="cardsection-tab">
                @include('section.cardpaymentsection')
            </div>
            <div class="tab-pane fade show" id="paypalsection" role="tabpanel" aria-labelledby="paypalsection-tab">
                @include('section.paypalpaymentsection')
            </div>
        </div>
    </div>

</div>


<script type="text/javascript">
    window.onload = function() {
        $.ajax({
            type: 'get',
            url: "{{ route('customer.customerdatalist') }}",
            datatype: 'JSON',
            success: function(data) {
                $('#banknames').html(data);
            },
            error: function(data) {}
        });
    }
</script>