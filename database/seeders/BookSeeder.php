<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run()
    {
        Book::create([
            'title' => 'Harry Potter',
            'author_id' => 1, // pastikan ada author di tabel
            'category_id' => 1,
            'publisher_id' => 1,
            'shelf_id' => 1,
            'year' => 1998,
            'cover' => 'books/harrypotter.jpg'
        ]);
    }
}
