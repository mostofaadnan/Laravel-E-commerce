<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function subcategory()
    {
        return $this->hasMany(Subcategory::class);
    }

    protected $fillable = [
        'title', 'status',
    ];

    public function getRouteKeyName()
    {
        return 'title';
    }
}
