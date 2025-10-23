<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\User;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Buat user default jika belum ada
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Default User',
                'email' => 'user@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        $categories = [
            ['name' => 'Salary', 'type' => 'income', 'color' => '#10B981', 'user_id' => $user->id],
            ['name' => 'Freelance', 'type' => 'income', 'color' => '#059669', 'user_id' => $user->id],
            ['name' => 'Food & Drinks', 'type' => 'expense', 'color' => '#EF4444', 'user_id' => $user->id],
            ['name' => 'Shopping', 'type' => 'expense', 'color' => '#8B5CF6', 'user_id' => $user->id],
            ['name' => 'Transportation', 'type' => 'expense', 'color' => '#F59E0B', 'user_id' => $user->id],
            ['name' => 'Entertainment', 'type' => 'expense', 'color' => '#EC4899', 'user_id' => $user->id],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
