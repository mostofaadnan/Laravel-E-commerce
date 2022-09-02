<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $addresses = null;

    public function __construct($oldCart)

    {
        /* if ($oldCart) { */
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
          //  $this->totalvat = $oldCart->totalvat;
      /*   } */
    }
}
