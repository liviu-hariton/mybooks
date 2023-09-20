<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // establish relation to reviews table
    public function reviews() {
        return $this->hasMany(Review::class);
    }
}
