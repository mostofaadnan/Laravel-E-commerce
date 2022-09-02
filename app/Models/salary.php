<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;

class salary extends Model
{

    public function Details()
    {
        return $this->hasMany(salaryDetails::class, 'salary_id');
    }
}
