<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author_id',
        'category_id',
        'publisher_id',
        'shelf_id',
        'year',
        'book_img' 
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function shelf()
    {
        return $this->belongsTo(Shelf::class);
    }

    // relasi ini untuk fitur peminjaman
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    // method ini untuk mengecek ketersediaan buku
    public function isAvailable()
    {
        return $this->borrowings()->whereNull('returned_at')->doesntExist();
    }
}