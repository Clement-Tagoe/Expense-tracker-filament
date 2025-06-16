<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'user_id' => 1,
            'type' => 'expense',
            'name' => 'Food',
        ]);

        Category::create([
            'user_id' => 1,
            'type' => 'expense',
            'name' => 'Transportation',
        ]);

        Category::create([
            'user_id' => 1,
            'type' => 'expense',
            'name' => 'Housing',
        ]);

        Category::create([
            'user_id' => 1,
            'type' => 'expense',
            'name' => 'Utilities',
        ]);

        Category::create([
            'user_id' => 1,
            'type' => 'expense',
            'name' => 'Entertainment',
        ]);

        Category::create([
            'user_id' => 1,
            'type' => 'expense',
            'name' => 'Healthcare',
        ]);

        Category::create([
            'user_id' => 1,
            'type' => 'expense',
            'name' => 'Clothing',
        ]);

        Category::create([
            'user_id' => 1,
            'type' => 'expense',
            'name' => 'Education',
        ]);

        Category::create([
            'user_id' => 1,
            'type' => 'income',
            'name' => 'Salary',
        ]);

        Category::create([
            'user_id' => 1,
            'type' => 'income',
            'name' => 'Freelance',
        ]);

        Category::create([
            'user_id' => 1,
            'type' => 'income',
            'name' => 'Investments',
        ]);
    }
}
