<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayClose extends Model
{
    protected $fillable = [
         'date', 
         'branch_id',
         'cashinvoice',
         'creditinvoice',
         'salereturn',
         'purchase',
         'grn',
         'purchasereturn',
         'supplierpayment',
         'creditpayment',
         'expenses',
         'stockamount',
         'income',
         'profit',
         'cashin',
         'cashout',
         'cashdrawer',
         'cashinbank',
         'status',
         'user_id',
         'type',
         'month',
         'year',
         
    ];
}
