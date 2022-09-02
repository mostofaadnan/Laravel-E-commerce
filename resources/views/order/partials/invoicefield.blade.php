<div class="card card-design">
    <div class="card-header card-header-section">
        @include('section.invoicesection')
    </div>
    <div class="card-body">
        <div class="card">
            <div class="card-header">
                @include('section.itemsection')
            </div>
            <div class="card-body">
                <div class="row invoice-section no-gutters">
                    <div class="col-sm-9 mr-0">
                        <div class="my-custom-scrollbar my-custom-scrollbar-primary scrollbar-morpheus-den">
                            @include('invoice.partials.invoiceTable')
                        </div>
                    </div>
                    <div class="col-sm-3 mr-0" style="background-color:#001f3f;">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="basicInfo-tab" data-toggle="tab" href="#basicInfo" role="tab" aria-controls="basicInfo" aria-selected="true"><small>@lang('home.cash')</small></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="banksection-tab" data-toggle="tab" href="#banksection" role="tab" aria-controls="banksection" aria-selected="false">@lang('home.bank')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="cardsection-tab" data-toggle="tab" href="#cardsection" role="tab" aria-controls="cardsection" aria-selected="false">@lang('home.card')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="paypalsection-tab"  data-toggle="tab" href="#paypalsection" role="tab" aria-controls="basicInfo" aria-selected="false">@lang('home.paypal')</a>
                            </li>
                        </ul>
                        @include('invoice.partials.sumsidebarsection')
                    </div>
                </div>
                @include('invoice.partials.footerbutton')
                <!--  </div> -->
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>