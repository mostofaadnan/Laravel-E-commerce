<style>
    .opening {
        border: 1px #ccc solid;
    }
</style>
<div class="col-sm-6 form-single-input-section">
    <div class="card opening">
        <div class="card-header card-header-custom">
            @lang('home.customer') @lang('home.balance')  @lang('home.information') 
        </div>
        <div class="card-body">
            @include('partials.ErrorMessage')
            <form action="{{ route('customer.storeopening') }}" method="post">
            <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                    <input type="hidden" id="balanceid" name="balanceid">
                @csrf
                <div class="input-group  mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="">@lang('home.customer') </span>
                    </div>
                    <input type="text" name="sup_name" id="sup_name" class="form-control" placeholder="@lang('home.customer')  @lang('home.name')" value="{{ $customer->name }}" readonly>

                </div>
              <!--   <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">@lang('home.cash')  @lang('home.invoice')</label>
                    </div>
                    <input type="number" class="form-control" name="cashinvoice" id="cashinvoice" placeholder="0">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">@lang('home.credit') @lang('home.invoice')</label>
                    </div>
                    <input type="number" class="form-control" name="creditinvoice" id="creditinvoice" placeholder="0">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">@lang('home.consignment')</label>
                    </div>
                    <input type="number" class="form-control" name="consignment" id="consignment" placeholder="0" readonly>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01"> @lang('home.discount') </label>
                    </div>
                    <input type="number" class="form-control" name="totaldiscount" id="totaldiscount" placeholder="0">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">@lang('home.credit') @lang('home.payment')</label>
                    </div>
                    <input type="number" class="form-control" name="payment" id="payment" placeholder="0">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">@lang('home.netpayment')</label>
                    </div>
                    <input type="number" class="form-control" id="netpayment" placeholder="0" readonly>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">@lang('home.balancedue') </label>
                    </div>
                    <input type="number" class="form-control" name="balancedue" id="balancedue" placeholder="0" readonly>
                </div>
                <hr>
                <div class="pull-right">
                    <button type="submit" class="btn btn-lg btn-primary btn-block">@lang('home.submit')</button>
                </div> -->
            </form>
        </div>
    </div>
</div>