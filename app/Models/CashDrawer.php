<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
use App\Models\Invoice;

class CashDrawer extends Model
{
    public function username()
    {
        return $this->belongsto(Admin::class, 'user_id');
    }

    public function RefNo($type)
    {
        switch ($type) {
            case 1:
                return $this->belongsto(Invoice::class,'payment_id');
                break;
            case 2:
                return $this->belongsto(SupplierPayment::class,'payment_id');
                break;
            case 3:
                return $this->belongsto(CustomerPaymentRecieve::class, 'payment_id');
                break;
            case 4:
                return $this->belongsto(SaleReturn::class, 'payment_id');
                break;
            case 5:
                return $this->belongsto(Expenses::class, 'payment_id');
                break;
            default:
                break;
        }
    }
}
