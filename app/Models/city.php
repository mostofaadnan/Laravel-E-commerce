<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class city extends Model
{
    public function StateName()
    {
        return $this->belongsto(state::class, 'state_id');
    }
}
