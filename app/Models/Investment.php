<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Investment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'plan_id',
        'amount',
        'status',
        'start_date',
        'end_date',
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'maturity_date',
    ];
    public function plan()
    {
        return $this->belongsTo(InvestmentPlan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
