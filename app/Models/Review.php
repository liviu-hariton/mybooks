<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'review', 'rating'
    ];

    // establish relation to books table
    public function book(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    protected static function booted(): void
    {
        static::created(fn(Review $review) => cache()->forget('book:'.$review->book_id));
        static::updated(fn(Review $review) => cache()->forget('book:'.$review->book_id));
        static::deleted(fn(Review $review) => cache()->forget('book:'.$review->book_id));
    }
}
