<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentPlan extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'daily_return_rate',
        'lock_period',
    ];

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
}
