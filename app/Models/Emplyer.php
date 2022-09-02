<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emplyer extends Model
{
    protected $fillable = [
        'name', 'employer_id', 'address','mobile_no','email','job_type','designation','salary_basis','salary','joining_date','image','other_description'
    ];
}
