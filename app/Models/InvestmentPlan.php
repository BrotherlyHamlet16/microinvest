<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestmentPlan extends Model
{
    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
}
