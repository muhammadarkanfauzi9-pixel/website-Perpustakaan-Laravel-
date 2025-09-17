<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = ['Fiksi', 'Non-Fiksi', 'Sejarah', 'Teknologi', 'Agama', 'Komik'];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat,
                'description' => $cat . ' books'
            ]);
        }
    }
}
