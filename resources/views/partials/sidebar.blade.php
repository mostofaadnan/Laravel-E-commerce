<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3 style="border-bottom:1px solid #ccc !important;">@lang('home.menu')</h3>
        <ul class="nav side-menu">
            <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home"></i>@lang('home.deshboard')</a></li>
            <li><a><i class="fa fa-product-hunt"></i>@lang('home.page') <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{route('page.contactus')}}"> @lang('home.message')</a></li>
                    <li><a href="{{route('privacies')}}"> @lang('home.privacy') @lang('home.policy')</a></li>
                    <li><a href="{{route('terms')}}"> @lang('home.term') @lang('home.&') @lang('home.condition')</a></li>
                    <li><a href="{{route('faqs')}}"> @lang('home.faq')</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-wrench" aria-hidden="true"></i> @lang('home.setup') <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{route('company')}}">@lang('home.company')</a></li>
                    <li><a href="{{Route('stories')}}">Store Managment</a></li>
                    <li><a href="{{route('categories')}}">@lang('home.category')</a></li>
                    <li><a href="{{Route('subcategories')}}">@lang('home.subcategory')</a></li>
                    <li><a href="{{Route('units')}}">@lang('home.unit')</a></li>
                    <li><a href="{{Route('brands')}}">@lang('home.brand')</a></li>
             
                    <li><a href="{{Route('numberformat')}}">@lang('home.number') @lang('home.format')</a></li>
                    <li><a href="{{Route('mailconfigs')}}">@lang('home.mail') @lang('home.config')</a></li>
                    <li><a href="{{Route('countrys')}}">@lang('home.country') @lang('home.list')</a></li>
                    <li><a href="{{Route('states')}}">@lang('home.state') @lang('home.list')</a></li>
                    <li><a href="{{Route('citys')}}">@lang('home.city') @lang('home.list')</a></li>
               
                    <li><a href="{{Route('sliders')}}">@lang('home.slider')</a></li>
                    <li><a href="{{Route('banners')}}">@lang('home.banner')</a></li>
                    <li><a href="{{Route('homecategories')}}">@lang('home.home') @lang('home.category')</a></li>
                    <li><a href="{{Route('slidesTypes')}}">@lang('home.slide') @lang('home.type')</a></li>
                    <li><a href="{{Route('productslides')}}">@lang('home.product') @lang('home.slide')</a></li>
                    <li><a href="{{Route('shipments')}}">@lang('home.shipment') @lang('home.charge')</a></li>
                </ul>
            </li>

            <li><a><i class="fa fa-product-hunt"></i>@lang('home.item') @lang('home.management') <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{route('products')}}"> @lang('home.item') @lang('home.management')</a></li>
                    <li><a href="{{Route('product.create')}}">@lang('home.new') @lang('home.item')</a></li>
                    <li><a href="{{ Route('stocks') }}">@lang('home.stock') @lang('home.management')</a></li>
                    <li><a href="{{ Route('product.discount') }}">@lang('home.price')/ @lang('home.discount') @lang('home.update')</a></li>
                    <li><a href="{{ Route('product.Archive') }}">@lang('home.archive')</a></li>
                </ul>
            </li>
            </li>
            <li><a><i class="fa fa-user" aria-hidden="true"></i>@lang('home.customer') <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('customers') }}">@lang('home.customer') @lang('home.management')</a></li>
                    <li><a href="{{ route('customer.statement')}}">@lang('home.statement')</a></li>
                    <li><a href="{{ route('customer.Archived') }}">@lang('home.customer') @lang('home.archive')</a></li>
                </ul>
            </li>
         
            <li><a><i class="fa fa-money" aria-hidden="true"></i>@lang('home.payment')<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  
                    <li><a href="{{ route('customerpayments') }}">@lang('home.credit') @lang('home.payment')</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-shopping-cart" aria-hidden="true"></i>@lang('home.order') <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('orders') }}">@lang('home.order') @lang('home.list')</a></li>
                    <li><a href="{{ route('order.paymentinfo') }}">@lang('home.payment') @lang('home.information')</a></li>
                </ul>
            </li>
     
            <li><a><i class="fa fa-university" aria-hidden="true"></i> @lang('home.account') <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('cashdrawers') }}">@lang('home.cash') @lang('home.drawer')</a></li>
                    <li><a href="{{ route('banks') }}">@lang('home.bank') @lang('home.transection')</a></li>
                    <li><a href="{{ route('cashincashouts') }}">@lang('home.cashin')/@lang('home.cashout')</a></li>
                    <li><a href="{{ route('cards') }}">@lang('home.card') @lang('home.payment')</a></li>
                    <li><a href="{{ route('paypals') }}">@lang('home.paypal') @lang('home.payment')</a></li>
                </ul>
            </li>
 
            <li><a><i class="fa fa-flag" aria-hidden="true"></i> @lang('home.report')<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('report.orders') }}">@lang('home.order')</a></li>
                    <li><a href="{{ route('report.cpayment') }}">@lang('home.customer') @lang('home.payment')</a></li>
                    <li><a href="{{ route('report.stockReport') }}">@lang('home.stock')</a></li>
                    <li><a href="{{ route('report.cashdrawer') }}">@lang('home.cash') @lang('home.drawer')</a></li>
                    <li><a href="{{ route('report.bank') }}">@lang('home.bank') @lang('home.transection')</a></li>
                    <li><a href="{{ route('report.card') }}">@lang('home.card') @lang('home.payment')</a></li>
                    <li><a href="{{ route('report.paypal') }}">@lang('home.paypal') @lang('home.payment')</a></li>
                    <li><a href="{{ route('report.vatpayment') }}">@lang('home.vat') @lang('home.payment')</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-envelope-o" aria-hidden="true"></i> @lang('home.mail')<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('sendmails') }}">@lang('home.send') @lang('home.mail')</a></li>
                </ul>
            </li>
  
            <li><a><i class="fa fa-user" aria-hidden="true"></i> @lang('home.user') <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('users') }}">@lang('home.user') @lang('home.list')</a></li>
                    <li><a href="{{ route('user.create') }}">@lang('home.new') @lang('home.user')</a></li>
                    <li><a href="{{ route('roles') }}">@lang('home.user') @lang('home.role')</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-database" aria-hidden="true"></i> @lang('home.database') <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{route('database.index')}}"> @lang('home.backup')</a></li>
                </ul>
            </li>
        </ul>


    </div>
</div>