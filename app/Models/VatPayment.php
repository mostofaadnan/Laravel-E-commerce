<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
class VatPayment extends Model
{
    public function Vat_Collection()
    {
        return $this->belongsto(VatCollection::class, 'vat_id');
    }
    public function username()
    {
        return $this->belongsto(Admin::class, 'user_id');
    }
}