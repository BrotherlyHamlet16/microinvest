<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\InvestmentConfirmation;
use App\Mail\WithdrawalConfirmation;
use App\Models\Investment;
use App\Models\InvestmentPlan;
use App\Notifications\InvestmentMade;
use App\Notifications\InvestmentWithdrawn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class InvestmentController extends Controller
{
    // List investments for authenticated user
    public function index(Request $request)
    {
        $user = $request->user();

        $investments = Investment::with('plan')
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($inv) {
                $currentValue = $this->calculateCurrentValue($inv);
                return [
                    'id' => $inv->id,
                    'plan' => $inv->plan,
                    'amount' => $inv->amount,
                    'start_date' => $inv->start_date->toDateString(),
                    'maturity_date' => $inv->maturity_date->toDateString(),
                    'withdrawn_at' => $inv->withdrawn_at,
                    'current_value' => $currentValue,
                    'can_withdraw' => $this->canWithdraw($inv),
                ];
            });

        return response()->json(['data' => $investments]);
    }

    // Create new investment
    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required | exists:plans, id',
            'amount' => 'required | numeric | min:1',
        ]);

        $user = $request->user();
        $plan = InvestmentPlan::findOrFail($request->plan_id);

        $now = Carbon::now();
        $maturity = $now->copy()->addDays($plan->lock_period_days);

        $investment = Investment::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'amount' => $request->amount,
            'start_date' => $now,
            'maturity_date' => $maturity,
        ]);

        $user->notify(new InvestmentMade());

        return response()->json(['message' => 'Investment created', 'investment' => $investment], 201);
    }

    // Withdraw investment
    public function withdraw(Request $request, $id)
    {
        $user = $request->user();

        $investment = Investment::where('id', $id)
            ->where('user_id', $user->id)
            ->whereNull('withdrawn_at')
            ->firstOrFail();

        if (!$this->canWithdraw($investment)) {
            return response()->json(['error' => 'Investment is still locked'], 403);
        }

        $investment->withdrawn_at = Carbon::now();
        $investment->save();

        $user->notify(new InvestmentWithdrawn());

        // TODO: trigger withdrawal payment, notifications, etc.

        return response()->json(['message' => 'Investment withdrawn']);
    }

    private function calculateCurrentValue(Investment $investment)
    {
        $plan = $investment->plan;
        $start = $investment->start_date;
        $now = Carbon::now();

        $daysElapsed = $start->diffInDays(min($now, $investment->maturity_date));

        // Compound interest calculation daily for simplicity:
        // current_value = amount * (1 + return_rate/100)^daysElapsed
        $rate = $plan->return_rate / 100;
        $currentValue = $investment->amount * pow(1 + $rate, $daysElapsed);

        return round($currentValue, 2);
    }

    private function canWithdraw(Investment $investment)
    {
        $now = Carbon::now();
        return $investment->withdrawn_at === null && $now->gte($investment->maturity_date);
    }
}
