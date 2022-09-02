<?php

namespace App\Models;

class Cart
{

    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;
   // public $totalvat = 0;

    public function __construct($oldCart)

    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
          //  $this->totalvat = $oldCart->totalvat;
        }
    }

    public function add($item, $id)
    {

        if ($item->discount > 0) {
            $mrp = $item->discount;
        } else {
            $mrp = $item->mrp;
        }

        $storedItem = [
            'qty' => 0,
            'price' => $mrp,
            'unitprice' => $mrp,
            'item' => $item,
        ];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['qty']++;
        $storedItem['price'] = $mrp * $storedItem['qty'];
        //$vatvalue = $item->vatvalue;
       // $vat = (($vatvalue * 100) / $mrp);
        $this->items[$id] = $storedItem;
        $this->totalQty++;
        $this->totalPrice += $mrp;
       // $this->totalvat += $vat;
    }

    public function removeItemByOne($id)
    {
        $this->items[$id]['qty']--;
        $this->items[$id]['price'] -= $this->items[$id]['item']['mrp'];

        $this->totalQty--;
        $this->totalPrice -= $this->items[$id]['item']['mrp'];

        if ($this->items[$id]['qty'] <= 0) {
            unset($this->items[$id]);
        }
    }
    public function removeItem($id)
    {
        $this->totalQty = $this->items[$id]['qty'];
        $this->totalPrice = $this->items[$id]['price'];
        unset($this->items[$id]);
    }
}
