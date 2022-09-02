<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\unit;
use App\Models\VatSetting;
use App\Models\Admin;

class Product extends Model
{


    public function CategoryName()
    {
        return $this->belongsto(Category::class, 'category_id');
    }
    public function SubcategoryName()
    {
        return $this->belongsto(Subcategory::class, 'subcategory_id');
    }
    public function BrandName()
    {
        return $this->belongsto(Brand::class, 'brand_id');
    }
    public function UnitName()
    {

        return $this->belongsto(unit::class, 'unit_id');
    }
    public function VatName()
    {
        return $this->belongsto(VatSetting::class, 'VatSetting_id', 'id');
    }
    public function username()
    {
        return $this->belongsto(Admin::class, 'admin_id');
    }
    public function openingStock()
    {
        return $this->hasMany(OpeningStock::class, 'product_id');
    }
    public function QuantityOutBySale()
    {
        return $this->hasMany(InvoiceDetails::class, 'item_id')
            ->where('cancel', 0);
    }


    public function QuantityOutByPurchase()
    {
        return $this->hasMany(purchasedetails::class, 'itemcode')
            ->where('status', '1');
    }
    public function QuantityOutBySaleReturn()
    {
        return $this->hasMany(SaleReturnDetails::class, 'item_id');
    }
    public function QuantityOutByPurchaseReturn()
    {
        return $this->hasMany(PurchaseReturnDetails::class, 'itemcode');
    }
    public function QuantityOrder()
    {
        return $this->hasMany(OrderDetails::class, 'item_id');
    }
    public function ColorName()
    {
        return $this->hasMany(productColor::class, 'product_id');
    }
    public function SizeName()
    {
        return $this->hasMany(productSize::class, 'product_id');
    }

    public function MuliImage()
    {
        return $this->hasMany(productImage::class, 'product_id');
    }
    public function getRouteKeyName()
    {
        return 'name';
    }
    function convertCurrency($amount, $from_currency, $to_currency)
    {
        
        $apikey = '2f461a73fee21adf355a';
        $from_Currency = urlencode($from_currency);
        $to_Currency = urlencode($to_currency);
        $query =  "{$from_Currency}_{$to_Currency}";
        // change to the free URL if you're using the free version
        $json = file_get_contents("https://api.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apikey}");
        $obj = json_decode($json, true);
        $val = floatval($obj["$query"]);
        $total = $val * $amount;
        return number_format($total, 2, '.', '');
    }
}
