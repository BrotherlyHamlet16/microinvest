<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\InvestmentConfirmation;
use App\Mail\WithdrawalConfirmation;
use App\Models\Investment;
use App\Models\InvestmentPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvestmentController extends Controller
{
    // store(Request $request) Function to handle investment creation
    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:investment_plans,id',
            'amount' => 'required|numeric|min:10',
        ]);

        $plan = InvestmentPlan::findOrFail($request->plan_id);
        $start = now();
        $maturity = $start->copy()->addDays($plan->lock_period);

        $investment = Investment::create([
            'user_id' => $request->user()->id,
            'investment_plan_id' => $plan->id,
            'amount' => $request->amount,
            'start_date' => $start,
            'maturity_date' => $maturity,
        ]);

        // Optional email notification
        Mail::to($request->user()->email)->send(new InvestmentConfirmation($investment));

        return response()->json(['message' => 'Investment successful', 'investment' => $investment], 201);
    }

    //index() Function to list all investments for a user
    public function index(Request $request)
    {
        $investments = $request->user()->investments()->with('plan')->get();

        $portfolio = $investments->map(function ($investment) {
            $days = $investment->start_date->diffInDays(now());
            $rate = $investment->plan->daily_return_rate;
            $accrued = $investment->amount * ($rate / 100) * $days;

            return [
                'id' => $investment->id,
                'plan' => $investment->plan->name,
                'amount' => $investment->amount,
                'accrued_interest' => round($accrued, 2),
                'maturity_date' => $investment->maturity_date,
                'status' => $investment->status,
                'eligible_for_withdrawal' => now()->greaterThanOrEqualTo($investment->maturity_date),
                'total_value' => round($investment->amount + $accrued, 2),
            ];
        });

        return response()->json($portfolio);
    }

    //withdraw($id) Function to withdraw an investment if lock period passed)
    public function withdraw($id, Request $request)
    {
        $investment = Investment::where('id', $id)->where('user_id', $request->user()->id)->firstOrFail();

        if ($investment->status !== 'active') {
            return response()->json(['error' => 'Already withdrawn'], 400);
        }

        if (now()->lt($investment->maturity_date)) {
            return response()->json(['error' => 'Cannot withdraw before maturity'], 403);
        }

        $days = $investment->start_date->diffInDays(now());
        $rate = $investment->plan->daily_return_rate;
        $accrued = $investment->amount * ($rate / 100) * $days;
        $total = $investment->amount + $accrued;

        $investment->status = 'withdrawn';
        $investment->save();

        Mail::to($request->user()->email)->send(new WithdrawalConfirmation($investment, $total));

        return response()->json([
            'message' => 'Withdrawal successful',
            'withdrawn_amount' => round($total, 2)
        ]);
    }
}
