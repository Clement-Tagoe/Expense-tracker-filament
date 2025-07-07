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
        // March 2025 Transactions (9 transactions: 6 expenses, 3 income)
        Transaction::create([
            'user_id' => 1,
            'category_id' => 1, // Food
            'description' => 'Grocery shopping',
            'amount' => 78.20,
            'date' => '2025-03-02'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 9, // Salary
            'description' => 'Monthly salary',
            'amount' => 2500.00,
            'date' => '2025-03-03'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 2, // Transportation
            'description' => 'Bus pass',
            'amount' => 40.00,
            'date' => '2025-03-05'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 3, // Housing
            'description' => 'Rent payment',
            'amount' => 1200.00,
            'date' => '2025-03-07'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 4, // Utilities
            'description' => 'Electricity bill',
            'amount' => 110.50,
            'date' => '2025-03-10'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 5, // Entertainment
            'description' => 'Movie tickets',
            'amount' => 25.00,
            'date' => '2025-03-15'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 10, // Freelance
            'description' => 'Consulting fee',
            'amount' => 350.00,
            'date' => '2025-03-20'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 6, // Healthcare
            'description' => 'Doctor visit',
            'amount' => 60.00,
            'date' => '2025-03-25'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 11, // Investments
            'description' => 'Stock dividends',
            'amount' => 120.00,
            'date' => '2025-03-28'
        ]);

        // April 2025 Transactions (8 transactions: 6 expenses, 2 income)
        Transaction::create([
            'user_id' => 1,
            'category_id' => 1, // Food
            'description' => 'Restaurant dinner',
            'amount' => 45.80,
            'date' => '2025-04-01'
        ]);
        
        Transaction::create([
            'user_id' => 1,
            'category_id' => 9, // Salary
            'description' => 'Monthly salary',
            'amount' => 2500.00,
            'date' => '2025-04-02'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 2, // Transportation
            'description' => 'Fuel for car',
            'amount' => 50.00,
            'date' => '2025-04-05'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 3, // Housing
            'description' => 'Rent payment',
            'amount' => 1200.00,
            'date' => '2025-04-07'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 4, // Utilities
            'description' => 'Internet bill',
            'amount' => 60.00,
            'date' => '2025-04-10'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 5, // Entertainment
            'description' => 'Streaming subscription',
            'amount' => 14.99,
            'date' => '2025-04-15'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 7, // Clothing
            'description' => 'New jacket',
            'amount' => 75.00,
            'date' => '2025-04-20'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 10, // Freelance
            'description' => 'Graphic design project',
            'amount' => 300.00,
            'date' => '2025-04-25'
        ]);

        // May 2025 Transactions (10 transactions: 7 expenses, 3 income)
        Transaction::create([
            'user_id' => 1,
            'category_id' => 1, // Food
            'description' => 'Grocery shopping',
            'amount' => 90.30,
            'date' => '2025-05-02'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 9, // Salary
            'description' => 'Monthly salary',
            'amount' => 2500.00,
            'date' => '2025-05-03'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 2, // Transportation
            'description' => 'Train ticket',
            'amount' => 35.00,
            'date' => '2025-05-05'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 3, // Housing
            'description' => 'Rent payment',
            'amount' => 1200.00,
            'date' => '2025-05-07'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 4, // Utilities
            'description' => 'Water bill',
            'amount' => 48.75,
            'date' => '2025-05-10'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 5, // Entertainment
            'description' => 'Concert tickets',
            'amount' => 70.00,
            'date' => '2025-05-12'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 6, // Healthcare
            'description' => 'Pharmacy purchase',
            'amount' => 30.00,
            'date' => '2025-05-15'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 8, // Education
            'description' => 'Online course fee',
            'amount' => 120.00,
            'date' => '2025-05-20'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 10, // Freelance
            'description' => 'Consulting fee',
            'amount' => 400.00,
            'date' => '2025-05-25'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 11, // Investments
            'description' => 'Stock dividends',
            'amount' => 150.00,
            'date' => '2025-05-28'
        ]);

        // June 2025 Transactions (8 transactions: 6 expenses, 2 income)
        Transaction::create([
            'user_id' => 1,
            'category_id' => 1, // Food
            'description' => 'Takeout meal',
            'amount' => 32.50,
            'date' => '2025-06-01'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 9, // Salary
            'description' => 'Monthly salary',
            'amount' => 2500.00,
            'date' => '2025-06-02'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 2, // Transportation
            'description' => 'Car maintenance',
            'amount' => 140.00,
            'date' => '2025-06-05'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 3, // Housing
            'description' => 'Rent payment',
            'amount' => 1200.00,
            'date' => '2025-06-07'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 4, // Utilities
            'description' => 'Gas bill',
            'amount' => 65.00,
            'date' => '2025-06-10'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 5, // Entertainment
            'description' => 'Gaming subscription',
            'amount' => 14.99,
            'date' => '2025-06-15'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 7, // Clothing
            'description' => 'New shoes',
            'amount' => 65.00,
            'date' => '2025-06-20'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 10, // Freelance
            'description' => 'Website design project',
            'amount' => 350.00,
            'date' => '2025-06-25'
        ]);

        // July 2025 Transactions (8 transactions: 6 expenses, 2 income)
        Transaction::create([
            'user_id' => 1,
            'category_id' => 1, // Food
            'description' => 'Dinner at Frankies',
            'amount' => 28.50,
            'date' => '2025-07-01'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 9, // Salary
            'description' => 'Monthly salary',
            'amount' => 2500.00,
            'date' => '2025-07-02'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 2, // Transportation
            'description' => 'Car maintenance',
            'amount' => 120.00,
            'date' => '2025-07-04'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 3, // Housing
            'description' => 'Rent payment',
            'amount' => 1200.00,
            'date' => '2025-07-06'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 4, // Utilities
            'description' => 'Gas bill',
            'amount' => 60.00,
            'date' => '2025-07-10'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 5, // Entertainment
            'description' => 'Gaming subscription',
            'amount' => 14.99,
            'date' => '2025-07-14'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 7, // Clothing
            'description' => 'New shirts',
            'amount' => 75.00,
            'date' => '2025-07-19'
        ]);
        Transaction::create([
            'user_id' => 1,
            'category_id' => 10, // Freelance
            'description' => 'Flyer design project',
            'amount' => 255.00,
            'date' => '2025-07-26'
        ]);

        Transaction::create([
            'user_id' => 1,
            'category_id' => 8, // Education
            'description' => 'School Fees',
            'amount' => 650.00,
            'date' => '2025-07-28'
        ]);

        Transaction::create([
            'user_id' => 1,
            'category_id' => 6, // Healthcare
            'description' => 'Dental Check up',
            'amount' => 185.00,
            'date' => '2025-07-18'
        ]);
    
    }
}
