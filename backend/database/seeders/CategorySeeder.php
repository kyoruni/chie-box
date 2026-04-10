<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'バトル', 'slug' => 'battle', 'sort_order' => 1],
            ['name' => '育成', 'slug' => 'training', 'sort_order' => 2],
            ['name' => 'わざ・とくせい', 'slug' => 'moves-abilities', 'sort_order' => 3],
            ['name' => 'どうぐ', 'slug' => 'items', 'sort_order' => 4],
            ['name' => '暮らし・生活', 'slug' => 'daily-life', 'sort_order' => 5],
            ['name' => 'その他', 'slug' => 'other', 'sort_order' => 6],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category,
            );
        }
    }
}
