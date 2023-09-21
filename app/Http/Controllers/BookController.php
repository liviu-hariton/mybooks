<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = $request->input('title');
        $filter = $request->input('filter', '');
        $pageno = $request->input('page', '');

        $books = Book::when($title, fn($query, $title) => $query->title($title));

        $books = match($filter) {
            'popular_last_month' => $books->popularLastMonth()->paginate(5),
            'popular_last_6months' => $books->popularLast6Months()->paginate(5),
            'highest_rated_last_month' => $books->highestRatedLastMonth()->paginate(5),
            'highest_rated_last_6months' => $books->highestRatedLast6Months()->paginate(5),
            default => $books->latest()->withAvgRating()->withReviewsCount()->paginate(5)
        };

        $cache_key = 'books:'.$filter.':'.$title.':'.$pageno;

        $books = cache()->remember(
            $cache_key,
            3600,
            fn() => $books
        );

        return view('books.index', [
            'books' => $books
        ]);
    }

    public function setFilters() {
        $filters = [
            '' => 'Latest',
            'popular_last_month' => 'Popular last month',
            'popular_last_6months' => 'Popular last 6 months',
            'highest_rated_last_month' => 'Highest rated last month',
            'highest_rated_last_6months' => 'Highest rated last 6 months'
        ];

        return $filters;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $cache_key = 'book:'.$id;

        $book = cache()->remember(
            $cache_key,
            3600,
            fn() => Book::with([
            'reviews' => fn($query) => $query->latest()
        ])->withAvgRating()->withReviewsCount()->findOrFail($id)
        );

        return view('books.show', [
            'book' => $book
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
