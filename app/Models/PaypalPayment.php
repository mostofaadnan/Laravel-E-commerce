<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
class PaypalPayment extends Model
{
    public function username()
    {
        return $this->belongsto(Admin::class, 'user_id');
    }
}
