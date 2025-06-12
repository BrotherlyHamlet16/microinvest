<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvestmentPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('investment_plans')->insert([
            [
                'name' => 'SaveDaily',
                'daily_return_rate' => 1.5,
                'lock_period' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'GrowFast',
                'daily_return_rate' => 2.0,
                'lock_period' => 14,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
