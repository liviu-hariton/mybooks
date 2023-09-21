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

    public function scopeWithReviewsCount(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withCount([
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ]);
    }

    public function scopePopular(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withReviewsCount()
            ->orderBy('reviews_count', 'desc');
    }

    public function scopeWithAvgRating(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withAvg([
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ], 'rating');
    }

    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withAvgRating()
            ->orderBy('reviews_avg_rating', 'desc');
    }

    public function scopePopularLastMonth(Builder $query): Builder
    {
        return $query->popular(now()->subMonth(), now())
            ->highestRated(now()->subMonth(), now())
            ->minReviews(2);
    }

    public function scopePopularLast6Months(Builder $query): Builder
    {
        return $query->popular(now()->subMonths(6), now())
            ->highestRated(now()->subMonth(), now())
            ->minReviews(5);
    }

    public function scopeHighestRatedLastMonth(Builder $query): Builder
    {
        return $query->highestRated(now()->subMonth(), now())
            ->popular(now()->subMonth(), now())
            ->minReviews(2);
    }

    public function scopeHighestRatedLast6Months(Builder $query): Builder
    {
        return $query->highestRated(now()->subMonth(), now())
            ->popular(now()->subMonths(6), now())
            ->minReviews(5);
    }

    protected static function booted(): void
    {
        static::updated(fn(Book $book) => cache()->forget('book:'.$book->id));
        static::deleted(fn(Book $book) => cache()->forget('book:'.$book->id));
    }
}
