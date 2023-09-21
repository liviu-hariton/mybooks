@extends('layouts.app')

@section('title')
    Leave a review for the book &quot;{{ $book->title }}&quot;
@endsection

@section('content')
    <form method="post" name="f-review" id="f-review" action="{{ route('books.review.store', $book) }}">
        @csrf

        <div class="mb-3">
            <label for="review" class="form-label">Your review</label>
            <textarea @class(['form-control', 'is-invalid' => $errors->has('review')]) id="review" name="review" rows="5" required>{{ old('review') }}</textarea>
            @error('review')
            <p><span class="badge text-bg-danger">{{ $message }}</span></p>
            @enderror
        </div>

        <div class="mb-3">
            <select name="rating" id="rating" required @class(['form-select', 'is-invalid' => $errors->has('rating')]) aria-label="Choose a rating option">
                <option selected>Choose a rating option</option>
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ $i == old('rating') ? 'selected="selected"' : '' }}>{{ $i }} {{ Str::plural('star', $i) }}</option>
                @endfor
            </select>
            @error('rating')
            <p><span class="badge text-bg-danger">{{ $message }}</span></p>
            @enderror
        </div>

        <div class="col-12">
            <button class="btn btn-success" type="submit">Submit review <i class="fa fa-chevron-right"></i></button>
        </div>
    </form>
@endsection
