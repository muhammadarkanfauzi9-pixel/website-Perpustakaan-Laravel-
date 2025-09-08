<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    
    public function publisher(){
        return $this->belongsTo(Publisher::class);
    }
    
    public function shelf(){
        return $this->belongsTo(Shelf::class);
    }
    
    public function category(){
        return $this->belongsTo(Category::class);
    }
    
    public function borrowings(){
        return $this->hasMany(Borrowing::class);
    }
}
