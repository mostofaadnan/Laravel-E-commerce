<?php

use Illuminate\Support\Facades\Route;
/* use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Session\Session; */

Route::group(['middleware' => ['cache']], function () {
    Route::get('/', 'Home\HomeController@index')->name('home');
    Route::get('/About', 'Home\PageController@about')->name('about');
    Route::get('/Privacy-Policy', 'Home\PageController@privacy')->name('privacy');
    Route::get('/Terms&Conditions', 'Home\PageController@term')->name('term');
    Route::get('/FAQ', 'Home\PageController@faq')->name('faq');
    Route::get('/Payment', 'Home\PageController@payment')->name('paymentpoliicy');
    
    Route::group(['prefix' => 'Products'], function () {
        Route::get('/', 'Home\ProductControllers@index')->name('allproducts');
        Route::get('/getProductById', 'Home\ProductControllers@getByid')->name('allproduct.getById');
        Route::get('/Product-Details/{product}', 'Home\ProductControllers@productDetails')->name('product.productDetails');
        Route::get('/product-review', 'Home\ProductControllers@productReview')->name('product.productreview');
        Route::get('/product-reply', 'Home\ProductControllers@ReviewReplay')->name('product.reviewreplies');
        Route::get('/Category-Product/{category}', 'Home\ProductControllers@CategoryProduct')->name('product.categoryproduct');
        Route::get('/subCategory-Product/{subcategory}', 'Home\ProductControllers@SubCategoryProduct')->name('product.subcategoryproduct');
        Route::get('/Brand-Product/{brand}', 'Home\ProductControllers@BrandProduct')->name('product.brandproduct');
        Route::get('/itemList', 'Home\ProductControllers@ItemDataList')->name('product.itemdatalistsearch');
        Route::get('/Search', 'Home\ProductControllers@Search')->name('product.prosearch');
        Route::post('/pro-reviewreply', 'Home\ProductControllers@ReviewReply')->name('product.reviewreplys');
        Route::get('/Currency', 'Home\ProductControllers@SetCurrency')->name('product.currencyChange');
    });
    Route::group(['prefix' => 'Review'], function () {
        Route::post('/store', 'Home\CustomerReviewContrller@Store')->name('review.store');
    });
    Route::group(['prefix' => 'StoreInformation'], function () {
        Route::get('/', 'Home\StoreController@index')->name('storeInformations');
        Route::get('/storeDetails/{store}', 'Home\StoreController@Details')->name('storeInformation.details');
    });
    Route::group(['prefix' => 'Contact'], function () {
        Route::get('/', 'Home\ContactController@index')->name('contacts');
        Route::post('/store', 'Home\ContactController@NewsLatterStore')->name('newslatter.store');
        Route::post('/contactus-Store', 'Home\ContactController@contactusStore')->name('contactus.store');
    });


    Route::group(['prefix' => 'Cart'], function () {
        Route::get('/', 'Home\CartController@index')->name('carts');
        Route::get('/AddToCart', 'Home\CartController@addToCart')->name('cart.addtocart');
        Route::get('/removCartByOne/{id}', 'Home\CartController@RemoveItemByOne')->name('cart.removebyOne');
        Route::get('/removCart/{id}', 'Home\CartController@RemoveItem')->name('cart.remove');
        Route::get('/Get-Cart-Item', 'Home\CartController@getCartItem')->name('cart.getcart');
    });
    Route::group(['prefix' => 'Wish-list'], function () {
        Route::get('/', 'Home\WishlistController@index')->name('wishlists');
        Route::get('/Add-To-Wish/{id}', 'Home\WishlistController@addToWish')->name('wishlist.addToWish');
        Route::get('/removCart/{id}', 'Home\WishlistController@RemoveItem')->name('wishlist.remove');
    });
    Route::get('State/getstate', 'StateController@getStateList');
    Route::get('City/getcity', 'CityController@getCityList');
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['prefix' => 'CheckOut'], function () {
            Route::get('/', 'Home\CheckOutController@ShipingAddress')->name('checkouts');
            Route::get('/overview', 'Home\CheckOutController@OverView')->name('checkout.overview');
            Route::get('/storeAddress', 'Home\CheckOutController@AddCustomerInfo')->name('checkout.storeAddress');
            Route::get('/payment', 'Home\CheckOutController@Payment')->name('checkout.Payment');
            Route::post('/store', 'Home\CheckOutController@Store')->name('checkout.store');
            Route::post('/storecash', 'Home\CheckOutController@StoreCash')->name('checkout.storecash');
            Route::get('/orderslip/{id}', 'Home\CheckOutController@orderSlip')->name('checkout.orderslip');
            Route::get('/pdf/{id}', 'Home\CheckOutController@orderpdf')->name('checkout.orderpdf');
            Route::post('/bkashtoken', 'Home\CheckOutController@BkashToken')->name('checkout.bkashtoken');
            Route::get('/shipment', 'Home\CheckOutController@Shipmentcharge')->name('checkout.Shipmentcharge');
            Route::get('/PlaceOder', 'Home\CheckOutController@PlaceOrder')->name('checkout.placeorder');
            Route::get('/Complete/{id}', 'Home\CheckOutController@OrderComplete')->name('checkout.complete');
            //ssl

        });
        /*   Route::post('/pay', 'Home\CheckOutController@Pay'); */
        Route::post('/pay-via-ajax', 'Home\CheckOutController@payViaAjax');
        Route::post('/success', 'Home\CheckOutController@success');
        Route::post('/fail', 'Home\CheckOutController@fail');
        Route::post('/cancel', 'Home\CheckOutController@cancel');
        Route::post('/ipn', 'Home\CheckOutController@ipn');


        Route::group(['prefix' => 'Notification'], function () {
            Route::get('/', 'Home\NotificationController@index')->name('notifications');
            Route::get('/markAsRead/{id}', 'Home\NotificationController@markAsRead')->name('notification.markasread');
            Route::get('/markAsAllRead', 'Home\NotificationController@markAllAsRead')->name('notification.markasallread');
        });
        Route::group(['prefix' => 'Account'], function () {
            Route::get('/', 'Home\UserAccount@index')->name('accounts');
            Route::post('/addressUpdate', 'Home\UserAccount@AddressUpdate')->name('account.addressUpdate');
            Route::post('/userUpdate', 'Home\UserAccount@Userupdate')->name('account.userupdate');
        });
    });
});
Route::get('/runmigrate', 'RunMigrateController@RunMigrate')->name('runmigrate');

Route::group(['prefix' => 'Admin'], function () {

    Route::get('login', 'Admin\AdminLoginController@showLoginFrom')->name('admin.login');
    Route::post('login', 'Admin\AdminLoginController@login')->name('admin.login.submit');
    Route::post('logout', 'Admin\AdminLoginController@logout')->name('admin.logout');
    Route::group(['middleware' => ['auth:admin']], function () {

        Route::get('/', 'PageController@index')->name('admin.dashboard');
        Route::get('/contactus', 'PageController@ContactUs')->name('page.contactus');
        Route::get('/contactusload', 'PageController@loadContactUs')->name('page.contactloadall');
        Route::get('/contactusview/{id}', 'PageController@loadContactusview')->name('page.contactusView');
        Route::post('/contactusdelete/{id}', 'PageController@Contactusdelete')->name('page.contactusdelete');
        Route::get('/accountsummery', 'PageController@AccountSummery')->name('accountsummery');

        //Chart Contrller
        Route::group(['prefix' => 'Chart'], function () {
            Route::get('invoiceView', 'ChartMakeController@Invoice')->name('chart.invoiceview');
            Route::get('InvoiceBarchart', 'ChartMakeController@InvoiceBarchart');
            Route::get('invoiceMonthlyView', 'ChartMakeController@InvoiceMonthly')->name('chart.invoicemonthlyview');
            Route::get('InvoiceBarchartMonthly', 'ChartMakeController@InvoiceBarchartMonthly');

            Route::get('OrderView', 'ChartMakeController@Order')->name('chart.orderview');
            Route::get('OrderBarchart', 'ChartMakeController@OrderBarchart');
            Route::get('OrderMonthlyView', 'ChartMakeController@OrderMonthly')->name('chart.ordermonthlyview');
            Route::get('OrderBarchartMonthly', 'ChartMakeController@OrderBarchartMonthly');

            Route::get('purchaseViewYearly', 'ChartMakeController@purchaseViewYearly')->name('chart.purchaseViewYearly');
            Route::get('PurchaseBarchart', 'ChartMakeController@PurchaseBarchart');
            Route::get('purchaseViewMonthly', 'ChartMakeController@purchaseViewMonthly')->name('chart.purchaseViewMonthly');
            Route::get('PurchaseBarchartMonthly', 'ChartMakeController@PurchaseBarchartMonthly');

            Route::get('supplieyPaymentYearlyView', 'ChartMakeController@supplieyPaymentYearlyView')->name('chart.supplieyPaymentYearlyView');
            Route::get('SupplierPaymentChart', 'ChartMakeController@SupplierPaymentChart');
            Route::get('supplieyPaymentMonthlyView', 'ChartMakeController@supplieyPaymentMonthlyView')->name('chart.supplieyPaymentMonthlyView');
            Route::get('SupplierPaymentChartMonthly', 'ChartMakeController@SupplierPaymentChartMonthly');
            Route::get('customerPaymentYearlyView', 'ChartMakeController@customerPaymentYearlyView')->name('chart.customerPaymentYearlyView');
            Route::get('CustomerPaymentchart', 'ChartMakeController@CustomerPaymentchart');
            Route::get('customerPaymentMonthlyView', 'ChartMakeController@customerPaymentMonthlyView')->name('chart.customerPaymentMonthlyView');
            Route::get('CustomerPaymentMonthlychart', 'ChartMakeController@CustomerPaymentMonthlychart');
            Route::get('ExpensesYearlyChartView', 'ChartMakeController@ExpensesYearlyChartView')->name('chart.ExpensesYearlyChartView');
            Route::get('ExpensesChart', 'ChartMakeController@ExpensesChart');
            Route::get('ExpensesMonthlyChartView', 'ChartMakeController@ExpensesMonthlyChartView')->name('chart.ExpensesMonthlyChartView');
            Route::get('ExpensesMonthlyChart', 'ChartMakeController@ExpensesMonthlyChart');
        });
        //Comapny Router
        Route::group(['prefix' => 'Company'], function () {
            Route::get('/', 'CompanyController@index')->name('company');
            Route::get('/information', 'CompanyController@Information')->name('company.information');
            Route::post('/update', 'CompanyController@Update')->name('company.update');
            Route::get('/timezone', 'TimeZoneLocalController@index')->name('company.timezone');
            Route::post('/timezoneupdate', 'CompanyController@TimezoneUpdate')->name('company.timezoneupdate');
        });
        Route::group(['prefix' => 'Slider'], function () {
            Route::get('/', 'Admin\SliderController@index')->name('sliders');
            Route::get('/loadall', 'Admin\SliderController@LoadAll')->name('slider.loadall');
            Route::get('/show', 'Admin\SliderController@show')->name('slider.show');
            Route::post('/store', 'Admin\SliderController@store')->name('slider.store');
            Route::post('/delete/{id}', 'Admin\SliderController@destroy')->name('slider.delete');
            Route::post('/update', 'Admin\SliderController@update')->name('slider.update');
        });
        Route::group(['prefix' => 'Banner'], function () {
            Route::get('/', 'Admin\BannerController@index')->name('banners');
            Route::get('/loadall', 'Admin\BannerController@LoadAll')->name('banner.loadall');
            Route::get('/show', 'Admin\BannerController@show')->name('banner.show');
            Route::post('/store', 'Admin\BannerController@store')->name('banner.store');
            Route::post('/delete/{id}', 'Admin\BannerController@destroy')->name('banner.delete');
            Route::post('/update', 'Admin\BannerController@update')->name('banner.update');
        });
        //Category Router
        Route::group(['prefix' => 'Category'], function () {
            Route::get('/', 'CategoryController@index')->name('categories');
            Route::get('/loadall', 'CategoryController@LoadAll')->name('category.loadall');
            Route::post('/store', 'CategoryController@store')->name('category.store');
            Route::post('/delete/{id}', 'CategoryController@destroy')->name('category.delete');
            Route::get('/show', 'CategoryController@show')->name('category.show');
            Route::post('/update', 'CategoryController@update')->name('category.update');
        });

        //home
        Route::group(['prefix' => 'Home-Category'], function () {
            Route::get('/', 'Admin\HomeCategoryController@index')->name('homecategories');
            Route::get('/loadall', 'Admin\HomeCategoryController@LoadAll')->name('homecategory.loadall');
            Route::get('/show', 'Admin\HomeCategoryController@show')->name('homecategory.show');
            Route::post('/store', 'Admin\HomeCategoryController@store')->name('homecategory.store');
            Route::post('/delete/{id}', 'Admin\HomeCategoryController@destroy')->name('homecategory.delete');
            Route::post('/update', 'Admin\HomeCategoryController@update')->name('homecategory.update');
        });

        //prvacy
        Route::group(['prefix' => 'Privacy'], function () {
            Route::get('/', 'Admin\PrivacyPolycyController@index')->name('privacies');
            Route::get('/loadall', 'Admin\PrivacyPolycyController@LoadAll')->name('privacy.loadall');
            Route::post('/store', 'Admin\PrivacyPolycyController@store')->name('privacy.store');
            Route::post('/delete/{id}', 'Admin\PrivacyPolycyController@destroy')->name('privacy.delete');
            Route::get('/show', 'Admin\PrivacyPolycyController@show')->name('privacy.show');
            Route::post('/update', 'Admin\PrivacyPolycyController@update')->name('privacy.update');
        });
        //prvacy
        Route::group(['prefix' => 'TermCondition'], function () {
            Route::get('/', 'Admin\TermAndConditionController@index')->name('terms');
            Route::get('/loadall', 'Admin\TermAndConditionController@LoadAll')->name('term.loadall');
            Route::post('/store', 'Admin\TermAndConditionController@store')->name('term.store');
            Route::post('/delete/{id}', 'Admin\TermAndConditionController@destroy')->name('term.delete');
            Route::get('/show', 'Admin\TermAndConditionController@show')->name('term.show');
            Route::post('/update', 'Admin\TermAndConditionController@update')->name('term.update');
        });
        //FAQ
        Route::group(['prefix' => 'FAQ'], function () {
            Route::get('/', 'Admin\FaqController@index')->name('faqs');
            Route::get('/loadall', 'Admin\FaqController@LoadAll')->name('faq.loadall');
            Route::post('/store', 'Admin\FaqController@store')->name('faq.store');
            Route::post('/delete/{id}', 'Admin\FaqController@destroy')->name('faq.delete');
            Route::get('/show', 'Admin\FaqController@show')->name('faq.show');
            Route::post('/update', 'Admin\FaqController@update')->name('faq.update');
        });

        //product slide Type
        Route::group(['prefix' => 'Product-Slide'], function () {
            Route::get('/', 'Admin\productSlideTypeController@index')->name('slidesTypes');
            Route::get('/loadall', 'Admin\productSlideTypeController@LoadAll')->name('slidetype.loadall');
            Route::post('/store', 'Admin\productSlideTypeController@store')->name('slidetype.store');
            Route::post('/delete/{id}', 'Admin\productSlideTypeController@destroy')->name('slidetype.delete');
            Route::get('/show', 'Admin\productSlideTypeController@show')->name('slidetype.show');
            Route::post('/update', 'Admin\productSlideTypeController@update')->name('slidetype.update');
        });

        //product slide 
        Route::group(['prefix' => 'Product-Sliders'], function () {
            Route::get('/', 'Admin\ProductSliderController@index')->name('productslides');
            Route::get('/loadall', 'Admin\ProductSliderController@LoadAll')->name('productslide.loadall');
            Route::post('/store', 'Admin\ProductSliderController@store')->name('productslide.store');
            Route::post('/delete/{id}', 'Admin\ProductSliderController@destroy')->name('productslide.delete');
            Route::get('/show', 'Admin\ProductSliderController@show')->name('productslide.show');
            Route::post('/update', 'Admin\ProductSliderController@update')->name('productslide.update');
        });
        //subcategory Router
        Route::group(['prefix' => 'Sub-Category'], function () {
            Route::get('/', 'SubcategoryController@index')->name('subcategories');
            Route::get('/loadall', 'SubcategoryController@LoadAll')->name('subcategory.loadall');
            Route::get('/show', 'SubcategoryController@show')->name('subcategory.show');
            Route::post('/store', 'SubcategoryController@store')->name('subcategory.store');
            Route::post('/delete/{id}', 'SubcategoryController@destroy')->name('subcategory.delete');
            Route::post('/update', 'SubcategoryController@update')->name('subcategorys.update');
        });
        //Unit Router
        Route::group(['prefix' => 'Unit'], function () {
            Route::get('/', 'UnitController@index')->name('units');
            Route::get('/loadall', 'UnitController@LoadAll')->name('unit.loadall');
            Route::post('/store', 'UnitController@store')->name('unit.store');
            Route::post('/delete/{id}', 'UnitController@destroy')->name('unit.delete');
            Route::get('/show', 'UnitController@show')->name('unit.show');
            Route::post('/update', 'UnitController@update')->name('units.update');
        });

        //BrandBrandController Router
        Route::group(['prefix' => 'Brand'], function () {
            Route::get('/', 'BrandController@index')->name('brands');
            Route::get('/loadall', 'BrandController@LoadAll')->name('brand.loadall');
            Route::post('/store', 'BrandController@store')->name('brand.store');
            Route::post('/delete/{id}', 'BrandController@destroy')->name('brand.delete');
            Route::get('/show', 'BrandController@show')->name('brand.show');
            Route::post('/update', 'BrandController@update')->name('brands.update');
        });

        //Vat Setting Router
        Route::group(['prefix' => 'Vatsetting'], function () {
            Route::get('/', 'VatSettingController@index')->name('vatsettings');
            Route::get('/loadall', 'VatSettingController@LoadAll')->name('vatsetting.loadall');
            Route::get('/getlist', 'VatSettingController@GetList')->name('vatsetting.getlist');
            Route::get('/getlistvat', 'VatSettingController@GetListVat')->name('vatsetting.getlistvat');
            Route::get('/search', 'VatSettingController@search')->name('vatsetting.search');
            Route::post('/store', 'VatSettingController@store')->name('vatsetting.store');
            Route::post('/delete/{id}', 'VatSettingController@destroy')->name('vatsetting.delete');
            Route::get('/Show', 'VatSettingController@Show')->name('vatsetting.show');
            Route::get('/getview/{id}', 'VatSettingController@GetView')->name('vatsetting.getview');
            Route::post('/update', 'VatSettingController@update')->name('vatsetting.update');
            Route::post('/updatevalue', 'VatSettingController@updateValue')->name('vatsetting.updatevalue');
        });

        Route::group(['prefix' => 'Number-format'], function () {
            Route::get('/', 'numberFormatController@index')->name('numberformat');
            Route::get('/view', 'numberFormatController@View')->name('numberformat.view');
            Route::post('/update', 'numberFormatController@Update')->name('numberformat.update');
        });
        //Country Router
        Route::group(['prefix' => 'Country'], function () {
            Route::get('/', 'CountryController@index')->name('countrys');
            Route::get('/loadall', 'CountryController@LoadAll')->name('country.loadall');
            Route::post('/store', 'CountryController@store')->name('country.store');
            Route::post('/delete/{id}', 'CountryController@destroy')->name('country.delete');
            Route::get('/show', 'CountryController@show')->name('country.show');
            Route::post('/update', 'CountryController@update')->name('country.update');
        });

        //State Router
        Route::group(['prefix' => 'State'], function () {
            Route::get('/', 'StateController@index')->name('states');
            Route::get('/loadall', 'StateController@LoadAll')->name('state.loadall');
            Route::post('/store', 'StateController@store')->name('state.store');
            Route::post('/delete/{id}', 'StateController@destroy')->name('state.delete');
            Route::get('/show', 'StateController@show')->name('state.show');
            Route::post('/update', 'StateController@update')->name('state.update');
            Route::get('/get-state-list', 'StateController@getStateList');
        });

        //State Router
        Route::group(['prefix' => 'City'], function () {
            Route::get('/', 'CityController@index')->name('citys');
            Route::get('/loadall', 'CityController@LoadAll')->name('city.loadall');
            Route::post('/store', 'CityController@store')->name('city.store');
            Route::post('/delete/{id}', 'CityController@destroy')->name('city.delete');
            Route::get('/show', 'CityController@show')->name('city.show');
            Route::post('/update', 'CityController@update')->name('city.update');
            Route::get('/get-city-list', 'CityController@getCityList');
        });
        //Shipment charge Setup
        Route::group(['prefix' => 'Shipment'], function () {
            Route::get('/', 'ShipingChargeController@index')->name('shipments');
            Route::get('/loadall', 'ShipingChargeController@LoadAll')->name('shipment.loadall');
            Route::get('/show', 'ShipingChargeController@show')->name('shipment.show');
            Route::post('/store', 'ShipingChargeController@store')->name('shipment.store');
            Route::post('/delete/{id}', 'ShipingChargeController@destroy')->name('shipment.delete');
            Route::post('/update', 'ShipingChargeController@update')->name('shipment.update');
        });


        //Product Router

        Route::group(['prefix' => 'Product'], function () {
            Route::get('/', 'ProductController@index')->name('products');
            Route::get('/ItemDataList', 'ProductController@ItemDataList')->name('product.itemdatalist');
            Route::get('/ItemDataListCategory', 'ProductController@ItemDataListCategory')->name('product.ItemDataListCategory');
            Route::get('/itesearch', 'ProductController@ItemSearch')->name('product.itemsearch');
            Route::get('/loadall', 'ProductController@LoadAll')->name('product.loadall');
            Route::get('/productgetlist', 'ProductController@productGetList')->name('product.productgetlist');
            Route::get('/barcodemake', 'ProductController@BarcodeMaker')->name('product.barcodemaker');
            Route::get('/Create', 'ProductController@create')->name('product.create');
            Route::get('/getDataById', 'ProductController@getDataById')->name('product.getDataById');
            Route::get('/search', 'ProductController@search')->name('product.search');
            Route::put('/ProductStore', 'ProductController@Store')->name('product.storeData');
            Route::get('/edit/{id}', 'ProductController@edit')->name('product.edit');
            Route::post('/delete/{id}', 'ProductController@destroy')->name('product.delete');
            Route::get('/show/{id}', 'ProductController@show')->name('product.show');
            Route::get('/edir/{id}', 'ProductController@Edit')->name('product.edit');
            Route::post('/update', 'ProductController@update')->name('product.update');
            Route::post('/DataUpdates', 'ProductController@DataUpdate')->name('product.dataUpdate');
            Route::get('/get-subcategory-list', 'ProductController@getSubcaegoryList');
            Route::get('/get-Brand-list', 'ProductController@getBrandList');
            Route::post('/Active/{id}', 'ProductController@Active')->name('product.active');
            Route::post('/Inactive/{id}', 'ProductController@Inactive')->name('product.inactive');
            Route::get('/currentstock', 'ProductController@CurrentStock')->name('product.currentstock');
            Route::get('/openstock/{id}', 'ProductController@OpeningStock')->name('product.openstock');
            Route::post('/openingstore', 'ProductController@OpeningStore')->name('product.openingstore');
            Route::get('/getopening/{id}', 'ProductController@GetOpening')->name('product.getopening');
            Route::get('/discount', 'ProductController@Discount')->name('product.discount');
            Route::post('/updateDiscount', 'ProductController@updateDiscount')->name('product.updateDiscount');
            Route::get('/Archive', 'ProductController@Archive')->name('product.Archive');
            Route::get('/loadallarchive', 'ProductController@loadallarchive')->name('product.loadallarchive');
            Route::post('/makeArchive/{id}', 'ProductController@makeArchive')->name('product.makeArchive');
            Route::post('/makeRetrive/{id}', 'ProductController@makeRetrive')->name('product.makeRetrive');
            Route::post('imageupload', 'ProductController@UploadImage')->name('product.uploadImage');
            Route::post('/profileupload', 'ProductController@ProfileUpload')->name('product.profileUpload');
            Route::post('/UploadDelete', 'ProductController@uploadDelete')->name('product.uploadDelete');
            Route::get('/allProduct', 'ProductController@allProducts')->name('product.allproduct');
            Route::get('/productDetails/{id}', 'ProductController@ProductDetails')->name('product.productdetails');
            Route::post('/reviewreply', 'ProductController@ReviewReply')->name('product.reviewreply');
            Route::post('/deleterReview/{id}', 'ProductController@DeleterReview')->name('product.deleterReview');
            Route::post('/deleterReply/{id}', 'ProductController@DeleterReply')->name('product.deleterReply');
        });
        //Stock Manage

        Route::group(['prefix' => 'StockManage'], function () {
            Route::get('/', 'QuantityControll@index')->name('stocks');
            Route::get('/loadall', 'QuantityControll@LoadAll')->name('stock.loadall');
        });

        //Customer Router
        Route::group(['prefix' => 'Customer'], function () {
            Route::get('/', 'CustomerController@index')->name('customers');
            Route::get('/loadall', 'CustomerController@LoadAll')->name('customer.loadall');
            Route::get('/getlist', 'CustomerController@GetList')->name('customer.getlist');
            Route::get('/Create', 'CustomerController@create')->name('customer.create');
            Route::get('/customercode', 'CustomerController@CustomerCode')->name('customer.customercode');
            Route::get('/openingbalance/{id}', 'CustomerController@OpeningBalance')->name('customer.openingbalance');
            Route::get('/getopening', 'CustomerController@GetOpening')->name('customer.getopening');
            Route::post('/storeopening', 'CustomerController@StoreOpening')->name('customer.storeopening');
            Route::get('/balanceloadall', 'CustomerController@BalanceLoadAll')->name('customer.balanceloadall');
            Route::post('/store', 'CustomerController@store')->name('customer.store');
            Route::post('/update', 'CustomerController@Update')->name('customer.update');
            Route::get('/edit/{id}', 'CustomerController@Edit')->name('customer.edit');
            Route::get('/CustomerDatalist', 'CustomerController@CustomerDatalist')->name('customer.customerdatalist');
            Route::get('/document/{id}', 'CustomerController@Document')->name('customer.document');
            Route::post('/documentupload', 'CustomerController@DocumentUpload')->name('customer.documentupload');
            Route::get('/customercearchdatalist', 'CustomerController@CustomerSearchDatalist')->name('customer.customercearchdatalist');
            Route::get('/show/{id}', 'CustomerController@show')->name('customer.show');
            Route::get('/profile', 'CustomerController@Profile')->name('customer.profile');
            Route::get('/getAmounthistory/{id}', 'CustomerController@GetAmounthistory')->name('customer.getsmounthistory');
            Route::post('/Active/{id}', 'CustomerController@Active')->name('customer.active');
            Route::post('/Inactive/{id}', 'CustomerController@Inactive')->name('customer.inactive');
            Route::get('/search', 'CustomerController@Search')->name('customer.search');
            Route::get('/customerinfo', 'CustomerController@CustomerInfo')->name('customer.info');
            Route::get('/statement', 'CustomerController@Statement')->name('customer.statement');
            Route::get('/sendmail', 'CustomerController@SendMail')->name('customer.sendmail');
            Route::post('/ImageChange', 'CustomerController@ImageChange')->name('customer.ImageChange');
            Route::post('/delete/{id}', 'CustomerController@destroy')->name('customer.delete');
            Route::get('/Archived', 'CustomerController@Archived')->name('customer.Archived');
            Route::get('/LoadAllArchived', 'CustomerController@LoadAllArchived')->name('customer.LoadAllArchived');
            Route::post('/permanentdelete/{id}', 'CustomerController@PermanentDelete')->name('customer.permanentdelete');
            Route::post('/retrive/{id}', 'CustomerController@Retrive')->name('customer.retrive');
        });
        Route::group(['prefix' => 'Sale-Config'], function () {
            Route::get('/', 'SaleConfigaration@index')->name('saleconfig');
            Route::get('/view', 'SaleConfigaration@View')->name('saleconfig.view');
            Route::post('/update', 'SaleConfigaration@Update')->name('saleconfig.update');
        });
        //Cash Invoice Router
        Route::group(['prefix' => 'Invoice'], function () {
            Route::get('/', 'InvoiceController@index')->name('invoices');
            Route::get('/Create', 'InvoiceController@create')->name('invoice.create');
            Route::get('/invoicecode', 'InvoiceController@InvoiceCode')->name('invoice.invoicecode');
            Route::post('/store', 'InvoiceController@store')->name('invoice.store');
            Route::get('/getlist', 'InvoiceController@GetList')->name('invoice.getlist');
            Route::get('/loadall', 'InvoiceController@LoadAll')->name('invoice.loadall');
            Route::get('/getlistcustomercash', 'InvoiceController@GetListCustomerCash')->name('invoice.getlistcustomercash');
            Route::get('/show/{id}', 'InvoiceController@Show')->name('invoice.show');
            Route::get('/profile', 'InvoiceController@Profile')->name('invoice.profile');
            Route::get('/getView', 'InvoiceController@GetView')->name('invoice.getView');
            Route::get('/invoicecodedatalist', 'InvoiceController@InvoiceodeDataList')->name('invoice.invoicecodedatalist');
            Route::get('/invoicepdf/{id}', 'InvoiceController@invoicepdf')->name('invoice.invoicepdf');
            Route::get('/invoiceeitem', 'InvoiceController@InvoiceItem')->name('invoce.invoiceitem');
            Route::get('/LoadPrintslip/{id}', 'InvoiceController@LoadPrintslip')->name('invoce.LoadPrintslip');
            Route::post('/paypalcartstore', 'InvoiceController@PayPalCartStore')->name('invoice.paypalcartstore');
            Route::get('/paypalpayment', 'InvoiceController@PaypalPayment')->name('invoice.paypalpayment');
            Route::get('/paypalprocess/{id}', 'InvoiceController@PaypalProcess')->name('invoice.paypalprocess');
            Route::get('/paypalpaymentsuccess', 'InvoiceController@PaypalPaymentSuccess')->name('invoice.paypalpaymentsuccess');
            Route::post('/cancel/{id}', 'InvoiceController@Cancel')->name('invoice.cancel');
            Route::get('/cancelload', 'InvoiceController@CancelLoad')->name('invoice.cancelload');
            Route::get('/cancel', 'InvoiceController@Cancels')->name('invoice.cancels');
            Route::get('/cancelview/{id}', 'InvoiceController@CancelView')->name('invoice.cancelview');
            Route::post('/canceldestroy/{id}', 'InvoiceController@CancelDestroy')->name('invoice.canceldestroy');
            Route::post('/retrive/{id}', 'InvoiceController@Retrive')->name('invoice.retrive');
            //Send Mail
            Route::get('/sendmail/{id}', 'InvoiceController@SendMail')->name('invoice.sendmail');
        });

        //Order
        Route::group(['prefix' => 'Order'], function () {
            Route::get('/', 'OrderController@index')->name('orders');
            Route::get('/Create', 'OrderController@create')->name('order.create');
            Route::get('/invoicecode', 'OrderController@InvoiceCode')->name('order.invoicecode');
            Route::post('/store', 'OrderController@store')->name('order.store');
            Route::get('/getlist', 'OrderController@GetList')->name('order.getlist');
            Route::get('/loadall', 'OrderController@LoadAll')->name('order.loadall');
            Route::get('/recent', 'OrderController@Recent')->name('order.recent');
            Route::get('/getlistcustomercash', 'OrderController@GetListCustomerCash')->name('order.getlistcustomercash');
            Route::get('/show/{id}', 'OrderController@Show')->name('order.show');
            Route::get('/profile', 'OrderController@Profile')->name('order.profile');
            Route::get('/getView', 'OrderController@GetView')->name('order.getView');
            Route::get('/invoicecodedatalist', 'OrderController@InvoiceodeDataList')->name('order.invoicecodedatalist');
            Route::get('/orderPdf/{id}', 'OrderController@orderpdf')->name('order.orderpdf');
            Route::get('/invoiceeitem', 'OrderController@InvoiceItem')->name('order.invoiceitem');
            Route::get('/LoadPrintslip/{id}', 'OrderController@LoadPrintslip')->name('order.LoadPrintslip');
            Route::post('/paypalcartstore', 'OrderController@PayPalCartStore')->name('order.paypalcartstore');
            Route::get('/paypalpayment', 'OrderController@PaypalPayment')->name('order.paypalpayment');
            Route::get('/paypalprocess/{id}', 'OrderController@PaypalProcess')->name('order.paypalprocess');
            Route::get('/paypalpaymentsuccess', 'OrderController@PaypalPaymentSuccess')->name('order.paypalpaymentsuccess');
            Route::post('/cancel/{id}', 'OrderController@Cancel')->name('order.cancel');
            Route::get('/cancelload', 'OrderController@CancelLoad')->name('order.cancelload');
            Route::get('/cancel', 'OrderController@Cancels')->name('order.cancels');
            Route::get('/cancelview/{id}', 'OrderController@CancelView')->name('order.cancelview');
            Route::post('/canceldestroy/{id}', 'OrderController@CancelDestroy')->name('order.canceldestroy');
            Route::post('/retrive/{id}', 'OrderController@Retrive')->name('order.retrive');
            //Send Mail
            Route::get('/sendmail/{id}', 'OrderController@SendMail')->name('order.sendmail');
            Route::get('/orderrecived/{id}', 'OrderController@OrderRecived')->name('order.orderrecived');
            Route::post('/recived/{id}', 'OrderController@Recived')->name('order.recived');
            Route::get('/OrderDelivery/{id}', 'OrderController@OrderDelivery')->name('order.orderdelivery');
            Route::post('/delivery/{id}', 'OrderController@Delivery')->name('order.delivery');
            Route::get('/deliverypdf/{id}', 'OrderController@deliverPdf')->name('order.deliverypdf');
            Route::get('/loadnotification', 'OrderController@LoadNotification')->name('order.loadnotification');
            Route::get('/deliveryloadnotification', 'OrderController@DeliveryLoadNotification')->name('order.deliverloadnotification');
            Route::get('/paymentinfo', 'OrderController@paymentInfo')->name('order.paymentinfo');
            Route::get('/paymentinfoload', 'OrderController@paymentInfoLoad')->name('order.paymentinfoload');
        });


        //customer Payment Recieve Router
        Route::group(['prefix' => 'CustomerPayment'], function () {
            Route::get('/', 'CustomerPaymentRecieveController@index')->name('customerpayments');
            Route::get('/Create', 'CustomerPaymentRecieveController@create')->name('customerpayment.create');
            Route::get('/paymentno', 'CustomerPaymentRecieveController@PaymentNo')->name('customerpayment.paymentno');
            Route::post('/BalanceCheck', 'CustomerPaymentRecieveController@BalanceCheck')->name('customerpayment.balancecheck');
            Route::post('/store', 'CustomerPaymentRecieveController@Store')->name('customerpayment.store');
            Route::post('/paypalstore', 'CustomerPaymentRecieveController@PaypalStore')->name('customerpayment.paypalstore');
            Route::get('/paypalprocess/{id}', 'CustomerPaymentRecieveController@PaypalProcess')->name('customerpayment.paypalprocess');
            Route::get('/paypalpaymentsuccess', 'CustomerPaymentRecieveController@PaypalPaymentSuccess')->name('customerpayment.paypalpaymentsuccess');
            Route::get('/getlist', 'CustomerPaymentRecieveController@GetList')->name('customerpayment.getlist');
            Route::get('/loadall', 'CustomerPaymentRecieveController@LoadAll')->name('customerpayment.loadall');
            Route::get('/getlistcustomer', 'CustomerPaymentRecieveController@GetListCustomer')->name('customerpayment.getlistcustomer');
            Route::get('/show/{id}', 'CustomerPaymentRecieveController@Show')->name('customerpayment.show');
            Route::get('/pdf/{id}', 'CustomerPaymentRecieveController@Pdf')->name('customerpayment.pdf');
            Route::get('/paymentcodedatalist', 'CustomerPaymentRecieveController@PaymentCodeDatalist')->name('customerpayment.paymentcodedatalist');
            Route::get('/getView', 'CustomerPaymentRecieveController@GetView')->name('customerpayment.getView');
            Route::post('/delete/{id}', 'CustomerPaymentRecieveController@destroy')->name('customerpayment.delete');
            Route::get('/sendmail/{id}', 'CustomerPaymentRecieveController@SendMail')->name('customerpayment.sendmail');
        });

        //Cash Drwaer Router
        Route::group(['prefix' => 'CashDrawer'], function () {
            Route::get('/', 'CashDrawerController@index')->name('cashdrawers');
            Route::get('/loadall', 'CashDrawerController@LoadAll')->name('cashdrawer.loadall');
            Route::get('/getlist', 'CashDrawerController@GetList')->name('cashdrawer.getlist');
            Route::get('/prasentBalance', 'CashDrawerController@PrasentBalance')->name('cashdrawer.prasentbalance');
            Route::get('/balancecheck', 'CashDrawerController@BalanceCheck')->name('cashdrawer.balancechek');
        });
        //Bankname Router
        Route::group(['prefix' => 'BankName'], function () {
            Route::get('/', 'BankNameController@index')->name('banknames');
            Route::get('/loadall', 'BankNameController@LoadAll')->name('bankname.loadall');
            Route::post('/store', 'BankNameController@store')->name('bankname.store');
            Route::get('/show', 'BankNameController@show')->name('bankname.show');
            Route::get('/banknamedatalist', 'BankNameController@BankDataList')->name('bankname.banknamedatalist');
            Route::post('/update', 'BankNameController@update')->name('bankname.update');
            Route::post('/delete/{id}', 'BankNameController@destroy')->name('bankname.delete');
        });
        //Bank transection Router
        Route::group(['prefix' => 'Banks'], function () {
            Route::get('/', 'BankController@index')->name('banks');
            Route::get('/loadall', 'BankController@LoadAll')->name('banks.loadall');
            Route::get('/prasentBalance', 'BankController@PrasentBalance')->name('banks.prasentbalance');
        });
        //Card Payment
        Route::group(['prefix' => 'card'], function () {
            Route::get('/', 'CardPaymentController@index')->name('cards');
            Route::get('/loadall', 'CardPaymentController@LoadAll')->name('cards.loadall');
            Route::get('/prasentBalance', 'CardPaymentController@PrasentBalance')->name('cards.prasentbalance');
            Route::get('/StripeBalancseHistry', 'CardPaymentController@StripeBalancseHistry')->name('cards.StripeBalancseHistry');
            Route::get('/StripeLoad', 'CardPaymentController@StripeLoad')->name('cards.StripeLoad');
        });
        Route::group(['prefix' => 'Paypal'], function () {
            Route::get('/', 'PayPalController@index')->name('paypals');
            Route::get('/loadall', 'PayPalController@LoadAll')->name('paypals.loadall');
        });
        //cash In Cash Out Router
        Route::group(['prefix' => 'CashInCashOut'], function () {
            Route::get('/', 'CashInCashOuController@index')->name('cashincashouts');
            Route::get('/create', 'CashInCashOuController@Create')->name('cashincashout.create');
            Route::get('/loadall', 'CashInCashOuController@LoadAll')->name('cashincashout.loadall');
            Route::get('/paymentno', 'CashInCashOuController@PaymentNo')->name('cashincashout.paymentno');
            Route::get('/show/{id}', 'CashInCashOuController@Show')->name('cashincashout.show');
            Route::get('/cicocodedatalist', 'CashInCashOuController@CiCoCodeDataList')->name('cashincashout.cicocodedatalist');
            Route::post('/store', 'CashInCashOuController@Store')->name('cashincashout.store');
            Route::get('/getlist', 'CashInCashOuController@GetList')->name('cashincashout.getlist');
            Route::get('/getView/{id}', 'CashInCashOuController@GetView')->name('cashincashout.getView');
            Route::get('/pdf/{id}', 'CashInCashOuController@Pdf')->name('cashincashout.pdf');
            Route::post('/delete/{id}', 'CashInCashOuController@Delete')->name('cashincashout.delete');
        });

        //Expenses Type Route
        Route::group(['prefix' => 'ExpensesType'], function () {
            Route::get('/', 'ExpensesTypeController@index')->name('expensestypes');
            Route::get('/loadall', 'ExpensesTypeController@LoadAll')->name('expensestype.loadall');
            Route::post('/store', 'ExpensesTypeController@store')->name('expensestype.store');
            Route::get('/show', 'ExpensesTypeController@show')->name('expensestype.show');
            Route::get('/expensestypedatalist', 'ExpensesTypeController@ExpensesTypeDataList')->name('expensestype.expensestypedatalist');
            Route::post('/update', 'ExpensesTypeController@update')->name('expensestype.update');
            Route::post('/delete/{id}', 'ExpensesTypeController@destroy')->name('expensestype.delete');
        });
        //Expenses Route
        Route::group(['prefix' => 'Expenses'], function () {
            Route::get('/', 'ExpensesController@index')->name('exepensess');
            Route::get('/create', 'ExpensesController@create')->name('expenses.create');
            Route::get('/expensesno', 'ExpensesController@Expensesno')->name('expenses.expensesno');
            Route::post('/store', 'ExpensesController@Store')->name('expenses.store');
            Route::get('/getlist', 'ExpensesController@GetList')->name('expenses.getlist');
            Route::get('/loadall', 'ExpensesController@LoadAll')->name('expenses.loadall');
            Route::get('/show/{id}', 'ExpensesController@Show')->name('expenses.show');
            Route::get('/getView', 'ExpensesController@GetView')->name('expenses.getView');
            Route::get('/expensescodedatalist', 'ExpensesController@ExpensesCodeDataList')->name('expenses.expensescodedatalist');
            Route::post('/cancel/{id}', 'ExpensesController@Cancel')->name('expenses.cancel');
            Route::post('/destroy/{id}', 'ExpensesController@Destroy')->name('expenses.destroy');
            Route::post('/retrive/{id}', 'ExpensesController@Retrive')->name('expenses.retrive');
            Route::get('/pdf/{id}', 'ExpensesController@Pdf')->name('expenses.pdf');
            Route::get('/LoadPrintslip/{id}', 'ExpensesController@LoadPrintslip')->name('expenses.LoadPrintslip');
            Route::get('/print/{id}', 'ExpensesController@Print')->name('expenses.print');
            Route::get('/Sectorexpenditureview', 'ExpensesController@SectorexpenditureView')->name('expenses.sectorexpenditureview');
            Route::get('/Sectorexpenditure', 'ExpensesController@Sectorexpenditure')->name('expenses.sectorexpenditure');
        });

        Route::group(['prefix' => 'User'], function () {
            Route::get('/', 'UserController@index')->name('users');
            Route::get('/create', 'UserController@create')->name('user.create');
            Route::post('/store', 'UserController@store')->name('user.store');
            Route::get('/edit/{id}', 'UserController@edit')->name('user.edit');
            Route::post('/update/{id}', 'UserController@update')->name('user.update');
            Route::get('/loadall', 'UserController@LoadAll')->name('user.loadall');
            Route::post('/delete/{id}', 'UserController@destroy')->name('user.delete');
        });
        Route::group(['prefix' => 'Reset-Password'], function () {
            Route::get('/', 'ResetPasswordController@index')->name('reset.password');
            Route::post('reset-password', 'ResetPasswordController@updatePassword')->name('reset.update');
        });
        Route::group(['prefix' => 'UserProfile'], function () {
            Route::get('/profile', 'UserProfileController@Profile')->name('user.profile');
            Route::get('/UserOperationByUser/{id}', 'UserProfileController@UserOperationByUser')->name('user.UserOperationByUser');
            Route::get('/UserOperationByUserCurrentdate/{id}', 'UserProfileController@UserOperationByUserCurrentdate')->name('user.UserOperationByUserCurrentdate');
            Route::post('/ImageChange', 'UserProfileController@ImageChange')->name('user.ImageChange');
        });

        Route::group(['prefix' => 'UserRole'], function () {
            Route::get('/', 'RoleController@index')->name('roles');
            Route::get('/create', 'RoleController@create')->name('role.create');
            Route::post('/store', 'RoleController@store')->name('role.store');
            Route::get('/loadall', 'RoleController@LoadAll')->name('role.loadall');
            Route::get('/show/{id}', 'RoleController@show')->name('role.show');
            Route::get('/edit/{id}', 'RoleController@edit')->name('role.edit');
            Route::post('/update/{id}', 'RoleController@update')->name('role.update');
            Route::post('/delete/{id}', 'RoleController@destroy')->name('role.delete');
            Route::get('/getPermission', 'RoleController@getPermission')->name('role.getPermission');
        });
        Route::group(['prefix' => 'Day-Close'], function () {
            Route::get('/', 'DayCloseController@index')->name('daycloses');
            Route::get('/loadall', 'DayCloseController@LoadAll')->name('dayclose.loadall');
            Route::get('/create', 'DayCloseController@Create')->name('dayclose.create');
            Route::get('/getData', 'DayCloseController@GetData')->name('dayclose.getData');
            Route::post('/store', 'DayCloseController@Store')->name('dayclose.store');
            Route::get('/show/{id}', 'DayCloseController@Show')->name('dayclose.show');
            Route::get('/getView/{id}', 'DayCloseController@GetView')->name('dayclose.getView');
            Route::get('/dayclosepdf/{id}', 'DayCloseController@DayClosePdf')->name('dayclose.dayclosepdf');
            Route::get('/daycloseerror', 'DayCloseController@DayClosePermission')->name('dayclose.daycloseerror');
            Route::post('/delete/{id}', 'DayCloseController@destroy')->name('dayclose.delete');
            Route::get('/getviewbydate', 'DayCloseController@GetViewByDate')->name('dayclose.getviewbydate');
            //monthly
            Route::get('/monthly', 'DayCloseController@Monthly')->name('dayclose.monthly');
            Route::get('/monthlycreate', 'DayCloseController@MonthlyCreate')->name('dayclose.monthlycreate');
            Route::get('/getDatamonthly', 'DayCloseController@GetDataMonthly')->name('dayclose.getDataMonthly');
            Route::get('/loadallmonthly', 'DayCloseController@LoadAllMonthly')->name('dayclose.loadallmonthly');
            //yearly
            Route::get('/yearly', 'DayCloseController@Yearly')->name('dayclose.yearly');
            Route::get('/yearlycreate', 'DayCloseController@YearlyCreate')->name('dayclose.yearlycreate');
            Route::get('/getDatayearly', 'DayCloseController@GetDataYearly')->name('dayclose.getDataYearly');
            Route::get('/loadallyearly', 'DayCloseController@LoadAllyearly')->name('dayclose.loadallyearly');
        });

        Route::group(['prefix' => 'Vat-Collections'], function () {
            Route::get('/', 'VatCollectionContrller@index')->name('vatcollections');
            Route::get('/loadall', 'VatCollectionContrller@LoadAll')->name('vatcollection.loadall');
            Route::get('/create', 'VatCollectionContrller@Create')->name('vatcollection.create');
            Route::get('/collectionno', 'VatCollectionContrller@CollectionNo')->name('vatcollection.collectionno');
            Route::get('/getdata', 'VatCollectionContrller@GetData')->name('vatcollection.getdata');
            Route::post('/store', 'VatCollectionContrller@Store')->name('vatcollection.store');
            Route::get('/vatcodedatalistall', 'VatCollectionContrller@vatcodeDatalistall')->name('vatcollection.vatcodedatalistall');
            Route::get('/show/{id}', 'VatCollectionContrller@Show')->name('vatcollection.show');
            Route::post('/setVatcollectionId/{id}', 'VatCollectionContrller@setVatcollectionId')->name('vatpayment.setVatcollectionId');
            Route::get('/getView', 'VatCollectionContrller@getView')->name('vatcollection.getView');
            Route::post('/delete/{id}', 'VatCollectionContrller@Delete')->name('vatcollection.delete');
            Route::get('/LoadPrintslip/{id}', 'VatCollectionContrller@LoadPrintslip')->name('vatcollection.LoadPrintslip');
            Route::get('/pdf/{id}', 'VatCollectionContrller@Pdf')->name('vatcollection.pdf');
            Route::get('/vatpayment', 'VatCollectionContrller@Vatpayment')->name('vatcollection.vatpayment');
            Route::get('/vploadall', 'VatCollectionContrller@VatpaymentLoad')->name('vatpayment.loadall');
            Route::get('/paymentcreate', 'VatCollectionContrller@paymentcreate')->name('vatpayment.paymentcreate');
            Route::get('/vatcodedatalist', 'VatCollectionContrller@vatcodeDatalist')->name('vatpayment.vatcodedatalist');
            Route::get('/vatPaymentNo', 'VatCollectionContrller@vatPaymentNo')->name('vatpayment.vatPaymentNo');
            Route::post('/storepayment', 'VatCollectionContrller@storepayment')->name('vatpayment.storepayment');
            Route::get('/paymentshow/{id}', 'VatCollectionContrller@paymentshow')->name('vatpayment.paymentshow');
            Route::post('/SetPaymentId/{id}', 'VatCollectionContrller@SetPaymentId')->name('vatpayment.SetPaymentId');
            Route::get('/vatPaymentCodatalist', 'VatCollectionContrller@vatPaymentCodatalist')->name('vatpayment.vatPaymentCodatalist');
            Route::get('/getPaymentView', 'VatCollectionContrller@getPaymentView')->name('vatpayment.getPaymentView');
            Route::get('/vatPaymentPdf/{id}', 'VatCollectionContrller@vatPaymentPdf')->name('vatpayment.vatPaymentPdf');
            Route::post('/VatPaymentDelete/{id}', 'VatCollectionContrller@VatPaymentDelete')->name('vatcollection.VatPaymentDelete');
            Route::get('/vatpLoadPrintslip/{id}', 'VatCollectionContrller@LoadPrintslipvatPyment')->name('vatpayment.LoadPrintslip');
        });

        Route::group(['prefix' => 'Income'], function () {
            Route::get('/', 'IncomeController@index')->name('income');
            Route::get('/loadall', 'IncomeController@LoadAll')->name('income.loadall');
        });

        Route::group(['prefix' => 'Report'], function () {
            Route::get('/purchase', 'ReportController@purchase')->name('report.purchase');
            Route::get('/PurchaseQuery', 'ReportController@PurchaseQuery')->name('report.PurchaseQuery');
            Route::post('/PurchaseQueryPdf', 'ReportController@PurchaseQueryPdf')->name('report.PurchaseQueryPdf');
            Route::get('/PurchasePdfView', 'ReportController@PurchasePdfView')->name('report.PurchasePdfView');
            //invoice report
            Route::get('/invoice', 'ReportController@invoice')->name('report.invoice');
            Route::get('/InvoiceQuery', 'ReportController@InvoiceQuery')->name('report.InvoiceQuery');
            Route::post('/InvoiceQueryPdf', 'ReportController@InvoiceQueryPdf')->name('report.InvoiceQueryPdf');
            Route::get('/InvoicePdfView', 'ReportController@InvoicePdfView')->name('report.InvoicePdfView');

            //order report
            Route::get('/order', 'ReportController@order')->name('report.orders');
            Route::get('/OrderQuery', 'ReportController@OrderQuery')->name('report.OrderQuery');
            Route::post('/OrderQueryPdf', 'ReportController@OrderQueryPdf')->name('report.OrderQueryPdf');
            Route::get('/OrderPdfView', 'ReportController@OrderPdfView')->name('report.OrderPdfView');

            //supplier payment
            Route::get('/spayment', 'ReportController@spayment')->name('report.spayment');
            Route::get('/spQuery', 'ReportController@spQuery')->name('report.spQuery');
            Route::post('/spQueryPdf', 'ReportController@spQueryPdf')->name('report.spQueryPdf');
            Route::get('/spPdfView', 'ReportController@spPdfView')->name('report.spPdfView');
            //customer Payment
            Route::get('/cpayment', 'ReportController@cpayment')->name('report.cpayment');
            Route::get('/cpQuery', 'ReportController@cpQuery')->name('report.cpQuery');
            Route::post('/cpQueryPdf', 'ReportController@cpQueryPdf')->name('report.cpQueryPdf');
            Route::get('/cpPdfView', 'ReportController@cpPdfView')->name('report.cpPdfView');
            //stock report
            Route::get('/stockReport', 'ReportController@stockReport')->name('report.stockReport');
            Route::get('/stockReportQuery', 'ReportController@stockReportQuery')->name('report.stockReportQuery');
            Route::post('/stockReportQueryPdf', 'ReportController@stockReportQueryPdf')->name('report.stockReportQueryPdf');
            Route::get('/stockReportPdfView', 'ReportController@stockReportPdfView')->name('report.stockReportPdfView');
            //cash drawer
            Route::get('/cashdrawer', 'ReportController@cashdrawer')->name('report.cashdrawer');
            Route::get('/cashdrawerQuery', 'ReportController@cashdrawerQuery')->name('report.cashdrawerQuery');
            Route::post('/cashdrawerQueryPdf', 'ReportController@cashdrawerQueryPdf')->name('report.cashdrawerQueryPdf');
            Route::get('/cashdrawerPdfView', 'ReportController@cashdrawerPdfView')->name('report.cashdrawerPdfView');
            //Bank Transection
            Route::get('/bank', 'ReportController@Bank')->name('report.bank');
            Route::get('/bankQuery', 'ReportController@bankQuery')->name('report.bankQuery');
            Route::post('/bankQueryPdf', 'ReportController@bankQueryPdf')->name('report.bankQueryPdf');
            Route::get('/bankPdfView', 'ReportController@bankPdfView')->name('report.bankPdfView');

            //card payment
            Route::get('/card', 'ReportController@Card')->name('report.card');
            Route::get('/cardQuery', 'ReportController@cardQuery')->name('report.cardQuery');
            Route::post('/cardQueryPdf', 'ReportController@cardQueryPdf')->name('report.cardQueryPdf');
            Route::get('/cardPdfView', 'ReportController@cardPdfView')->name('report.cardPdfView');
            //paypal payment
            Route::get('/paypal', 'ReportController@Paypal')->name('report.paypal');
            Route::get('/paypalQuery', 'ReportController@paypalQuery')->name('report.paypalQuery');
            Route::post('/paypalQueryPdf', 'ReportController@paypalQueryPdf')->name('report.paypalQueryPdf');
            Route::get('/paypalPdfView', 'ReportController@paypalPdfView')->name('report.paypalPdfView');
            //Expenses
            Route::get('/expenses', 'ReportController@expenses')->name('report.expenses');
            Route::get('/expensesQuery', 'ReportController@expensesQuery')->name('report.expensesQuery');
            Route::post('/expensesQueryPdf', 'ReportController@expensesQueryPdf')->name('report.expensesQueryPdf');
            Route::get('/expensesPdfView', 'ReportController@expensesPdfView')->name('report.expensesPdfView');
            //Expenditure sector
            Route::get('/sectorexpenditure', 'ReportController@sectorexpenditure')->name('report.sectorexpenditure');
            Route::get('/sectorexpenditureQuery', 'ReportController@sectorexpenditureQuery')->name('report.sectorexpenditureQuery');
            //sale return
            Route::get('/salereturn', 'ReportController@salereturn')->name('report.salereturn');
            Route::get('/salereturnQuery', 'ReportController@salereturnQuery')->name('report.salereturnQuery');
            Route::post('/salereturnQueryPdf', 'ReportController@salereturnQueryPdf')->name('report.salereturnQueryPdf');
            Route::get('/salereturnPdfView', 'ReportController@salereturnPdfView')->name('report.salereturnPdfView');
            //Invoice Details
            Route::get('/invoicedetails', 'ReportController@invoicedetails')->name('report.invoicedetails');
            Route::get('/invoicedetailsQuery', 'ReportController@invoicedetailsQuery')->name('report.invoicedetailsQuery');
            Route::post('/invoicedetailsQueryPdf', 'ReportController@invoicedetailsQueryPdf')->name('report.invoicedetailsQueryPdf');
            Route::get('/invoicedetailsPdfView', 'ReportController@invoicedetailsPdfView')->name('report.invoicedetailsPdfView');
            //Purchase Details
            Route::get('/purchasedeatils', 'ReportController@purchasedeatils')->name('report.purchasedeatils');
            Route::get('/purchasedeatilsQuery', 'ReportController@purchasedeatilsQuery')->name('report.purchasedeatilsQuery');
            Route::post('/purchasedeatilsQueryPdf', 'ReportController@purchasedeatilsQueryPdf')->name('report.purchasedeatilsQueryPdf');
            Route::get('/purchasedeatilsPdfView', 'ReportController@purchasedeatilsPdfView')->name('report.purchasedeatilsPdfView');
            //supplier statement
            Route::get('/supplierstatement', 'ReportController@supplierstatement')->name('report.supplierstatement');
            Route::get('/supplierstatementQuery', 'ReportController@supplierstatementQuery')->name('report.supplierstatementQuery');
            Route::post('/supplierstatementQueryPdf', 'ReportController@supplierstatementQueryPdf')->name('report.supplierstatementQueryPdf');
            Route::get('/supplierstatementPdfView', 'ReportController@supplierstatementPdfView')->name('report.supplierstatementPdfView');
            //customer statement
            Route::get('/customerstatement', 'ReportController@customerstatement')->name('report.customerstatement');
            Route::get('/customerstatementQuery', 'ReportController@customerstatementQuery')->name('report.customerstatementQuery');
            Route::post('/customerstatementQueryPdf', 'ReportController@customerstatementQueryPdf')->name('report.customerstatementQueryPdf');
            Route::get('/customerstatementPdfView', 'ReportController@customerstatementPdfView')->name('report.customerstatementPdfView');
            //Income 
            Route::get('/income', 'ReportController@income')->name('report.income');
            Route::get('/incomeQuery', 'ReportController@incomeQuery')->name('report.incomeQuery');
            Route::post('/incomeQueryPdf', 'ReportController@incomeQueryPdf')->name('report.incomeQueryPdf');
            Route::get('/incomePdfView', 'ReportController@incomePdfView')->name('report.incomePdfView');
            //vat
            Route::get('/vat', 'ReportController@vat')->name('report.vat');
            Route::get('/vatQuery', 'ReportController@vatQuery')->name('report.vatQuery');
            Route::post('/vatQueryPdf', 'ReportController@vatQueryPdf')->name('report.vatQueryPdf');
            Route::get('/vatPdfView', 'ReportController@vatPdfView')->name('report.vatPdfView');
            //vat payment
            Route::get('/vatpayment', 'ReportController@vatpayment')->name('report.vatpayment');
            Route::get('/vatpaymentQuery', 'ReportController@vatpaymentQuery')->name('report.vatpaymentQuery');
            Route::post('/vatpaymentQueryPdf', 'ReportController@vatpaymentQueryPdf')->name('report.vatpaymentQueryPdf');
            Route::get('/vatpaymentPdfView', 'ReportController@vatpaymentPdfView')->name('report.vatpaymentPdfView');
        });

        Route::group(['prefix' => 'Session-Id'], function () {
            Route::post('/productId/{id}', 'ProductController@productId')->name('product.productId');
            Route::post('/purchaseId/{id}', 'PurchaseController@purchaseId')->name('purchase.purchaseId');
            Route::post('/grnid/{id}', 'PurchaseRecievedController@grnid')->name('grn.grnid');
            Route::post('/spaymentid/{id}', 'SupplierPaymentController@spaymentid')->name('spayment.spaymentid');
            Route::post('/cpaymentid/{id}', 'CustomerPaymentRecieveController@cpaymentid')->name('cpayment.cpaymentid');
            Route::post('/invid/{id}', 'InvoiceController@invid')->name('invoice.invid');
            Route::post('/salereturnid/{id}', 'SaleReturnController@salereturnid')->name('invoice.salereturnid');
            Route::post('/expensesid/{id}', 'ExpensesController@expensesid')->name('invoice.expensesid');
        });
        Route::group(['prefix' => 'Backup'], function () {
            Route::get('/', 'DataBaseBackupController@index')->name('database.index');
            Route::get('/backup', 'DataBaseBackupController@Backup')->name('database.backup');
            Route::get('/restore', 'DataBaseBackupController@restore')->name('database.restore');
            Route::post('/backuprestore', 'DataBaseBackupController@Backuprestore')->name('database.backuprestore');
        });
        //Mail Config
        Route::group(['prefix' => 'mailconfig'], function () {
            Route::get('/', 'MailConfigController@index')->name('mailconfigs');
            Route::get('/getdata', 'MailConfigController@GetData')->name('mailconfig.getdata');
            Route::post('/store', 'MailConfigController@Store')->name('mailconfig.store');
        });

        Route::group(['prefix' => 'Send-Mail'], function () {
            Route::get('/sendmails', 'SendMailController@Index')->name('sendmails');
            Route::post('/documentsend', 'SendMailController@DocumentSend')->name('sendmail.documentsend');
            Route::post('/invoicesend', 'SendMailController@InvoiceSend')->name('sendmail.invoicesend');
            Route::post('/creditinvoicesend', 'SendMailController@CreditInvoiceSend')->name('sendmail.creditinvoicesend');
            Route::post('/purchasesend', 'SendMailController@PurchaseSend')->name('sendmail.purchasesend');
            Route::post('/grnsend', 'SendMailController@GrnSend')->name('sendmail.grnsend');
            Route::post('/salereturnsend', 'SendMailController@SaleReturnSend')->name('sendmail.salereturnsend');
            Route::post('/purchasereturnsend', 'SendMailController@PurchaseReturnSend')->name('sendmail.purchasereturnsend');
            Route::post('/suppliaerpaymentsend', 'SendMailController@SuppliaerPaymentSend')->name('sendmail.suppliaerpaymentsend');
            Route::post('/customerpaymentsend', 'SendMailController@CustomerPaymentSend')->name('sendmail.customerpaymentsend');
            Route::post('/supplierstatement', 'SendMailController@SupplierStatement')->name('sendmail.supplierstatement');
            Route::post('/customerstatement', 'SendMailController@CustomerStatement')->name('sendmail.customerstatement');
        });


        Route::group(['prefix' => 'Notifications'], function () {
            // Route::get('/', 'Admin\NotificationController@index')->name('notifications');
            Route::get('/markAsRead/{id}', 'Admin\NotificationController@markAsRead')->name('notifications.markasread');
            Route::get('/markAsReadmessage/{id}', 'Admin\NotificationController@markAsReadmessage')->name('notifications.markasreadmessage');
            // Route::get('/markAsAllRead', 'Home\NotificationController@markAllAsRead')->name('notification.markasallread');
        });
        //BrandBrandController Router
        Route::group(['prefix' => 'CompanyStore'], function () {
            Route::get('/', 'Admin\StoreController@index')->name('stories');
            Route::get('/loadall', 'Admin\StoreController@LoadAll')->name('CompanyStore.loadall');
            Route::post('/store', 'Admin\StoreController@store')->name('CompanyStore.store');
            Route::post('/delete/{id}', 'Admin\StoreController@destroy')->name('CompanyStore.delete');
            Route::get('/show', 'Admin\StoreController@show')->name('CompanyStore.show');
            Route::post('/update', 'Admin\StoreController@update')->name('CompanyStore.update');
        });
        /*This Link will add session of language when they click to change language*/
        
    });
});
Auth::routes(['verify' => true]);
Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});
