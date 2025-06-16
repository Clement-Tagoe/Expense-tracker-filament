<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaction::create([
            'user_id' => 1,
            'category_id' => 1, // Food
            'description' => 'Grocery Shopping',
            'amount' => 85.50,
            'date' => '2025-06-01'
        ]);

        Transaction::create([
            'user_id' => 1,
            'category_id' => 2, // Transportation
            'description' => 'Gas for Car',
            'amount' => 45.00,
            'date' => '2025-06-02'
        ]);

        Transaction::create([
            'user_id' => 1,
            'category_id' => 3, // Housing
            'description' => 'Monthly Rent',
            'amount' => 1200.00,
            'date' => '2025-06-03'
        ]);

        Transaction::create([
            'user_id' => 1,
            'category_id' => 4, // Utilities
            'description' => 'Water Bill',
            'amount' => 120.00,
            'date' => '2025-06-04'
        ]);

        Transaction::create([
            'user_id' => 1,
            'category_id' => 4, // Utilities
            'description' => 'Electricity Bill',
            'amount' => 90.75,
            'date' => '2025-06-05'
        ]);

        Transaction::create([
            'user_id' => 1,
            'category_id' => 5, // Entertainment
            'description' => 'Streaming Subscription',
            'amount' => 15.99,
            'date' => '2025-06-06'
        ]);

        Transaction::create([
            'user_id' => 1,
            'category_id' => 6, // Healthcare
            'description' => 'Doctor Visit',
            'amount' => 200.00,
            'date' => '2025-06-07'
        ]);

        Transaction::create([
            'user_id' => 1,
            'category_id' => 7, // Clothing
            'description' => 'New Shoes',
            'amount' => 75.00,
            'date' => '2025-06-08'
        ]);

        Transaction::create([
            'user_id' => 1,
            'category_id' => 8, // Education
            'description' => 'Online Course',
            'amount' => 150.00,
            'date' => '2025-06-09'
        ]);

        Transaction::create([
            'user_id' => 1,
            'category_id' => 1, // Food
            'description' => 'Dining Out',
            'amount' => 60.25,
            'date' => '2025-06-10'
        ]);

        Transaction::create([
            'user_id' => 1,
            'category_id' => 9, // Salary
            'description' => 'Monthly Paycheck',
            'amount' => 3000.00,
            'date' => '2025-06-01'
        ]);

        Transaction::create([
            'user_id' => 1,
            'category_id' => 10, // Freelance
            'description' => 'Web Design Project',
            'amount' => 500.00,
            'date' => '2025-06-05'
        ]);

        Transaction::create([
            'user_id' => 1,
            'category_id' => 11, // Investments
            'description' => 'Stock Dividends',
            'amount' => 200.00,
            'date' => '2025-06-07'
        ]);

        Transaction::create([
            'user_id' => 1,
            'category_id' => 10, // Freelance
            'description' => 'Consulting Fee',
            'amount' => 350.00,
            'date' => '2025-06-10'
        ]);
    }
}
