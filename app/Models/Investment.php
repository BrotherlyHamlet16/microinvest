<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    public function plan()
    {
        return $this->belongsTo(InvestmentPlan::class);
    }
}
