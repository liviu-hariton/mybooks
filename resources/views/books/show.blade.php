@extends('layouts.app')

@section('title', $book->title)

@section('content')
    <div class="list-group">
        <div class="list-group-item list-group-item-action mb-2">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1"></h5>
                <small>
                    <span class="badge bg-primary rounded-pill">{{ number_format($book->reviews_avg_rating, 1) }}</span>

                    <x-star-rating :rating="$book->reviews_avg_rating" /><br />

                    out of {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
                </small>
            </div>
            <p class="mb-1">by {{ $book->author }}</p>
            <p class="text-secondary">
                <small>
                    <i class="fa fa-calendar-plus"></i> Created: {{ $book->created_at->diffForHumans() }}
                    <i class="fa fa-clock"></i> Edited: {{ $book->updated_at->diffForHumans() }}
                </small>
            </p>
        </div>
    </div>

    <h3 class="mb-1 mt-3">Reviews</h3>

    @if($book->reviews)
        <div class="list-group">
            @foreach($book->reviews as $review)
                <div class="list-group-item list-group-item-action mb-2">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"></h5>
                        <small>
                            <span class="badge bg-primary rounded-pill">{{ number_format($review->rating, 1) }}</span>

                            <x-star-rating :rating="$review->rating" />
                        </small>
                    </div>
                    <p class="mb-1">{{ $review->review }}</p>
                    <p class="text-secondary">
                        <small>
                            <i class="fa fa-calendar-plus"></i> Created: {{ $review->created_at->format('j M Y') }}
                            <i class="fa fa-clock"></i> Edited: {{ $review->updated_at->diffForHumans() }}
                        </small>
                    </p>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-warning">
            There are no reviews to display.
            <!--<a href="{{ route('books.index') }}" class="text-warning-emphasis fw-bold"><i class="fa fa-refresh"></i> Reset items</a>-->
        </div>
    @endif

@endsection
