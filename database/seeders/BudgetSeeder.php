<?php

namespace Database\Seeders;

use App\Models\Budget;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Budget::create([
            'user_id' => 1,
            'category_id' => null, // Total expense budget
            'month' => 6,
            'year' => 2025,
            'amount' => 2500.00,
        ]);

        Budget::create([
            'user_id' => 1,
            'category_id' => 1, // Food
            'month' => 6,
            'year' => 2025,
            'amount' => 300.00,
        ]);

        Budget::create([
            'user_id' => 1,
            'category_id' => 2, // Transportation
            'month' => 6,
            'year' => 2025,
            'amount' => 150.00,
        ]);

        Budget::create([
            'user_id' => 1,
            'category_id' => 3, // Housing
            'month' => 6,
            'year' => 2025,
            'amount' => 1300.00,
        ]);

        Budget::create([
            'user_id' => 1,
            'category_id' => 4, // Utilities
            'month' => 6,
            'year' => 2025,
            'amount' => 300.00,
        ]);

        Budget::create([
            'user_id' => 1,
            'category_id' => 5, // Entertainment
            'month' => 6,
            'year' => 2025,
            'amount' => 100.00,
        ]);
    }
}
