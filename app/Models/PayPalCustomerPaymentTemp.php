<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayPalCustomerPaymentTemp extends Model
{
    public function CustomerName()
    {
        return $this->belongsto(customer::class, 'customer_id');
    }
}
