<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Subcategory extends Model
{
    public function Categoryname()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function getRouteKeyName()
    {
        return 'title';
    }
}
