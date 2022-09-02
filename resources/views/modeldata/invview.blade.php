<div class="input-group mb-2">
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">@lang('home.invoice') @lang('home.no')</label>
    </div>
    <input type="text" class="form-control" id="invoicecodecheck" list="invoicenumbercheck" placeholder="@lang('home.search')">
    <datalist id="invoicenumbercheck">
    </datalist>
</div>
<div class="table-wrapper-scroll-y my-custom-scrollbar">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h2 id="customernamec"></h2>
                <address>
                    <i class="" id="customeraddressc"></i>
                    <i class="" id="customercountryc"></i>
                    <i id="mobilec" class="fa fa-mobile " aria-hidden="true"></i><br>
                    <i id="telnoc" class="fa fa-phone" aria-hidden="true"></i><br>
                    <i id="emailc" class="fa fa-envelope-o" aria-hidden="true"></i><br>
                    <i id="websitec" class="fa fa-address-book-o" aria-hidden="true"></i>
                </address>
            </div>
            <div class="col-sm-6">
                <table class="table table-bordered  mb-0 table-sm ">
                    <tr>
                        <th>@lang('home.invoice') @lang('home.type')</th>
                        <td id="typec"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.invoice') @lang('home.no')</th>
                        <td id="invoicenoc"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.date')</th>
                        <td id="invoicedatec"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.reference') @lang('home.no')</th>
                        <td id="refnoc"></td>
                    </tr>
                    <tr>
                        <th>@lang('home.payment') @lang('home.type')</th>
                        <td id="paymenttypec"></td>
                    </tr>
                </table>
            </div>
        </div>
        <table class="table table-bordered mb-0 table-sm data-tablec" width="100%">
            <thead>
                <th>#@lang('home.sl')</th>
                <th>@lang('home.description')</th>
                <th>@lang('home.quantity')</th>
                <th>@lang('home.unit')</th>
                <th>@lang('home.unit') @lang('home.price')</th>
                <th>@lang('home.total')</th>
            </thead>
            <tbody id="tablebodyc">
            </tbody>
        </table>
    </div>
</div>