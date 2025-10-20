<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Income Categories
            ['name' => 'Salary', 'type' => 'income', 'color' => '#10B981'],
            ['name' => 'Freelance', 'type' => 'income', 'color' => '#3B82F6'],
            ['name' => 'Investment', 'type' => 'income', 'color' => '#8B5CF6'],
            ['name' => 'Bonus', 'type' => 'income', 'color' => '#F59E0B'],

            // Expense Categories
            ['name' => 'Food & Dining', 'type' => 'expense', 'color' => '#EF4444'],
            ['name' => 'Transportation', 'type' => 'expense', 'color' => '#6B7280'],
            ['name' => 'Shopping', 'type' => 'expense', 'color' => '#EC4899'],
            ['name' => 'Entertainment', 'type' => 'expense', 'color' => '#8B5CF6'],
            ['name' => 'Bills & Utilities', 'type' => 'expense', 'color' => '#06B6D4'],
            ['name' => 'Healthcare', 'type' => 'expense', 'color' => '#84CC16'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
