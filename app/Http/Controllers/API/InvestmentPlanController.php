<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\InvestmentPlan;
use Illuminate\Http\Request;

class InvestmentPlanController extends Controller
{
    // index() Function to list all investment plans)
    public function index()
    {
        return response()->json(['data' => InvestmentPlan::all()]);
    }
}
