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

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Books list</a></li>
        </ul>
    </header>

    <main>
        <h1>@yield('title')</h1>

        <div class="row mt-5 mb-5">
            <div class="col-12">
                <form method="GET" name="f-search" id="f-search" action="{{ route('books.index') }}">
                    <div class="input-group mb-3">
                        <input type="text" name="title" id="src-title" value="{{ request('title') }}" class="form-control form-control-lg" placeholder="Search a book by title" aria-label="Search a book by title" aria-describedby="go-search">
                        <button class="btn btn-secondary" type="submit" id="go-search">Go</button>
                        <span class="input-group-text"><a href="{{ route('books.index') }}" class="text-warning-emphasis"><i class="fa fa-refresh"></i></a></span>
                    </div>
                </form>
            </div>
        </div>

        @yield('content')
    </main>
</div>
</body>
</html>
