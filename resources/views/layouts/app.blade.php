<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>My Books</title>

    @vite(['resources/js/app.js'])
</head>
<body>
<div class="col-lg-8 mx-auto p-4 py-md-5">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center col-md-3 mb-3 mb-md-0 text-dark text-decoration-none">
            <i class="fa-brands fa-bootstrap fa-2xl"></i>
            <span class="fs-3">MyBooks</span>
        </a>

        <div class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Books list</a>

            @if(Route::is('books.show'))
                <a href="{{ route('books.review.create', $book) }}" class="btn btn-success ms-2">Add a review <i class="fa fa-plus"></i></a>
            @endif
        </div>
    </header>

    <main>
        @if( session()->has('success') )
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fa fa-check-double"></i> {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @include('books.blocks.search-form')

        @include('books.blocks.filters')

        <h1>@yield('title')</h1>

        @yield('content')
    </main>
</div>
</body>
</html>
