<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    // establish relation to reviews table
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // you'll call this like Book::title('something')->get()
    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'like', '%'.$title.'%');
    }

    private function dateRangeFilter(Builder $query, $from = null, $to = null): void
    {
        if($from && !$to) {
            $query->where('created_at', '>=', $from);
        }

        if($to && !$from) {
            $query->where('created_at', '<=', $to);
        }

        if($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }
    }

    public function scopeMinReviews(Builder $query, int $minReviews) {
        return $query->having('reviews_count', '>=', $minReviews);
    }

    public function scopePopular(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withCount([
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ])
            ->orderBy('reviews_count', 'desc');
    }

    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withAvg([
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ], 'rating')
            ->orderBy('reviews_avg_rating', 'desc');
    }
}
