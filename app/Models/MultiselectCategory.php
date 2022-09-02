<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultiselectCategory extends Model
{

    function CateName()
    {
        return $this->belongsto(Category::class, 'category_id');
    }
}
