@extends('layouts.app')

@section('title', 'Books list')

@section('content')
    @if($books->count())
        <div class="list-group">
            @foreach($books as $book)
                <div class="list-group-item list-group-item-action mb-2">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><a href="{{ route('books.show', $book) }}" class="text-success-emphasis">{{ $book->title }}</a></h5>

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
            @endforeach
        </div>

        {{ $books->withQueryString()->links() }}
    @else
        <div class="alert alert-warning">
            There are no books to display.
            <a href="{{ route('books.index') }}" class="text-warning-emphasis fw-bold"><i class="fa fa-refresh"></i> Reset items</a>
        </div>
    @endif

@endsection
