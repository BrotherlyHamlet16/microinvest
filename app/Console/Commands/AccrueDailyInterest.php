<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Investment;
use Carbon\Carbon;

class AccrueDailyInterest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investments:accrue-interest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulate daily interest accrual for investments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        $investments = Investment::whereNull('withdrawn_at')
            ->where('maturity_date', '>=', $today)
            ->get();

        foreach ($investments as $inv) {
            // Optional: cache or log accrual, or trigger notifications
            $this->info("Accrued interest for investment ID {$inv->id}");
        }
    }
}
